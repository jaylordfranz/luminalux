$(document).ready(function () {
    // Fetch and display products
    $.ajax({
        type: "GET",
        url: "/api/products",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                var img = "<img src='" + value.images + "' width='50px' height='50px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(value.product_name));
                tr.append($("<td>").html(value.brand.brand_name));
                tr.append($("<td>").html(value.product_type));
                tr.append($("<td>").html(`₱${value.price.toFixed(2)}`));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(value.stock));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#productModal' class='editbtn' data-id=" + value.id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td><a href='#' class='deletebtn' data-id=" + value.id + "><i class='fa fa-trash' style='font-size:24px; color:red'></a></i></td>");
                $("#pbody").append(tr);
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("Error loading data");
        }
    });

    // Create new product
    $('#productSubmit').on('click', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '/products',  // Replace with your actual route URL for storing products
            type: 'POST',
            data: $('#pform').serialize(),  // Serialize the form data
            dataType: 'json',
            success: function(response) {
                // Handle success response
                console.log(response);
                // Optionally, close the modal or clear the form
                $('#productModal').modal('hide');
                $('#pform')[0].reset();  // Reset the form
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error:', error);
            }
        });
    });

    // Populate the modal for editing
    $('#productModal').on('show.bs.modal', function (e) {
        $("#pform").trigger("reset");
        $('#productId').remove();
        $('#image').remove();
        var id = $(e.relatedTarget).attr('data-id');
        if (id) {
            $('<input>').attr({ type: 'hidden', id: 'productId', name: 'product_id', value: id }).appendTo('#pform');
            $.ajax({
                type: "GET",
                url: `/api/products/${id}`,
                success: function (data) {
                    $("#productId").val(data.id);
                    $("#productName").val(data.product_name);
                    $("#brandId").val(data.brand_id);
                    $("#productType").val(data.product_type);
                    $("#price").val(data.price);
                    $("#stock").val(data.stock);
                    $("#pform").append(`<img src="${data.images}" width='50px' height='50px' id="image" />`);
                },
                error: function () {
                    console.log('AJAX load did not work');
                    alert("Error loading data");
                }
            });
        }
    });

    // Update product
    $("#productUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#productId').val();
        var $row = $('tr td > a[data-id="' + id + '"]').closest('tr');
        let formData = new FormData($('#pform')[0]);
        formData.append('_method', 'PUT');
        $.ajax({
            type: "POST",
            url: `/api/products/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $('#productModal').modal('hide');
                $row.remove();
                var img = "<img src='" + data.product.images + "' width='50px' height='50px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(data.product.id));
                tr.append($("<td>").html(data.product.product_name));
                tr.append($("<td>").html(data.product.brand.brand_name));
                tr.append($("<td>").html(data.product.product_type));
                tr.append($("<td>").html(`₱${data.product.price.toFixed(2)}`));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(data.product.stock));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#productModal' class='editbtn' data-id=" + data.product.id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td><a href='#' class='deletebtn' data-id=" + data.product.id + "><i class='fa fa-trash' style='font-size:24px; color:red'></a></i></td>");
                $('#pbody').prepend(tr.hide().fadeIn(5000));
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Delete product
    $('#ptable tbody').on('click', 'a.deletebtn', function (e) {
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        e.preventDefault();
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
                if (result)
                    $.ajax({
                        type: "DELETE",
                        url: `/api/products/${id}`,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            $row.fadeOut(4000, function () {
                                $row.remove();
                            });
                            bootbox.alert(data.message);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
            }
        });
    });
});