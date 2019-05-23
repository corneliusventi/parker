@extends('layouts.bread.show', [
    'title' => 'Show User',
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
    ],
    'back' => route('users.index'),
])
