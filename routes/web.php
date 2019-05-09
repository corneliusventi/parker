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

    Route::resource('booking', 'BookingController')->only(['index', 'store', 'destroy']);
    Route::resource('parking', 'ParkingController')->only(['index', 'store']);

    Route::get('/topup', 'TopUpController@index')->name('topup');
    Route::put('/topup', 'TopUpController@update')->name('topup.update');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::put('/profile/photo', 'ProfileController@updatePhoto')->name('profile.update.photo');

    Route::resource('user', 'UserController')->only(['index']);
    
    Route::resource('slot', 'SlotController')->only(['update']);
    Route::get('slot/{slot}/print', 'SlotController@print')->name('slot.print');

    Route::resource('parking-lot', 'ParkingLotController');
    Route::get('parking-lot/{parking_lot}/print', 'ParkingLotController@print')->name('parking-lot.print');
    

});

