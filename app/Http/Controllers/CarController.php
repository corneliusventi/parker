<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CarController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:manage,App\Car');
    }

    public function index(Request $request)
    {
        $this->authorize('browse', Car::class);

        if ($request->ajax()) {
            return Laratables::recordsOf(Car::class, function ($query)
            {
                return $query->where('user_id', auth()->id());
            });
        } else {
            return view('pages.cars.index');
        }
    }

    public function create()
    {
        $this->authorize('add', Car::class);

        return view('pages.cars.create');
    }

    public function store(Request $request)
    {
        $this->authorize('add', Car::class);

        $request->validate([
            'plate' => 'required|alpha_num|unique:cars,plate',
            'brand' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $car = new Car([
                'plate' => strtoupper($request->plate),
                'brand' => $request->brand,
            ]);

            auth()->user()->cars()->save($car);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Oops...', 'Car could not been saved');
            return redirect()->route('cars.index');
        }

        Alert::success('Success', 'Car has been saved');
        return redirect()->route('cars.index');
    }

    public function show(Car $car)
    {
        $this->authorize('read', $car);

        return view('pages.cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        $this->authorize('edit', $car);

        return view('pages.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $this->authorize('edit', Car::class);

        $request->validate([
            'plate' => 'required|alpha_num|unique:cars,plate,'.$car->id,
            'brand' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $car->update([
                'plate' => strtoupper($request->plate),
                'brand' => $request->brand,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Oops...', 'Car could not been updated');
            return redirect()->route('cars.index');
        }
        Alert::success('Success', 'Car has been updated');
        return redirect()->route('cars.index');
    }

    public function destroy(Request $request, Car $car)
    {
        $this-> authorize('delete', $car);

        try {
            DB::beginTransaction();

            $car->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Oops...', 'Car could not been deleted');
            return redirect()->route('cars.index');
        }
        Alert::error('Success', 'Car has been deleted');
        return redirect()->route('cars.index');
    }
}
