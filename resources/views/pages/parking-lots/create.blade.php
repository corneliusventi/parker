@extends('layouts.bread.create', [
    'title' => 'Create Parking Lot',
    'back' => route('parking-lots.index'),
    'store' => route('parking-lots.store'),
    'enctype' => 'multipart/form-data',
])

@section('form')

    @include('pages.parking-lots.form')

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