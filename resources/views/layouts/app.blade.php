@extends('layouts.html')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2 bg-primary p-1">
            @include('layouts.sidebar')
        </div>
        <div class="col-sm-2 p-5">
            @yield('content')
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        html, body, .container-fluid, .row {
            height: 100vh;
        }
    </style>
@endpush
