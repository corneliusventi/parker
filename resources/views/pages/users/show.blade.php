@extends('layouts.bread.show', [
    'title' => 'Show User',
    'details' => [
        [
            'name' => 'id',
            'value' => $user->id,
        ],
        [
            'name' => 'fullname',
            'value' => $user->fullname,
        ],
        [
            'name' => 'username',
            'value' => $user->username,
        ],
        [
            'name' => 'email',
            'value' => $user->email,
        ],
    ],
    'back' => route('users.index'),
])
