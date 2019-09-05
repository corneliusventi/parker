@extends('layouts.bread.index', [
    'mode' => 'simple',
    'title' => 'Cars',
    'columns' => [
        [
            'name' => 'plate',
            'display_name' => 'Plate',
        ],
        [
            'name' => 'brand',
            'display_name' => 'Brand',
        ],
        [
            'name' => 'action',
            'display_name' => 'Action',
        ],
    ],
    'ajax' => route('cars.index'),
    'create' => route('cars.create'),
])

@if(!collect(auth()->user()->intros)->contains('car-intro'))
    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/driver.js/dist/driver.min.css">
    @endpush

    @push('js')
        <script src="https://unpkg.com/driver.js/dist/driver.min.js"></script>
            <script>
                const carDriver = new Driver({
                    onReset: (Element) => {
                        $.ajax({
                            data: {'intro': 'car-intro'},
                            method: 'POST',
                            url: '{{ route('intros.store') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                    }, 
                });

                // Define the steps for introduction
                carDriver.defineSteps([
                    {
                        element: '#table-area',
                        popover: {
                            title: 'List Cars',
                            description: 'List of your cars',
                            position: 'bottom'
                        }
                    },
                    {
                        element: '#create-btn',
                        popover: {
                            title: 'Create Car',
                            description: 'Register your car',
                            position: 'auto'
                        }
                    },
                ]);

                setTimeout(() => {
                    carDriver.start();
                }, 1000);

            </script>
    @endpush
@endif