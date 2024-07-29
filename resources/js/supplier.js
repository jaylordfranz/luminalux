$(document).ready(function () {
    const table = $('#suppliersTable').DataTable({
        ajax: {
            url: "/api/suppliers",
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Supplier',
                className: 'btn btn-primary',
                action: function () {
                    showSupplierModal();
                    $('#supplierUpdate').hide();
                }
            }
        ],
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'contact_info' },
            { data: 'address' },
            {
                data: 'images',
                render: function (data) {
                    return data.map(image => `<img src="/storage/${image}" width="50" height="50">`).join(' ');
                }
            },
            {
                data: null,
                render: function (data) {
                    return `<a href="#" class="editBtn" data-id="${data.id}">
                                <i class="fas fa-edit" aria-hidden="true" style="font-size:24px"></i>
                            </a>
                            <a href="#" class="deleteBtn" data-id="${data.id}">
                                <i class="fas fa-trash-alt" style="font-size:24px; color:red"></i>
                            </a>`;
                }
            }
        ]
    });

    function showSupplierModal(data = {}) {
        $("#supplierForm").trigger("reset");
        $('#supplierModal').modal('show');
        if (data.id) {
            $('#supplierSubmit').hide();
            $('#supplierUpdate').show();
            $('#supplierName').val(data.name || '');
            $('#supplierContactInfo').val(data.contact_info || '');
            $('#supplierAddress').val(data.address || '');
            $('#supplierImages').val(data.images || '');
            $('<input>').attr({ type: 'hidden', id: 'supplierId', name: 'supplier_id', value: data.id }).appendTo('#supplierForm');
        } else {
            $('#supplierSubmit').show();
            $('#supplierUpdate').hide();
        }
    }

    $("#supplierSubmit").on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/suppliers",
            data: new FormData($('#supplierForm')[0]),
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#supplierModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.error("Error:", error);
                alert("An error occurred while saving the supplier.");
            }
        });
    });

    $('#suppliersTable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "/api/suppliers/" + id,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                showSupplierModal(data);
            },
            error: function (error) {
                console.error("Error:", error);
                alert("An error occurred while fetching the supplier details.");
            }
        });
    });

    $("#supplierUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#supplierId').val();
        $.ajax({
            type: "POST",
            url: "/api/suppliers/" + id,
            data: new FormData($('#supplierForm')[0]).append("_method", "PUT"),
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#supplierModal').modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.error("Error:", error);
                alert("An error occurred while updating the supplier.");
            }
        });
    });

    $('#suppliersTable tbody').on('click', 'a.deleteBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        bootbox.confirm({
            message: "Do you want to delete this supplier?",
            buttons: {
                confirm: { label: 'Yes', className: 'btn-success' },
                cancel: { label: 'No', className: 'btn-danger' }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        type: "DELETE",
                        url: "/api/suppliers/" + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            table.row($('a.deleteBtn[data-id="' + id + '"]').closest('tr')).remove().draw();
                            bootbox.alert(data.message);
                        },
                        error: function (error) {
                            console.error("Error:", error);
                            bootbox.alert("Error deleting supplier.");
                        }
                    });
                }
            }
        });
    });
});
