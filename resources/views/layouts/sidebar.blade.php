<div class="d-flex justify-content-center pt-4 pb-2">
    <div class="photo-profile">
        <img src="/image/profile.jpg" alt="">
    </div>
</div>

<div class="w-100 text-center text-white">
    <h2 class="p-1 pb-4">Cornelius Venti</h2>
    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-big btn-block">Dashboard</a>
    <a href="{{ route('booking') }}" class="btn btn-primary btn-big btn-block">Booking</a>
    <a href="{{ route('topup') }}" class="btn btn-primary btn-big btn-block">Top Up</a>
    <a href="{{ route('profile') }}" class="btn btn-primary btn-big btn-block">Profile</a>
    <a href="{{ route('about') }}" class="btn btn-primary btn-big btn-block">About</a>
    <a href="{{ route('login') }}" class="btn btn-primary btn-big btn-block">Logout</a>
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
