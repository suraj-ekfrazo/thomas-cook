<!DOCTYPE html>
<html>

<head>
    <?php echo $__env->make('partials.tcuser-head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.tcuser-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('pagestyle'); ?>
</head>

<body
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <?php echo $__env->yieldContent('content'); ?>
</body>

</html>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/layouts/tcuser/app.blade.php ENDPATH**/ ?>