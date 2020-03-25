<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Auth */
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::get('email/verify/{id}', 'Api\Auth\VerificationController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'Api\Auth\VerificationController@resend')->name('verificationapi.resend');
Route::post('password/email', 'Api\Auth\ForgotPasswordController@sendResetCodeEmail');
Route::post('password/verify', 'Api\Auth\ForgotPasswordController@verifyResetCode');
Route::post('password/reset', 'Api\Auth\ResetPasswordController@reset');

/* Authenticated Resources*/
Route::group(['middleware' => ['auth:api', 'verified']], function () {

    /* Offer */
    Route::get('offers', 'OfferController@index');
    Route::get('offers/{offer}', 'OfferController@show');
    Route::post('offers', 'OfferController@store');
    Route::put('offers/{offer}', 'OfferController@update');
    Route::delete('offers/{offer}', 'OfferController@delete');
    Route::post('offer-files', 'OfferController@uploadFiles');

    /* Invitation */
    Route::get('invitations', 'InvitationController@index');
    Route::get('invitations/{invitation}', 'InvitationController@show');
    Route::post('invitations', 'InvitationController@store');
    Route::put('invitations/{invitation}', 'InvitationController@update');
    Route::delete('invitations/{invitation}', 'InvitationController@delete');

    /* User */
    Route::get('profile', 'UserController@show');
    Route::put('profile', 'UserController@update');
    Route::post('avatar', 'UserController@updateAvatar');

});
