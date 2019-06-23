@extends('layouts.bread.edit', [
    'title' => 'Edit Car',
    'back' => route('cars.index'),
    'update' => route('cars.update', $car->id),
])

@section('form')

    @include('pages.cars.form')

@endsection