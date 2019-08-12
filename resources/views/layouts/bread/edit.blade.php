@extends('layouts.app')

@section('title', $title ?? 'Edit')

@section('buttons')

    @link(['url' => $back])
        Back
    @endlink

@endsection

@section('content')

    @form(['action' => $update, 'method' => 'PUT', 'enctype' => $enctype ?? null])

        @yield('form')

        @button(['type' => 'submit', 'class' => 'btn-block'])
            Update
        @endbutton

    @endform

@endsection
