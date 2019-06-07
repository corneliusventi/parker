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
    @if((isset($detail['if']) && $detail['if']) || !isset($detail['if']) )
    <tr>
        <th>{{ $detail['name'] }}</th>
        <td>
            @if (isset($detail['link']))
            <a href="{{ $detail['link'] }}" target="_blank">
                {{ $detail['value'] }}
            </a>
            @else
            {{ $detail['value'] }}
            @endif
        </td>
    </tr>
    @endif
    @endforeach
</table>

@endsection