<!DOCTYPE html>
<html>

<head>
    <?php echo $__env->make('partials.auth-head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.auth-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('pagestyle'); ?>
</head>

<body class="authentication-bg authentication-bg-pattern">
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('partials.auth-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('pagescript'); ?>
</body>

</html>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/layouts/auth.blade.php ENDPATH**/ ?>