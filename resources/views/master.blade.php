<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="{{ asset('img/dirjab_favicon.ico') }}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        @include('Layouts._head')
        @yield('head')

    </head>
    <body class="skin-light light-sidebar sidebar-mini fixed">
        <div class="wrapper">
            @include('Layouts._navbar')
            <!-- Left side column. contains the logo and sidebar -->
            {{-- @if(auth()->user()->hasRole('Admin')) --}}
            @include('Layouts._sidebarAdmin')
            {{-- @else
            @include('Layouts._sidebar')
            @endif --}}
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="container">
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                        <div class="d-flex align-items-center">
                            @yield('breadcrumb')
                        </div>
                    </div>
                    <!-- Main content -->
                    <section class="content">
                        @yield('content')
                    </section>
                    <!-- /.content -->
                </div>
            </div>
            <footer class="main-footer">
                <?php
                    echo "&copy;" . date("Y") . " All Rights Reserved";
                ?>
            </footer>
        </div>
        @include('Layouts._script')
        @yield('script')
    </body>
</html>
