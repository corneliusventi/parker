@extends('layouts.bread.edit', [
    'title' => 'Edit User',
    'back' => route('users.index'),
    'update' => route('users.update', $user->id),
])

@section('form')

    @include('pages.users.form')

@endsection