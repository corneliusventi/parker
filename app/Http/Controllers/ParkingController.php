<?php

namespace App\Http\Controllers;

use App\Parking;
use Illuminate\Http\Request;
use App\Booking;
use App\ParkingLot;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = auth()->user()->bookings->filter(function ($booking) {
            return $booking->status == true;
        });
        return view('pages.parking', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);
        $parking_lot = ParkingLot::findOrFail($request->parking_lot_id);

        $booking->status = false;
        $booking->save();
        $parking_lot->parkings()->create([
            'date' => today(),
            'time_start' => now(),
            'time_end' => now()->addHour($booking->hour),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('parking.index')->withStatus('Parking Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function show(Parking $parking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function edit(Parking $parking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parking $parking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parking $parking)
    {
        //
    }
}
