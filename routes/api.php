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

/* Authenticated Resources*/
Route::group(['middleware' => 'auth:api'], function () {

    /* Offer */
    Route::get('offers', 'OfferController@index');
    Route::get('offers/{offer}', 'OfferController@show');
    Route::post('offers', 'OfferController@store');
    Route::put('offers/{offer}', 'OfferController@update');
    Route::delete('offers/{offer}', 'OfferController@delete');

    /* Invitation */
    Route::get('invitations', 'InvitationController@index');
    Route::get('invitations/{invitation}', 'InvitationController@show');
    Route::post('invitations', 'InvitationController@store');
    Route::put('invitations/{invitation}', 'InvitationController@update');
    Route::delete('invitations/{invitation}', 'InvitationController@delete');

});
