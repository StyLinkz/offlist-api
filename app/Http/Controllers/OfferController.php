<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Group;
use App\Offer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use JD\Cloudder\Facades\Cloudder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
    $offer = $this->_save($request);
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

    /* Save new groups */
    if ($request->input('groups')) {
      /* Detach current groups */
      $currentGroupIds = [];
      foreach ($offer->groups as $group) {
        $currentGroupIds[] = $group->id;
      }
      if (!empty($currentGroupIds)) {
        $offer->groups()->detach($currentGroupIds);
      }
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

  public function showGroupOffers(Request $request)
  {
    $group_id = $request->input('group_id');
    return Offer::with(['user', 'type', 'category', 'tags', 'groups', 'wishlistUsers'])
      ->whereHas('groups', function ($q) use ($group_id) {
          $q->where('group_id', '=', $group_id);
      })
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

  public function createFreeOffer(Request $request) {
    $offer = $this->_save($request);

    // Handle register a new account for the supplier and send an email notification
    $supplier = $request->input('seller');
    if ($supplier) {

      // Create new user account with a random password
      $raw_password = Str::random(16);
      $password = Hash::make($raw_password);
      $user = User::create([
        'prename' => $supplier['prename'],
        'name' => $supplier['name'],
        'email' => $supplier['email'],
        'phone' => $supplier['phone'] ?? '',
        'company' => $supplier['company'] ?? '',
        'address' => $supplier['address'] ?? '',
        'city' => $supplier['city'] ?? '',
        'zip_code' => $supplier['zipcode'] ?? '',
        'avatar' => $supplier['avatar'] ?? '',
        'password' => $password,
        'raw_password' => $raw_password,
        'offer_types' => '',
        'role' => 'free_user',
      ]);

      // Update user_id property of the created offer
      $offer->update([
        'user_id' => $user->id,
      ]);

      // Send a notification to user email
      $this->_sendFreeUserAccountNotification($user);

      // Send a notification to the admin
      $this->_sendNewFreeUserNotificationToAdmin($user);
    }

    return response()->json($offer, 201);
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

  protected function _save(Request $request) {
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

    return $offer;
  }

  protected function _sendFreeUserAccountNotification(User $user)
  {
    $to_name = $user->prename . ' ' . $user->name;
    $to_email = $user->email;
    $data = [
      'name' => $to_name,
    ];

    Mail::send(
      'templates.mail.registerFreeAccount',
      $data,
      function ($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
          ->subject('[Offlist] Account Notification');
        $message->from('info@offlist.de', 'Offlist');
      }
    );
  }

  protected function _sendNewFreeUserNotificationToAdmin(User $user)
  {
    $to_name = 'Offlist Admin';
    $to_email = 'offlistcontact@mailinator.com'; // TODO: Replace it with the real email later and also place it in .env instead
    $data = [
      'name' => $user->prename . ' ' . $user->name,
      'email' => $user->email,
      'phone' => $user->phone,
      'company' => $user->company,
      'website' => $user->website,
      'address' => $user->address,
      'city' => $user->city,
      'zip_code' => $user->zip_code,
    ];

    Mail::send(
      'templates.mail.newFreeAccountNotification',
      $data,
      function ($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
          ->subject('[Offlist] New Free User');
        $message->from('info@offlist.de', 'Offlist');
      }
    );
  }
}
