@extends('layouts.bread.create', [
    'title' => 'Create Car',
    'back' => route('cars.index'),
    'store' => route('cars.store'),
])

@section('form')

    @input([
        'name' => 'fullname',
        'required' => true,
    ])
        Fullname
    @endinput

    @input([
        'name' => 'username',
        'required' => true,
    ])
        Username
    @endinput

@endsection