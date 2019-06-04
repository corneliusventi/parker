@extends('layouts.bread.create', [
    'title' => 'Create Parking Lot',
    'back' => route('parking-lots.index'),
    'store' => route('parking-lots.store'),
])

@section('form')

    @input([
        'type' => 'text',
        'name' => 'name',
        'required' => true,
    ])
        Name
    @endinput

    @select([
        'name' => 'type',
        'required' => true,
        'options' => [
            ['value' => 'street', 'text' => 'Street'],
            ['value' => 'building', 'text' => 'Building'],
        ],
    ])
        Type
    @endselect

    @input([
        'type' => 'text',
        'name' => 'address',
        'required' => true,
    ])
        address
    @endinput

@endsection