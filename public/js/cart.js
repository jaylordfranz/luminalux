$(document).ready(function () {
    function initializeDataTable() {
        $('#cartTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/cart",
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
                    text: 'Add to Cart',
                    className: 'btn btn-primary',
                    action: function () {
                        $("#cartForm").trigger("reset");
                        $('#cartModal').modal('show');
                        $('#cartUpdate').hide();
                        $('#cartProduct').remove();
                    }
                }
            ],
            columns: [
                { data: 'id' },
                {
                    data: null,
                    render: function (data) {
                        if (data.product && data.product.image) {
                            return '<img src="' + data.product.image + '" width="50" height="60">';
                        } else {
                            return 'No Image';
                        }
                    }
                },
                { data: 'product.name' },
                { data: 'quantity' },
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

    function handleCartSubmit() {
        $("#cartSubmit").on('click', function (e) {
            e.preventDefault();
            var formData = new FormData($('#cartForm')[0]);

            $.ajax({
                type: "POST",
                url: "/api/cart",
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function () {
                    $("#cartModal").modal("hide");
                    var table = $('#cartTable').DataTable();
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCartUpdate() {
        $("#cartUpdate").on('click', function (e) {
            e.preventDefault();
            var id = $('#cartId').val();
            var formData = new FormData($('#cartForm')[0]);
            formData.append("_method", "PUT");

            $.ajax({
                type: "POST",
                url: "/api/cart/" + id,
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function () {
                    $('#cartModal').modal("hide");
                    var table = $('#cartTable').DataTable();
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCartEdit() {
        $('#cartTable tbody').on('click', 'a.editBtn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $("#cartForm").trigger("reset");
            $('#cartModal').modal('show');
            $('#cartSubmit').hide();
            $('#cartUpdate').show();

            $.ajax({
                type: "GET",
                url: "/api/cart/" + id,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function (data) {
                    $('#cartQuantity').val(data.quantity);
                    if (data.product && data.product.image) {
                        $('#cartForm').append('<img src="' + data.product.image + '" width="200px" height="200px" id="cartProduct">');
                    }
                    $('<input>').attr({ type: 'hidden', id: 'cartId', name: 'cart_id', value: id }).appendTo('#cartForm');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCartDelete() {
        $('#cartTable tbody').on('click', 'a.deleteBtn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var table = $('#cartTable').DataTable();
            var $row = $(this).closest('tr');
    
            bootbox.confirm({
                message: "Do you want to delete this item from the cart?",
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
                            url: "/api/cart/" + id,
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
                                bootbox.alert("Error deleting item from cart.");
                            }
                        });                        
                    }
                }
            });
        });
    }
    
    initializeDataTable();
    handleCartSubmit();
    handleCartUpdate();
    handleCartEdit();
    handleCartDelete();
});
