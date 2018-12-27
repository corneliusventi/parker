@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <table id="user-table" class="table" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fullname</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
        </thead>
    </table>
@endsection

@push('js')
    <script>
        $('#user-table').DataTable({
            serverSide: true,
            ajax: "{{ route('user.index') }}",
            columns: [
                { name: 'id' },
                { name: 'fullname' },
                { name: 'username' },
                { name: 'email' },
                // { name: 'role.name', orderable: false },
                // { name: 'action', orderable: false, searchable: false }
            ],
        });
    </script>
@endpush
