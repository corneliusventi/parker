@extends('layouts.app')

@section('title', 'Booking')

@section('content')
    <form id="form-destination">
        <div class="input-group pb-3">
            <input type="text" class="form-control" name="destination" id="destination" placeholder="Destination" required>
            <input type="text" class="form-control" name="radius" id="radius" placeholder="Radius (Default 200m)">
            <span class="input-group-append">
                <button type="submit" class="btn btn-primary" type="button">Search</button>
            </span>
        </div>
    </form>
    <div>
        {!! $map['html'] !!}
    </div>
@endsection

@section('modal')

    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('booking.book') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" class="parkingLotId" name="parking_lot" value="">
                        <p>
                            <span class="parkingLotName"></span>
                            -
                            <span class="parkingLotAddress"></span>
                        </p>
                        <p>Booking - Rp. <span class="bookingPrice">5000</span></p>
                        <p>Parking - Rp. <span class="parkingPrice">1000</span> / hour</p>
                        <div class="form-group">
                            <label for="car" class="col-form-label">Car</label>
                            <select class="custom-select" id="car" name="car">
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->plate }} - {{ $car->brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="level form-group d-none">
                            <label for="level" class="col-form-label">Level</label>
                            <select class="custom-select" id="level" name="level">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="slot" class="col-form-label">Slot</label>
                            <select class="custom-select" id="slot" name="slot">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hourBookNow" class="col-form-label">Hour</label>
                            <select class="custom-select" id="hourBookNow" name="hour">
                                <option value="1" selected>1 Hour</option>
                                <option value="2">2 Hour</option>
                                <option value="3">3 Hour</option>
                                <option value="4">4 Hour</option>
                                <option value="5">5 Hour</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="totalBookNow" class="col-form-label">Total</label>
                            <input type="number" value="6000" class="form-control" id="totalBookNow" name="total" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Book Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    {!! $map['js'] !!}
    <script>
        const defaultZoomIn = 17;
        const bookingPrice = 5000;
        const parkingPrice = 1000;

        let destinationMarker;
        let radiusCircle;
        let radiusParking = 200; //meter

        $('#bookingPrice').text(bookingPrice);
        $('#parkingPrice').text(parkingPrice);

        $('#form-destination').submit(function (event) {
            event.preventDefault();
            if(geocoder) {
                let formData = $( this ).serializeArray();
                let destination = formData[0].value;
                let radius = formData[1].value;

                if(radius === "") {
                    radius = radiusParking
                } else {
                    radius = parseInt(radius);
                }

                geocoder.geocode({ address: destination + ' Pontianak' }, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        let location = results[0].geometry.location;
                        placeDestination(location, radius);
                        showParkingLotInRadius(radius);

                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                })

            }
        })

        function mapOnClick(event) {
            placeDestination(event.latLng, radiusParking);
        }

        function placeDestination(location, radius) {
            placeMarker(location, radius);
            placeCircle(location, radius);
            showParkingLotInRadius(radius);
        }

        function placeMarker(location, radius) {
            map.setCenter(location);
            map.setZoom(defaultZoomIn);
            if (destinationMarker) {
                destinationMarker.setPosition(location)
                google.maps.event.clearListeners(destinationMarker, 'dragend');
            } else {
                destinationMarker = new google.maps.Marker({
                    map: map,
                    icon: 'https://cdn.mapmarker.io/api/v1/pin?text=D&size=40&background=38c172&color=FFF&hoffset=-1',
                    draggable: true,
                    position: location
                });
            }

            google.maps.event.addListener(destinationMarker, 'dragend', function (event) {
                placeDestination(event.latLng, radius);
            });

            if (radiusCircle) {
                destinationMarker.bindTo("position", radiusCircle, "center");
            }
        }

        function placeCircle(center, radius) {
            if (radiusCircle) {
                radiusCircle.setCenter(center);
                radiusCircle.setRadius(radius);
            } else {
                radiusCircle = new google.maps.Circle({
                    strokeColor: '#3490dc',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#3490dc',
                    fillOpacity: 0.35,
                    map: map,
                    center: center,
                    radius: radius
                });
            }
            if (destinationMarker) {
                destinationMarker.bindTo("position", radiusCircle, "center");
            }
        }

        function showParkingLotInRadius(radius) {
            markers_map.forEach(marker => {
                if (google.maps.geometry.spherical.computeDistanceBetween(marker.position, destinationMarker.position) <= radius) {
                    marker.setVisible(true);
                } else {
                    marker.setVisible(false);
                }
            })
        }

        function bookNow(parkingLotId) {
            $.ajax({
                url: '{{ route('parking-lots.detail') }}',
                data: {
                    parkingLotId: parkingLotId
                },
                success: function (response) {
                    let parkingLot = response.data.parkingLot
                    let name = parkingLot.name;
                    let id = parkingLot.id;
                    let address = parkingLot.address;
                    let slots = parkingLot.slots;
                    let type = parkingLot.type;

                    let slotSelectbox = $('#slot');
                    slotSelectbox.empty();
                    slots.forEach(slot => {
                        let option = `<option value="${slot.id}" data-level="${slot.level}">${slot.code}</option>`;
                        slotSelectbox.append(option);
                    });

                    if(type == 'building') {
                        $('.level').removeClass('d-none');
                        let levels = _.chain(slots).map('level').uniq().value();
                        let levelSelectbox = $('#level')
                        levelSelectbox.empty();
                        levels.forEach(level => {
                            let option = `<option value="${level}">${level}</option>`;
                            levelSelectbox.append(option);
                        });
                        $('#slot option').not(`[data-level="1"]`).hide();
                    } else {
                        $('.level').addClass('d-none');
                    }
                    let modal = $('#bookingModal');
                    modal.find('.parkingLotId').val(id);
                    modal.find('.parkingLotName').text(name);
                    modal.find('.parkingLotAddress').text(address);
                    $('#bookingModal').modal();
                },
            });
        }

        $('#hourBookNow').change(function () {
            let time = $(this).val();
            $('#totalBookNow').val( bookingPrice + (time * parkingPrice));
        })

        $('#level').on('change', function (event) {
            let level = $(this).val();
            $('#slot option').show();
            $('#slot option').not(`[data-level="${level}"]`).hide();
            let slot = $(`#slot option[data-level="${level}"]`).first().val();
            $('#slot').val(slot);
        })
    </script>
@endpush
