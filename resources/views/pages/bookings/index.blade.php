@extends('layouts.bread.index', [
    'title' => 'Bookings',
    'columns' => [
        [
            'name' => 'id',
            'display_name' => 'ID',
        ],
        [
            'name' => 'user.fullname',
            'display_name' => 'User',
        ],
        [
            'name' => 'car.plate',
            'display_name' => 'Car',
        ],
        [
            'name' => 'date',
            'display_name' => 'Date',
        ],
        [
            'name' => 'time',
            'display_name' => 'Time',
        ],
        [
            'name' => 'hour',
            'display_name' => 'Hour',
        ],
        [
            'name' => 'parkingLot.name',
            'display_name' => 'Parking Lot',
        ],
        [
            'name' => 'slot.code',
            'display_name' => 'Slot',
        ],
    ],
    'ajax' => route('bookings.index'),
])