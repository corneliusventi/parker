@extends('layouts.bread.show', [
    'title' => 'Show Car',
    'details' => [
        [
            'name' => 'ID',
            'value' => $car->id,
        ],
        [
            'name' => 'Plate',
            'value' => $car->plate,
        ],
        [
            'name' => 'Username',
            'value' => $car->brand,
        ],
    ],
    'back' => route('cars.index'),
])
