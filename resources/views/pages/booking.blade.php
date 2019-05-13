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

    <div class="modal fade" id="bookNowModal" tabindex="-1" role="dialog" aria-labelledby="bookNowModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookNowModalLabel">Booking Parking Lot Now</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('booking.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="type" value="now">
                        <input type="hidden" class="parkingLotId" name="parking_lot_id" value="">
                        <p>
                            <span class="parkingLotName"></span>
                            -
                            <span class="parkingLotAddress"></span>
                        </p>
                        <p>Booking - Rp. <span class="bookingPrice">5000</span></p>
                        <p>Parking - Rp. <span class="parkingPrice">1000</span> / hour</p>
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
    <div class="modal fade" id="bookLaterModal" tabindex="-1" role="dialog" aria-labelledby="bookLaterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookLaterModalLabel">Booking Parking Lot Later</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('booking.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="type" value="later">
                        <input type="hidden" class="parkingLotId" name="parking_lot_id" value="">
                        <p>
                            <span class="parkingLotName"></span>
                            -
                            <span class="parkingLotAddress"></span>
                        </p>
                        <p>Booking - Rp. <span class="bookingPrice">5000</span></p>
                        <p>Parking - Rp. <span class="parkingPrice">1000</span> / hour</p>
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
                            <label for="timeBookNow" class="col-form-label">Time</label>
                            <input type="time" class="form-control" id="timeBookNow" name="time" required>
                        </div>
                        <div class="form-group">
                            <label for="totalBookNow" class="col-form-label">Total</label>
                            <input type="number" value="6000" class="form-control" id="totalBookNow" name="total" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Book Later</button>
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

        function showParkingLotInRadius(radius) {
            let latitude = destinationMarker.position.lat();
            let longitude = destinationMarker.position.lng();
            let innerRadius = 0;
            let outerRadius = radius / 1000;
            $.ajax({
                url: "{{ route('parking-lot.available') }}",
                contentType: 'application/json',
                method: 'GET',
                data: {
                    latitude: latitude,
                    longitude: longitude,
                    innerRadius: innerRadius,
                    outerRadius: outerRadius,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    let parkingLots = response.parkingLots;
                    parkingLots.forEach(parkingLot => {
                        let location = new google.maps.LatLng(parseFloat(parkingLot.latitude), parseFloat(parkingLot.longitude));
                        new google.maps.Marker({
                            map: map,
                            icon: 'https://cdn.mapmarker.io/api/v1/pin?text=P&size=40&background=14ACBC&color=FFF&hoffset=-1',
                            draggable: true,
                            position: location
                        });
                    });
                                        
                },
            });
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
            if (radiusCircle) destinationMarker.bindTo("position", radiusCircle, "center");
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
                    // draggable: true,
                    center: center,
                    radius: radius
                });
                // google.maps.event.addListener(radiusCircle, 'dragend', function (event) {
                //     placeDestination(event.latLng, radius);
                // });
            }
            if (destinationMarker) destinationMarker.bindTo("position", radiusCircle, "center");
        }

        function placeDestination(location, radius) {
            placeMarker(location, radius);
            placeCircle(location, radius);
            showParkingLotInRadius(radius);
        }

        function mapOnClick(event) {
            placeDestination(event.latLng, radiusParking);
        }

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

                geocoder.geocode({ address: destination }, function (results, status) {
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

        $('#bookNowModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var parkingLotId = button.data('id');
            var address = button.data('address');
            var modal = $(this);
            modal.find('.parkingLotId').val(parkingLotId);
            modal.find('.parkingLotName').text(name);
            modal.find('.parkingLotAddress').text(address);
        })
        $('#bookLaterModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var parkingLotId = button.data('id');
            var address = button.data('address');
            var modal = $(this);
            modal.find('.parkingLotId').val(parkingLotId);
            modal.find('.parkingLotName').text(name);
            modal.find('.parkingLotAddress').text(address);
        })

        $('#hourBookNow').change(function () {
            let time = $(this).val();
            $('#totalBookNow').val( bookingPrice + (time * parkingPrice));
        })
    </script>
@endpush
