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
    return view('pages.welcome');
});

Route::get('/login', function () {
    return view('pages.login');
})->name('login');

Route::get('/register', function () {
    return view('pages.register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('pages.forgot-password');
})->name('forgot-password');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('/booking', function () {
    return view('pages.booking');
})->name('booking');

Route::get('/topup', function () {
    return view('pages.topup');
})->name('topup');

Route::get('/profile', function () {
    return view('pages.profile');
})->name('profile');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');
