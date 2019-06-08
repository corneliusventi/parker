@extends('layouts.bread.index', [
    'title' => 'Parking Lots',
    'columns' => [
        [
            'name' => 'id',
            'display_name' => 'ID',
        ],
        [
            'name' => 'name',
            'display_name' => 'Name',
        ],
        [
            'name' => 'type',
            'display_name' => 'Type',
        ],
        [
            'name' => 'address',
            'display_name' => 'Address',
        ],
        [
            'name' => 'user.fullname',
            'display_name' => 'Operator',
        ],
    ],
    'ajax' => route('parking-lots.index'),
    'create' => route('parking-lots.create'),
])
