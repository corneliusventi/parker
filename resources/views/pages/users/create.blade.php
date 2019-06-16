@extends('layouts.bread.create', [
    'title' => 'Create User',
    'back' => route('users.index'),
    'store' => route('users.store'),
])

@section('form')

    @include('pages.users.form')

@endsection