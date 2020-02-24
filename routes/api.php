<?php

use App\Offer;
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
Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');

/* Authenticated Resources*/
Route::group(['middleware' => 'auth:api'], function () {

    /* Offer */
    Route::get('offers', 'OfferController@index')->middleware('verified');
    Route::get('offers/{offer}', 'OfferController@show')->middleware('verified');
    Route::post('offers', 'OfferController@store')->middleware('verified');
    Route::put('offers/{offer}', 'OfferController@update')->middleware('verified');
    Route::delete('offers/{offer}', 'OfferController@delete')->middleware('verified');

    /* Invitation */
    Route::get('invitations', 'InvitationController@index')->middleware('verified');
    Route::get('invitations/{invitation}', 'InvitationController@show')->middleware('verified');
    Route::post('invitations', 'InvitationController@store')->middleware('verified');
    Route::put('invitations/{invitation}', 'InvitationController@update')->middleware('verified');
    Route::delete('invitations/{invitation}', 'InvitationController@delete')->middleware('verified');

});
