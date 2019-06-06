@extends('layouts.app')

@section('title', 'Booking')

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
        <tr>
            <th>Level</th>
            <td>{{ $booking->slot->level }}</td>
        </tr>
    </table>
    <div class="mb-4">
        {!! $map['html'] !!}
    </div>
    <div class="row">
        <div class="col-6">
            <a href="{{ route('parking.index') }}" class="btn btn-primary btn-block">Parking</a>
        </div>
        <div class="col-6">
            <a href="{{ route('booking.cancel') }}" class="btn btn-danger btn-block" data-toggle="modal" data-target="#cancelModal">Cancel</a>
        </div>
    </div>
@endsection

@push('js')
    {!! $map['js'] !!}
@endpush

@section('modal')

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