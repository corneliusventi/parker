@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row">
        <div class="col-12">
            <div id="recent-bookings" class="container-fluid border border-primary rounded-lg px-0">
                <div class="d-md-flex align-items-center pt-3 px-3 pb-1 bg-primary rounded-top">
                    <div>
                        <h5 class="text-white">Recent Bookings</h5>
                    </div>
                </div>
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
        <div class="col-12 mt-4">
            <div id="recent-parkings" class="container-fluid border border-primary rounded-lg px-0">
                <div class="d-md-flex align-items-center pt-3 px-3 pb-1 bg-primary rounded-top">
                    <div>
                        <h5 class="text-white">Recent Parkings</h5>
                    </div>
                </div>
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
        <div class="col-12 mt-4">
            <div id="recent-topups" class="container-fluid border border-primary rounded-lg px-0">
                <div class="d-md-flex align-items-center pt-3 px-3 pb-1 bg-primary rounded-top">
                    <div>
                        <h5 class="text-white">Recents Top Ups</h5>
                    </div>
                </div>
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
@endsection

@push('css')
    <link rel="stylesheet" href="https://unpkg.com/driver.js/dist/driver.min.css">
@endpush

@push('js')
    <script src="{{ mix('/js/datatable.js') }}"></script>
    <script src="https://unpkg.com/driver.js/dist/driver.min.js"></script>
    <script>
        let options = {
            responsive: true,
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
    @if(!collect(auth()->user()->intros)->contains('menu-intro'))
        <script>
            const menuDriver = new Driver({
                onReset: (Element) => {
                    $.ajax({
                        data: {'intro': 'menu-intro'},
                        method: 'POST',
                        url: '{{ route('intros.store') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                }, 
            });

            // Define the steps for introduction
            menuDriver.defineSteps([
                {
                    element: '#home-menu',
                    popover: {
                        title: 'Home',
                        description: 'Home sweet home',
                        position: 'bottom'
                    }
                },
                {
                    element: '#cars-menu',
                    popover: {
                        title: 'Cars Menu',
                        description: 'Register your car',
                        position: 'bottom'
                    }
                },
                {
                    element: '#booking-menu',
                    popover: {
                        title: 'Booking',
                        description: 'Booking area',
                        position: 'bottom'
                    }
                },
                {
                    element: '#parking-menu',
                    popover: {
                        title: 'Parking',
                        description: 'Use your booked slot',
                        position: 'bottom'
                    }
                },
                {
                    element: '#topup-menu',
                    popover: {
                        title: 'Top Up',
                        description: 'Top up your balance',
                        position: 'bottom'
                    }
                },
                {
                    element: '#notification-menu',
                    popover: {
                        title: 'Notification',
                        description: 'Notification area',
                        position: 'bottom'
                    }
                },
                {
                    element: '#profile-menu',
                    popover: {
                        title: 'Profile Menu',
                        description: 'Change avatar, profile and password',
                        position: 'bottom'
                    }
                },
            ]);

            if($('#sidebar').css('position') == 'relative') {
                @if(collect(auth()->user()->intros)->contains('home-intro'))
                    menuDriver.start();
                @endif
            } else {
                $('#menu').on('click', function() {
                    setTimeout(() => {
                        menuDriver.start();
                    }, 1000);
                });
            }


        </script>
    @endif
    @if(!collect(auth()->user()->intros)->contains('home-intro'))
        <script>

            const homeDriver = new Driver({
                onReset: (Element) => {
                    $.ajax({
                        data: {'intro': 'home-intro'},
                        method: 'POST',
                        url: '{{ route('intros.store') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function () {
                            @if(!collect(auth()->user()->intros)->contains('home-intro'))
                                if($('#sidebar').css('position') == 'relative') {
                                    setTimeout(() => {
                                        menuDriver.start();
                                    }, 1000);
                                }
                            @endif
                        }
                    })
                }, 
            });

            homeDriver.defineSteps([
                {
                    element: '#recent-bookings',
                    popover: {
                        title: 'Recent Bookings',
                        description: 'Your recent bookings history',
                        position: 'bottom'
                    }
                },
                {
                    element: '#recent-parkings',
                    popover: {
                        title: 'Recent Parkings',
                        description: 'Your recent parkings history',
                        position: 'bottom'
                    }
                },
                {
                    element: '#recent-topups',
                    popover: {
                        title: 'Recent Top Ups',
                        description: 'Your recent top ups history',
                        position: 'bottom'
                    }
                },
            ]);
            
            homeDriver.start();
            
        </script>
    @endif
@endpush