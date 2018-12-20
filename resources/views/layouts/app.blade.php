@extends('layouts.html')

@section('body')
<div class="container-fluid my-container">
    <div class="row my-row">
        <div class="col-sm-2 bg-primary p-1">
            @include('layouts.sidebar')
        </div>
        <div class="col-sm-10 p-4">
            <div class="card">
                <div class="card-header bg-primary text-white"> @yield('title') </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        html, body, .my-container .my-row{
            height: 100vh;
        }
    </style>
@endpush
