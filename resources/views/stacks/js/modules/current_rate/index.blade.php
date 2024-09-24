<script>
    $(function() {
        var
            filters = {
                search: "",
                page: "",
            },
            columns = [{
                    data: 'cur_id ',
                    orderable: false
                },
                {
                    data: 'currency_name_key',
                    orderable: true

                },
                {
                    data: 'cur_bye',
                    orderable: true

                },
                {
                    data: 'cur_sell',
                    orderable: true
                },
            ],

            columnDefs = [{
                    "targets": [0],
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    },

                }
            ],
            dataTable = callDataTable('data-datatable', '{!! route("currentrate.data") !!}', filters, columns, '', '',
                columnDefs);

    });

    // function openEditModal(id) {
    //     $.ajax({
    //         url: "ratemaster/edit/" + id,
    //         type: 'GET',
    //         contentType: "application/json",

    //         success: function(result) {
    //             console.log(result)
    //             $('.addModals').html(result);
    //             $('#editData').modal('show');
    //         }
    //     });
    // }
</script>
