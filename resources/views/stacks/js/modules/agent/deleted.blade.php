<script>

    $(function () {
        var
            filters = {
                search: "",
                page: "",
            },
            columns = [
                {data: 'id', orderable: false},
                {data: 'user_name', orderable: true},
                {data: 'agent_code', orderable: true},
                {data: 'email', orderable: true},
                {data: 'agent_form', orderable: true},
                {data: 'agent_to', orderable: true},
                {data: 'mobile_number', orderable: true},
                {data: 'create_date', orderable: true},
                {data: 'created_by', orderable: true},
                {data: 'updated_by', orderable: true},
            ],
            columnDefs = [
                {
                    "targets": [0],
                    render: function (data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "targets": [8],
                    render: function (data, type, full, meta) {
                        var createdBy = full.created_by;
                        if(createdBy != null){
                            return createdBy.email;
                        }
                        return '';
                    }
                },
                {
                    "targets": [9],
                    render: function (data, type, full, meta) {
                        var updatedBy = full.updated_by;
                        if(updatedBy != null){
                            return updatedBy.email;
                        }
                        return '';
                    }
                },
                {
                    "targets": [10],
                    className: 'r-col-action',
                    render: function (data, type, full, meta) {
                        var id = full.id;
                        return '<a href="javascript: void(0);" onclick="openViewModal(' + id + ')" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>' +
                            '<a href="javascript: void(0);" onclick="reActivate(' + full.id + ')" class="btn btn-xs btn-danger ml-1"><i class="mdi mdi-lock-open"></i></a>';
                    }
                }
            ],
            dataTable = callDataTable('data-datatable', '{!! route('agent.deleted.data') !!}', filters, columns, '', '', columnDefs);
    });

    function openViewModal(id) {
        $.ajax({
            url: "../agent/show-deleted/" + id,
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

    function reActivate(id) {
        swal({
            title: "Are you sure you want to re-active agent?",
            text: "",
            icon: "error",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: "../agent/reactive/" + id,
                    type: 'GET',
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
