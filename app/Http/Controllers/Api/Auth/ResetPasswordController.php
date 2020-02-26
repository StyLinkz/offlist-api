<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * @param Request $request
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function reset(Request $request) {
        /* Validate request */
//        $this->validateRequest($request);

        /* Get the user */
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response()->json('User not found.', 404);
        }

        /* Validate token and Change password */
        if ($user->reset_password_token != $request['token']) {
            return response()->json('Invalid token.', 422);
        } else {
            $user->resetPassword($request['password']);
            return response()->json('Password is reset successfully');
        }
    }

    /**
     * Validate the email/password for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateRequest(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'token' => 'required|size:6',
        ]);
    }
}
