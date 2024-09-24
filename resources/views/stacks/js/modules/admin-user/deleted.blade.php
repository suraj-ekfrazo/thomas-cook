<script>

    $(function () {
        var
            filters = {
                search: "",
                page: "",
            },
            columns = [
                {data: 'id', orderable: false},
                {data: 'user_profile', orderable: true},
                {data: 'name', orderable: true},
                {data: 'email', orderable: true},
                {data: 'email', orderable: true},
                {data: 'created_at', orderable: true},
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
                    "targets": [1],
                    render: function (data, type, full, meta) {
                        var user_profile = full.user_profile;
                        if(user_profile == null)
                            user_profile = 'default.png';
                        return '<img src="users/admin/profile/' + user_profile + '" style="width:50px; height:auto;">';
                    }
                },
                {
                    "targets": [4],
                    render: function (data, type, full, meta) {
                        var roles = full.roles;
                        var rolesString = '';
                        roles.forEach(element => {
                            console.log('element', element);
                            rolesString += '<label class="badge badge-success">' + element.name + '</label>';
                        });
                        return rolesString;
                    }
                },
                {
                    "targets": [6],
                    render: function (data, type, full, meta) {
                        var createdBy = full.created_by;
                        if(createdBy != null){
                            return createdBy.email;
                        }
                        return '';
                    }
                },
                {
                    "targets": [7],
                    render: function (data, type, full, meta) {
                        var updatedBy = full.updated_by;
                        if(updatedBy != null){
                            return updatedBy.email;
                        }
                        return '';
                    }
                },
                {
                    "targets": [8],
                    className: 'r-col-action',
                    render: function (data, type, full, meta) {
                        var id = full.id;
                        return '<a href="javascript: void(0);" onclick="openViewModal(' + id + ')" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>' +
                            '<a href="javascript: void(0);" onclick="reActive(' + full.id + ')" class="btn btn-xs btn-success ml-1"><i class="mdi mdi-lock-open"></i></a>';
                    }
                }
            ],
            dataTable = callDataTable('data-datatable', '{!! route('admin-users.deleted.data') !!}', filters, columns, '', '', columnDefs);
    });

    function openViewModal(id) {
        $.ajax({
            url: "../admin-users/show-deleted/" + id,
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

    function reActive(id) {
        swal({
            title: "Are you sure you want to re-activate user?",
            text: "",
            icon: "error",
            buttons: true,
            dangerMode: true,
            buttons: ["Cancel", "Confirm"],
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: "../admin-users/reactive/" + id,
                    type: 'GET',
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
