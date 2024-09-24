<script>
    $(function() {
        var
            filters = {
                search: "",
                page: "",
                from_date: "",
                to_date: "",
            },
            columns = [{
                    data: 'id',
                    orderable: true
                },
                // 1St Column
                {
                    data: 'inci_number',
                    orderable: false
                },
                {
                    data: 'inci_number',
                    orderable: true
                },
                {
                    data: 'inci_number',
                    orderable: true
                },
                {
                    data: 'inci_forex_card_no',
                    orderable: true
                },
                // 5Th Column
                {
                    data: 'inci_number',
                    orderable: true
                },
                {
                    data: 'inci_received_date',
                    orderable: true
                },
                {
                    data: 'inci_received_time',
                    orderable: true
                },
                {
                    data: 'inci_buy_sell_req',
                    orderable: true
                },
                {
                    data: 'inci_agent_margin',
                    orderable: true
                },
                // 10th Column
                {
                    data: 'created_at',
                    orderable: true
                },
            ],
            columnDefs = [{
                    "targets": [0],
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },{
                    "targets": [1],
                    render: function(data, type, full, meta) {
                        if(full.agent){
                            if(full.agent.first_name && full.agent.last_name){
                                return full.agent.first_name + ' ' + full.agent.last_name;
                            }
                        }
                        return '';
                    }
                },{
                    "targets": [2],
                    render: function(data, type, full, meta) {
                        if(full.agent){
                            if(full.agent.agent_key){
                                return full.agent.agent_key;
                            }
                        }
                        return '';
                    }
                },{
                    "targets": [3],
                    render: function(data, type, full, meta) {
                        if(full.inci_number){
                            var id = full.id;
                            return '<a href="javascript: void(0);" data-inc="' + full.inci_number + '" class="view-inci btn btn-xs btn-info"><i class="mdi mdi-eye"></i> ' + full.inci_number + '</a>';
                        }
                        return '';
                    }
                },{
                    "targets": [5],
                    render: function(data, type, full, meta) {
                        var incidentCurrency = '';
                        if(full.incident_currency){
                            if(full.incident_currency.length > 0){
                                full.incident_currency.forEach(element => {
                                    incidentCurrency += element.inci_currency_type + '|' + element.inci_frgn_curr_amount + '|' + element.inci_inr_amount + '|' + element.inci_currency_rate + '<br/>';
                                });
                                return incidentCurrency;
                            }
                        }
                        return '';
                    }
                },{
                    "targets": [8],
                    render: function(data, type, full, meta) {
                        if(full.inci_buy_sell_req){
                            if(full.inci_buy_sell_req == '0'){
                                return 'Buy';
                            } else {
                                return 'Sell';
                            }
                        }
                        return '';
                    }
                },
                // inci_buy_sell_req // 7
                {
                    "targets": [11],
                    className: 'r-col-action',
                    render: function(data, type, full, meta) {
                        var id = full.id;
                        return '<a href="javascript: void(0);" onclick="openViewModal(' + id +
                            ')" class="btn btn-xs btn-info"><i class="mdi mdi-eye"></i></a>' +
                            '<a href="javascript: void(0);" onclick="openEditModal(' + id +
                            ')" class="btn btn-xs btn-primary ml-1"><i class="mdi mdi-pencil"></i></a>' +
                            '<a href="javascript: void(0);" onclick="removeData(' + full.id +
                            ')" class="btn btn-xs btn-danger ml-1"><i class="mdi mdi-minus"></i></a>';
                    }
                }
            ],
            dataTable = callDataTable('data-datatable', '{!! route('admin-incidents.tableDataUnassigned') !!}', filters, columns, '', '',
                columnDefs);

        $('#filterBtn').click(function () {
            filters['from_date'] = $('#from_date').val();
            filters['to_date'] = $('#to_date').val();
            $('#data-datatable').DataTable().ajax.reload();
        });

    });
</script>

<script type="text/javascript">
    $(document).delegate(".view-inci", "click", function() {
        var incident = $(this).attr('data-inc');

        $.ajax({
            url: "{{ route('admin-incidents.getIncidentDetails') }}",
            data: {
                'incident': incident
            },
            success: function(result) {
                var incident = result.data;
                var html = '';
                var status = '';
                var inci_buy_sell_req = '';
                var inci_up_recived_date = '';
                var inci_up_recived_time = '';
                var inci_up_comment = '';
                var agentName = '';
                var agentCode = '';

                if(incident.incident_update){
                    if (incident.incident_update.inci_up_accept_status == '0inci') {
                        status = "Under Process";
                    } else if (incident.incident_update.inci_up_accept_status == '1inci') {
                        status = "Accepted";
                    } else if (incident.incident_update.inci_up_accept_status == 0) {
                        status = "File Under Process";
                    } else if (incident.incident_update.inci_up_accept_status == 1) {
                        status = "File Accepted";
                    } else {
                        status = "Decline";
                    }
                }

                if (incident.inci_buy_sell_req == 0) {
                    inci_buy_sell_req = "Buy";
                } else {
                    inci_buy_sell_req = "Sell";
                }

                if(incident.incident_update){
                    if (incident.incident_update.inci_up_recived_date) {
                        inci_up_recived_date = incident.incident_update.inci_up_recived_date;
                    }
                    if (incident.incident_update.inci_up_recived_time) {
                        inci_up_recived_time = incident.incident_update.inci_up_recived_time;
                    }
                    if (incident.incident_update.inci_up_comment) {
                        inci_up_comment = incident.incident_update.inci_up_comment;
                    }
                }
                if(incident.agent){
                    agentName = incident.agent.first_name + ' ' + incident.agent.last_name;
                    agentCode = incident.agent.agent_code;
                }

                html += '<p class=""><strong style="width:140px; display:inline-block;">Incident Number</strong>: ' + incident.inci_number + ' </p>';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Agent Name</strong>: ' + agentName + '</p> ';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Agent Code</strong>: ' + agentCode + '</p>';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Status</strong>: ' + status + '</p>';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Agent Type</strong>: ' + incident.inci_agent_type + '</p> ';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Card Number</strong>: ' + incident.inci_forex_card_no + ' </p>';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Date</strong>: ' + incident.inci_received_date + '</p>';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Time</strong>: ' + incident.inci_received_time + ' </p>';
                if (incident.incident_currency.length == 0) {
                    html += '<p class=""><strong style="width:140px; display:inline-block;">Currency Type</strong>:' + incident.inci_currency_type + ' </p>';
                    html += '<p class=""><strong style="width:140px; display:inline-block;">Currency Amount</strong>: ' + incident.inci_frgn_curr_amount + ' </p>';
                }
                html += '<p class=""><strong style="width:140px; display:inline-block;">Buy / Sell</strong>: ' + inci_buy_sell_req + ' </p>';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Agent margin</strong>: ' + incident.inci_agent_margin + '</p>';
                if (incident.incident_currency.length == 0) {
                    html += '<p class=""><strong style="width:140px; display:inline-block;">Inr Amount </strong>: ' + incident.inci_inr_amount + '</p>';
                }
                html += '<p class=""><strong style="width:140px; display:inline-block;">Date</strong>: ' + inci_up_recived_date + '</p>';
                html += '<p class=""><strong style="width:140px; display:inline-block;">Time</strong>: ' + inci_up_recived_time + '</p>';

                var currencyHtml = '';
                var currencyTotal = '0';
                if (incident.incident_currency.length >= 1) {
                    $.each(incident.incident_currency, function(key, value) {
                        console.log(value);
                        currencyHtml += ' <tr>';
                        currencyHtml += ' <td>' + value.inci_currency_type + '</td>';
                        currencyHtml += ' <td>' + value.inci_frgn_curr_amount + '</td>';
                        currencyHtml += ' <td>' + value.inci_currency_rate + '</td>';
                        currencyHtml += ' <td class="inci_inr_amount">' + value
                            .inci_inr_amount + '</td>';
                        currencyHtml += ' </tr>';
                        currencyTotal = parseFloat(currencyTotal) + parseFloat(value
                            .inci_inr_amount);
                    });
                    $("#selected-currency tbody").html(currencyHtml);
                    $("#selected-currency #total").html(currencyTotal.toFixed(2));
                } else {
                    $('#selected-currency').hide();
                }

                $("#incident-details").html(html);
                $('#incident-details-model').modal('show');
            },
            error: function(error){
                console.log('error', error);
            }
        });

    });
</script>
