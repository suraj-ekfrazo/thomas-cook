<!DOCTYPE html>
<html>
    <head>
        @include('partials.agent-head_main')
        {{--@include('partials.agent-style')--}}
        {{--@stack('pagestyle')--}}
    </head>
    <body data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
        @yield('content')
    </body>
    @include('partials.agent-script_main')
    @stack('pagescript')



</html>
