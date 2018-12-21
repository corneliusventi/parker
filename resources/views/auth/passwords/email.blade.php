@extends('layouts.html')

@section('title', 'Forgot Password')

@section('body')
<div class="container-fluid">
    <div class="d-flex flex-row">
        <div class="background col-md-6 d-none d-md-flex p-4 justify-content-center align-items-center">
            <img src="/image/logo.png" class="img-fluid" alt="logo parker" width="500">
        </div>
        <div class="col-md-6 d-flex flex-column p-4 justify-content-center align-items-center">
            <div class="w-75">
                <h1 class="display-4 text-primary text-center pb-4">Forgot Password</h1>

                <form action="#" method="post">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                    <button type="submit" name="reset" id="reset" class="btn btn-primary btn-block rounded">Reset Password</button>
                </form>

                <div class="mb-4 mt-4 text-center">
                    Already reset the password? <a href="{{ route('login') }}">Login</a>
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
