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
    Route::get('/booking', function () {
        return view('pages.booking');
    })->name('booking');

    Route::get('/topup', function () {
        return view('pages.topup');
    })->name('topup');

    Route::get('/profile', function () {
        return view('pages.profile');
    })->name('profile');

    // Route::get('/about', function () {
    //     return view('pages.about');
    // })->name('about');

});

