

<!-- Vendor js -->
<script src="<?php echo e(asset('assets/js/vendor.min.js')); ?>"></script>
<!-- App js -->
<script src="<?php echo e(asset('assets/js/app.min.js')); ?>"></script>
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-23581568-13');
</script>

<script>
    // Password show/hide
    $(document).ready(function() {
        $(".login-password").mousedown(function() {
            $("#password").attr("type", "text");
            $(".password-eye").removeClass("fa-eye-slash");
            $(".password-eye").addClass("fa-eye");
        });
        $(".login-password").mouseup(function() {
            $("#password").attr("type", "password");
            $(".password-eye").addClass("fa-eye-slash");
            $(".password-eye").removeClass("fa-eye");
        });

        $(".confirm-password").mousedown(function() {
            $("#password-confirm").attr("type", "text");
            $(".password-eye-c").removeClass("fa-eye-slash");
            $(".password-eye-c").addClass("fa-eye");
        });
        $(".confirm-password").mouseup(function() {
            $("#password-confirm").attr("type", "password");
            $(".password-eye-c").addClass("fa-eye-slash");
            $(".password-eye-c").removeClass("fa-eye");
        });
    })
</script>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/partials/auth-script.blade.php ENDPATH**/ ?>