@extends('layouts.admin')

@section('content')
@include('partials.header')

<div class="main-content">
    <h2>User Management</h2>
    <p>Here you can view and manage user accounts.</p>

    <!-- Buttons -->
    <div class="mb-3">
        <button class="btn btn-primary mr-2" onclick="handleAdd()">Add User</button>
        <button class="btn btn-success" onclick="handleExportPDF()">Export PDF</button>
    </div>

    <!-- Search Bar with Magnifying Glass -->
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
    </div>

    <!-- DataTable with Search Bar and Pagination -->
    <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Replace with Blade directives to loop through users -->
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>john.doe@example.com</td>
                <td>Admin</td>
                <td>Active</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewUserDetails(1)">View</button>
                    <button class="btn btn-warning btn-sm" onclick="editUser(1)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(1)">Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>jane.smith@example.com</td>
                <td>User</td>
                <td>Inactive</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewUserDetails(2)">View</button>
                    <button class="btn btn-warning btn-sm" onclick="editUser(2)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(2)">Delete</button>
                </td>
            </tr>
            <!-- End of demo data -->
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

@include('partials.footer')

<script>
    // DataTable initialization with search functionality
    $(document).ready(function() {
        var table = $('#usersTable').DataTable({
            "paging": true, // Enable pagination
            "ordering": true, // Enable sorting
            "info": true, // Enable table information
            "searching": true, // Enable search bar
            "order": [], // No initial ordering
            "language": {
                "search": "", // Clear default search text
                "searchPlaceholder": "Search..." // Placeholder for search input
            }
        });

        // Apply search functionality to search input
        $('#searchInput').on('keyup', function() {
            table.search($(this).val()).draw();
        });
    });

    // Functions for buttons
    function handleAdd() {
        // Implement functionality for Add User button
        alert('Add User button clicked');
    }

    function handleExportPDF() {
        // Implement functionality for Export PDF button
        alert('Export PDF button clicked');
    }

    function viewUserDetails(userId) {
        // Implement functionality to view user details
        alert('View details for User ID ' + userId);
    }

    function editUser(userId) {
        // Implement functionality to edit user
        alert('Edit User ID ' + userId);
    }

    function deleteUser(userId) {
        // Implement functionality to delete user
        alert('Delete User ID ' + userId);
    }
</script>
@endsection
