@extends('layouts.app')

@section('title', $title ?? 'Show')

@section('buttons')

    @link(['url' => $back])
        Back
    @endlink

@endsection

@section('content')

    <table class="table">
        @foreach ($details as $detail)

            <tr>
                <th>{{ $detail['name'] }}</th>
                <td>{{ $detail['value'] }}</td>
            </tr>

        @endforeach
    </table>

@endsection
