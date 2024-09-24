<!DOCTYPE html>
<html>
    <head>
        <?php echo $__env->make('partials.agent-head_main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        
    </head>
    <body data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
        <?php echo $__env->yieldContent('content'); ?>
    </body>
    <?php echo $__env->make('partials.agent-script_main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('pagescript'); ?>



</html>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/layouts/agent/appmain.blade.php ENDPATH**/ ?>