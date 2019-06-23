<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Parking;
use App\TopUp;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if($user->isA('user')) {
            $bookings = $user->bookings;
            $parkings = $user->parkings;
            $topUps = $user->topUps;

            return view('pages.home.user', compact('bookings', 'parkings', 'topUps'));
        } else if ($user->isA('operator', 'admin_operator')) {
            $parkingLot = $user->parkingLots->first();
            $bookings = $parkingLot->bookings;
            $parkings = $parkingLot->parkings;

            return view('pages.home.operator', compact('bookings', 'parkings'));
        } else if ($user->isA('administrator')) {
            $bookings = Booking::all();
            $parkings = Parking::all();
            $topUps = TopUp::all();
            $userss = User::all();

            $bookings_count = $bookings->count();
            $parkings_count = $parkings->count();
            $users_count = $user->whereIs('user')->count();
            $operators_count = $user->whereIs('operator', 'admin_operator')->count();

            return view('pages.home.administrator', compact('bookings', 'parkings', 'topUps', 'users_count', 'operators_count', 'bookings_count', 'parkings_count'));
        } else {
            return view('pages.home');
        }
    }
}
