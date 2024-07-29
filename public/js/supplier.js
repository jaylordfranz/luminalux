$(document).ready(function () {
    function initializeDataTable() {
        $('#suppliersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/suppliers",
                type: "GET",
                data: function (d) {
                    return $.extend({}, d, {
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
                    text: 'Add Supplier',
                    className: 'btn btn-primary',
                    action: function () {
                        $("#supplierForm").trigger("reset");
                        $('#supplierModal').modal('show');
                        $('#supplierUpdate').hide();
                        $('#supplierImage').remove();
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
                { data: 'contact_info' },
                { data: 'address' },
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

    function handleSupplierSubmit() {
        $("#supplierSubmit").on('click', function (e) {
            e.preventDefault();
            var formData = new FormData($('#supplierForm')[0]);

            $.ajax({
                type: "POST",
                url: "/api/suppliers",
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function () {
                    $("#supplierModal").modal("hide");
                    var table = $('#suppliersTable').DataTable();
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleSupplierUpdate() {
        $("#supplierUpdate").on('click', function (e) {
            e.preventDefault();
            var id = $('#supplierId').val();
            var formData = new FormData($('#supplierForm')[0]);
            formData.append("_method", "PUT");

            $.ajax({
                type: "POST",
                url: "/api/suppliers/" + id,
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function () {
                    $('#supplierModal').modal("hide");
                    var table = $('#suppliersTable').DataTable();
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleSupplierEdit() {
        $('#suppliersTable tbody').on('click', 'a.editBtn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $("#supplierForm").trigger("reset");
            $('#supplierModal').modal('show');
            $('#supplierSubmit').hide();
            $('#supplierUpdate').show();

            $.ajax({
                type: "GET",
                url: "/api/suppliers/" + id,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function (data) {
                    $('#supplierName').val(data.name);
                    $('#supplierContactInfo').val(data.contact_info);
                    $('#supplierAddress').val(data.address);
                    if (data.images && data.images.length > 0) {
                        $('#supplierForm').append('<img src="' + data.images[0] + '" width="200px" height="200px" id="supplierImage">');
                    }
                    $('<input>').attr({ type: 'hidden', id: 'supplierId', name: 'supplier_id', value: id }).appendTo('#supplierForm');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    function handleSupplierDelete() {
        $('#suppliersTable tbody').on('click', 'a.deleteBtn', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var table = $('#suppliersTable').DataTable();
            var $row = $(this).closest('tr');

            bootbox.confirm({
                message: "Do you want to delete this supplier?",
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
                            url: "/api/suppliers/" + id,
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            dataType: "json",
                            success: function (data) {
                                $row.fadeOut(400, function () {
                                    table.row($row).remove().draw();
                                });
                                bootbox.alert(data.message);
                            },
                            error: function (error) {
                                bootbox.alert("Error deleting supplier.");
                            }
                        });
                    }
                }
            });
        });
    }

    initializeDataTable();
    handleSupplierSubmit();
    handleSupplierUpdate();
    handleSupplierEdit();
    handleSupplierDelete();
});
