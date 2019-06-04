<?php

namespace App\Http\Controllers;

use App\ParkingLot;
use App\Slot;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use FarhanWazir\GoogleMaps\Facades\GMapsFacade as Gmaps;
use DB;
use PDF;
use QrCode;

class ParkingLotController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage,App\ParkingLot')->except('available');
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
            return view('pages.parking-lots.index');
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
        $config['ontilesloaded'] = 'mapOnTilesLoaded()';
        GMaps::initialize($config);
        $map = GMaps::create_map();

        return view('pages.parking-lots.create', compact('map'));
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
            'type' => ['required', 'in:street,building'],
            'latitude' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            $parkingLot = ParkingLot::create([
                'name' => $request->name,
                'address' => $request->address,
                'type' => $request->type,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('parking-lots.index')->withStatus('Parking Lot could not been saved');
        }

        return redirect()->route('parking-lots.index')->withStatus('Parking Lot has been saved');
    }

}
