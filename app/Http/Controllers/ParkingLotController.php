<?php

namespace App\Http\Controllers;

use App\ParkingLot;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use FarhanWazir\GoogleMaps\Facades\GMapsFacade as Gmaps;
use DB;
use App\User;
use App\Rules\Role;

class ParkingLotController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage,App\ParkingLot')->except('detail', 'blueprint');
    }

    public function index(Request $request)
    {
        $this->authorize('browse', ParkingLot::class);

        if ($request->ajax()) {
            return Laratables::recordsOf(ParkingLot::class);
        } else {
            return view('pages.parking-lots.index');
        }
    }

    public function create()
    {
        $this->authorize('add', ParkingLot::class);

        $config = array();
        $config['center'] = '-0.03109, 109.32199'; //Pontianak
        $config['zoom'] = 15;
        $config['onclick'] = 'mapOnClick(event)';
        GMaps::initialize($config);
        $map = GMaps::create_map();

        $operators = User::whereIs('operator', 'admin_operator')->doesntHave('parkingLots')->get();

        return view('pages.parking-lots.create', compact('map', 'operators', 'admin_operators'));
    }

    public function store(Request $request)
    {
        $this->authorize('add', ParkingLot::class);

        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'address'        => ['required', 'string', 'max:255'],
            'type'           => ['required', 'in:street,building'],
            'latitude'       => ['required', 'string', 'max:255'],
            'longitude'      => ['required', 'string', 'max:255'],
            'blueprint'      => ['required', 'image'],
            'operators'      => ['required'],
            'operators.*'    => ['exists:users,id', new Role(['operator', 'admin_operator'])],
        ]);

        try {
            DB::beginTransaction();

            $parkingLot = ParkingLot::create([
                'name'      => $request->name,
                'address'   => $request->address,
                'type'      => $request->type,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'blueprint' => $request->file('blueprint')->store('blueprints'),
            ]);

            $parkingLot->users()->attach($request->operators);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('parking-lots.index')->withStatus('Parking Lot could not been saved');
        }

        return redirect()->route('parking-lots.index')->withStatus('Parking Lot has been saved');
    }

    public function show(ParkingLot $parkingLot)
    {
        $this->authorize('read', $parkingLot);

        $location = $parkingLot->latitude . ', ' . $parkingLot->longitude;

        $config = array();
        $config['center'] = $location; //Pontianak
        $config['zoom'] = 15;
        $config['disableDefaultUI'] = true;
        GMaps::initialize($config);

        $marker = array();
        $marker['position'] = $location;
        $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=38c172&color=FFF&hoffset=-1';
        Gmaps::add_marker($marker);

        $map = GMaps::create_map();

        return view('pages.parking-lots.show', compact('parkingLot', 'map'));
    }

    public function edit(ParkingLot $parkingLot)
    {
        $this->authorize('edit', $parkingLot);

        $location = $parkingLot->latitude . ', ' . $parkingLot->longitude;

        $config = array();
        $config['center'] = $location; //Pontianak
        $config['zoom'] = 15;
        $config['onclick'] = 'mapOnClick(event)';
        $config['ontilesloaded'] = 'mapOnTilesLoaded()';
        GMaps::initialize($config);

        $marker = array();
        $marker['position'] = $location;
        $marker['icon'] = 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=38c172&color=FFF&hoffset=-1';
        $marker['draggable'] = true;
        Gmaps::add_marker($marker);

        $map = GMaps::create_map();

        $operators = User::whereIs('operator', 'admin_operator')->doesntHave('parkingLots')->get();
        $operators = $operators->merge($parkingLot->users);

        return view('pages.parking-lots.edit', compact('parkingLot', 'map', 'operators'));
    }

    public function update(Request $request, ParkingLot $parkingLot)
    {
        $this->authorize('edit', $parkingLot);

        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'address'        => ['required', 'string', 'max:255'],
            'type'           => ['required', 'in:street,building'],
            'latitude'       => ['required', 'string', 'max:255'],
            'longitude'      => ['required', 'string', 'max:255'],
            'operators'      => ['required'],
            'blueprint'      => ['nullable', 'image'],
            'operators.*'    => ['exists:users,id', new Role(['operator', 'admin_operator'])],
        ]);

        try {
            DB::beginTransaction();

            $parkingLot->update([
                'name'      => $request->name,
                'address'   => $request->address,
                'type'      => $request->type,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            if($request->blueprint) {
                $parkingLot->update([
                    'blueprint' => $request->file('blueprint')->store('blueprints'),
                ]);
            }

            $parkingLot->users()->sync($request->operators);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('parking-lots.index')->withStatus('Parking Lot could not been updated');
        }

        return redirect()->route('parking-lots.index')->withStatus('Parking Lot has been updated');
    }

    public function destroy(Request $request, ParkingLot $parkingLot)
    {
        $this->authorize('delete', $parkingLot);

        try {
            DB::beginTransaction();

            $parkingLot->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('parking-lots.index')->withStatus('Parking Lot could not been deleted');
        }

        return redirect()->route('parking-lots.index')->withStatus('Parking Lot has been deleted');
    }

    public function detail(Request $request)
    {
        if ($request->query('parkingLotId')) {
            $parkingLot = ParkingLot::withSlot()->find($request->query('parkingLotId'));

            if ($parkingLot) {
                return response()->json(['data' => ['parkingLot' => $parkingLot], 'status' => 'success']);
            } else {
                return response()->json(['error' => 'Parking Lot Not Found', 'status' => 'error'], 404);
            }
        } else {
            return response()->json(['error' => 'Parking Lot Id is Required', 'status' => 'error'], 400);
        }
    }

    public function blueprint(Request $request, ParkingLot $parkingLot)
    {
        return response()->file(storage_path('/app//' . $parkingLot->blueprint));
    }
}
