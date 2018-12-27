<?php

namespace App\Http\Controllers;

use App\ParkingLot;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use FarhanWazir\GoogleMaps\Facades\GMapsFacade as Gmaps;
use PDF;

class ParkingLotController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage,App\ParkingLot');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('read', ParkingLot::class);

        if ($request->ajax()) {
            return Laratables::recordsOf(ParkingLot::class);
        } else {
            return view('pages.parking-lot.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ParkingLot::class);


        $config = array();
        $config['center'] = '-0.03109, 109.32199'; //Pontianak
        $config['zoom'] = 15;
        $config['onclick'] = 'mapOnClick(event)';
        GMaps::initialize($config);
        $map = GMaps::create_map();

        return view('pages.parking-lot.create', compact('map'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', ParkingLot::class);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'string', 'max:255'],
        ]);

        ParkingLot::create([
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('parking-lot.index')->withStatus('Parking Lot has been saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ParkingLot  $parkingLot
     * @return \Illuminate\Http\Response
     */
    public function show(ParkingLot $parkingLot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ParkingLot  $parkingLot
     * @return \Illuminate\Http\Response
     */
    public function edit(ParkingLot $parkingLot)
    {
        $this->authorize('edit', $parkingLot);


        $config = array();
        $config['center'] = "$parkingLot->latitude, $parkingLot->longitude"; //Pontianak
        $config['zoom'] = 15;
        $config['onclick'] = 'mapOnClick(event)';

        $marker = array();
        $marker['id'] = 'parking_lot';
        $marker['position'] = $parkingLot->latitude . ',' . $parkingLot->longitude;
        $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=38c172&color=FFF&hoffset=-1';
        $marker['draggable'] = true;
        Gmaps::add_marker($marker);

        GMaps::initialize($config);
        $map = GMaps::create_map();

        return view('pages.parking-lot.edit', compact('map', 'parkingLot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ParkingLot  $parkingLot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParkingLot $parkingLot)
    {
        $this->authorize('update', $parkingLot);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'string', 'max:255'],
        ]);

        $parkingLot->update([
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('parking-lot.index')->withStatus('Parking Lot has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ParkingLot  $parkingLot
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParkingLot $parkingLot)
    {
        $this->authorize('delete', $parkingLot);

        $parkingLot->delete();

        return redirect()->route('parking-lot.index')->withStatus('Parking Lot has been deleted');
    }

    public function print(ParkingLot $parkingLot)
    {
        $this->authorize('print', $parkingLot);

        $pdf = PDF::loadView('pages.parking-lot.pdf', compact('parkingLot'));
        return $pdf->download('parking-lot.pdf');
    }
}
