@extends('layouts.app')

@section('title', $title ?? 'Title')

@section('button')

    @isset($create)
        @link(['url' => $create])
            Create
        @endlink
    @endisset

@endsection

@section('content')
    <table id="table" class="table" style="width:100%">
        <thead>
            <tr>
                @foreach ($columns as $column)
                    @if((isset($column['if']) && $column['if']) || !isset($column['if']) )
                        <th> {{ $column['display_name'] }} </th>
                    @endif
                @endforeach
            </tr>
        </thead>
    </table>
@endsection

@section('modal')

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Comfirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" action="#" method="POST">
                    @csrf
                    @method('Delete')
                    <div class="modal-body">
                        Are you sure you want to delete?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ mix('/css/datatable.css') }}">
@endpush

@push('js')
    <script src="{{ mix('/js/datatable.js') }}"></script>
    <script>
        $('#table').DataTable({
            serverSide: true,
            ajax: "{{ $ajax ?? '#' }}",
            columns: [
                @foreach ($columns as $column)
                    @if((isset($column['if']) && $column['if']) || !isset($column['if']) )
                        { name: '{{ $column['name'] }}' },
                    @endif
                @endforeach
            ],
            drawCallback: function() {
                feather.replace({
                    width: '16',
                    height: '16',
                })
            }
        });

         $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var url = button.data('url');
            var modal = $(this);
            modal.find('#deleteForm').attr('action', url);
        })
    </script>
@endpush
