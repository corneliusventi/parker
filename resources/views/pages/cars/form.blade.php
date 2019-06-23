@input([
    'name' => 'plate',
    'required' => true,
    'value' => $car->plate ?? old('plate'),
])
    Plate
@endinput

@input([
    'name' => 'brand',
    'required' => true,
    'value' => $car->brand ?? old('brand'),
])
    Brand
@endinput