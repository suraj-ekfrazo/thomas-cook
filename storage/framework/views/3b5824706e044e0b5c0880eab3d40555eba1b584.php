<script>
    $(function() {

        var
            filters = {
                search: "",
                page: "",
                from_date: "null",
                to_date: "null"
            },
            columns = [],
            columnDefs = [{
                    "targets": [0],
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "targets": [1],
                    render: function(data, type, full, meta) {

                    	if (full.incident_assign) {
				return full.incident_assign.name ? full.incident_assign.name : 'Admin';
                        
			}
			return 'Admin';
                    }
                },
                {
                    "targets": [2],
                    render: function(data, type, full, meta) {
                        if (full.assigned_count) {
                            return full.assigned_count;
                        }
                        return '0';
                    }
                },
                {
                    "targets": [3],
                    render: function(data, type, full, meta) {
                        if (full.approved_count) {
                            return full.approved_count;
                        }
                        return '0';
                    }
                },
                {
                    "targets": [4],
                    render: function(data, type, full, meta) {
                        if (full.rejected_count) {
                            return full.rejected_count;
                        }
                        return '0';
                    }
                },
                {
                    "targets": [5],
                    render: function(data, type, full, meta) {
                        if (full.pending_count) {
                            return full.pending_count;
                        }
                        return '0';
                    }
                },
                {
                    "targets": [6],
                    render: function(data, type, full, meta) {
                        if (full.before7_count) {
                            return full.before7_count;
                        }
                        return '0';
                    }
                },
                {
                    "targets": [7],
                    render: function(data, type, full, meta) {
                        if (full.after7_count) {
                            return full.after7_count;
                        }
                        return '0';
                    }
                },
            ],
            dataTable = callDataTable('data-datatable', '<?php echo route('admin-incidents.tcuser-summary-report'); ?>', filters, columns, '', '',
                columnDefs);
        $('#data-datatable').DataTable().ajax.reload();
        $('#filterBtn').click(function() {
            filters['from_date'] = $('#from_date').val();
            filters['to_date'] = $('#to_date').val();
            filters['tcuser_id'] = $('#tcuser_id').val();
            $('#data-datatable').DataTable().ajax.reload();
        });
    });
    //select 2
    $(document).ready(function() {
        $('#tcuser_id').select2();
    });

    function exportExcel() {
        var data = {};
        data['from_date'] = $('#from_date').val();
        data['to_date'] = $('#to_date').val();
        data['tcuser_id'] = $('#tcuser_id').val();
        $.ajax({
            url: "<?php echo route('admin-incidents.export-tc-user-report'); ?>",
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
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/stacks/js/modules/admin-incidents/tc-user-summary-report.blade.php ENDPATH**/ ?>