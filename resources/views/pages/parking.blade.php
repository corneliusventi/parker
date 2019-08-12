@extends('layouts.app')

@section('title', 'Start Parking')

@section('content')
    <table class="table">
        <tr>
            <th>Parking Lot</th>
            <td>{{ $booking->parkingLot->name }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $booking->parkingLot->address }}</td>
        </tr>
        <tr>
            <th>Code</th>
            <td>{{ $booking->slot->code }}</td>
        </tr>
        @if ($booking->parkingLot->type == 'building')
            <tr>
                <th>Level</th>
                <td>{{ $booking->slot->level }}</td>
            </tr>
        @endif
        <tr>
            <th>Time</th>
            <td>{{ $booking->time }}</td>
        </tr>
        <tr>
            <th>Hour</th>
            <td>{{ $booking->hour }}</td>
        </tr>
        <tr>
            <th>Expired in</th>
            <td>{{ \Carbon\Carbon::parse($booking->expired_at)->diffForHumans() }}</td>
        </tr>
        @if(isset($booking->parkingLot->blueprint))
        <tr>
            <th>Blueprint</th>
            <td><a href="{{ route('parking-lots.blueprint', $booking->parkingLot->id) }}">Preview</a></td>
        </tr>
        @endif
    </table>
    <div class="row">
        <div class="col-6">
            <botton class="btn btn-primary btn-block" data-toggle="modal" data-target="#scanModal">Scan</botton>
        </div>
        <div class="col-6">
            <a href="{{ route('booking.cancel') }}" class="btn btn-danger btn-block" data-toggle="modal" data-target="#cancelModal">Cancel</a>
        </div>
    </div>
@endsection


@section('modal')

    <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="scanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanModalLabel">Scanning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p>
                        <span class="parkingLotName">{{ $booking->parkingLot->name }}</span>
                        -
                        <span class="parkingLotAddress">{{ $booking->parkingLot->address }}</span>
                    </p>
                    <p>
                        {{ $booking->slot->code }}
                    </p>
                    <div class="p-4 embed-responsive embed-responsive-16by9 ">
                        <video class="embed-responsive-item" id="camera"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Cancel Comfirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('booking.cancel') }}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        Are you sure you want to cancel?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/js/instascan.min.js"></script>
    <script type="text/javascript" src="/js/jquery.redirect.js"></script>
    <script>
        let scanner;

        $('#scanModal').on('show.bs.modal', function (event) {
            if(!scanner) {
                scanner = new Instascan.Scanner({ video: document.getElementById('camera') });
            }
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
                let code = '{{ $booking->slot->code }}';
                let parking = '{{ $booking->parkingLot->id }}';
                let booking = '{{ $booking->id }}';
                let user = '{{ auth()->id() }}';
                if(code == content) {
                    scanner.stop();
                    $('#scanModal').modal('hide');
                    $.redirect("{{ route('parking.park') }}", {
                        _token: document.head.querySelector('meta[name="csrf-token"]').content,
                        parking_lot_id: parking,
                        booking_id: booking,
                        user_id: user
                    }, "POST");
                } else {
                    alert('Parking Lot doesn\'t match')
                }


            });
        })

        $('#scanModal').on('hide.bs.modal', function (event) {
            scanner.stop();
        });
    </script>
@endpush
