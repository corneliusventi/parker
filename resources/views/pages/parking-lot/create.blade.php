@extends('layouts.app')

@section('title', 'Create Parking Lot')

@section('buttons')
    <a href="{{ route('parking-lot.index') }}" class="btn btn-primary">Back</a>
@endsection

@section('content')
    <form action="{{ route('parking-lot.index') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select class="custom-select" id="type" name="type">
                <option selected>Pick Type</option>
                <option value="street">Street</option>
                <option value="building">Building</option>
            </select>
        </div>
        <div class="form-group">
            <label>Latitude & Longitude</label>
            <div class="input-group">
                <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" readonly required>
                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" readonly required>
            </div>
        </div>
        <div class="form-group">
            {!! $map['html'] !!}
        </div>
        <div id="slots" class="form-group">
            <label>Slots</label>
            <div class="input-group mb-1">
                <input type="text" class="form-control code" name="slots[0][code]" placeholder="Code" required value="001">
                <input type="text" class="form-control level" name="slots[0][level]" placeholder="Level" style="display: none;">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="add-slot">
                        <span aria-hidden="true">&plus;</span>
                    </button>
                </div>
            </div>
        </div>
        <button type="submit" name="save" id="save" class="btn btn-primary btn-block rounded">Save</button>
    </form>
@endsection

@push('js')
    {!! $map['js'] !!}
    <script>
        let parkingLotMarker;
        const defaultZoomIn = 17;

        function pad(num, size) {
            var s = num+"";
            while (s.length < size) s = "0" + s;
            return s;
        }

        function cleave(className) {
            $(className).toArray().forEach(function(field){
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'none',
                })
            });
        }
        cleave('.level');
            
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
        
        $('#add-slot').click(function (event) {
            let slots = $('#slots').children().length - 1;
            
            $('#slots').append(`
                <div class="input-group mb-1">
                    <input type="text" class="form-control code" name="slots[${slots}][code]" placeholder="Code" required value="${pad((slots+1), 3)}">
                    <input type="text" class="form-control level" name="slots[${slots}][level]" placeholder="Level">
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger delete-slot" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            `)

            if($('#type').val() == 'building') {
                cleave('.level');
            } else {
                $('.level').hide();
            }
            
        });
        
        $('#slots').on('click', '.delete-slot', function (event) {
            $(this).closest('.input-group').remove();
            $('#slots').children().slice(1).each(function(key) {
                $(this).find('.code').prop('name', `slots[${key}][code]`);
                $(this).find('.code').val(pad((key+1), 3));
                $(this).find('.level').prop('name', `slots[${key}][level]`);
            });
        });

        $('#type').on('change', function (event) {
            if(event.target.value === 'building') {
                $('.level').fadeIn();
                $('.level').prop('required', true);
            } else {
                $('.level').fadeOut(); 
                $('.level').prop('required', false);
            }
        });

    </script>
@endpush
