<script>
    function callDataTable(element, url, filters, columns, dataFilter, drawCallBack, columnDefs, createdRow, rowCallback=null) {
        var dataTable = $('#' + element);

        //console.log(dataTableOptions);
        return dataTable.DataTable({

            ...dataTableOptions,
            ajax: {
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: "application/json",
                dataType: "json",
                data: function(json) {
                    json = {
                        ...json,
                        ...filters,
                        "search_keywords": $(".dataTables_filter input").val().toLowerCase(),
                    };
                    return JSON.stringify(json);
                },
                dataFilter: dataFilter,
            },
            columns: columns,
            columnDefs: columnDefs,
            drawCallback: drawCallBack,
            createdRow: createdRow,
	    rowCallback: rowCallback,
        });
    }
</script>
