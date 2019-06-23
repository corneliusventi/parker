@extends('layouts.bread.index', [
    'title' => 'Cars',
    'columns' => [
        [
            'name' => 'id',
            'display_name' => 'ID',
        ],
        [
            'name' => 'plate',
            'display_name' => 'Plate',
        ],
        [
            'name' => 'brand',
            'display_name' => 'Brand',
        ],
        [
            'name' => 'action',
            'display_name' => 'Action',
        ],
    ],
    'ajax' => route('cars.index'),
    'create' => route('cars.create'),
])
