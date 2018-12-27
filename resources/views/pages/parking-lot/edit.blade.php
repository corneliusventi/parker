@extends('layouts.app')

@section('title', 'Edit Parking Lot')

@section('buttons')
    <a href="{{ route('parking-lot.index') }}" class="btn btn-light text-primary btn-sm">Back</a>
@endsection

@section('content')
    <form action="{{ route('parking-lot.update', $parkingLot->id) }}" method="POST">
        @csrf
        @method('Put')
        <div class="form-group">
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $parkingLot->name }}" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $parkingLot->address }}" required>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" value="{{ $parkingLot->latitude }}" readonly required>
                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" value="{{ $parkingLot->longitude }}" readonly required>
            </div>
        </div>
        <div class="form-group">
            {!! $map['html'] !!}
        </div>
        <button type="submit" name="save" id="save" class="btn btn-primary btn-block rounded">Update</button>
    </form>
@endsection

@push('js')
    {!! $map['js'] !!}
    <script>
        function updateLatLngInput(location) {
            $('#latitude').val(location.lat());
            $('#longitude').val(location.lng());
        }

        function placeMarker(location) {
            marker_parking_lot.setPosition(location)
            google.maps.event.addListener(marker_parking_lot, 'drag', function(event){
                updateLatLngInput(event.latLng);
            });
            google.maps.event.addListener(marker_parking_lot, 'dragend', function(event){
                updateLatLngInput(event.latLng);
            });
        }
        function mapOnClick(event) {
            placeMarker(event.latLng);
            updateLatLngInput(event.latLng);
        }
    </script>
@endpush
