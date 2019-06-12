@extends('layouts.html')

@section('body')
<div class="container-fluid my-container">
    <div class="row my-row position-relative">
        <div id="sidebar" class="col-auto bg-primary p-4 d-md-block">
            @include('layouts.sidebar')
        </div>
        <div class="content col p-4">
            <div class="row">
                <div class="col">
                    <h1 class="h1 text-primary">
                        <span id="menu"></span>
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
        <div id="backdrop" class="bg-secondary d-md-none"></div>
    </div>
</div>
@yield('modal')

@endsection

@push('css')
    <style>
        html, body, .my-container, .my-row{
            height: 100%;
        }
        @media (min-width: 768px) {
            #sidebar {
                position: relative !important;
                left: 0% !important;
                width: auto;
                height: auto !important;
                overflow-y: unset;
            }

        }
        #sidebar {
            overflow-y: auto;
            width: 200px;
            height: 100%;
            left: -200px;
            z-index: 3;
            position: fixed;
            transition: all 1s;
        }
        #sidebar.active {
            left: 0px;
            opacity: 1;
        }
        #backdrop {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            z-index: 2;
            opacity: 0.5;
        }
    </style>
@endpush

@push('js')
    <script>
        let menuIcon = feather.icons.menu.toSvg({ class: 'd-md-none' });
        let menu = $('#menu');
        let sidebar = $('#sidebar');
        let backdrop = $('#backdrop');
        menu.append(menuIcon);
        menu.click(() => {
            sidebar.toggleClass('active');
            backdrop.fadeIn();
        });
        backdrop.click(() => {
            sidebar.toggleClass('active');
            backdrop.fadeOut();
        });
    </script>
@endpush
