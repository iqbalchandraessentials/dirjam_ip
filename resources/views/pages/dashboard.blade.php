@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('title', 'Dashboard | Direktori Jabatan')
@section('content')
<div class="box">
    <div class="box-body">
            <div class="row justify-content-center">
                <div class="col-6">
                    <div id="IndonesiaPower" style="height: 300px;"></div>
                </div>
            </div>
            
            <div class="row mt-4">
                @foreach ($chartdata as $v)
                    @if ($v['element'] !== 'IndonesiaPower')
                        <div class="col-4">
                            <a href="{{route('cluster.detail', $v['element'])}}">
                                <div id="{{ $v['element'] }}" style="height: 200px;"></div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
            </div>
            </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Chart Indonesia Power dengan warna khusus
        new Morris.Donut({
            element: 'IndonesiaPower',
            data: {!! json_encode(collect($chartdata)->firstWhere('element', 'IndonesiaPower')['data']) !!},
            colors: ["#14A3B9"],
            resize: true
        });

        // Chart lainnya
        @foreach ($chartdata as $v)
            @if ($v['element'] !== 'IndonesiaPower')
                new Morris.Donut({
                    element: '{{ $v['element'] }}',
                    data: {!! json_encode($v['data']) !!},
                    colors: ["#14A2B8", "#FF5733", "#28A745", "#FFC107", "#6C757D", "#17A2B8", "#DC3545"], // Warna random
                    resize: true
                });
            @endif
        @endforeach
    });
</script>
@endsection