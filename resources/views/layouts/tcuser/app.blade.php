<!DOCTYPE html>
<html>

<head>
    @include('partials.tcuser-head')
    @include('partials.tcuser-style')
    @stack('pagestyle')
</head>

<body
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    @yield('content')
</body>

</html>
