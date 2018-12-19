@extends('layouts.html')

@section('title', 'Welcome')

@section('body')
    <div class="container d-flex flex-column p-4 justify-content-center align-items-center">
        <img src="/image/logo.png" class="img-fluid" alt="logo parker" width="500">
        <a class="btn btn-primary btn-lg" href="{{ route('login') }}">Login</a>
    </div>
@endsection

@push('css')
    <style>
        body, html, .container, .d-flex {
            height: 100%;
        }

        .container {
            position: relative;
        }
        .container::after {
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
