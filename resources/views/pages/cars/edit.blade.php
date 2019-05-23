@extends('layouts.bread.edit', [
    'title' => 'Edit Car',
    'back' => route('cars.index'),
    'update' => route('cars.update', $car->id),
])

@section('form')

    @input([
        'name' => 'plate',
        'required' => true,
        'value' => $car->plate,
    ])
        Plate
    @endinput

    @input([
        'name' => 'brand',
        'required' => true,
        'value' => $car->brand,
    ])
        Brand
    @endinput

@endsection