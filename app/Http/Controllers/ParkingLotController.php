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
        $config['ontilesloaded'] = 'mapOnTilesLoaded()';
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
            'type' => ['required', 'in:street,building'],
            'latitude' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'string', 'max:255'],
            'slots.*' => ['required', 'integer'],
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

            if($request->type == 'street') {
                for ($i=0; $i < $request->slots[0]; $i++) { 
                    $parkingLot->slots()->create([
                        'code' => 'PARKER-'.$parkingLot->id.'-0-'.($i+1),
                        'qrcode' => base64_encode(QrCode::format('png')->merge('/public/apple-icon.png')->size(500)->generate('PARKER-'.$parkingLot->id.'-0-'.($i+1))),
                    ]);
                }
            } else {
                foreach ($request->slots as $key => $slot) {
                    for ($i=0; $i < $slot; $i++) { 
                        $parkingLot->slots()->create([
                            'level' => ($key+1),
                            'code' => 'PARKER-'.$parkingLot->id.'-'.($key+1).'-'.($i+1),
                            'qrcode' => base64_encode(QrCode::format('png')->merge('/public/apple-icon.png')->size(500)->generate('PARKER-'.$parkingLot->id.'-'.($key+1).'-'.($i+1))),
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('parking-lot.index')->withStatus('Parking Lot could not been saved');
        }

        return redirect()->route('parking-lot.index')->withStatus('Parking Lot has been saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ParkingLot  $parkingLot
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ParkingLot $parkingLot)
    {
        $this->authorize('show', $parkingLot);

        if ($request->ajax()) {
            return Laratables::recordsOf(Slot::class, function ($query) use ($parkingLot)
            {
                return $query->where('parking_lot_id', $parkingLot->id);
            });
        } else {
            $config = array();
            $config['center'] = "$parkingLot->latitude, $parkingLot->longitude";
            $config['zoom'] = 17;
            $config['onclick'] = 'mapOnClick(event)';

            $marker = array();
            $marker['id'] = 'parking_lot';
            $marker['position'] = $parkingLot->latitude . ',' . $parkingLot->longitude;
            $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=38c172&color=FFF&hoffset=-1';
            Gmaps::add_marker($marker);

            GMaps::initialize($config);
            $map = GMaps::create_map();
            return view('pages.parking-lot.show', compact('parkingLot', 'map'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ParkingLot  $parkingLot
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ParkingLot $parkingLot)
    {
        $this->authorize('edit', $parkingLot);

        if ($request->ajax()) {
            return Laratables::recordsOf(Slot::class, function ($query) use ($parkingLot)
            {
                return $query->where('parking_lot_id', $parkingLot->id);
            });
        } else {

            $config = array();
            $config['center'] = "$parkingLot->latitude, $parkingLot->longitude"; //Pontianak
            $config['zoom'] = 15;
            $config['onclick'] = 'mapOnClick(event)';
            $config['ontilesloaded'] = 'mapOnTilesLoaded()';

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
        
        try {
            DB::beginTransaction();

            $parkingLot->update([
                'name' => $request->name,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('parking-lot.index')->withStatus('Parking Lot could not been updated');
        }

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

        $slots = $parkingLot->slots;

        $pdf = PDF::loadView('pages.parking-lot.pdf', compact('parkingLot', 'slots'));
        return $pdf->download('parking-lot.pdf');
    }

    public function available(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $innerRadius = $request->innerRadius;
        $outerRadius = $request->outerRadius;

        $parkingLots = ParkingLot::geofence($latitude, $longitude, $innerRadius, $outerRadius)->get();
            // ->whereHas('slots', function ($query)
            // {
            //     $query->whereHas('parkings', function ($query)
            //     {
            //         $query->where('status', true);
            //     }, '>=', 1);

            //     $query->whereHas('bookings', function ($query)
            //     {
            //         $query->where('status', true);
            //     }, '>=', 1);
            // })->get();

        return response()->json(['status' => 'success', 'parkingLots' => $parkingLots], 200);
    }
}
