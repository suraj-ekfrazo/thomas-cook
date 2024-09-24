{{-- <footer class="footer footer-alt">

    <script>
        document.write(new Date().getFullYear())
    </script> &copy; <a href="javascript:void(0);" class="text-white-50">{{ config('app.name') }}</a>
</footer> --}}

<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-23581568-13');
</script>
{{-- <script defer=""
    src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194"
    integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw=="
    data-cf-beacon="{&quot;rayId&quot;:&quot;742abde259e48563&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;,&quot;version&quot;:&quot;2022.8.0&quot;,&quot;si&quot;:100}"
    crossorigin="anonymous"></script> --}}
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
