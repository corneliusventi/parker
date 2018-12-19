@extends('layouts.html')

@section('title', 'Login')

@section('body')
<div class="container-fluid">
    <div class="d-flex flex-row">
        <div class="background col-md-6 d-flex p-4 justify-content-center align-items-center">
            <img src="/image/logo.png" class="img-fluid" alt="logo parker" width="500">
        </div>
        <div class="col-md-6 d-flex flex-column p-4 justify-content-center align-items-center">
            <div class="w-50">
                <h1 class="display-4 text-primary text-center pb-4">Login</h1>

                <form action="#" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <button type="submit" name="login" id="login" class="btn btn-primary btn-block rounded">Login</button>
                    <div class="mb-4 mt-4 text-center">
                        <a href="{{ route('forgot-password') }}">Forgot your password?</a>
                    </div>
                </form>

                <div class="mb-4 mt-4 text-center">
                    Not registered? <a href="{{ route('register') }}">Register</a>
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
