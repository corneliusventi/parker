@extends('layouts.bread.action', [
    'show' => route('cars.show', $car->id),
    'edit' => route('cars.edit', $car->id),
    'delete' => route('cars.destroy', $car->id),
])