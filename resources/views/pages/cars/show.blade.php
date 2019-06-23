@extends('layouts.bread.show', [
    'title' => 'Car',
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
            'name' => 'Brand',
            'value' => $car->brand,
        ],
    ],
    'back' => route('cars.index'),
])
