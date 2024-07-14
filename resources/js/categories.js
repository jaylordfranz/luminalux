$(document).ready(function() {
    // Initialize DataTable
    var table = $('#categoriesTable').DataTable({
        ajax: {
            url: "/api/categories", // Ensure this endpoint is correct
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Category',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#categoryForm").trigger("reset");
                    $('#categoryModal').modal('show');
                    $('#categoryUpdate').hide();
                    $('#categoryImage').remove();
                }
            }
        ],
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'description' },
            {
                data: null,
                render: function (data, type, row) {
                    return '<a href="#" class="editBtn" data-id="' + data.id + '"><i class="fas fa-edit" aria-hidden="true" style="font-size:24px"></i></a>' +
                           ' <a href="#" class="deleteBtn" data-id="' + data.id + '"><i class="fas fa-trash-alt" style="font-size:24px; color:red"></i></a>';
                }
            }
        ],
        columnDefs: [
            { targets: [0, 1, 2], orderable: true },
            { targets: [3], orderable: false, searchable: false }
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
                table.ajax.reload(); // Reload DataTable after adding new data
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
                table.ajax.reload(); // Reload DataTable after editing data
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });

    // Handle Delete Category
    $('#categoriesTable').on('click', '.deleteBtn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: '/api/categories/' + id,
                method: 'DELETE',
                success: function(response) {
                    table.ajax.reload(); // Reload DataTable after deleting data
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
    });

    // Handle Edit Button Click
    $('#categoriesTable').on('click', '.editBtn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: '/api/categories/' + id,
            method: 'GET',
            success: function(data) {
                $('#editCategoryId').val(data.id);
                $('#editName').val(data.name);
                $('#editDescription').val(data.description);
                $('#editCategoryModal').modal('show');
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });
});
