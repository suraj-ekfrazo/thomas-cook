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
                    data: 'currency_name',
                    orderable: true

                },
                {
                     data: 'buy_margin',
                     orderable: true
                
                },
                // {
                //     data: 'sell_margin',
                //     orderable: true
                // },
                {
                    data: 'sell_margin_10_12',
                    orderable: true
                },
                {
                    data: 'sell_margin_12_2',
                    orderable: true
                },
                {
                    data: 'sell_margin_2_3_30',
                    orderable: true
                },
                {
                    data: 'sell_margin_3_30_end',
                    orderable: true
                },
{
                    data:'holiday_margin',
                    orderable: true
                },

                {
                    data: '',
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
                    "targets": [7],
                    render: function(data, type, full, meta) {
                        return full.current_rate;
                    },

                },

 		{
                    "targets": [8],
                    render: function(data, type, full, meta) {
                        return full.holiday_margin;
                    },

                },


                {
                    "targets": [9],
                    className: 'r-col-action',
                    render: function(data, type, full, meta) {
                        var id = full.id;
                        return '<a href="javascript: void(0);" onclick="openEditModal(' + id +
                            ')" type="button" class="svg-bg m-0" style="background-color: rgba(37,101,171,0.14); color:#2565ab"><i class="fa-solid fa-pen" style="font-size: 14px;"> </i></a>';
                    }
                }
            ],
            dataTable = callDataTable('data-datatable', '{!! route("rate-master.data") !!}', filters, columns, '', '', columnDefs);

    });

    function openEditModal(id) {
        $.ajax({
            url: "ratemaster/edit/" + id,
            type: 'GET',
            contentType: "application/json",

            success: function(result) {
                // console.log(result)
                $('.addModals').html(result);
                $('#editData').modal('show');
            }
        });
    }
</script>
