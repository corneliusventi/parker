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

    Route::get('parking', 'ParkingController@parking')->name('parking.index');
    Route::post('parking', 'ParkingController@park')->name('parking.park');
    Route::put('parking', 'ParkingController@leave')->name('parking.leave');

    Route::resource('parkings', 'ParkingController')->only(['index']);

    Route::get('/top-up', 'TopUpController@topUp')->name('top-up.index');
    Route::post('/top-up', 'TopUpController@topUpping')->name('top-up.top-upping');
    Route::post('/top-up/upload', 'TopUpController@upload')->name('top-up.upload');

    Route::get( 'top-ups/{top_up}/receipt-transfer', 'TopUpController@receiptTransfer')->name( 'top-ups.receipt-transfer');
    Route::put('top-ups/{top_up}/approve', 'TopUpController@approve')->name('top-ups.approve');
    Route::put('top-ups/{top_up}/disapprove', 'TopUpController@disapprove')->name('top-ups.disapprove');
    Route::resource('top-ups', 'TopUpController')->only(['index', 'show']);

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
