@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<div class="row">
    <div class="col-12">
        <div id="notification-table" class="container-fluid border border-primary rounded-lg px-0">
            <div class="d-md-flex align-items-center justify-content-between py-3 px-3 pb-1 bg-primary rounded-top">
                <div>
                    <h5 class="text-white">Recents Notifications</h5>
                </div>
                <div>
                    <a href="{{ route('notifications.read-all') }}" id="read-btn" class="btn btn-primary p-1" title="Mark All as Read"><i data-feather="book-open"></i></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="notifications-table">
                    <thead>
                        <tr>
                            <th class="border-top-0">Notification</th>
                            <th class="border-top-0">Read / Unread</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                        <tr>
                            <td>
                                @if ($notification->type == 'App\Notifications\TopUpApproval')
                                    {{ 'Top Up with amount '.$notification->data['amount'].' has been '.$notification->data['status'] }}
                                @endif
                                @if ($notification->type == 'App\Notifications\BookingExpired')
                                    {{ 'Booking at '.$notification->data['parking_lot'].' has been expired' }}
                                @endif
                                @if ($notification->type == 'App\Notifications\ParkingExpired')
                                    {{ 'Parking at ' . $notification->data['parking_lot'] . ' expired in ' . $notification->data['diff']}}
                                @endif
                            </td>
                            <td>
                                @if ($notification->read())
                                    <form action="{{ route('notifications.unread', $notification->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary" title="Mark as Unread"><i data-feather="book"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button tkype="submit" class="btn btn-primary" title="Mark as Read"><i data-feather="book-open"></i></button>
                                    </form>
                                @endif
                            </td>
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
        $('#notifications-table').DataTable(options);
</script>
@endpush

@if(!collect(auth()->user()->intros)->contains('notification-intro'))
    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/driver.js/dist/driver.min.css">
    @endpush

    @push('js')
        <script src="https://unpkg.com/driver.js/dist/driver.min.js"></script>
            <script>
                const notificationDriver = new Driver({
                    onReset: (Element) => {
                        $.ajax({
                            data: {'intro': 'notification-intro'},
                            method: 'POST',
                            url: '{{ route('intros.store') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                    }, 
                });

                // Define the steps for introduction
                notificationDriver.defineSteps([
                    {
                        element: '#notification-table',
                        popover: {
                            title: 'Notifcations',
                            description: 'Your new notifications',
                            position: 'auto'
                        }
                    },
                    {
                        element: '#read-btn',
                        popover: {
                            title: 'Read All',
                            description: 'Mark as read all',
                            position: 'auto'
                        }
                    },
                ]);

                setTimeout(() => {
                    notificationDriver.start();
                }, 1000);

            </script>
    @endpush
@endif