<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Carbon\Carbon;
use App\Mail\ForgotPasswordNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Send the password-reset code.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetCodeEmail(Request $request)
    {
        /* Validate email */
        $this->validateEmail($request);

        /* Get the user */
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response()->json('User not found.', 404);
        }

        /* Create reset-password token */
        $user->generateResetPasswordToken();

        /* Send email */
        Mail::to($user)->send(new ForgotPasswordNotification($user));
        if (Mail::failures()) {
            return response()->json('Sorry! Please try again later', 422);
        } else {
            return response()->json('Great! Successfully send in your mail');
        }
    }

    /**
     * Verify the reset-password code
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function verifyResetCode(Request $request)
    {
        $this->validateEmail($request);

        /* Get the user */
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response()->json('User not found.', 404);
        }

        /* Verify the code */
        if (strlen($request['token']) != 6 ||
            $user->reset_password_token != $request['token']
        ) {
            return response()->json('The token is invalid.', 422);
        } else {
            $expired_at = Carbon::parse($user->reset_password_token_expired_at);
            if (Carbon::now()->gt($expired_at)) {
                return response()->json('The token is expired.', 422);
            }
            return response()->json('Verify success.');
        }
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }
}
