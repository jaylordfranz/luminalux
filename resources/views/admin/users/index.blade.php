@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <h2>Manage Users</h2>

        <div class="mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
        </div>

        <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->status }}</td>
                        <td>
                            <a href="{{ route('users.show', $customer->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('users.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.users.destroy', $customer->id) }}" method="POST" class="delete-form" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
</form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $customers->links() }}
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
            });
        });
    </script>
@endsection
