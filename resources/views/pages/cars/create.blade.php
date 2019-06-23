@extends('layouts.bread.create', [
    'title' => 'Create Car',
    'back' => route('cars.index'),
    'store' => route('cars.store'),
])

@section('form')

    @include('pages.cars.form')

@endsection