@extends('layouts.bread.index', [
    'title' => 'Parkings',
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
            'name' => 'time_start',
            'display_name' => 'Time Start',
        ],
        [
            'name' => 'time_end',
            'display_name' => 'Time End',
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
    'ajax' => route('parkings.index'),
])