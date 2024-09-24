<script>

    $(function () {
        var
            filters = {
                search: "",
                page: "",
            },
            columns = [
                {data: 'id', orderable: false},
                {data: 'name', orderable: true},
                {data: 'created_at', orderable: true},
            ],
            columnDefs = [
                {
                    "targets": [0],
                    render: function (data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "targets": [3],
                    className: '',
                    render: function (data, type, full, meta) {
                        var id = full.id;
                        var action = '';
                        var checkRole = meta.settings.json.checkRole;
                        /* View modal */
                        action += '<a href="javascript: void(0);" onclick="openViewModal(' + id + ')" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>';
                        /* Edit modal */
                        if(id != 1)
                            action +='<a href="javascript: void(0);" onclick="openEditModal(' + id + ')" class="btn btn-xs btn-primary ml-1"><i class="mdi mdi-pencil"></i></a>';
                        var added = false;
                        $.map(checkRole, function(elementOfArray, indexInArray) {
                            if (elementOfArray == id) {
                                added = true;
                            }
                        });
                        if (!added) {
                            /* Delete alert */
                            action += '<a href="javascript: void(0);" onclick="removeData(' + full.id + ')" class="btn btn-xs btn-danger ml-1"><i class="mdi mdi-minus"></i></a>';
                        }
                        return action;
                    }
                }
            ],
            dataTable = callDataTable('data-datatable', '{!! route('roles.data') !!}', filters, columns, '', '', columnDefs);

        $('#page').change(function (event) {
            event.preventDefault();
            $('#data-datatable').DataTable().page.len($(this).val()).draw();
        });
    });

    function openAddModal() {
        // alert('document');
        $.ajax({
            url: "{!! route('roles.add') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addModals').html(result);
                $('#AddData').modal('show');
            }
        });
    }

    function openViewModal(id) {
        $.ajax({
            url: "roles/show/" + id,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addModals').html(result);
                $('#showData').modal('show');
            }
        });
    }

    function openEditModal(id) {
        $.ajax({
            url: "roles/edit/" + id,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addModals').html(result);
                $('#editData').modal('show');
            }
        });
    }

    function removeData(id) {
        swal({
            title: "Are you sure you want to delete?",
            text: "",
            icon: "error",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: "roles/delete/" + id,
                    type: 'DELETE',
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#data-datatable').DataTable().ajax.reload();
                        } else {
                            toastr.error(result.message);
                        }
                    },
                    error: function (err){
                        toastr.error('Something went wrong! Try after sometime.');
                    }
                });
            }
        });
    }

</script>
