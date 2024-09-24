<script>
    $(function() {
        var loginuser='{!! auth()->user()->id !!}';
        var envdata='{{ env('TC_USER_ID') }}';
        //console.log(envdata);
        var
            filters = {
                search: "",
                page: "",
            },
            columns = [
                {
                    data: 'id',
                    orderable: false
                },
                {
                    data: 'inci_number',
                    orderable: true
                },
                {
                    data: 'agent_code',
                    orderable: false
                },
                {
                    data: 'inci_create_time',
                    orderable: false
                },
                {
                    data: 'inci_create_time',
                    orderable: false
                },
                {
                    data: 'inci_forex_card_no',
                    orderable: true
                },
                {
                    data: 'inci_passport_number',
                    orderable: true
                },

            ],
            columnDefs = [
                {
                    "targets": [0],
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
		{
                    "targets": [1],
                    render: function(data, type, full, meta) {
                        if(loginuser==envdata){
                            return full.inci_number;
                        }
                        else{
                            var url = '{{ route("tcuser.booking-request", ":id") }}';
                            url = url.replace(':id', full.inci_number);
                            return '<a href="'+url+'" type="button" class="svg-bg m-0 fw-bold" style="color:#00B7FF;"> <i class="fa-solid fa-eye"></i> '+full.inci_number+'</a>';
                        }
                    }
                },
                {
                    "targets": [2],
                    render: function(data, type, full, meta) {
                        return full.agent ? full.agent.agent_code : '' ;
                    }
                },
                {
                    "targets": [3],
                    render: function(data, type, full, meta) {
                        return moment(full.inci_create_time).format('DD-MM-YYYY');
                    }
                },
                {
                    "targets": [4],
                    render: function(data, type, full, meta) {
                        return moment(full.inci_create_time).format('hh:mm:ss');
                    }
                },
                {
                    "targets": [5],
                    render: function(data, type, full, meta) {
                        var incidentCurrency = '';
                        if(full.incident_currency){
                            if(full.incident_currency.length > 0){
                                full.incident_currency.forEach(element => {
                                    incidentCurrency += '<b>'+element.inci_currency_type + '</b><br/>';
                                });
                                return incidentCurrency;
                            }
                        }
                        return '';
                    }
                },
                {
                    "targets": [6],
                    render: function(data, type, full, meta) {
                        var incidentCurrency = '';
                        if(full.incident_currency){
                            if(full.incident_currency.length > 0){
                                full.incident_currency.forEach(element => {
                                    incidentCurrency += '<b>'+element.inci_frgn_curr_amount + '</b><br/>';
                                });
                                return incidentCurrency;
                            }
                        }
                        return '';
                    }
                },
                {
                    "targets": [7],
                    render: function(data, type, full, meta) {
                        var incidentCurrency = '';
                        if(full.incident_currency){
                            if(full.incident_currency.length > 0){
                                full.incident_currency.forEach(element => {
                                    incidentCurrency += '<b>'+element.inci_currency_rate + '</b><br/>';
                                });
                                return incidentCurrency;
                            }
                        }
                        return '';
                    }
                },
                {
                    "targets": [8],
                    render: function(data, type, full, meta) {
                        var incidentCurrency = '';
                        if(full.incident_currency){
                            if(full.incident_currency.length > 0){
                                full.incident_currency.forEach(element => {
                                    incidentCurrency += '<b>'+element.inci_inr_amount + '</b><br/>';
                                });
                                return incidentCurrency;
                            }
                        }
                        return '';
                    }
                },
                {
                    "targets": [9],
                    render: function(data, type, full, meta) {
                        return full.inci_forex_card_no;
                    }
                },
                {
                    "targets": [10],
                    render: function(data, type, full, meta) {
                        return full.inci_passport_number;
                    }
                },
                {
                    "targets": [11],
                    "bVisible": loginuser==envdata,
                    render: function(data, type, full, meta) {
                        return '<div class="form-check form-check-inline"><input class="form-check-input mudraposting" type="checkbox" data-id="'+full.inci_number+'" value="'+full.mudra_posting+'"></div>';
                    }
                },
            ],
	    rowCallback = function (row, data) {
                //console.log(row, data);
                if (data.doc_type == 1) {

                    $(row).addClass('table-success');
                }
            },
            dataTable = callDataTable('data-datatable', '{!! route('tcuser.bookingRequest') !!}', filters, columns, '', '', columnDefs, '', rowCallback);
    });

</script>
