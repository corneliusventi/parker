<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        } else {
            return view('pages.home');
        }
    }
}
