<script>
    $(function() {
        var filters = {
                search: "",
                page: "",
            },
            columns = [{
                    data: 'id',
                    orderable: false
                },
                {
                    data: 'holiday_name',
                    orderable: true
                },
                {
                    data: 'holiday_date',
                    orderable: true
                },
                {
                    data: 'created_at',
                    orderable: true
                },
                {
                    data: 'updated_at',
                    orderable: true
                },
            ],
            columnDefs = [{
                    "targets": [0],
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "targets": [5],
                    className: 'r-col-action',
                    render: function(data, type, full, meta) {
                        var id = full.id;
                        return '<a href="javascript: void(0);" onclick="openEditModal(' + id + ')" class="btn btn-xs btn-light"><i class="mdi mdi-pencil"></i></a>' +
                            '<a href="javascript: void(0);" onclick="removeHoliday(' + full.id + ')" class="btn btn-xs btn-danger ml-1"><i class="mdi mdi-minus"></i></a>';
                    }
                }
            ],
            dataTable = callDataTable('holiday-datatable', '{!! route('holidays.data') !!}', filters, columns, '', '',
                columnDefs);


        $('#filter-holiday-form').submit(function(event) {
            $(this).attr("disabled", true);
            event.preventDefault();
            filters['promo_code'] = $('#promo_code').val();
            filters['page'] = $('#page').val();
            $('#holiday-datatable').DataTable().ajax.reload();
        });

        $('#app_id').change(function() {
            $('.filter-holiday-form').submit();
        });

        $('#page').change(function(event) {
            event.preventDefault();
            $('#holiday-datatable').DataTable().page.len($(this).val()).draw();
        });
    });

    function openAddModal() {
        $.ajax({
            url: "{!! route('holidays.add') !!}",
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addModals').html(result);
                $('#AddHoliday').modal('show');
            }
        });
    }

    function openEditModal(id) {
        $.ajax({
            url: "holidays/edit/" + id,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                $('.addModals').html(result);
                $('#editHoliday').modal('show');
            }
        });
    }

    function removeHoliday(id) {
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
                    url: "holidays/delete/" + id,
                    type: 'DELETE',
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.type === 'SUCCESS') {
                            toastr.success(result.message);
                            $('#holiday-datatable').DataTable().ajax.reload();
                        } else {
                            toastr.error(result.message);
                        }
                    }
                });
            }
        });
    }

</script>
