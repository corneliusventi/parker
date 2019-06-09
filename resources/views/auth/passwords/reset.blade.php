@extends('layouts.html')

@section('title', 'Reset Password')

@section('body')
<div class="container-fluid">
    <div class="d-flex flex-row">
        <div class="background col-md-6 d-none d-md-flex p-4 justify-content-center align-items-center">
            <img src="/image/logo.png" class="img-fluid" alt="logo parker" width="500">
        </div>
        <div class="col-md-6 d-flex flex-column p-4 justify-content-center align-items-center">
            <div class="w-75">
                <h1 class="display-4 text-primary text-center pb-4">Forgot Password</h1>
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form action="{{ route('password.update') }}" method="post">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                            value="{{ $email ?? old('email') }}" required autofocus>
                        @if($errors->first('email'))
                        <small class="form-text text-danger">
                            {{ $errors->first('email') }}
                        </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                            required>
                        @if($errors->first('password'))
                        <small class="form-text text-danger">
                            {{ $errors->first('password') }}
                        </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation" placeholder="Password" required>
                    </div>
                    <button type="submit" name="reset" id="reset" class="btn btn-primary btn-block rounded">Reset
                        Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    body,
    html,
    .container-fluid,
    .d-flex {
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