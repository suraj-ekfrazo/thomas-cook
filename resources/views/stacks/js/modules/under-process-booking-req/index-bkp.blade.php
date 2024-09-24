<script>
    $(function() {
        var
            filters = {
                search: "",
                page: "",
                from_date: "",
                to_date: "",
            },
            columns = [
                /* 0th */
                {
                    data: 'id',
                    orderable: true
                },
                {
                    data: 'inci_number',
                    orderable: true
                },
                {
                    data: '',
                    orderable: true
                },
                {
                    data: 'id',
                    orderable: true
                },
                {
                    data: '',
                    orderable: true
                },
                /* 5th */
                {
                    data: 'inci_forex_card_no',
                    orderable: true
                },
                {
                    data: 'inci_passport_number',
                    orderable: true
                },
                {
                    data: '',
                    orderable: true
                },
                {
                    data: '',
                    orderable: true
                },
                {
                    data: '',
                    orderable: true
                },
                // 10th start
                {
                    data: '',
                    orderable: true
                },

                {
                    data: 'inci_inr_amount',
                    orderable: true
                },
                {
                    data: 'inci_currency_rate',
                    orderable: true
                },

                {
                    data: '',
                    orderable: true
                },

                {
                    data: 'inci_number',
                    orderable: true
                },
                //15th
                {
                    data: 'inci_departure_date',
                    orderable: true
                },

                {
                    data: '',
                    orderable: true
                },
                {
                    data: '',
                    orderable: true
                },

                {
                    data: '',
                    orderable: false
                },

                //20th
                {
                    data: '',
                    orderable: false
                },
                {
                    data: '',
                    orderable: false
                },
                {
                    data: 'inci_recived_date',
                    orderable: false
                },
                {
                    data: 'inci_recived_time',
                    orderable: false
                },
                {
                    data: '',
                    orderable: false
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

                        if (full.incident_assign) {
                            return full.incident_assign.user_code;
                        }
                        return '';
                    }
                },
                {
                    "targets": [3],
                    render: function(data, type, full, meta) {
                        if (full.agent) {
                            return full.agent.agent_key;
                        }
                        return '';
                    }
                },
                {
                    "targets": [4],
                    render: function(data, type, full, meta) {
                        if (full.agent) {
                            return full.agent.first_name + ' ' + full.agent.last_name;
                        }
                        return '';
                    }
                },
                {
                    "targets": [7],
                    render: function(data, type, full, meta) {
                        if (full.transaction_type) {
                            var transactionType = full.transaction_type;
                            if (transactionType == '1')
                                return 'Activation';
                            else if (transactionType == '2')
                                return 'Reload';
                            else if (transactionType == '3')
                                return 'Activation + Reload';
                            else if (transactionType == '4')
                                return 'Encashment';
                            else
                                return '';
                        }
                        return '';
                    }
                },
                {
                    "targets": [8],
                    render: function(data, type, full, meta) {
                        var incidentCurrency = '';
                        if (full.incident_currency) {
                            if (full.incident_currency.length > 0) {
                                full.incident_currency.forEach(element => {
                                    incidentCurrency += element.inci_currency_type;
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
                        var frgn_curr_amount = '';
                        if (full.incident_currency) {
                            if (full.incident_currency.length > 0) {
                                full.incident_currency.forEach(element => {
                                    frgn_curr_amount += element.inci_frgn_curr_amount;
                                });
                                return frgn_curr_amount;
                            }
                        }
                        return '';
                    }
                },

                {
                    "targets": [10],
                    render: function(data, type, full, meta) {
                        return 'INR';
                    }
                },

                {
                    "targets": [11],
                    render: function(data, type, full, meta) {
                        var inr_amount = '';
                        if (full.incident_currency) {
                            if (full.incident_currency.length > 0) {
                                full.incident_currency.forEach(element => {
                                    inr_amount += element.inci_inr_amount;
                                });
                                return inr_amount;
                            }
                        }
                        return '';
                    }
                },

                {
                    "targets": [12],
                    render: function(data, type, full, meta) {
                        var inci_curr_rate = '';
                        if (full.incident_currency) {
                            if (full.incident_currency.length > 0) {
                                full.incident_currency.forEach(element => {
                                    inci_curr_rate += element.inci_currency_rate;
                                });
                                return inci_curr_rate;
                            }
                        }
                        return '';
                    }
                },
                {
                    "targets": [13],
                    render: function(data, type, full, meta) {
                        if ((full.buy_documents && full.buy_documents.length > 0) || (full
                                .sell_documents && full.sell_documents.length > 0)) {
                            return 'Yes';
                        }
                        return 'No';
                    }
                },

                {
                    "targets": [14],
                    render: function(data, type, full, meta) {

                        newStatus = '';
                        if (full.inci_status == 0) {
                            newStatus = "Rejected";
                        } else if (full.inci_status == 1) {
                            newStatus = "Accepted";
                        } else if (full.inci_status == 2) {
                            newStatus = "Expired";
                        } else if (full.inci_status == 3) {
                            newStatus = "Under Process";
                        }
                        return newStatus;
                    }
                },

                {
                    "targets": [15],
                    render: function(data, type, full, meta) {
                        if (full.inci_departure_date) {
                            return moment(full.inci_departure_date).format('DD-MM-YYYY');
                        }
                        return '';
                    }
                },

                {
                    "targets": [16],
                    render: function(data, type, full, meta) {
                        if (full.bordox_no) {
                            return full.bordox_no;
                        }
                        return '';
                    }
                },
                {
                    "targets": [17],
                    render: function(data, type, full, meta) {
                        return 'Admin';
                    }
                },
                {
                    "targets": [18],
                    render: function(data, type, full, meta) {
                        if (full.inci_recived_date) {
                            return moment(full.inci_recived_date).format('DD-MM-YYYY');
                        }
                        return '';
                    }
                },

                //doc upload
                {
                    "targets": [19],
                    render: function(data, type, full, meta) {
                        var doc_upload = '';
                        if (full.sell_documents) {
                            if (full.sell_documents.length > 0) {
                                full.sell_documents.forEach(element => {
                                    doc_upload += element.created_at;
                                });
                                return moment(doc_upload).format('DD-MM-YYYY');
                            }
                        }
                        return '';
                    }
                },
                {
                    "targets": [20],
                    render: function(data, type, full, meta) {
                        var doc_upload_time = '';
                        if (full.sell_documents) {
                            if (full.sell_documents.length > 0) {
                                full.sell_documents.forEach(element => {
                                    doc_upload_time += element.created_at;
                                });
                                return moment(doc_upload_time).format('HH:mm');
                            }
                        }
                        return '';
                    }
                },

                //completed date
                {
                    "targets": [21],
                    render: function(data, type, full, meta) {
                        if (full.inci_recived_date) {
                            //return moment(full.incident_update.inci_up_received_date).format('DD-MM-YYYY');
                            return moment(full.inci_recived_date).format('DD-MM-YYYY');

                        }
                        return '';
                    }
                },
                {
                    "targets": [22],
                    render: function(data, type, full, meta) {
                        if (full.inci_recived_time) {
                            return full.inci_recived_time;
                        }
                        return '';
                    }
                },
                {
                    "targets": [23],
                    render: function(data, type, full, meta) {
                        if (full.inci_status_message) {
                            return full.inci_status_message;
                        }
                        return '';
                    }
                },

            ],
            dataTable = callDataTable('data-datatable', '{!! route('under-process-request.data') !!}', filters, columns, '', '',
                columnDefs);

        $('#filterBtn').click(function() {
            filters['from_date'] = $('#from_date').val();
            filters['to_date'] = $('#to_date').val();
            $('#data-datatable').DataTable().ajax.reload();
        });

        $('.type').click(function() {
            filters['type'] = $(this).data('type');
            $('#data-datatable').DataTable().ajax.reload();
        });

    });

    function exportExcel() {
        var data = {};
        data['from_date'] = $('#from_date').val();
        data['to_date'] = $('#to_date').val();
        $.ajax({
            url: "{!! route('under-process-request.export') !!}",
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
