@extends('layouts.bread.index', [
    'mode' => 'simple',
    'title' => 'Cars',
    'columns' => [
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
