@extends('layouts.bread.create', [
    'title' => 'Create User',
    'back' => route('users.index'),
    'store' => route('users.store'),
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

    @input([
        'type' => 'email',
        'name' => 'email',
        'required' => true,
    ])
        Email
    @endinput
    @select([
        'name' => 'role',
        'required' => true,
        'options' => $roles,
    ])
        Role
    @endselect

    @input([
        'type' => 'password',
        'name' => 'password',
        'required' => true,
    ])
        Password
    @endinput

    @input([
        'type' => 'password',
        'name' => 'password_confirmation',
        'required' => true,
    ])
        Password Confimation
    @endinput

@endsection