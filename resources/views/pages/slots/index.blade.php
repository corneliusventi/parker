@extends('layouts.bread.index', [
    'title' => 'Slots',
    'columns' => [
        [
            'name' => 'id',
            'display_name' => 'ID',
        ],
        [
            'name' => 'code',
            'display_name' => 'Code',
        ],
        [
            'name' => 'level',
            'display_name' => 'Level',
            'if' => optional(auth()->user()->parkingLot)->type == 'building',
        ],
        [
            'name' => 'print',
            'display_name' => 'Print',
        ]
    ],
    'ajax' => route('slots.index'),
    'create' => route('slots.create'),
])
