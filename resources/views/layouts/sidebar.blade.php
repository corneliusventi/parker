<div class="container-fluid text-center text-white">
    <div class="row justify-content-center">
        <div class="col-12 d-md-block order-1 order-md-1">
            <h1 class="pt-1">
                <strong>PARKER</strong>
            </h1>
            <h5 class="text-white-50">Parkir Keren</h5>
        </div>
        <div class="col-md-12 d-none d-md-flex justify-content-center order-2 order-md-2 p-4">
            <div class="rounded-circle" style="width: 150px; height: 150px; background-image: url('{{ auth()->user()->avatar }}'); background-size: cover; background-position: center center;"></div>
        </div>
        <div class="col-md-12 d-none d-md-block order-3 order-md-3">
            <h4 class="pt-1">{{ auth()->user()->fullname }}</h4>
        </div>
        <div class="col-12 col-md-12 order-13 order-md-4">
            @if (auth()->user()->isA('superadministrator') || auth()->user()->isAn('administrator'))
                <h6 class="mb-4">{{ auth()->user()->getRoles()->first() }}</h6>
            @else
                <h6 class="mb-4">Rp. {{ number_format(auth()->user()->wallet) }}</h6>
            @endif
        </div>
        <div class="col-4 col-md-12 order-4 order-md-5">
            <a href="{{ route('home') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="home"></i> Home</a>
        </div>
        @can('manage', \App\User::class)
            <div class="col-4 col-md-12 order-5 order-md-6">
                <a href="{{ route('users.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="users"></i> Users</a>
            </div>
        @endcan
        @can('manage', \App\ParkingLot::class)
            <div class="col-4 col-md-12 order-6 order-md-7">
                <a href="{{ route('parking-lots.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="flag"></i> Parking Lots</a>
            </div>
        @endcan
        @can('manage', \App\Slot::class)
            <div class="col-4 col-md-12 order-7 order-md-8">
                <a href="{{ route('slots.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="grid"></i> Slots</a>
            </div>
        @endcan
        @can('manage', \App\Car::class)
            <div class="col-4 col-md-12 order-7 order-md-8">
                <a href="{{ route('cars.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="truck"></i> Cars</a>
            </div>
        @endcan
        @can('manage', \App\TopUp::class)
            <div class="col-4 col-md-12 order-7 order-md-8">
                <a href="{{ route('top-ups.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="dollar-sign"></i> Top Ups</a>
            </div>
        @endcan
        @can('manage', \App\Booking::class)
            <div class="col-4 col-md-12 order-7 order-md-8">
                <a href="{{ route('bookings.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="book-open"></i> Bookings</a>
            </div>
        @endcan
        @can('manage', \App\Parking::class)
            <div class="col-4 col-md-12 order-7 order-md-8">
                <a href="{{ route('parkings.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="map-pin"></i> Parkings</a>
            </div>
        @endcan
        @can('booking')
            <div class="col-4 col-md-12 order-8 order-md-9">
                <a href="{{ route('booking.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="book-open"></i> Booking</a>
            </div>
        @endcan
        @can('parking')
            <div class="col-4 col-md-12 order-9 order-md-10">
                <a href="{{ route('parking.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="map-pin"></i> Parking</a>
            </div>
        @endcan
        @can('topup')
            <div class="col-4 col-md-12 order-10 order-md-11">
                <a href="{{ route('top-up.index') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="dollar-sign"></i> Top Up</a>
            </div>
        @endcan
        @can('change-profile')
            <div class="col-4 col-md-12 order-11 order-md-12">
                <a href="{{ route('profile') }}" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="user"></i> Profile</a>
            </div>
        @endcan
        <div class="col-4 col-md-12 order-12 order-md-13">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary text-md-left pl-md-5 btn-big btn-block"><i data-feather="log-out"></i> Logout</button>
            </form>
        </div>
    </div>
</div>

@push('css')
    <style>
        .photo-profile {
            width: 150px;
            height: 150px;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
        }

        .photo-profile img {
            display: inline;
            margin: 0 auto;
            height: 100%;
            width: auto;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace({
            class: 'd-none d-md-inline align-middle mr-1',
            width: '22',
            height: '22',
        })
    </script>
@endpush
