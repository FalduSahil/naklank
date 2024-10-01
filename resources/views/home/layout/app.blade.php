<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') {{ getConstant('SITE_NAME') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ getPath('common') }}/images/64-round.png"/>
    <link href="{{ getPath('home') }}/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/feather-webfont/dist/feather-icons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ getPath('home') }}/css/theme.min.css"/>

    @stack('styles')
</head>

<body>

@include('home.includes.nav')

<main>
    @yield('content')
</main>

@include('home.includes.footer')


<script src="{{ getPath('home') }}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ getPath('home') }}/libs/simplebar/dist/simplebar.min.js"></script>
<script src="{{ getPath('home') }}/js/theme.min.js"></script>
<script src="{{ getPath('home') }}/js/vendors/jquery.min.js"></script>

@stack('scripts')
</body>
</html>