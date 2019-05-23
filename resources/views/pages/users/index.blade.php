@extends('layouts.bread.index', [
    'title' => 'Users',
    'columns' => [
        [
            'name' => 'id',
            'display_name' => 'ID',
        ],
        [
            'name' => 'fullname',
            'display_name' => 'Fullname',
        ],
        [
            'name' => 'username',
            'display_name' => 'Username',
        ],
        [
            'name' => 'email',
            'display_name' => 'Email',
        ],
        [
            'name' => 'role',
            'display_name' => 'Role',
        ],
        [
            'name' => 'action',
            'display_name' => 'Action',
        ],
    ],
    'ajax' => route('users.index'),
    'create' => route('users.create'),
])
