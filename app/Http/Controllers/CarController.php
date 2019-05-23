<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:manage,App\Car');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('read', Car::class);

        if ($request->ajax()) {
            return Laratables::recordsOf(Car::class, function ($query)
            {
                return $query->where('user_id', auth()->id());
            });
        } else {
            return view('pages.cars.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Car::class);

        return view('pages.cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('store', Car::class);

        $request->validate([
            'plate' => 'required|string',
            'brand' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $car = new Car([
                'plate' => $request->plate,
                'brand' => $request->brand,
            ]);

            auth()->user()->cars()->save($car);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('cars.index')->withStatus('Car could not been saved');
        }

        return redirect()->route('cars.index')->withStatus('Car has been saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        $this->authorize('show', $car);

        return view('pages.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        $this->authorize('edit', $car);

        return view('pages.cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $request->validate([
            'plate' => 'required|string',
            'brand' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $car->update([
                'plate' => $request->plate,
                'brand' => $request->brand,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('cars.index')->withStatus('Car could not been updated');
        }

        return redirect()->route('cars.index')->withStatus('Car has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        try {
            DB::beginTransaction();

            $car->delete();

            DB::commit();
        } catch (Excaption $e) {
            DB::rollBack();

            return redirect()->route('cars.index')->withStatus('Car could not been deleted');
        }

        return redirect()->route('cars.index')->withStatus('Car has been deleted');
    }
}
