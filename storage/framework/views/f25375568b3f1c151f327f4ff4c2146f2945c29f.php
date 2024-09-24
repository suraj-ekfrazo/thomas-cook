<!DOCTYPE html>
<html>

<head>
    <?php echo $__env->make('partials.tcuser-head_main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    
</head>

<body
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <?php echo $__env->yieldContent('content'); ?>
</body>
<?php echo $__env->make('partials.tcuser-script_main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('pagescript'); ?>

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
            sProcessing: "<?php echo e(trans('app.processing')); ?>",
            sLengthMenu: "<?php echo e(trans('app.show_entries')); ?>",
            sZeroRecords: "<?php echo e(trans('app.no_records')); ?>",
            sInfo: "<?php echo e(trans('app.pagination_info')); ?>",
            sInfoEmpty: "<?php echo e(trans('app.pagination_empty')); ?>",
            sInfoFiltered: "<?php echo e(trans('app.pagination_filtered')); ?>",
            sInfoPostFix: "",
            sSearch: "<?php echo e(trans('Search')); ?>",
            sUrl: "",
            sEmptyTable: "<?php echo e(trans('app.empty_table')); ?>",
            sLoadingRecords: "<?php echo e(trans('app.loading')); ?>",
            sInfoThousands: ",",
            oPaginate: {
                sFirst: "<?php echo e(trans('app.first')); ?>",
                sLast: "<?php echo e(trans('app.last')); ?>",
                sNext: "<?php echo e(trans('app.next')); ?>",
                sPrevious: "<?php echo e(trans('app.previous')); ?>"
            },
            oAria: {
                sSortAscending: ": activate to sort column ascending",
                sSortDescending: ": activate to sort column descending"
            },
        }
    };
</script>


</html>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/layouts/tcuser/appmain.blade.php ENDPATH**/ ?>