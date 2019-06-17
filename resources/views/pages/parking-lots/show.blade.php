@extends('layouts.bread.show', [
    'title' => 'Parking Lot',
    'details' => [
        [
            'name' => 'ID',
            'value' => $parkingLot->id,
        ],
        [
            'name' => 'Name',
            'value' => $parkingLot->name,
        ],
        [
            'name' => 'Type',
            'value' => $parkingLot->type,
        ],
        [
            'name' => 'Address',
            'value' => $parkingLot->address,
        ],
        [
            'name' => 'Operators',
            'value' => $parkingLot->users->pluck('fullname')->implode(', '),
        ],
    ],
    'back' => route('parking-lots.index'),
])

@section('content')
    @parent
    {!! $map['html'] !!}
@endsection

@push('js')
    {!! $map['js'] !!}
@endpush
