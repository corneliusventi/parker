@extends('layouts.app')

@section('title', 'Parking')

@section('content')
    <table class="table">
        <tr>
            <th>Parking Lot</th>
            <td>{{ $parking->parkingLot->name }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $parking->parkingLot->address }}</td>
        </tr>
        <tr>
            <th>Code</th>
            <td>{{ $parking->slot->code }}</td>
        </tr>
        @if ($parking->parkingLot->type == 'building')
            <tr>
                <th>Level</th>
                <td>{{ $parking->slot->level }}</td>
            </tr>
        @endif
        <tr>
            <th>Time Left</th>
            <td>
                {{ \Carbon\Carbon::parse($parking->time_end)->diffForHumans() }}
            </td>
        </tr>
    </table>

    <a href="{{ route('parking.leave') }}" class="btn btn-primary btn-block" data-toggle="modal" data-target="#scanModal">Scan</a>
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
                        <span class="parkingLotName">{{ $parking->parkingLot->name }}</span>
                        -
                        <span class="parkingLotAddress">{{ $parking->parkingLot->address }}</span>
                    </p>
                    <p>
                        {{ $parking->slot->code }}
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
                let code = '{{ $parking->slot->code }}';
                let parkingLot = '{{ $parking->parkingLot->id }}';
                let parking = '{{ $parking->id }}';
                let user = '{{ auth()->id() }}';
                if(code == content) {
                    scanner.stop();
                    $('#scanModal').modal('hide');
                    $.redirect("{{ route('parking.leave') }}", {
                        _token: document.head.querySelector('meta[name="csrf-token"]').content,
                        _method: 'PUT',
                        parking_lot_id: parkingLot,
                        parking_id: parking,
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
