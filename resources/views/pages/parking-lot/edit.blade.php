@extends('layouts.app')

@section('title', 'Edit Parking Lot')

@section('buttons')
    <a href="{{ route('parking-lot.index') }}" class="btn btn-primary">Back</a>
@endsection

@section('content')
    <form action="{{ route('parking-lot.update', $parkingLot->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $parkingLot->name }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $parkingLot->address  }}" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select class="custom-select" id="type" name="type" disabled>
                <option value="">Pick Type</option>
                <option value="street" {{ $parkingLot->type =='street' ? 'selected' : ''}}>Street</option>
                <option value="building" {{ $parkingLot->type =='building' ? 'selected' : ''}}>Building</option>
            </select>
        </div>
        <div id="slots" class="form-group">
            <div class="row">
                <div class="col">
                    <label>Slots</label>
                </div>
            </div>
            <table class="table text-center" id="slot-table">
                <thead>
                    <th>Code</th>

                    @if ($parkingLot->type == 'building')
                        <th>Level</th>                
                    @endif

                    <th>Active</th>
                </thead>
                {{-- @foreach ($parkingLot->slots as $slot)

                    <tr>
                        <td>{{ $slot->code }}</td>
                        <td>
                            @if ($slot->active)
                                <button class="btn btn-outline-primary" type="button" id="add-slot">
                                    Active
                                </button>
                            @else
                                <button class="btn btn-outline-danger delete-slot" type="button">
                                    Disable
                                </button>
                            @endif
                        </td>
                    </tr>

                @endforeach --}}
            </table>
        </div>
        <div class="form-group">
            <label>Latitude & Longitude</label>
            <div class="input-group">
                <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" value="{{ $parkingLot->latitude }}" readonly required>
                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" value="{{ $parkingLot->longitude }}" readonly required>
            </div>
        </div>
        <div class="form-group">
            {!! $map['html'] !!}
        </div>
        <button type="submit" id="save" class="btn btn-primary btn-block rounded">Update</button>
    </form>
@endsection

@push('js')
    {!! $map['js'] !!}
    <script>
        $('#slot-table').DataTable({
            serverSide: true,
            ajax: "{{ route('parking-lot.edit', $parkingLot->id) }}",
            columns: [
                { name: 'code' },

                @if ($parkingLot->type == 'building')
                    { name: 'level' },
                @endif

                { name: 'active_button' },
            ],
        });
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

        function mapOnTilesLoaded() {
            parkingLotMarker = marker_parking_lot;
            @if (old('latitude') && old('longitude'))
                let old = new google.maps.LatLng(parseFloat("{{ old('latitude') }}"), parseFloat("{{ old('longitude') }}"));
                placeMarker(old);
            @endif
        }

        function mapOnClick(event) {
            placeMarker(event.latLng);
            updateLatLngInput(event.latLng);
        }
        
        $('#slot-table').on('click', '.slot', function (event) {
            let button = $(this);
            let id = button.data('id');
            let url = '{{ route("slot.update", ":slot") }}';
            url = url.replace(':slot', id);
            $.ajax({
                url: url,
                contentType: 'application/json',
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    let active = response.active;
                    if (active) {
                        button.removeClass('btn-outline-danger');
                        button.addClass('btn-outline-primary');
                        button.text('Active');
                    } else {
                        button.removeClass('btn-outline-primary');
                        button.addClass('btn-outline-danger');
                        button.text('Disable');
                    }
                    
                }
            })
        })
        
    </script>
@endpush
