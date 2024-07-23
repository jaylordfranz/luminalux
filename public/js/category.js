$(document).ready(function () {
    function initializeDataTable() {
        $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/categories",
                type: "GET",
                data: function (d) {
                    // Add any additional parameters to the request if needed
                    return $.extend({}, d, {
                        // Example of additional parameters
                        start: d.start,
                        length: d.length
                    });
                }
            },
            dom: 'Bfrtip',
            buttons: [
                'pdf',
                'excel',
                {
                    text: 'Add Category',
                    className: 'btn btn-primary',
                    action: function () {
                        $("#categoryForm").trigger("reset");
                        $('#categoryModal').modal('show');
                        $('#categoryUpdate').hide();
                        $('#categoryImage').remove();
                    }
                }
            ],
            columns: [
                { data: 'id' },
                {
                    data: null,
                    render: function (data) {
                        if (data.images && data.images.length > 0) {
                            return '<img src="' + data.images[0] + '" width="50" height="60">';
                        } else {
                            return 'No Image';
                        }
                    }
                },
                { data: 'name' },
                { data: 'description' },
                {
                    data: null,
                    render: function (data) {
                        return '<a href="#" class="editBtn" data-id="' + data.id + '"><i class="fas fa-edit" aria-hidden="true" style="font-size:24px"></i></a>' +
                               '<a href="#" class="deleteBtn" data-id="' + data.id + '"><i class="fas fa-trash-alt" style="font-size:24px; color:red"></i></a>';
                    }
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search..."
            }
        });
    }

    function handleCategorySubmit() {
        $("#categorySubmit").on('click', function (e) {
            e.preventDefault();
            var formData = new FormData($('#categoryForm')[0]);

            $.ajax({
                type: "POST",
                url: "/api/categories",
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function () {
                    $("#categoryModal").modal("hide");
                    var table = $('#categoriesTable').DataTable();
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCategoryUpdate() {
        $("#categoryUpdate").on('click', function (e) {
            e.preventDefault();
            var id = $('#categoryId').val();
            var formData = new FormData($('#categoryForm')[0]);
            formData.append("_method", "PUT");

            $.ajax({
                type: "POST",
                url: "/api/categories/" + id,
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function () {
                    $('#categoryModal').modal("hide");
                    var table = $('#categoriesTable').DataTable();
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCategoryEdit() {
        $('#categoriesTable tbody').on('click', 'a.editBtn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $("#categoryForm").trigger("reset");
            $('#categoryModal').modal('show');
            $('#categorySubmit').hide();
            $('#categoryUpdate').show();

            $.ajax({
                type: "GET",
                url: "/api/categories/" + id,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function (data) {
                    $('#categoryName').val(data.name);
                    $('#categoryDescription').val(data.description);
                    if (data.images && data.images.length > 0) {
                        $('#categoryForm').append('<img src="' + data.images[0] + '" width="200px" height="200px" id="categoryImage">');
                    }
                    $('<input>').attr({ type: 'hidden', id: 'categoryId', name: 'category_id', value: id }).appendTo('#categoryForm');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCategoryDelete() {
        $('#categoriesTable tbody').on('click', 'a.deleteBtn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var table = $('#categoriesTable').DataTable();
            var $row = $(this).closest('tr');
    
            bootbox.confirm({
                message: "Do you want to delete this category?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            type: "DELETE",
                            url: "/api/categories/" + id,
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            dataType: "json",
                            success: function (data) {
                                // Handle success
                                $row.fadeOut(400, function () {
                                    table.row($row).remove().draw();
                                });
                                bootbox.alert(data.message);
                            },
                            error: function (error) {
                                // Handle error
                                bootbox.alert("Error deleting category.");
                            }
                        });                        
                    }
                }
            });
        });
    }
    
    initializeDataTable();
    handleCategorySubmit();
    handleCategoryUpdate();
    handleCategoryEdit();
    handleCategoryDelete();
});
