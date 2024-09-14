<!DOCTYPE html>
<html lang="en">
<head>
<meta name="robots" content="noindex, nofollow">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ getPath('admin') }}/img/64.png" />
<title>{{ getConstant('SITE_NAME')  }} | @yield('title')</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="{{ getPath('admin') }}/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="{{ getPath('admin') }}/css/adminlte.min.css">
<link rel="stylesheet" href="{{ getPath('admin') }}/custom/css/custom.css">
@stack('styles')
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    @include('admin.includes.header')
    @include('admin.includes.sidebar')
    @yield('content')
    @include('admin.includes.footer')
</div>
<script src="{{ getPath('admin') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ getPath('admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ getPath('admin') }}/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>
