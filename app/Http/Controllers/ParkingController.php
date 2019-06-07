<?php

namespace App\Http\Controllers;

use App\Parking;
use Illuminate\Http\Request;
use App\Booking;
use App\ParkingLot;

class ParkingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:parking');

        $this->middleware(function ($request, $next) {
            $bookings = auth()->user()->bookings->where('status', true);
            $booking = $bookings->first();
            $parkings = auth()->user()->parkings->where('status', true);
            $parking = $parkings->first();

            if ($parking) {
                return $next($request);
            } else if (!$booking) {
                return redirect()->route('booking.index')->withStatus('Booking First');
            }

            return $next($request);
        });
    }
    public function parking()
    {
        $parkings = auth()->user()->parkings->where('status', true);
        $parking = $parkings->first();

        if ($parking) {

            return view('pages.leaving', compact('parking'));
        } else {
            $bookings = auth()->user()->bookings->where('status', true);
            $booking = $bookings->first();

            return view('pages.parking', compact('booking'));
        }
    }

    public function park(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        $booking->status = false;
        $booking->save();
        Parking::create([
            'date' => today(),
            'time_start' => now(),
            'time_end' => now()->addHour($booking->hour),
            'user_id' => auth()->id(),
            'car_id' => $booking->car_id,
            'slot_id' => $booking->slot_id,
            'parking_lot_id' => $booking->parking_lot_id,
        ]);

        return redirect()->route('parking.index')->withStatus('Parking Successful');
    }

    public function leave(Request $request)
    {
        $parking = Parking::findOrFail($request->parking_id);

        $parking->status = false;
        $parking->save();

        return redirect()->route('booking.index')->withStatus('Parking Successful');
    }
}
