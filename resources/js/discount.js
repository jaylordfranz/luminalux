$(document).ready(function () {
    const table = $('#discountsTable').DataTable({
        ajax: {
            url: "/api/discounts",
            dataSrc: ""
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Discount',
                className: 'btn btn-primary',
                action: function () {
                    showDiscountModal();
                    $('#discountUpdate').hide();
                }
            }
        ],
        columns: [
            { data: 'id' },
            { data: 'code' },
            { data: 'description' },
            {
                data: 'discount_percentage',
                render: function (data) {
                    return data + '%';
                }
            },
            { data: 'valid_from' },
            { data: 'valid_to' },
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

    function showDiscountModal(data = {}) {
        $("#discountForm").trigger("reset");
        $('#discountModal').modal('show');
        if (data.id) {
            $('#discountSubmit').hide();
            $('#discountUpdate').show();
            $('#discountCode').val(data.code || '');
            $('#discountDescription').val(data.description || '');
            $('#discountPercentage').val(data.discount_percentage || '');
            $('#discountValidFrom').val(data.valid_from || '');
            $('#discountValidTo').val(data.valid_to || '');
            $('<input>').attr({ type: 'hidden', id: 'discountId', name: 'discount_id', value: data.id }).appendTo('#discountForm');
        } else {
            $('#discountSubmit').show();
            $('#discountUpdate').hide();
        }
    }

    $("#discountSubmit").on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/discounts",
            data: new FormData($('#discountForm')[0]),
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#discountModal").modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.error("Error:", error);
                alert("An error occurred while saving the discount.");
            }
        });
    });

    $('#discountsTable tbody').on('click', 'a.editBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "/api/discounts/" + id,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                showDiscountModal(data);
            },
            error: function (error) {
                console.error("Error:", error);
                alert("An error occurred while fetching the discount details.");
            }
        });
    });

    $("#discountUpdate").on('click', function (e) {
        e.preventDefault();
        var id = $('#discountId').val();
        $.ajax({
            type: "POST",
            url: "/api/discounts/" + id,
            data: new FormData($('#discountForm')[0]).append("_method", "PUT"),
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#discountModal').modal("hide");
                table.ajax.reload();
            },
            error: function (error) {
                console.error("Error:", error);
                alert("An error occurred while updating the discount.");
            }
        });
    });

    $('#discountsTable tbody').on('click', 'a.deleteBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        bootbox.confirm({
            message: "Do you want to delete this discount?",
            buttons: {
                confirm: { label: 'Yes', className: 'btn-success' },
                cancel: { label: 'No', className: 'btn-danger' }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        type: "DELETE",
                        url: "/api/discounts/" + id,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            table.row($('a.deleteBtn[data-id="' + id + '"]').closest('tr')).remove().draw();
                            bootbox.alert(data.success);
                        },
                        error: function (error) {
                            console.error("Error:", error);
                            bootbox.alert("Error deleting discount.");
                        }
                    });
                }
            }
        });
    });
});
