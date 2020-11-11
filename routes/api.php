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
Route::post('check-invitation', 'InvitationController@checkInvitation');
Route::post('update-invitation/{invitation}', 'InvitationController@updateInvitationStatus');
Route::post('request-access', 'AccessRequestController@store');

/* Authenticated Resources*/
Route::group(['middleware' => ['auth:api', 'verified']], function () {
    /* Common */
    Route::post('files', 'ApiController@uploadFiles');

    /* Offer */
    Route::get('offers', 'OfferController@index');
    Route::get('offers/{offer}', 'OfferController@show');
    Route::post('offers', 'OfferController@store');
    Route::post('offers/import', 'OfferController@import');
    Route::put('offers/{offer}', 'OfferController@update');
    Route::put('offers/{offer}/status', 'OfferController@updateStatus');
    Route::put('offers/{offer}/publish-type', 'OfferController@updatePublishType');
    Route::delete('offers/{offer}', 'OfferController@delete');
    Route::post('offer-files', 'OfferController@uploadFiles');
    Route::post('offer-images', 'OfferController@uploadImages');
    Route::get('feed-offers', 'OfferController@showFeedOffers');
    Route::get('auth-offers', 'OfferController@showUserOffers');

    /* Application */
    Route::get('applications', 'ApplicationController@index');
    Route::get('applications/{application}', 'ApplicationController@show');
    Route::post('applications', 'ApplicationController@store');
    Route::delete('applications/{application}', 'ApplicationController@delete');
    Route::get('auth-applications', 'ApplicationController@showAuthApplications');
    Route::get('receive-applications', 'ApplicationController@showReceiveApplications');

    /* Group */
    Route::get('groups', 'GroupController@index');
    Route::get('groups/{group}', 'GroupController@show');
    Route::post('groups', 'GroupController@store');
    Route::put('groups/{group}', 'GroupController@update');
    Route::delete('groups/{group}', 'GroupController@delete');

    /* Contact */
    Route::get('contacts', 'ContactController@index');
    Route::get('contacts/{contact}', 'ContactController@show');
    Route::post('contacts', 'ContactController@store');
    Route::put('contacts/{contact}', 'ContactController@update');
    Route::delete('contacts/{contact}', 'ContactController@delete');
    Route::delete('search-contacts', 'ContactController@delete');

    /* Wishlist */
    Route::get('wishlist', 'WishlistController@show');
    Route::post('offers/{id}/wishlist/add', 'WishlistController@add');
    Route::delete('offers/{id}/wishlist/remove', 'WishlistController@remove');

    /* Invitation */
    Route::get('invitations', 'InvitationController@index');
    Route::get('invitations/{invitation}', 'InvitationController@show');
    Route::post('invitations', 'InvitationController@store');
    Route::put('invitations/{invitation}', 'InvitationController@update');
    Route::delete('invitations/{invitation}', 'InvitationController@delete');
    Route::get('auth-invitations', 'InvitationController@showAuthInvitations');
    Route::get('invitation-limit', 'InvitationController@getInvitationLimit');

    /* Tags */
    Route::get('tags', 'TagController@index');

    /* User */
    Route::get('profile', 'UserController@show');
    Route::put('profile', 'UserController@update');
    Route::post('avatar', 'UserController@updateAvatar');

});
