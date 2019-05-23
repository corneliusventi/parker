@extends('layouts.bread.edit', [
    'title' => 'Edit User',
    'back' => route('users.index'),
    'update' => route('users.update', $user->id),
])

@section('form')

    @input([
        'name' => 'fullname',
        'required' => true,
        'value' => $user->fullname,
    ])
        Fullname
    @endinput

    @input([
        'name' => 'username',
        'required' => true,
        'value' => $user->username,
    ])
        Username
    @endinput

    @input([
        'type' => 'email',
        'name' => 'email',
        'required' => true,
        'value' => $user->email,
    ])
        Email
    @endinput
    @select([
        'name' => 'role',
        'required' => true,
        'options' => $roles,
        'selected' => $user->roles->first(),
    ])
        Role
    @endselect

    @input([
        'type' => 'password',
        'name' => 'password',
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