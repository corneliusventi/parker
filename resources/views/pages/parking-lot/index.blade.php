@extends('layouts.app')

@section('title', 'Parking Lots')
@section('buttons')
    <a href="{{ route('parking-lot.create') }}" class="btn btn-primary">Create</a>
@endsection

@section('content')
    <table id="user-table" class="table" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Address</th>
                <th>Action</th>
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
        $('#user-table').DataTable({
            serverSide: true,
            ajax: "{{ route('parking-lot.index') }}",
            columns: [
                { name: 'id' },
                { name: 'name' },
                { name: 'type' },
                { name: 'address' },
                { name: 'action' },
                // { name: 'role.name', orderable: false },
                // { name: 'action', orderable: false, searchable: false }
            ],
            drawCallback: function() {
                feather.replace({
                    width: '16',
                    height: '16', 
                })
            }
        });

         $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('parkinglot') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#deleteForm').attr('action', '{{ route('parking-lot.index') }}' + '/' + id)
        })
    </script>
@endpush
