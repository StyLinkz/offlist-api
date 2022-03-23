<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Group;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use JD\Cloudder\Facades\Cloudder;
use Carbon\Carbon;

class OfferController extends Controller
{
  public function index()
  {
    return Offer::with(['user', 'type', 'category', 'tags', 'groups', 'wishlistUsers'])
      ->orderByDesc('created_at')
      ->get();
  }

  public function show(Offer $offer)
  {
    return $offer
      ->load(['user', 'type', 'category', 'tags', 'groups', 'wishlistUsers']);
  }

  public function store(Request $request)
  {
    $offer_data = $request->all();
    $offer_data['commission'] = str_replace(',', '.', $offer_data['commission']);
    $offer_data['commission'] = str_replace('%', '', $offer_data['commission']);

    /* Generate offer code */
    $today_offers = Offer::whereDate('created_at', Carbon::today())->get();
    $code_date = Carbon::today()->format('dmy');
    $code_number = str_pad(count($today_offers) + 1, 3, STR_PAD_LEFT);
    $offer_data['code'] = "ID{$code_date}{$code_number}";

    /* Create a new offer */
    $offer = Offer::create($offer_data);

    /* Save tags */
    if ($request->input('tags')) {
      $tags = Tag::find($request->input('tags'));
      $offer->tags()->attach($tags);
    }

    /* Save groups */
    if ($request->input('groups')) {
      $groups = Group::find($request->input('groups'));
      $offer->groups()->attach($groups);
    }

    return response()->json($offer, 201);
  }

  public function update(Request $request, Offer $offer)
  {
    $offer->update($request->all());

    /* Detach current tags */
    $currentTagIds = [];
    foreach ($offer->tags as $tag) {
      $currentTagIds[] = $tag->id;
    }
    if (!empty($currentTagIds)) {
      $offer->tags()->detach($currentTagIds);
    }

    /* Save new tags */
    if ($request->input('tags')) {
      $tags = Tag::find($request->input('tags'));
      $offer->tags()->attach($tags);
    }

    /* Detach current groups */
    $currentGroupIds = [];
    foreach ($offer->groups as $group) {
      $currentGroupIds[] = $group->id;
    }
    if (!empty($currentGroupIds)) {
      $offer->groups()->detach($currentGroupIds);
    }

    /* Save new groups */
    if ($request->input('groups')) {
      $groups = Group::find($request->input('groups'));
      $offer->groups()->attach($groups);
    }

    return response()->json($offer, 200);
  }

  public function delete(Offer $offer)
  {
    $offer->update([
      'status' => 'deleted',
    ]);
    return response()->json(null, 204);
  }

  public function updateStatus(Request $request, Offer $offer)
  {
    $status = $request->input('status');
    $offer->update([
      'status' => $status,
    ]);
    return response()->json($offer, 200);
  }

  public function updatePublishType(Request $request, Offer $offer)
  {
    $publish_type = $request->input('publish_type');
    $offer->update([
      'publish_type' => $publish_type,
    ]);
    return response()->json($offer, 200);
  }

  public function showFeedOffers(Request $request)
  {
    $user = auth()->user();
    $query = Offer::feed($user)
      ->with(['user', 'type', 'category', 'tags', 'groups', 'wishlistUsers']);

    /* Filter */
    if (
      $request->input('categories')
      || $request->input('types')
      || $request->input('market_types')
    ) {
      $query->filter($request);
    }

    return $query
      ->orderByDesc('created_at')
      ->get();
  }

  public function showUserOffers()
  {
    $user = auth()->user();
    return Offer::auth($user)
      ->with(['user', 'type', 'category', 'tags', 'groups', "wishlistUsers"])
      ->orderByDesc('created_at')
      ->get();
  }

  public function showFreeOffers()
  {
    return Offer::free()
      ->with(['type', 'category', 'tags'])
      ->orderByDesc('created_at')
      ->get();
  }

  public function import(Request $request)
  {
    $requestOffers = $request->input('offers');
    foreach ($requestOffers as $requestOffer) {
      $offer = Offer::create($requestOffer);

      /* Save tags */
      if ($requestOffer['tags']) {
        $tags = Tag::find($requestOffer['tags']);
        $offer->tags()->attach($tags);
      }

      /* Save groups */
      if ($requestOffer['groups']) {
        $groups = Group::find($requestOffer['groups']);
        $offer->groups()->attach($groups);
      }
    }
    return response()->json($offer, 201);
  }

  public function generateCodes()
  {
    $dayCounter = [];
    $offers = Offer::all();
    foreach ($offers as $offer) {
      $date = Carbon::parse($offer->created_at)->format('dmy');

      if (empty($dayCounter[$date])) {
        $dayCounter[$date] = 0;
      }
      $dayCounter[$date] += 1;

      $code_number = str_pad($dayCounter[$date], 3, '0', STR_PAD_LEFT);
      $code = "ID{$date}{$code_number}";
      $offer->update([
        'code' => $code,
      ]);
    }
  }

  public function uploadImages(Request $request)
  {
    $this->validate($request, [
      'file' => 'required',
    ]);

    if ($request->hasFile('file')) {
      $uploadedFileUrls = [];
      foreach ($request->file('file') as $i => $file) {
        $name = $file->getClientOriginalName();

        Cloudder::upload($file);
        $result = Cloudder::getResult();

        $uploadedFileUrls[] = [
          'name' => $name,
          'url' => $result['secure_url'],
        ];
      }

      return response()->json(array('files' => $uploadedFileUrls), 200);
    }
  }

  public function uploadFiles(Request $request)
  {
    $this->validate($request, [
      'file' => 'required',
      //            'file.*' => 'mimes:jpg,jpeg,png,doc,pdf,docx,xls,xlsx,ppt,pptx'
    ]);

    if ($request->hasFile('file')) {
      $uploadedFileUrls = [];
      foreach ($request->file('file') as $i => $file) {
        /* Get file's detail */
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        Cloudder::upload($file);
        $result = Cloudder::getResult();

        /* Max file size is 2MB */
        //                $fileSize = $file->getSize();
        //                $maxFileSize = 2097152;
        //                if ($fileSize > $maxFileSize) {
        //                    return response()->json('File\'s size must be less than 2MB.', 422);
        //                }
        //                if (in_array($extension, ['jpg','jpeg','png'])) {
        //                    $type = 'images';
        //                } else {
        //                    $type = 'files';
        //                }
        //                $file->move(public_path('upload/offer/' . $type), $filename);

        /* Handle upload the avatar */
        $uploadedFileUrls[] = [
          'name' => $filename,
          'url' => $result['secure_url'],
        ];
      }

      return response()->json(array('files' => $uploadedFileUrls), 200);
    }
  }
}
