<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\Facades\GMapsFacade as Gmaps;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{

    public function __construct()
    {

        $this->middleware('can:booking');

        $this->middleware(function ($request, $next) {
            $parkings = auth()->user()->parkings->where('status', true);
            $parking = $parkings->first();
            if ($parking) {
                return redirect()->route('parking.index')->withStatus('Already Booking');
            }

            return $next($request);
        });
    }

    public function booking()
    {
        $bookings = auth()->user()->bookings->where('status', true);

        if ($bookings->count() > 0) {
            $booking = $bookings->first();

            $config = array();
            $config['center'] = '-0.03109, 109.32199'; //Pontianak
            $config['zoom'] = 15;
            $config['geometry'] = true;
            $config['trafficOverlay'] = true;
            $config['onclick'] = 'mapOnClick(event)';
            $config['directions'] = true;
            $config['directionsStart'] = 'auto';
            $config['directionsEnd'] = $booking->parkingLot->latitude . ', ' . $booking->parkingLot->longitude;
            GMaps::initialize($config);

            $marker = array();
            $marker['position'] = $booking->parkingLot->latitude . ', ' . $booking->parkingLot->longitude;
            $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=14ACBC&color=FFF&hoffset=-1';
            Gmaps::add_marker($marker);

            $map = GMaps::create_map();

            return view('pages.navigating', compact('booking', 'map'));
        } else {
            $cars = auth()->user()->cars;

            $config = array();
            $config['center'] = '-0.03109, 109.32199'; //Pontianak
            $config['zoom'] = 15;
            $config['geometry'] = true;
            $config['onclick'] = 'mapOnClick(event)';
            GMaps::initialize($config);

            $map = GMaps::create_map();
            $map['js'] = Str::replaceFirst('&v=3', '&v=3&libraries=geometry', $map['js']);
            return view('pages.booking', compact('map', 'cars'));
        }
    }

    public function book(Request $request)
    {
        if (auth()->user()->wallet >= 10000) {
            Booking::create([
                'hour' => (int)$request->input('hour'),
                'time' => now(),
                'date' => today(),
                'user_id' => auth()->id(),
                'car_id' => $request->input('car'),
                'slot_id' => $request->input('slot'),
                'parking_lot_id' => $request->input('parking_lot'),
            ]);

            $bookingPrice = 5000;
            $parkingPrice = 1000;

            auth()->user()->update([
                'wallet' => auth()->user()->wallet - ($bookingPrice + ($parkingPrice * $request->hour))
            ]);
            return redirect()->route('booking.index')->withStatus('Booking Successful');
        } else {
            return redirect()->route('booking.index')->withStatus('Minimum Saldo Rp. 10.000');
        }
    }

    public function cancel()
    {
        $booking = auth()->user()->bookings->where('status', true)->first();
        $bookingPrice = 5000;
        $parkingPrice = 1000;

        $user = auth()->user();

        if (Carbon::createFromTimeString($booking->time)->lte(now()->addMinute(30))) {
            $user->update([
                'wallet' => $user->wallet + ($parkingPrice * $booking->hour)
            ]);
        }

        $booking->delete();
        return redirect()->route('booking.index')->withStatus('Delete Booking Successful');
    }
}
