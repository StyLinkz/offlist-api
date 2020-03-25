<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function show() {
        $user = Auth::user();
        return response()->json($user, 200);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'prename' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/([0-9]+)/'],
        ]);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function updateAvatar(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file;

            /* Get file's detail */
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            /* Valid avatar extension */
            $validExtensions = array('jpg', 'jpeg', 'png');

            /* Max file size is 2MB */
            $maxFileSize = 2097152;

            if (!in_array(strtolower($extension), $validExtensions)) {
                return response()->json('Invalid file extension.', 422);
            }

//            if ($fileSize > $maxFileSize) {
//                return response()->json('File\'s size must be less than 2MB.', 422);
//            }

            /* Handle upload the avatar */
            $file->move(public_path('upload/user'), $filename);

            return response()->json(array( "avatar_url" => URL::asset('upload/user/' . $filename) ), 200);
        }
    }
}
