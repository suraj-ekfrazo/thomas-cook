<!DOCTYPE html>
<html>

<head>
    @include('partials.head')
    @include('partials.style')
    @stack('pagestyle')
</head>

<body
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <div class="">
        @include('partials.header')
        @yield('content')
    </div>
    @include('partials.footer')
    @include('partials.script')
    @include('stacks.js.script')
    @stack('pagescript')
    <script>
        var dataTableOptions = {
            // dom: '<""' +
            //     'rt' +
            //     '<"datatable-footer"' +
            //     '<"datatable-footer-inner row"' +
            //     '<"col"' +
            //     '<"page-count pull-right"i>' +
            //     '>' +
            //     '<"col-md-auto col"' +
            //     '<"datatable-pager"p>' +
            //     '>' +
            //     '>' +
            //     '>' +
            //     '>',
            dom: 'Blfrtip',
            buttons: [{
                "extend": 'excel',
                "text": '<span class="text-white">Export</span>',
                "titleAttr": 'Excel',
                //"title": '{{ Request::segment(1) }}',
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                },
                title: function() {
                    var title = '{{ Request::segment(1) }}';
                    if (title != null) {
                        return title;
                    } else {
                        return title = 'Thomas-cook';
                    }
                },
                filename: function() {
                    var filename = '{{ Request::segment(1) }}';
                    if (filename != null) {
                        return filename;
                    } else {
                        return filename = 'Thomas-cook';
                    }
                }

            }, ],
            processing: false,
            serverSide: true,
            searching: true,
            lengthChange: true,
            aaSorting: [
                [0, "desc"]
            ],
            pageLength: 25,
            pagingType: 'full_numbers',
            order: [
                [1, "desc"]
            ],
            language: {
                sProcessing: "{{ trans('app.processing') }}",
                sLengthMenu: "{{ trans('app.show_entries') }}",
                sZeroRecords: "{{ trans('app.no_records') }}",
                sInfo: "{{ trans('app.pagination_info') }}",
                sInfoEmpty: "{{ trans('app.pagination_empty') }}",
                sInfoFiltered: "{{ trans('app.pagination_filtered') }}",
                sInfoPostFix: "",
                sSearch: "{{ trans('Search') }}",
                sUrl: "",
                sEmptyTable: "{{ trans('app.empty_table') }}",
                sLoadingRecords: "{{ trans('app.loading') }}",
                sInfoThousands: ",",
                oPaginate: {
                    sFirst: "{{ trans('app.first') }}",
                    sLast: "{{ trans('app.last') }}",
                    sNext: "{{ trans('app.next') }}",
                    sPrevious: "{{ trans('app.previous') }}"
                },
                oAria: {
                    sSortAscending: ": activate to sort column ascending",
                    sSortDescending: ": activate to sort column descending"
                },
            }
        };
    </script>
</body>

</html>
