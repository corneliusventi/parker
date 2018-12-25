<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\Facades\GMapsFacade as Gmaps;
use App\ParkingLot;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = array();
        $config['center'] = '-0.03109, 109.32199'; //Pontianak
        $config['zoom'] = 15;
        $config['geometry'] = true;
        $config['onclick'] = 'mapOnClick(event)';
        GMaps::initialize($config);

        $parkingLots = ParkingLot::all();
        foreach ($parkingLots as $parkingLot) {
            $marker = array();
            $marker['position'] = $parkingLot->latitude . ',' . $parkingLot->longitude;
            $marker['visible'] = false;
            if ($parkingLot->parkings()->where('status', true)->first() && Carbon::createFromTimeString($parkingLot->parkings()->where('status', true)->first()->time_end)->diffInMinutes(Carbon::now()) <= 60) {
                $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=ffed4a&color=FFF&hoffset=-1';
                $marker['infowindow_content'] = "<div class='text-center'><h5>$parkingLot->name</h5><h6 class='pb-4'>$parkingLot->address</h6><p>Available in One Hour</p><button class='btn btn-primary btn-disabled btn-block' data-toggle='modal' data-target='#bookLaterModal' data-name='$parkingLot->name' data-address='$parkingLot->address' data-id='$parkingLot->id'>Book Later</button></div>";
            } else if ($parkingLot->bookings()->where('status', true)->first() || $parkingLot->parkings()->where('status', true)->first()) {
                $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=D94B43&color=FFF&hoffset=-1';
                $marker['infowindow_content'] = "<div class='text-center'><h5>$parkingLot->name</h5><h6 class='pb-4'>$parkingLot->address</h6><button class='btn btn-danger btn-block disabled'>Booked</button></button></div>";
            } else {
                $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=14ACBC&color=FFF&hoffset=-1';
                $marker['infowindow_content'] = "<div class='text-center'><h5>$parkingLot->name</h5><h6 class='pb-4'>$parkingLot->address</h6><p>Available in Now</p><button class='btn btn-primary btn-block' data-toggle='modal' data-target='#bookNowModal' data-id='$parkingLot->id' data-name='$parkingLot->name' data-address='$parkingLot->address'>Book</button><button class='btn btn-secondary btn-block' data-toggle='modal' data-target='#bookLaterModal' data-name='$parkingLot->name' data-address='$parkingLot->address' data-id='$parkingLot->id'>Book Later</button></div>";
            }
            Gmaps::add_marker($marker);
        }
        $map = GMaps::create_map();
        $map['js'] = str_replace_first('&v=3', '&v=3&libraries=geometry', $map['js']);
        return view('pages.booking', compact('map'));
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
        if (auth()->user()->wallet >= 10000) {
            $parkingLot = ParkingLot::find($request->parking_lot_id);
            $parkingLot->bookings()->create([
                'type' => $request->type,
                'hour' => (int)$request->hour,
                'time' => $request->time ?? now(),
                'date' => $request->date ?? today(),
                'user_id' => auth()->id(),
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $bookingPrice = 5000;
        $parkingPrice = 1000;

        $user = auth()->user();
        if ($booking->type == 'later') {
            if (now()->lte(Carbon::createFromTimeString($booking->time)->subMinute(30))) {
                $user->update([
                    'wallet' => $user->wallet + ($parkingPrice * $booking->hour)
                ]);
            }
        } else if ($booking->type == 'now') {
            if (Carbon::createFromTimeString($booking->time)->lte(now()->addMinute(30))) {
                $user->update([
                    'wallet' => $user->wallet + ($parkingPrice * $booking->hour)
                ]);
            }
        }

        $booking->delete();
        return redirect()->route('parking.index')->withStatus('Delete Booking Successful');
    }
}
