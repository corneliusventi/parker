@extends('layouts.bread.create', [
    'title' => 'Create Slot',
    'back' => route('slots.index'),
    'store' => route('slots.store'),
])

@section('form')

    @input([
        'name' => 'code',
        'value' => $code ?? '',
        'readonly' => true,
    ])
        Code
    @endinput

    @if ($parkingLot->type == 'building')
        @input([
            'type' => 'number',
            'min' => 1,
            'name' => 'level',
            'required' => true,
            'value' => 1,
        ])
            Level
        @endinput

        @push('js')
            <script>
                $('#level').on('change', function (event) {
                    let level = $('#level').val();
                    let data = {
                        level: level,
                    }

                    $.ajax({
                        data: data,
                        method: 'GET',
                        url: '{{ route('slots.code') }}',
                        success: function (response) {
                            let code = response.code;
                            $('#code').val(code);
                        }
                    })
                })
            </script>
        @endpush
    @endif

@endsection
