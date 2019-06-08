@extends('layouts.bread.create', [
    'title' => 'Create Parking Lot',
    'back' => route('parking-lots.index'),
    'store' => route('parking-lots.store'),
])

@section('form')

    @input([
        'type' => 'text',
        'name' => 'name',
        'required' => true,
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
    ])
        Type
    @endselect

    @input([
        'type' => 'text',
        'name' => 'address',
        'required' => true,
    ])
        Address
    @endinput

    @select([
        'name' => 'operator',
        'required' => true,
        'options' => $operators,
    ])
        Operator
    @endselect

    @map([
        'map' => $map,
        'latitude' => [
            'name' => 'latitude',
            'placeholder' => 'Latitude',
            'readonly' => true,
            'required' => true
        ],
        'longitude' => [
            'name' => 'longitude',
            'placeholder' => 'Longitude',
            'readonly' => true,
            'required' => true
        ],

    ])
        Latitude & Longitude
    @endmap
@endsection

@push('js')
    <script>

        let parkingLotMarker;

        function updateLatLngInput(location) {
            $('#latitude').val(location.lat());
            $('#longitude').val(location.lng());
        }

        function placeMarker(location) {
            if (parkingLotMarker) {
                parkingLotMarker.setPosition(location)
            } else {
                parkingLotMarker = new google.maps.Marker({
                    map: map,
                    icon: 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=38c172&color=FFF&hoffset=-1',
                    draggable: true,
                    position: location
                });

                google.maps.event.addListener(parkingLotMarker, 'drag', function(event){
                    updateLatLngInput(event.latLng);
                });
                google.maps.event.addListener(parkingLotMarker, 'dragend', function(event){
                    updateLatLngInput(event.latLng);
                });
            }
        }


        function mapOnClick(event) {
            placeMarker(event.latLng);
            updateLatLngInput(event.latLng);
        }

    </script>
@endpush