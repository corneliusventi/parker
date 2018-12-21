@extends('layouts.html')

@section('title', 'Register')

@section('body')
<div class="container-fluid">
    <div class="d-flex flex-row">
        <div class="background col-md-6 d-md-flex p-4 justify-content-center align-items-center d-none">
            <img src="/image/logo.png" class="img-fluid" alt="logo parker" width="500">
        </div>
        <div class="col-md-6 d-flex flex-column p-4 justify-content-center align-items-center">
            <div class="w-75">
                <h1 class="display-4 text-primary text-center pb-4">Register</h1>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation">
                    </div>
                    <button type="submit" name="login" id="login" class="btn btn-primary btn-block rounded">Register</button>
                </form>

                <div class="mb-4 mt-4 text-center">
                    Already registered? <a href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        body, html, .container-fluid, .d-flex {
            height: 100%;
        }

        .background {
            position: relative;
        }
        .background::after {
            content: "";
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: -1;
            position: absolute;
            background-image: url('/image/parking-lot.png');
            background-position: center;
            background-size: 90%;
            opacity: 0.15;
            background-repeat: no-repeat;
        }
    </style>
@endpush
