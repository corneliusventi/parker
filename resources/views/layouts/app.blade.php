@extends('layouts.html')

@section('body')
<div class="container-fluid my-container">
    <div class="row my-row">
        <div class="col-12 col-md-3 col-lg-2 bg-primary p-1">
            @include('layouts.sidebar')
        </div>
        <div class="col-12 col-md-9 col-lg-10 p-4">
            <div class="card">
                <div class="card-header bg-primary text-white font-weight-bold"> @yield('title') </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

@yield('modal')

@endsection

@push('css')
    <style>
        @media (min-width: 768px) {
            html, body, .my-container .my-row{
                height: 100vh;
            }
        }
    </style>
@endpush
