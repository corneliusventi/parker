@extends('layouts.bread.action', [
    'show' => route('parking-lots.show', $parkingLot->id),
    'edit' => route('parking-lots.edit', $parkingLot->id),
    'delete' => route('parking-lots.destroy', $parkingLot->id),
])