@extends('layouts.html')

@section('body')
<div class="container-fluid my-container">
    <div class="row my-row">
        <div class="col-12 col-md-3 col-lg-2 bg-primary p-1">
            @include('layouts.sidebar')
        </div>
        <div class="content col-12 col-md-9 col-lg-10 p-4">
            <div class="row">
                <div class="col">
                    <h1 class="h1 text-primary">
                        @yield('title')
                    </h1>
                </div>
                <div class="col-auto">
                    @yield('buttons')
                    @yield('button')
                </div>
            </div>
            @hasSection ('content')
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            @else
                <ul class="list-group list-group-flush">
                    @yield('list')
                </ul>
            @endif
        </div>
    </div>
</div>

@yield('modal')

@endsection

@push('css')
    <style>
        @media (min-width: 768px) {
            html, body, .my-container, .my-row{
                height: 100%;
            }
            .content {
                overflow-y: auto;
            }
        }
    </style>
@endpush
