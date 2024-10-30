<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    @include('Layouts._head')
    @stack('prepend-style')
    @stack('addon-style')
</head>

<body class="hold-transition bg-img bg-custom" data-overlay="1">
    {{-- Page Content --}}
    @yield('content')
</body>

@include('Layouts._script')