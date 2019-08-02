@input([
    'name' => 'plate',
    'required' => true,
    'value' => $car->plate ?? old('plate'),
    'placeholder' => 'KB1234OL',
    'mask' => 'AAAAAAAAAA',
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

@push('css')
    <style>
        #plate {
            text-transform: uppercase;
        }
    </style>
@endpush

@push('js')
    <script>
        $("#plate").keyup(function (event) {
            var ucase = event.target.value.toUpperCase()
            event.target.value = ucase;
        });
    </script>
@endpush