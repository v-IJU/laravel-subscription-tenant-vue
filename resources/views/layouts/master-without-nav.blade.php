<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') |
        {{ isset(Configurations::getConfig('site')->site_name) ? Configurations::getConfig('site')->site_name : '' }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Vivek Admin & Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->

    <link rel="title icon"
        href="{{ isset(Configurations::getConfig('site')->site_icon) ? URL::asset(Configurations::getConfig('site')->site_icon) : '' }}">

    @include('layouts.head-css')
</head>

@yield('body')

@yield('content')

@include('layouts.vendor-scripts')
</body>

</html>
