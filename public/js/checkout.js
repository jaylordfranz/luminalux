$(document).ready(function () {
    function initializeDataTable() {
        $('#checkoutsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/checkouts",
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
                    text: 'Add Checkout',
                    className: 'btn btn-primary',
                    action: function () {
                        $("#checkoutForm").trigger("reset");
                        $('#checkoutModal').modal('show');
                        $('#checkoutUpdate').hide();
                    }
                }
            ],
            columns: [
                { data: 'id' },
                { data: 'checkout_date' },
                { data: 'total_amount' },
                { data: 'checkout_status' },
                { data: 'payment_status' },
                { data: 'billing_address' },
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

    function handleCheckoutSubmit() {
        $("#checkoutSubmit").on('click', function (e) {
            e.preventDefault();
            var formData = new FormData($('#checkoutForm')[0]);

            $.ajax({
                type: "POST",
                url: "/api/checkouts",
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function () {
                    $("#checkoutModal").modal("hide");
                    var table = $('#checkoutsTable').DataTable();
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCheckoutUpdate() {
        $("#checkoutUpdate").on('click', function (e) {
            e.preventDefault();
            var id = $('#checkoutId').val();
            var formData = new FormData($('#checkoutForm')[0]);
            formData.append("_method", "PUT");

            $.ajax({
                type: "POST",
                url: "/api/checkouts/" + id,
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function () {
                    $('#checkoutModal').modal("hide");
                    var table = $('#checkoutsTable').DataTable();
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCheckoutEdit() {
        $('#checkoutsTable tbody').on('click', 'a.editBtn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $("#checkoutForm").trigger("reset");
            $('#checkoutModal').modal('show');
            $('#checkoutSubmit').hide();
            $('#checkoutUpdate').show();

            $.ajax({
                type: "GET",
                url: "/api/checkouts/" + id,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function (data) {
                    $('#checkoutDate').val(data.checkout_date);
                    $('#totalAmount').val(data.total_amount);
                    $('#checkoutStatus').val(data.checkout_status);
                    $('#paymentStatus').val(data.payment_status);
                    $('#billingAddress').val(data.billing_address);
                    $('<input>').attr({ type: 'hidden', id: 'checkoutId', name: 'checkout_id', value: id }).appendTo('#checkoutForm');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleCheckoutDelete() {
        $('#checkoutsTable tbody').on('click', 'a.deleteBtn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var table = $('#checkoutsTable').DataTable();
            var $row = $(this).closest('tr');
    
            bootbox.confirm({
                message: "Do you want to delete this checkout?",
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
                            url: "/api/checkouts/" + id,
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
                                bootbox.alert("Error deleting checkout.");
                            }
                        });                        
                    }
                }
            });
        });
    }
    
    initializeDataTable();
    handleCheckoutSubmit();
    handleCheckoutUpdate();
    handleCheckoutEdit();
    handleCheckoutDelete();
});
