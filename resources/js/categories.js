$(document).ready(function() {
    // Initialize DataTable
    var table = $('#categoriesTable').DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "searching": true,
        "order": [],
        "language": {
            "search": "",
            "searchPlaceholder": "Search..."
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Categories'
            },
            {
                extend: 'pdfHtml5',
                title: 'Categories'
            }
        ]
    });

    // Handle Add Category Form Submission
    $('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#addCategoryModal').modal('hide');
                window.location.href = '/categories'; // Redirect to index.blade.php
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });

    // Handle Edit Category Form Submission
    $('#editCategoryForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action').replace(':id', $('#editCategoryId').val());
        $.ajax({
            url: url,
            method: 'PUT',
            data: form.serialize(),
            success: function(response) {
                $('#editCategoryModal').modal('hide');
                window.location.href = '/categories'; // Redirect to index.blade.php
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });

    // Handle Delete Category
    $('#categoriesTable').on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: url,
                method: 'DELETE',
                data: form.serialize(),
                success: function(response) {
                    window.location.href = '/categories'; // Redirect to index.blade.php
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
    });
});
