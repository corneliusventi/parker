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

Route::group(['middleware' => ['guest']], function () {

    Route::get('/', function () {
        return view('pages.welcome');
    });

});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('booking', 'BookingController@booking')->name('booking.index');
    Route::post('booking', 'BookingController@book')->name('booking.book');
    Route::delete('booking', 'BookingController@cancel')->name('booking.cancel');

    Route::resource('bookings', 'BookingController')->only(['index']);

    Route::resource('parking', 'ParkingController')->only(['index', 'store']);

    Route::get('/topup', 'TopUpController@index')->name('topup');
    Route::put('/topup', 'TopUpController@update')->name('topup.update');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::put('/profile/photo', 'ProfileController@updatePhoto')->name('profile.update.photo');

    Route::resource('users', 'UserController')->only(['index', 'create', 'store']);
    Route::resource('cars', 'CarController');

    Route::get('parking-lots/available', 'ParkingLotController@available')->name('parking-lots.available');
    Route::resource('parking-lots', 'ParkingLotController')->only(['index', 'create', 'store']);

    Route::get('slots/code', 'SlotController@code')->name('slots.code');
    Route::get('slots/{slot}/print', 'SlotController@print')->name('slots.print');
    Route::resource('slots', 'SlotController')->only(['index', 'create', 'store']);



});
