@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-primary h-100">
                <div class="card-body p-2">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Bookings</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $bookings_count }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-primary" data-feather="book-open"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-primary h-100">
                <div class="card-body p-2">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Parkings</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $parkings_count }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-primary" data-feather="map-pin"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-primary  h-100">
                <div class="card-body p-2">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Users Registerd</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $users_count }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-primary" data-feather="users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-primary h-100">
                <div class="card-body p-2">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Operators Registered</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $operators_count }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-primary" data-feather="users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
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
        <div class="col-12 mt-4">
            <div class="container-fluid border border-primary rounded-lg px-0">
                <div class="d-md-flex align-items-center pt-3 px-3 pb-1 bg-primary rounded-top">
                    <div>
                        <h5 class="text-white">Recents Top Ups</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="topups-table">
                        <thead>
                            <tr>
                                <th class="border-top-0">Date</th>
                                <th class="border-top-0">Time</th>
                                <th class="border-top-0">Amount</th>
                                <th class="border-top-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topUps as $topUp)
                            <tr>
                                <td>{{ $topUp->date }}</td>
                                <td>{{ $topUp->time }}</td>
                                <td> Rp {{ number_format($topUp->amount) }}</td>
                                <td>{{ $topUp->status }}</td>
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