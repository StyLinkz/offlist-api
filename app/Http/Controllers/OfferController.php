<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Group;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use JD\Cloudder\Facades\Cloudder;

class OfferController extends Controller
{
    public function index()
    {
        return Offer::with(['user', 'type', 'category', 'tags', 'groups'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function show(Offer $offer)
    {
        return $offer->load(['tags', 'groups']);
    }

    public function store(Request $request)
    {
        $offer = Offer::create($request->all());

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

    public function showFeedOffers()
    {
        $user = auth()->user();
        return Offer::feed($user)
            ->with(['user', 'type', 'category', 'tags', 'groups'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function showUserOffers() {
        $user = auth()->user();
        return Offer::auth($user)
            ->with(['user', 'type', 'category', 'tags', 'groups'])
            ->orderByDesc('created_at')
            ->get();
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

                /* Max file size is 2MB */
//                $fileSize = $file->getSize();
//                $maxFileSize = 2097152;
//                if ($fileSize > $maxFileSize) {
//                    return response()->json('File\'s size must be less than 2MB.', 422);
//                }
                if (in_array($extension, ['jpg','jpeg','png'])) {
                    $type = 'images';
                } else {
                    $type = 'files';
                }

                /* Handle upload the avatar */
                $file->move(public_path('upload/offer/' . $type), $filename);
                $uploadedFileUrls[] = [
                    'name' => $filename,
                    'url' => URL::asset('upload/offer/' . $type . '/' . $filename),
                ];
            }

            return response()->json(array('files' => $uploadedFileUrls), 200);
        }
    }
}
