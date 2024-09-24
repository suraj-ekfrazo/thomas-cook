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
                    data: 'inci_frgn_curr_amount',
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

                // {
                //     data: '',
                //     orderable: false
                // },
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
                        if (full.incident_currency && full.incident_currency.length > 0) {
                            var InternationalCurrency = '';
                            $.each(full.incident_currency, function(key, data) {
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
                        if (full.incident_currency && full.incident_currency.length > 0) {
                            var amount = '';
                            $.each(full.incident_currency, function(key, data) {
                                amount += data.inci_frgn_curr_amount + '<br>';
                            });
                            return amount;
                        }
                        return '';
                    }
                },

                {
                    "targets": [10],
                    render: function(data, type, full, meta) {
                        if (full.incident_currency && full.incident_currency.length > 0) {
                            var rate = '';
                            $.each(full.incident_currency, function(key, data) {
                                rate += data.inci_currency_rate + '<br>';
                            });
                            return rate;
                        }
                        return '';
                    }
                },
                {
                    "targets": [11],
                    render: function(data, type, full, meta) {
                        if (full.incident_currency && full.incident_currency.length > 0) {
                            var inr_amount = '';
                            $.each(full.incident_currency, function(key, data) {
                                inr_amount += data.inci_inr_amount + '<br>';
                            });
                            return inr_amount;
                        }
                        return '';
                    }
                },
                {
                    "targets": [12],
                    render: function(data, type, full, meta) {
                        if ((full.buy_documents && full.buy_documents.length > 0) || (full
                            .sell_documents && full.sell_documents.length > 0)) {
                            return 'Yes';
                        }
                        return 'No';
                    }
                },

                {
                    "targets": [13],
                    render: function(data, type, full, meta) {

                        if(full.inci_status==0){
                            newStatus = "Rejected";
                        } else if (full.inci_status == '1') {
                            newStatus = "Approved";
                        } else if (full.inci_status == '2') {
                            newStatus = "Expired";
                        } else{
                            newStatus = "Under Process";
                        }
                        return newStatus;
                    }
                },
                {
                    "targets": [14],
                    render: function(data, type, full, meta) {
                        if (full.inci_departure_date && full.inci_departure_date!="1970-01-01") {
                            return moment(full.inci_departure_date).format('DD-MM-YYYY');
                        }
                        return '';
                    }
                },
                {
                    "targets": [15],
                    render: function(data, type, full, meta) {
                        if (full.bordox_no) {
                            return full.bordox_no;
                        }
                        return '';
                    }
                },
                {
                    "targets": [16],
                    render: function(data, type, full, meta) {
                        return 'Admin';
                    }
                },
                {
                    "targets": [17],
                    render: function(data, type, full, meta) {
                        if (full.inci_create_time) {
                            return moment(full.inci_create_time).format('DD-MM-YYYY');
                            //return full.inci_create_time;
                        }
                        return '';
                    }
                },
                // {
                //     "targets": [19],
                //     render: function(data, type, full, meta) {
                //         if (full.incident_update) {
                //             return full.incident_update.inci_up_time;
                //         }
                //         return '';
                //     }
                // },
                {
                    "targets": [18],
                    render: function(data, type, full, meta) {
                        if (full.inci_create_time) {
                            return moment(full.inci_create_time).format('HH:mm:ss');
                            //return full.inci_create_time;
                        }
                        return '';
                    }
                },
                {
                    "targets": [19],
                    render: function(data, type, full, meta) {
                        if (full.inci_recived_date) {
                            return moment(full.inci_recived_date).format('DD-MM-YYYY');
                        }
                        return '';
                    }
                },
                {
                    "targets": [20],
                    render: function(data, type, full, meta) {
                        if (full.inci_recived_time) {
                            return full.inci_recived_time;
                        }
                        return '';
                    }
                },
                {
                    "targets": [21],
                    render: function(data, type, full, meta) {
                        if (full.completed_at != null) {
                            return moment(full.completed_at).format('DD-MM-YYYY');
                        }
                        return '';
                    }
                },
                {
                    "targets": [22],
                    render: function(data, type, full, meta) {
                        if (full.completed_at != null) {
                            return moment(full.completed_at).format('HH:mm:ss');
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
                {
                    "targets": [24],
                    render: function(data, type, full, meta) {
                        if (full.created_at) {
                            return moment(full.created_at).format('DD-MM-YYYY');
                        }
                        return '';
                    }
                },

                {
                    "targets": [25],
                    className: 'r-col-action',
                    render: function(data, type, full, meta) {
                        if (full.id) {
                            var id = full.id;
                            var routeUrl = '<?php echo e(url("admin-incident-requests/documents")); ?>/' + id;
                            return '<a href="' + routeUrl +
                                '" class="btn  btn-info py-1 px-3" title="View Document"><i class="fa-solid fa-eye fa-sm"></i></a>';
                        }
                        return '';
                    }
                },
            ],
            dataTable = callDataTable('data-datatable', '<?php echo route("admin-incident-requests.data"); ?>', filters, columns, '', '',
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
            url: "<?php echo route('admin-incident-requests.export'); ?>",
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
</script><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/stacks/js/modules/admin-incident-requests/index.blade.php ENDPATH**/ ?>