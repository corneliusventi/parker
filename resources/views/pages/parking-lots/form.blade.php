@input([
    'type' => 'text',
    'name' => 'name',
    'required' => true,
    'value' => isset($parkingLot) ? $parkingLot->name : old('name'),
])
    Name
@endinput

@select([
    'name' => 'type',
    'required' => true,
    'options' => [
        ['value' => 'street', 'text' => 'Street'],
        ['value' => 'building', 'text' => 'Building'],
    ],
    'selected' => isset($parkingLot) ? $parkingLot->type : old('type'),
])
    Type
@endselect

@input([
    'type' => 'text',
    'name' => 'address',
    'required' => true,
    'value' => isset($parkingLot) ? $parkingLot->address : old('address'),
])
    Address
@endinput

@select([
    'name' => 'operators[]',
    'required' => true,
    'options' => $operators,
    'multiple' => true,
    'selected' => isset($parkingLot) ? $parkingLot->users : old('operators'),
])
    Operator
@endselect

@map([
    'map' => $map,
    'latitude' => [
        'name' => 'latitude',
        'placeholder' => 'Latitude',
        'value' => isset($parkingLot) ? $parkingLot->latitude : old('latitude'),
        'readonly' => true,
        'required' => true
    ],
    'longitude' => [
        'name' => 'longitude',
        'value' => isset($parkingLot) ? $parkingLot->longitude : old('longitude'),
        'placeholder' => 'Longitude',
        'readonly' => true,
        'required' => true
    ],

])
    Latitude & Longitude
@endmap