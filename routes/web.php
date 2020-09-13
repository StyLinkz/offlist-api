<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/offers', function () {
    return view('offers');
});
Route::get('/offers/create', function () {
    return view('offerCreate');
});
Route::get('/offers/{offerId}/edit', function ($offerId) {
    return view('offerCreate', [
        'offerId' => 48
    ]);
});
Route::get('/verify-email-success', function () {
    return view('verifyEmailSuccess');
});
Route::get('/imprint', function () {
    return view('imprint');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
