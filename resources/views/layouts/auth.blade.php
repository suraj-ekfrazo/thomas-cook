<!DOCTYPE html>
<html>

<head>
    @include('partials.auth-head')
    @include('partials.auth-style')
    @stack('pagestyle')
</head>

<body class="authentication-bg authentication-bg-pattern">
    @yield('content')
    @include('partials.auth-script')
    @stack('pagescript')
</body>

</html>
