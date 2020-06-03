<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class ApiController extends Controller
{
    public function uploadFiles(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        if ($request->hasFile('file')) {
            $uploadedFileUrls = [];
            foreach ($request->file('file') as $i => $file) {
                $name = $file->getClientOriginalName();

                Cloudder::upload($file, null, array('quality' => 'auto'));
                $result = Cloudder::getResult();

                $uploadedFileUrls[] = [
                    'name' => time() . '_' . $name,
                    'url' => $result['secure_url'],
                ];
            }

            return response()->json(array('files' => $uploadedFileUrls), 200);
        }
    }

}
