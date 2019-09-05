<div class="text-center text-white">
    <div>
        <h1 class="pt-1">
            <strong>PARKER</strong>
        </h1>
        <h5 class="text-white-50">Parkir Keren</h5>
    </div>
    <div class="d-flex justify-content-center">
        <div class="rounded-circle avatar"></div>
    </div>
    <div>
        <h4 class="pt-1">{{ auth()->user()->fullname }}</h4>
    </div>
    <div>
        @if (auth()->user()->isA('user'))
            <h6 class="mb-4">Rp. {{ number_format(auth()->user()->wallet) }}</h6>
        @else
            <h6 class="mb-4">{{ auth()->user()->getRoles()->first() }}</h6>
        @endif
    </div>
    <div id="home-menu">
        <a href="{{ route('home') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="home"></i> Home</a>
    </div>
    @can('manage', \App\User::class)
        <div id="users-menu">
            <a href="{{ route('users.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="users"></i> Users</a>
        </div>
    @endcan
    @can('manage', \App\ParkingLot::class)
        <div id="parkingLots-menu">
            <a href="{{ route('parking-lots.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="flag"></i> Parking Lots</a>
        </div>
    @endcan
    @can('manage', \App\Slot::class)
        <div id="slots-menu">
            <a href="{{ route('slots.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="grid"></i> Slots</a>
        </div>
    @endcan
    @can('manage', \App\Car::class)
        <div id="cars-menu">
            <a href="{{ route('cars.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="truck"></i> Cars</a>
        </div>
    @endcan
    @can('manage', \App\TopUp::class)
        <div id="topups-menu"> 
            <a href="{{ route('top-ups.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="dollar-sign"></i> Top Ups</a>
        </div>
    @endcan
    @can('manage', \App\Booking::class)
        <div id="bookings-menu">
            <a href="{{ route('bookings.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="book-open"></i> Bookings</a>
        </div>
    @endcan
    @can('manage', \App\Parking::class)
        <div id="parkings-menu">
            <a href="{{ route('parkings.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="map-pin"></i> Parkings</a>
        </div>
    @endcan
    @can('booking')
        <div id="booking-menu">
            <a href="{{ route('booking.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="book-open"></i> Booking</a>
        </div>
    @endcan
    @can('parking')
        <div id="parking-menu">
            <a href="{{ route('parking.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="map-pin"></i> Parking</a>
        </div>
    @endcan
    @can('topup')
        <div id="topup-menu">
            <a href="{{ route('top-up.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="dollar-sign"></i> Top Up</a>
        </div>
    @endcan
    @can('notifications')
    <div id="notification-menu">
        <a href="{{ route('notifications.index') }}" class="btn btn-primary text-left p-auto btn-big btn-block">
            <i data-feather="bell"></i> Notifications
            @if (!blank(auth()->user()->unreadNotifications))
                <span class="badge badge-light">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </a>
    </div>
    @endcan
    @can('change-profile')
        <div id="profile-menu">
            <a href="{{ route('profile') }}" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="user"></i> Profile</a>
        </div>
    @endcan
    <div id="logout-menu">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary text-left p-auto btn-big btn-block"><i data-feather="log-out"></i> Logout</button>
        </form>
    </div>
</div>
<div id="close" class="mt-4 text-center d-md-none text-white"></div>

@push('css')
    <style>
        .avatar {
            width: 100px;
            height: 100px;
            background-image: url('{{ auth()->user()->avatar }}');
            background-size: cover;
            background-position: center center;
        }
        @media (min-width: 768px) {
            .avatar {
                width: 150px;
                height: 150px;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        feather.replace({
            width: '22',
            height: '22',
        })
        let closeIcon = feather.icons.x.toSvg();
        let close = $('#close');
        close.append(closeIcon);
        close.click(() => {
            sidebar.toggleClass('active');
            backdrop.fadeOut();
            content.show();
        });
    </script>
@endpush
