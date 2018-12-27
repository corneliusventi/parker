@extends('layouts.app')

@section('title', 'Parking')

@if (!$bookings->isEmpty())
    @section('list')
    <ul class="list-group list-group-flush">
        @foreach ($bookings as $booking)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-12 col-md d-flex align-items-center">
                        <span>
                            {{ $booking->parkingLot->name }}
                            -
                            {{ $booking->parkingLot->address }}
                            -
                            Booking {{ $booking->type }}
                            -
                            Time: {{ $booking->time }}
                            -
                            {{ $booking->hour }} Hour

                        </span>
                    </div>
                    <div class="col-12 col-md-auto">
                        <form class="inline-form" action="{{ route('booking.destroy', $booking->id) }}" method="POST">
                                @csrf
                                @method('Delete')
                                <botton class="btn btn-primary" data-toggle="modal" data-target="#parkingModal" data-parkingLotId="{{ $booking->parkingLot->id }}" data-bookingId="{{ $booking->id }}" data-name="{{ $booking->parkingLot->name }}" data-address="{{ $booking->parkingLot->address }}">Scan</botton>
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </form>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @endsection
@else
    @section('content')
        You are not booking any parking lot.
    @endsection
@endif


@section('modal')

    <div class="modal fade" id="parkingModal" tabindex="-1" role="dialog" aria-labelledby="parkingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="parkingModalLabel">Scan Parking Lot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <span class="parkingLotName"></span>
                        -
                        <span class="parkingLotAddress"></span>
                    </p>
                    <div class="p-4 embed-responsive embed-responsive-16by9 ">
                        <video class="embed-responsive-item" id="camera"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="text/javascript" src="/js/instascan.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
    <script>
        $('#parkingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var name = button.data('name');
            var address = button.data('address');
            var parkingLotId = button.data('parkinglotid');
            var bookingId = button.data('bookingid');

            var modal = $(this);
            modal.find('.parkingLotName').text(name);
            modal.find('.parkingLotAddress').text(address);
            let scanner = new Instascan.Scanner({ video: document.getElementById('camera') });
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.camera = cameras[cameras.length - 1];
                    scanner.start();
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });
            scanner.addListener('scan', function (content) {
                let parking = parkingLotId;
                let booking = bookingId;

                if("PARKER" + parking == content) {
                    scanner.stop();
                    modal.modal('hide');
                    $.redirect("{{ route('parking.store') }}", {
                        _token: document.head.querySelector('meta[name="csrf-token"]').content,
                        parking_lot_id: parking,
                        booking_id: booking,
                        user_id: {{ auth()->id() }}
                    }, "POST");
                } else {
                    alert('Parking Lot doesn\'t match')
                }


            });
        })

    </script>
@endpush
