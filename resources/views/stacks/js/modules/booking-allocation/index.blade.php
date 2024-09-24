<script>
    $(function() {
        var
            filters = {
                search: "",
                page: "",
            },
            columns = [{
                    data: 'id',
                    orderable: true
                },

                {
                    data: 'inci_number',
                    orderable: true

                },
		{
                    data: 'inci_buy_sell_req',
                    orderable: true

                },
                {
                    data: 'inci_departure_date',
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
                        if (full.inci_number) {
                            return full.inci_number;
                        }
                        return '';
                    },

                },
                {
                    "targets": [2],
                    render: function(data, type, full, meta) {
                        if (full.agent) {
                            return full.agent.agent_code;
                        }
                        return '';
                    },

                },
                {
                    "targets": [3],
                    render: function(data, type, full, meta) {
                        if (full.inci_buy_sell_req=="0") {
                            return "Buy";
                        }
                        else {
                            return "Sell";
                        }
                        return '';
                    },

                },
                {
                    "targets": [4],
                    render: function(data, type, full, meta) {
                        if (full.inci_departure_date) {
                            if (full.inci_departure_date != "0000-00-00" && full.inci_departure_date != "" && full.inci_departure_date != "1970-01-01") {
                                return full.inci_departure_date;
                            }
                        }
                        return '';
                    },

                },

                {
                    "targets": [5],
                    render: function(data, type, full, meta) {
                        if (full.inci_assign_name) {
                            return full.inci_assign_name;
                        }
                        return '';
                    },

                },

                {
                    "targets": [6],
                    render: function(data, type, full, meta) {
                        var allUsers = full.allUsers;
                         var inci_number=full.inci_number;
                        let letter = inci_number.charAt(0);
                        var nameString = '';
                        nameString =
                            '<select class="form-select fw-bold border-0 pb-0 bg-transparent w-50" name="tc_name" id="tcUserName" data-id = "' +
                            full.inci_number + '"><option value="">Select User</option>';

                        // $.each(allUsers, function(key, val) {
                        //     if (full.userid != val.id) {
                        //         nameString += '<option value="' +
                        //             val.id + '" >' +
                        //             val.name + '</option>';
                        //     }
                        // });
                         $.each(allUsers, function(key, val) {
                            var tc_series=val.tc_series;
                            var tcSeriesArray = tc_series.split(',');
                            if(letter=='B' || letter=='C' || letter=='D' || letter=='E' ){
                                if(jQuery.inArray(letter, tcSeriesArray) !== -1){
                                    if (full.userid != val.id) {
                                        nameString += '<option value="' +
                                            val.id + '" >' +
                                            val.name + '</option>';
                                    }
                                }
                            }else{
                                if (full.userid != val.id) {
                                        nameString += '<option value="' +
                                            val.id + '" >' +
                                            val.name + '</option>';
                                    }
                            }
                        });

                        nameString += '</select>';

                        return nameString;
                    }
                },

                // {
                //     "targets": [4],
                //     className: 'r-col-action',
                //     render: function(data, type, full, meta) {
                //         var id = full.inci_number;
                //         return '<a href="javascript: void(0);" class="delete svg-bg" title="Delete" style="background-color: rgba(236,0,0,0.07); color:#EC0000"><i class="fa-solid fa-trash-can" style="font-size: 14px;"></i>';
                //     }
                // }
            ],
            dataTable = callDataTable('data-datatable', '{!! route('booking-allocation.data') !!}', filters, columns, '', '',
                columnDefs);

	    $('#filterBtn').click(function() {
                filters['from_date'] = $('#from_date').val();
                filters['to_date'] = $('#to_date').val();
                filters['type'] = $('#booking_type').val();
		filters['agent_id'] = $('#agent_id').val();
                $('#data-datatable').DataTable().ajax.reload();
            });

    });

	

    // Update assigned user
    $(document).on('change', '#tcUserName', function() {
        var tcuser_id = $(this).val();
        var inci_number = $(this).attr('data-id');

        $.ajax({
            url: "{{ route('booking-allocation.update-assigned-user') }}",
            type: 'POST',
            data: {
                'tcuser_id': tcuser_id,
                'inci_number': inci_number
            },
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
    });
</script>
