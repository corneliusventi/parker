@extends('layouts.bread.show', [
    'title' => 'User',
    'details' => [
        [
            'name' => 'ID',
            'value' => $user->id,
        ],
        [
            'name' => 'Fullname',
            'value' => $user->fullname,
        ],
        [
            'name' => 'Username',
            'value' => $user->username,
        ],
        [
            'name' => 'Email',
            'value' => $user->email,
        ],
        [
            'name' => 'Role',
            'value' => $user->roles->first()->title,
        ],
    ],
    'back' => route('users.index'),
])
