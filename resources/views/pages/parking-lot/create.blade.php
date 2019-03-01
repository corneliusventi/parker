@extends('layouts.app')

@section('title', 'Create Parking Lot')

@section('buttons')
    <a href="{{ route('parking-lot.index') }}" class="btn btn-primary">Back</a>
@endsection

@section('content')
    <form action="{{ route('parking-lot.index') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" readonly required>
                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" readonly required>
            </div>
        </div>
        <div class="form-group">
            {!! $map['html'] !!}
        </div>
        <button type="submit" name="save" id="save" class="btn btn-primary btn-block rounded">Save</button>
    </form>
@endsection

@push('js')
    {!! $map['js'] !!}
    <script>
        let parkingLotMarker;
        const defaultZoomIn = 17;

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
