@extends('layouts.app')

@section('title', 'Top Up Wallet')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 p-1">
                <button class="btn btn-lg btn-block btn-warning p-1" data-toggle="modal" data-target="#topupModal" data-topup="10000">10,000</button>
            </div>
            <div class="col-xs-12 col-md-6 p-1">
                <button class="btn btn-lg btn-block btn-warning p-1" data-toggle="modal" data-target="#topupModal" data-topup="20000">20,000</button>
            </div>
            <div class="col-xs-12 col-md-6 p-1">
                <button class="btn btn-lg btn-block btn-warning p-1" data-toggle="modal" data-target="#topupModal" data-topup="30000">30,000</button>
            </div>
            <div class="col-xs-12 col-md-6 p-1">
                <button class="btn btn-lg btn-block btn-warning p-1" data-toggle="modal" data-target="#topupModal" data-topup="40000">40,000</button>
            </div>
            <div class="col-xs-12 col-md-6 p-1">
                <button class="btn btn-lg btn-block btn-warning p-1" data-toggle="modal" data-target="#topupModal" data-topup="50000">50,000</button>
            </div>
        </div>
    </div>
@endsection

@section('modal')

    <div class="modal fade" id="topupModal" tabindex="-1" role="dialog" aria-labelledby="topupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topupModalLabel">Top Up Wallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('topup.update') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <p>BCA - PT. PARKER - 0123456789</p>
                        <div class="form-group">
                            <label for="saldo" class="col-form-label">Saldo</label>
                            <input type="text" class="form-control" id="saldo" name="saldo" readonly>
                        </div>
                        <div class="form-group">
                            <label for="rekening" class="col-form-label">Rekening</label>
                            <input type="text" class="form-control" id="rekening" name="rekening">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Top Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $('#topupModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var saldo = button.data('topup') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('Top Up ' + saldo)
            modal.find('.modal-body #saldo').val(saldo)
        })
    </script>
@endpush
