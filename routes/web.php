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

/* Admin routes */
// Route::get('/admin/offers', function () {
//     return view('offers');
// });
// Route::get('/admin/offers/create', function () {
//     return view('offerCreate');
// });
// Route::get('/admin/offers/{offerId}/edit', function ($offerId) {
//     return view('offerCreate', [
//         'offerId' => 48
//     ]);
// });
// Route::get('/admin/verify-email-success', function () {
//     return view('verifyEmailSuccess');
// });
// Route::get('/admin/free-listing', function () {
//     return view('freeListing');
// });

/* User route */
// Route::get('/', function () {
//     return view('index');
// });
// Route::get('/imprint', function () {
//     return view('imprint');
// });

/* New routes for free users */
// Route::get('/offers', function () {
//     return view('offers');
// });
// Route::get('/offer/{offerId}', function () {
//     return view('offerDetail', [
//         'offerId' => 123
//     ]);
// });
// Route::get('/offers/create', function () {
//     return view('offerCreate');
// });

Route::view('/{any}', 'index')->where('any', '.*');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
