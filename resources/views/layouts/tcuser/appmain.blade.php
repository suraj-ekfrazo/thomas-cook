<!DOCTYPE html>
<html>

<head>
    @include('partials.tcuser-head_main')
    {{-- @include('partials.tcuser-style') --}}
    {{-- @stack('pagestyle') --}}
</head>

<body
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    @yield('content')
</body>
@include('partials.tcuser-script_main')
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
        processing: false,
        serverSide: true,
        searching: true,
        lengthChange: true,
        aaSorting: [
            [0, "desc"]
        ],
        pageLength: 10,
        pagingType: 'full_numbers',
        order: [
            [0, "desc"]
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


</html>
