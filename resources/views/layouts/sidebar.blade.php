<div class="container-fluid text-center text-white">
    <div class="row justify-content-center">
        <div class="col-md-12 d-none d-md-block order-1 order-md-1 p-4">
            <img class="img-fluid rounded-circle" src="/image/profile.jpg" alt="">
        </div>
        <div class="col-md-12 d-none d-md-block order-2 order-md-2">
            <h2 class="pt-1">Cornelius Venti</h2>
        </div>
        <div class="col-12 col-md-12 order-8 order-md-3">
            <h4>Rp. {{ number_format(auth()->user()->wallet) }}</h4>
        </div>
        <div class="col col-md-12 order-3 order-md-4">
            <a href="{{ route('home') }}" class="btn btn-primary btn-big btn-block">Home</a>
        </div>
        <div class="col col-md-12 order-4 order-md-5">
            <a href="{{ route('booking.index') }}" class="btn btn-primary btn-big btn-block">Booking</a>
        </div>
        <div class="col col-md-12 order-4 order-md-5">
            <a href="{{ route('parking.index') }}" class="btn btn-primary btn-big btn-block">Parking</a>
        </div>
        <div class="col col-md-12 order-5 order-md-6">
            <a href="{{ route('topup') }}" class="btn btn-primary btn-big btn-block">Top Up</a>
        </div>
        <div class="col col-md-12 order-6 order-md-7">
            <a href="{{ route('profile') }}" class="btn btn-primary btn-big btn-block">Profile</a>
        </div>
        <div class="col col-md-12 order-7 order-md-8">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary btn-big btn-block">Logout</button>
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
