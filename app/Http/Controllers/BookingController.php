<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\Facades\GMapsFacade as Gmaps;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Freshbitsweb\Laratables\Laratables;
use App\ParkingLot;

class BookingController extends Controller
{

    public function __construct()
    {

        $this->middleware('can:booking')->only(['booking', 'book', 'cancel']);
        $this->middleware('can:manage,App\Booking')->only(['index']);

        $this->middleware(function ($request, $next) {
            $parkings = auth()->user()->parkings->where('status', true);
            $parking = $parkings->first();
            if ($parking) {
                return redirect()->route('parking.index')->withStatus('Already Booking');
            }

            return $next($request);
        })->only(['bookings', 'book', 'cancel']);
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

            $parkingLots = ParkingLot::available()->get();

            foreach ($parkingLots as $parkingLot) {
                $marker = array();
                $marker['position'] = $parkingLot->latitude . ', ' . $parkingLot->longitude;
                $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=14ACBC&color=FFF&hoffset=-1';
                $marker['onclick'] = "bookNow($parkingLot->id)";
                Gmaps::add_marker($marker);
            }

            $map = GMaps::create_map();
            $map['js'] = Str::replaceFirst('&v=3', '&v=3&libraries=geometry', $map['js']);
            $map['js'] = Str::replaceFirst( '&sensor=falsesensor=false', '', $map['js']);
            return view('pages.booking', compact('map', 'cars'));
        }
    }

    public function book(Request $request)
    {
        $bookingPrice = 5000;
        $parkingPrice = 1000;

        $price = $bookingPrice + ($parkingPrice * $request->hour);

        if (auth()->user()->wallet >= 10000 && auth()->user()->wallet >= $price) {
            Booking::create([
                'hour' => (int)$request->input('hour'),
                'time' => now(),
                'date' => today(),
                'user_id' => auth()->id(),
                'car_id' => $request->input('car'),
                'slot_id' => $request->input('slot'),
                'parking_lot_id' => $request->input('parking_lot'),
            ]);

            auth()->user()->update([
                'wallet' => auth()->user()->wallet - $price
            ]);
            return redirect()->route('booking.index')->withStatus('Booking Successful');
        } else {
            return redirect()->route('booking.index')->withStatus('Minimum Saldo Rp. 10.000 And Saldo doesn\'t enough');
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

    public function index(Request $request)
    {
        $this->authorize('read', Booking::class);

        if ($request->ajax()) {
            return Laratables::recordsOf(Booking::class, function ($query) {
                if (!empty(auth()->user()->parkingLots)) {
                    return $query->whereHas('parkingLot', function ($query) {
                        $query->whereIn('id', auth()->user()->parkingLots->pluck('id')->toArray());
                    });
                } else {
                    return $query;
                }
            });
        } else {
            return view('pages.bookings.index');
        }
    }
}
