<script>
    $(function() {
        var
            filters = {
                search: "",
                page: "",
            },
            columns = [{
                    data: 'id',
                    orderable: false
                },
                {
                    data: 'user_profile',
                    orderable: true

                },
                {
                    data: 'name',
                    orderable: true

                },
                {
                    data: 'email',
                    orderable: true
                },
                {
                    data: 'email',
                    orderable: true
                },
                {
                    data: 'created_at',
                    orderable: true
                },

            ],

            columnDefs = [{
                    "targets": [0],
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    },

                },
                {
                    "targets": [1],
                    render: function(data, type, full, meta) {
                        var user_profile = full.user_profile;
                        if (user_profile == null)
                            user_profile = 'default.png';
                        return '<img src="users/admin/profile/' + user_profile +
                            '" style="width:50px; height:auto;">';
                    }
                },
                {
                    "targets": [4],
                    render: function(data, type, full, meta) {
                        var roles = full.roles;
                        var rolesString = '';
                        roles.forEach(element => {
                            // console.log('element', element);
                            rolesString += '<label class="badge badge-success">' + element.name +
                                '</label>';
                        });
                        return rolesString;
                    }
                },
                {
                    "targets": [5],
                    render: function(data, type, full, meta) {
                        var created_at = full.created_at;
                        return moment(created_at).format('DD-MM-YYYY hh:mm:ss');
                    }
                },

                {
                    "targets": [6],
                    render: function(data, type, full, meta) {
                        var id = full.id;
                        var status = full.status;

                        var html =
                            '<label class="switch"><input type="checkbox" class="switch-input" data-id = "' +
                            id + '" data-status= "' + status +
                            '"';
                        if (status == 1) {
                            html += 'checked';
                        }
                        html +=
                            '><span class="switch-label" data-on="Enable" data-off="Disable"  ></span> <span class="switch-handle"></span></label>';
                        return html;
                    }
                },

                {
                    "targets": [7],
                    className: 'r-col-action',
                    render: function(data, type, full, meta) {
                        var id = full.id;
                        return '<a href="javascript: void(0);" onclick="openEditModal(' + id +
                            ')" type="button" title="Edit Record" class="svg-bg m-0" style="background-color: rgba(37,101,171,0.14); color:#2565ab"><i class="fa-solid fa-pen" style="font-size: 14px;"> </i></a>' +
                            ' <a href="javascript: void(0);" onclick="removeData(' + full.id +
                            ')"class="delete svg-bg" title="Delete Record" style="background-color: rgba(236,0,0,0.07); color:#EC0000"><i class="fa-solid fa-trash-can" style="font-size: 14px;"></i>';
                    }
                }
            ],
            dataTable = callDataTable('data-datatable', '<?php echo route('subadmin.data'); ?>', filters, columns, '', '',
                columnDefs);

    });

    //----Open edit model-----
    function openEditModal(id) {
        $.ajax({
            url: "subadmin/edit/" + id,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.addModals').html(result);
                $('#editData').modal('show');
            }
        });
    }

    //------Remove admin record------
    function removeData(id) {
        swal({
                title: "Are you sure?",
                text: "Want to delete this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes ",
                cancelButtonText: "No ",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "subadmin/delete/" + id,
                        type: 'DELETE',
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            if (result.type === 'SUCCESS') {
                                toastr.success(result.message);
                                $('#data-datatable').DataTable().ajax.reload();
                            } else {
                                toastr.error(result.message);
                            }
                        },
                        error: function(err) {
                            toastr.error('Something went wrong! Try after sometime.');
                        }
                    });
                }
            });
    }

    //----- Update status ------
    $(document).on('change', '.switch-input ', function() {
        var status = $(this).data('status');
        var id = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "Want to change status",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes ",
            cancelButtonText: "No ",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                if (status == 2) {
                    status = 1;
                } else {
                    status = 2;
                }
                $.ajax({
                    url: "<?php echo e(route('subadmin.update-status')); ?>",
                    type: 'GET',
                    data: {
                        'status': status,
                        'id': id
                    },
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    success: function(result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#data-datatable').DataTable().ajax.reload();
                        } else {
                            toastr.error(result.message);
                        }
                    },
                    error: function(err) {
                        toastr.error(
                            'Something went wrong! Try after sometime.');
                    }
                });
            }
            $('#data-datatable').DataTable().ajax.reload();
        });
    });
</script>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/stacks/js/modules/subadmin/index.blade.php ENDPATH**/ ?>