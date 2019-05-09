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
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ old('address') }}" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select class="custom-select" id="type" name="type" required>
                <option value="" {{ old('type') =='' ? 'selected' : ''}}>Pick Type</option>
                <option value="street" {{ old('type') =='street' ? 'selected' : ''}}>Street</option>
                <option value="building" {{ old('type') =='building' ? 'selected' : ''}}>Building</option>
            </select>
        </div>
        <div id="slots" class="form-group">
            <div class="row">
                <div class="col">
                    <label>Slots</label>
                </div>
            </div>
            @if (count(old('slots') ?? []) <= 1)
                
                <div class="input-group mb-1">
                    <div class="input-group-prepend" style="display: none;">
                        <span class="input-group-text level">Level 1</span>
                    </div>
                    <input type="text" class="form-control slot" name="slots[]" placeholder="Slots" required value="{{ old('slots') && count(old('slots')) == 1 ? old('slots')[0] : '' }}">
                    <div class="input-group-append" style="display: none;">
                        <button class="btn btn-outline-primary" type="button" id="add-slot">
                            <span aria-hidden="true">&plus;</span>
                        </button>
                    </div>
                </div>

            @else
                @foreach (old('slots') as $slot)

                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text level">Level {{ $loop->index + 1 }}</span>
                        </div>
                        <input type="text" class="form-control slot" name="slots[]" placeholder="Slots" required value="{{ $slot }}">
                        <div class="input-group-append">
                            @if ($loop->first)
                                <button class="btn btn-outline-primary" type="button" id="add-slot">
                                    <span aria-hidden="true">&plus;</span>
                                </button>
                            @else
                                <button class="btn btn-outline-danger delete-slot" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            @endif
                        </div>
                    </div>

                @endforeach
            @endif
        </div>
        <div class="form-group">
            <label>Latitude & Longitude</label>
            <div class="input-group">
                <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" value="{{ old('latitude') }}" readonly required>
                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" value="{{ old('longitude') }}" readonly required>
            </div>
        </div>
        <div class="form-group">
            {!! $map['html'] !!}
        </div>
        <button type="submit" id="save" class="btn btn-primary btn-block rounded">Save</button>
    </form>
@endsection

@push('js')
    {!! $map['js'] !!}
    <script>
        let parkingLotMarker;
        const defaultZoomIn = 17;

        function cleave(className) {
            $(className).toArray().forEach(function(field){
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'none',
                })
            });
        }
        cleave('.slot');
            
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

        function mapOnTilesLoaded() {
            @if (old('latitude') && old('longitude'))
                let old = new google.maps.LatLng(parseFloat("{{ old('latitude') }}"), parseFloat("{{ old('longitude') }}"));
                placeMarker(old);
            @endif
        }

        function mapOnClick(event) {
            placeMarker(event.latLng);
            updateLatLngInput(event.latLng);
        }
        
        $('#add-slot').click(function (event) {
            let slots = $('#slots').children().length - 1; //remove the label from length
            
            $('#slots').append(`
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text level">Level ${slots + 1}</span>
                    </div>
                    <input type="text" class="form-control slot" name="slots[]" placeholder="Slots" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger delete-slot" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            `);
            cleave('.slot');
            
        });
        
        $('#slots').on('click', '.delete-slot', function (event) {
            $(this).closest('.input-group').remove();
            $('#slots').children().slice(1).each(function(key) {
                $(this).find('.level').text(`Level ${ key+1 }`);
            });
        });

        $('#type').on('change', function (event) {
            if(event.target.value === 'building') {
                $('#add-slot').closest('.input-group-append').fadeIn();
                $('.level').closest('.input-group-prepend').fadeIn();
            } else {
                $('#add-slot').closest('.input-group-append').fadeOut();
                $('.level').closest('.input-group-prepend').fadeOut();
                $('#slots').children().not(':nth-child(1), :nth-child(2)').remove();
            }
        });

    </script>
@endpush
