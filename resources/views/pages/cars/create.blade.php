@extends('layouts.bread.create', [
    'title' => 'Create Car',
    'back' => route('cars.index'),
    'store' => route('cars.store'),
])

@section('form')

    @input([
        'name' => 'plate',
        'required' => true,
    ])
        Plate
    @endinput

    @input([
        'name' => 'brand',
        'required' => true,
    ])
        Brand
    @endinput

@endsection