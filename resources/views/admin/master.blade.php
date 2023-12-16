<!DOCTYPE html>
<!--[if IE 9]>
<html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-focus"> <!--<![endif]-->
<head>
    {{--Header Files--}}
    @include('admin.includes.headerfiles')
    {{--End Header Files--}}
    @yield('custom-styles')
    <title>@yield('title')-{{config('app.name')}}</title>
</head>
<body>
{{-- Page Container --}}
<div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">

    {{--Sidebar--}}
    @include('admin.includes.sidebar')
    {{--END Sidebar--}}

    {{-- Header --}}
    @include('admin.includes.header')
    {{--END Header--}}

    {{--Main Container--}}
    <main id="main-container">
        @yield('maincontent')
    </main>
    {{--END Main Container--}}

    {{--Footer--}}
    @include('admin.includes.footer')
    {{--END Footer--}}
</div>
{{-- END Page Container --}}


{{--OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js --}}
{{--Footer Files--}}
@include('admin.includes.footerfiles')
@include('admin.includes.notifications')
{{--End Footer Files--}}
@yield('custom-js')
</body>
</html>