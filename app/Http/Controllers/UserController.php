<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use JD\Cloudder\Facades\Cloudder;

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

    public function showUser(User $user)
    {
        return $user;
    }

    public function updateAvatar(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file;

            /* Get file's detail */
            $filename = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            /* Valid avatar extension */
            $extension = $file->getClientOriginalExtension();
            $validExtensions = array('jpg', 'jpeg', 'png');
            if (!in_array(strtolower($extension), $validExtensions)) {
                return response()->json('Invalid file extension.', 422);
            }

//            /* Max file size is 2MB */
//            $maxFileSize = 2097152;
//            if ($fileSize > $maxFileSize) {
//                return response()->json('File\'s size must be less than 2MB.', 422);
//            }

            /* Handle upload the avatar */
            Cloudder::upload($file, null, array('quality' => 'auto'));
            $result = Cloudder::getResult();

            return response()->json(array( "avatar_url" => $result['secure_url'] ), 200);
        }
    }
}
