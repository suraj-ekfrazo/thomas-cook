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
                }, // 0th
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: true
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                }, // 5th
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                // 10th End
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                }, // 15th
                {
                    data: 'inci_up_comment',
                    orderable: true
                },
                {
                    data: 'inci_up_bordx_no',
                    orderable: true
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: false
                },
                {
                    data: 'inci_up_inc_key',
                    orderable: true
                },
                {
                    data: 'inci_up_date',
                    orderable: true
                },
                // 20th End
                {
                    data: 'inci_up_time',
                    orderable: true
                },
                {
                    data: 'inci_up_received_date',
                    orderable: true
                },
                {
                    data: 'inci_up_received_time',
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
                    }
                },
                {
                    "targets": [2],
                    render: function(data, type, full, meta) {
                        if (full.incident.incident_assign) {
                            return full.incident.incident_assign.user_code;
                        }
                        return '';
                    }
                },
                {
                    "targets": [3],
                    render: function(data, type, full, meta) {
                        if (full.incident.agent) {
                            return full.incident.agent.agent_key;
                        }
                        return '';
                    }
                },
                {
                    "targets": [4],
                    render: function(data, type, full, meta) {
                        if (full.incident.agent) {
                            return full.incident.agent.first_name + ' ' + full.incident.agent.last_name;
                        }
                        return '';
                    }
                },
                {
                    "targets": [5],
                    render: function(data, type, full, meta) {
                        if (full.incident) {
                            return full.incident.inci_forex_card_no;
                        }
                        return '';
                    }
                },
                {
                    "targets": [6],
                    render: function(data, type, full, meta) {
                        if (full.incident) {
                            return full.incident.inci_passport_number;
                        }
                        return '';
                    }
                },
                {
                    "targets": [7],
                    render: function(data, type, full, meta) {
                        if (full.incident) {
                            var transactionType = full.incident.transaction_type;
                            if (transactionType == '0')
                                return 'Reload';
                            else if (transactionType == '1')
                                return 'Activation';
                            else if (transactionType == '2')
                                return 'Refund';
                            else
                                return '';
                        }
                        return '';
                    }
                },
                {
                    "targets": [8],
                    render: function(data, type, full, meta) {
                        if (full.incident.incident_currency && full.incident.incident_currency.length > 0) {
                            var InternationalCurrency = '';
                            $.each(full.incident.incident_currency, function(key, data) {
                                var currencyType = data.inci_currency_type.substring(0, 3);
                                InternationalCurrency += currencyType + '<br>';
                            });
                            return InternationalCurrency;
                        }
                        return '';
                    }
                },
                {
                    "targets": [9],
                    render: function(data, type, full, meta) {
                        if (full.incident.incident_currency && full.incident.incident_currency.length > 0) {
                            var Amount = '';
                            $.each(full.incident.incident_currency, function(key, data) {
                                Amount += data.inci_frgn_curr_amount + '<br>';
                            });
                            return Amount;
                        }
                        return '';
                    }
                },
                {
                    "targets": [10],
                    render: function(data, type, full, meta) {
                        if (full.incident.incident_currency && full.incident.incident_currency.length > 0) {
                            var IndianCurrency = '';
                            $.each(full.incident.incident_currency, function(key, data) {
                                IndianCurrency += 'INR<br>';
                            });
                            return IndianCurrency;
                        }
                        return '';
                    }
                },
                {
                    "targets": [11],
                    render: function(data, type, full, meta) {
                        if (full.incident.incident_currency && full.incident.incident_currency.length > 0) {
                            var Amount = '';
                            $.each(full.incident.incident_currency, function(key, data) {
                                Amount += data.inci_inr_amount + '<br>';
                            });
                            return Amount;
                        }
                        return '';
                    }
                },
                {
                    "targets": [12],
                    render: function(data, type, full, meta) {
                        if (full.incident.incident_currency && full.incident.incident_currency.length > 0) {
                            var Amount = '';
                            $.each(full.incident.incident_currency, function(key, data) {
                                Amount += data.inci_currency_rate + '<br>';
                            });
                            return Amount;
                        }
                        return '';
                    }
                },
                {
                    "targets": [13],
                    render: function(data, type, full, meta) {
                        if ((full.incident.buy_documents && full.incident.buy_documents.length > 0) || (full
                                .incident.sell_documents && full.incident.sell_documents.length > 0)) {
                            return 'Yes';
                        }
                        return 'No';
                    }
                },
                {
                    "targets": [14],
                    render: function(data, type, full, meta) {
                        if (full.inci_up_accept_status) {
                            var acceptStatus = full.inci_up_accept_status;
                            if (acceptStatus == '0')
                                return 'Under Process';
                            else if (acceptStatus == '1')
                                return 'Accepted';
                            else if (acceptStatus == '2')
                                return 'Rejected';
                            else
                                return '';
                        }
                        return '';
                    }
                },
                {
                    "targets": [15],
                    render: function(data, type, full, meta) {
                        if (full.incident.inci_departure_date) {
                            var departureDate = full.incident.inci_departure_date;
                            if (departureDate != null)
                                return departureDate;
                            else
                                return '';
                        }
                        return '';
                    }
                },
                {
                    "targets": [18],
                    render: function(data, type, full, meta) {
                        return 'Admin';
                    }
                },
                {
                    "targets": [20],
                    render: function(data, type, full, meta) {
                        if (full.inci_up_date) {
                            return moment(full.inci_up_date).format('DD-MM-YYYY');
                        }
                        return '';
                    }
                },
                {
                    "targets": [22],
                    render: function(data, type, full, meta) {
                        if (full.inci_up_received_date) {
                            return moment(full.inci_up_received_date).format('DD-MM-YYYY');
                        }
                        return '';
                    }
                },
                {
                    "targets": [24],
                    render: function(data, type, full, meta) {
                        if (full.created_at) {
                            return moment(full.created_at).format('DD-MM-YYYY HH:mm:ss');
                        }
                        return '';
                    }
                },

            ],
            dataTable = callDataTable('data-datatable', '{!! route('admin-incidents.data') !!}', filters, columns, '', '',
                columnDefs);

        $('#filterBtn').click(function() {
            filters['from_date'] = $('#from_date').val();
            filters['to_date'] = $('#to_date').val();
            $('#data-datatable').DataTable().ajax.reload();
        });

    });

    function exportExcel() {
        var data = {};
        data['from_date'] = $('#from_date').val();
        data['to_date'] = $('#to_date').val();
        $.ajax({
            url: "{!! route('admin-incidents.export') !!}",
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                window.location.href = result.data.path;
            }
        });
    }
</script>
