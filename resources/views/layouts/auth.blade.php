<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- dinamis title --}}
    <title>@yield('title', 'Direktori Jabatan')</title>
    <link rel="icon" href="{{ asset('img/dirjab_favicon.ico') }}">
    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.css') }}">
    <!-- Bootstrap extend-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-extend.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/master_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.css') }}">
    @stack('prepend-style')
    @stack('addon-style')
</head>

<body class="hold-transition bg-img bg-custom" data-overlay="1">
    {{-- Page Content --}}
    @yield('content')
</body>
        <!-- jQuery 3 -->
        <script src="{{ asset('vendor/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
        <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/bootstrap.js') }}"></script>