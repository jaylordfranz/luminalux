$(document).ready(function () {
    $('#productsTable').DataTable({
        ajax: {
            url: "/api/products",
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Product',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#productForm").trigger("reset");
                    $('#productModal').modal('show');
                    $('#productUpdate').hide();
                    $('#productImage').remove();
                }
            }
        ],
        columns: [
            { data: 'id' },
            {
                data: 'category.name', // Assuming the category relationship is loaded
                title: 'Category'
            },
            { data: 'name' },
            { data: 'description' },
            { data: 'price' },
            { data: 'stock_quantity' },
            {
                data: null,
                render: function (data, type, row) {
                    // Assuming 'images' is stored as JSON and contains image paths
                    if (data.images && data.images.length > 0) {
                        return '<img src="' + data.images[0] + '" width="50" height="60">';
                    } else {
                        return 'No Image';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return '<a href="#" class="editBtn" data-id="' + data.id + '"><i class="fas fa-edit" aria-hidden="true" style="font-size:24px"></i></a>' +
                           '<a href="#" class="deleteBtn" data-id="' + data.id + '"><i class="fas fa-trash-alt" style="font-size:24px; color:red"></i></a>';
                }
            }
        ]
    });

    $("#productSubmit").on('click', function (e) {
        e.preventDefault();
        var formData = new FormData($('#productForm')[0]);

        $.ajax({
            type: "POST",
            url: "/api/products",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#productModal").modal("hide");
                var table = $('#productsTable').DataTable();
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#productsTable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $("#productForm").trigger("reset");
        $('#productModal').modal('show');
        $('#productSubmit').hide();
        $('#productUpdate').show();

        $.ajax({
            type: "GET",
            url: "/api/products/" + id,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#productName').val(data.name);
                $('#productDescription').val(data.description);
                $('#productPrice').val(data.price);
                $('#productStockQuantity').val(data.stock_quantity);
                $('#productCategory').val(data.category_id); // Assuming you have a select dropdown with id #productCategory
                if (data.images && data.images.length > 0) {
                    $('#productForm').append('<img src="' + data.images[0] + '" width="200px" height="200px" id="productImage">');
                }
                $('<input>').attr({ type: 'hidden', id: 'productId', name: 'product_id', value: id }).appendTo('#productForm');
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#productUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#productId').val();
        var formData = new FormData($('#productForm')[0]);
        formData.append("_method", "PUT");

        $.ajax({
            type: "POST",
            url: "/api/products/" + id,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#productModal').modal("hide");
                var table = $('#productsTable').DataTable();
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#productsTable tbody').on('click', 'a.deleteBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var table = $('#productsTable').DataTable();
        var $row = $(this).closest('tr');

        bootbox.confirm({
            message: "Do you want to delete this product?",
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
                        url: "/api/products/" + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            $row.fadeOut(400, function () {
                                table.row($row).remove().draw();
                            });
                            bootbox.alert(data.success);
                        },
                        error: function (error) {
                            console.log(error);
                            bootbox.alert("Error deleting product.");
                        }
                    });
                }
            }
        });
    });
});
