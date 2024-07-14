$(document).ready(function () {
    $('#inventoriesTable').DataTable({
        ajax: {
            url: "/api/inventories",
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Inventory',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#inventoryForm").trigger("reset");
                    $('#inventoryModal').modal('show');
                    $('#inventoryUpdate').hide();
                    $('#inventorySubmit').show();
                }
            }
        ],
        columns: [
            { data: 'id' },
            {
                data: 'product.name', // Assuming the product relationship is loaded
                title: 'Product'
            },
            { data: 'quantity' },
            {
                data: null,
                render: function (data, type, row) {
                    return '<a href="#" class="editBtn" data-id="' + data.id + '"><i class="fas fa-edit" aria-hidden="true" style="font-size:24px"></i></a>' +
                           '<a href="#" class="deleteBtn" data-id="' + data.id + '"><i class="fas fa-trash-alt" style="font-size:24px; color:red"></i></a>';
                }
            }
        ]
    });

    $("#inventorySubmit").on('click', function (e) {
        e.preventDefault();
        var formData = new FormData($('#inventoryForm')[0]);

        $.ajax({
            type: "POST",
            url: "/api/inventories",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#inventoryModal").modal("hide");
                var table = $('#inventoriesTable').DataTable();
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#inventoriesTable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $("#inventoryForm").trigger("reset");
        $('#inventoryModal').modal('show');
        $('#inventorySubmit').hide();
        $('#inventoryUpdate').show();

        $.ajax({
            type: "GET",
            url: "/api/inventories/" + id,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#inventoryQuantity').val(data.quantity);
                $('#inventoryProduct').val(data.product_id); // Assuming you have a select dropdown with id #inventoryProduct
                $('<input>').attr({ type: 'hidden', id: 'inventoryId', name: 'inventory_id', value: id }).appendTo('#inventoryForm');
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#inventoryUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#inventoryId').val();
        var formData = new FormData($('#inventoryForm')[0]);
        formData.append("_method", "PUT");

        $.ajax({
            type: "POST",
            url: "/api/inventories/" + id,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#inventoryModal').modal("hide");
                var table = $('#inventoriesTable').DataTable();
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#inventoriesTable tbody').on('click', 'a.deleteBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var table = $('#inventoriesTable').DataTable();
        var $row = $(this).closest('tr');

        bootbox.confirm({
            message: "Do you want to delete this inventory?",
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
                        url: "/api/inventories/" + id,
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
                            bootbox.alert("Error deleting inventory.");
                        }
                    });
                }
            }
        });
    });
});
