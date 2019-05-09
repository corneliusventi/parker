@extends('layouts.app')

@section('title', 'Parking Lot Detail')

@section('buttons')
    <a href="{{ route('parking-lot.index') }}" class="btn btn-primary">Back</a>
@endsection
    
@section('content')
    <table class="table">
        <tr>
            <th>Name</th>
            <td>{{ $parkingLot->name }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $parkingLot->address }}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ ucwords($parkingLot->type) }}</td>
        </tr>
        <tr>
            <th>Latitude & Longitude</th>
            <td>{{ $parkingLot->latitude }} - {{ $parkingLot->longitude }}</td>
        </tr>
    </table>
    <div class="mb-4">
        {!! $map['html'] !!}
    </div>
    <table class="table" id="slot-table">
        <thead>
            <th>Code</th>

            @if ($parkingLot->type == 'building')
                <th>Level</th>                
            @endif

            <th>Active</th>
            <th>Action</th>
        </thead>
    </table>
@endsection

@push('js')
    {!! $map['js'] !!}
    <script>
        $('#slot-table').DataTable({
            serverSide: true,
            ajax: "{{ route('parking-lot.show', $parkingLot->id) }}",
            columns: [
                { name: 'code' },

                @if ($parkingLot->type == 'building')
                    { name: 'level' },
                @endif

                { name: 'active' },
                { name: 'action' },
            ],
            drawCallback: function() {
                feather.replace({
                    width: '16',
                    height: '16', 
                })
            }
        });
    </script>
@endpush
