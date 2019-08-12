@extends('layouts.app')

@section('title', $title ?? 'Create')

@section('buttons')

    @link(['url' => $back])
        Back
    @endlink

@endsection

@section('content')

    @form(['action' => $store, 'method' => 'POST', 'enctype' => $enctype ?? null ])

        @yield('form')

        @button(['type' => 'submit', 'class' => 'btn-block'])
            Create
        @endbutton

    @endform

@endsection
