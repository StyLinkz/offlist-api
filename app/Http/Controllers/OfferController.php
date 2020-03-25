<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class OfferController extends Controller
{
    public function index()
    {
        return Offer::with(['type', 'category'])->get();
    }

    public function show(Offer $offer)
    {
        return $offer;
    }

    public function store(Request $request)
    {
        $offer = Offer::create($request->all());
        return response()->json($offer, 201);
    }

    public function update(Request $request, Offer $offer)
    {
        $offer->update($request->all());
        return response()->json($offer, 200);
    }

    public function delete(Offer $offer)
    {
        $offer->delete();
        return response()->json(null, 204);
    }

    public function uploadFiles(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
            'file.*' => 'mimes:jpg,jpeg,png,doc,pdf,docx,xls,xlsx,ppt,pptx'
        ]);

        if ($request->hasFile('file')) {
            $uploadedFileUrls = [];
            foreach ($request->file('file') as $i => $file) {
                /* Get file's detail */
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                /* Max file size is 2MB */
//            $fileSize = $file->getSize();
//            $maxFileSize = 2097152;
//            if ($fileSize > $maxFileSize) {
//                return response()->json('File\'s size must be less than 2MB.', 422);
//            }
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

            return response()->json(array( "files" => $uploadedFileUrls ), 200);
        }
    }
}
