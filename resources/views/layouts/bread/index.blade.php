@extends('layouts.app')

@section('title', $title ?? 'Title')

@section('button')

    @link(['url' => $create])
        Create
    @endlink

@endsection

@section('content')
    <table id="table" class="table" style="width:100%">
        <thead>
            <tr>
                @foreach ($columns as $column)
                    <th> {{ $column['display_name'] }} </th>
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

@push('js')
    <script>
        $('#table').DataTable({
            serverSide: true,
            ajax: "{{ $ajax ?? '#' }}",
            columns: [
                @foreach ($columns as $column)
                    { name: '{{ $column['name'] }}' },
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