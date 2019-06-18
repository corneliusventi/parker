@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="container-fluid border border-primary rounded-lg px-0">
                <div class="d-md-flex align-items-center pt-3 px-3 pb-1 bg-primary rounded-top">
                    <div>
                        <h5 class="text-white">Recents Bookings</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="bookings-table">
                        <thead>
                            <tr>
                                <th class="border-top-0">Parking Lot</th>
                                <th class="border-top-0">Address</th>
                                <th class="border-top-0">Date</th>
                                <th class="border-top-0">Time</th>
                                <th class="border-top-0">Hour</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->parkingLot->name }}</td>
                                    <td>{{ $booking->parkingLot->address }}</td>
                                    <td>{{ $booking->date }}</td>
                                    <td>{{ $booking->time }}</td>
                                    <td>{{ $booking->hour }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="container-fluid border border-primary rounded-lg px-0">
                <div class="d-md-flex align-items-center pt-3 px-3 pb-1 bg-primary rounded-top">
                    <div>
                        <h5 class="text-white">Recents Parkings</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="parkings-table">
                        <thead>
                            <tr>
                                <th class="border-top-0">Parking Lot</th>
                                <th class="border-top-0">Address</th>
                                <th class="border-top-0">Date</th>
                                <th class="border-top-0">Time Start</th>
                                <th class="border-top-0">Time End</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parkings as $parking)
                            <tr>
                                <td>{{ $parking->parkingLot->name }}</td>
                                <td>{{ $parking->parkingLot->address }}</td>
                                <td>{{ $parking->date }}</td>
                                <td>{{ $parking->time_start }}</td>
                                <td>{{ $parking->time_end }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ mix('/js/datatable.js') }}"></script>
    <script>
        let options = {
            info: false,
            searching: false,
            ordering: false,
            lengthChange: false,
            pagingType: "simple",
            dom: 't<".m-2"p>',
            pageLength: 5,
        };
        $('#bookings-table').DataTable(options);
        $('#parkings-table').DataTable(options);
        $('#topups-table').DataTable(options);
    </script>
@endpush