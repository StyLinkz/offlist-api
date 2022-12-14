<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            if (!$user->email_verified_at) {
                return $this->sendFailedLoginResponse($request, 'not_verified');
            }

            /* Generate api token */
            $api_token = $user->generateApiToken();

            return response()->json([
                'data' => array_merge($user->toArray(), ['api_token' => $api_token]),
            ]);
        }
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Logout
     *
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        /* Log out to delete the current API token */
        auth()->logout();

        /* Return success message */
        return response()->json([
            'data' => 'User logged out'
        ], 200);
    }

    /**
     * Send failed login response
     *
     * @param Request $request
     * @return mixed
     */
    protected function sendFailedLoginResponse(Request $request, $type = 'auth')
    {
        $errors = [ 'error' => $type === 'not_verified' ? 'Please verify your account.' : trans('auth.failed') ];
        return response()->json($errors, 422);
    }
}
