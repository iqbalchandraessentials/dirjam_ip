@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('title', 'Dashboard | Direktori Jabatan')

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="box-title text-center">
                    <h1>Cluster Detail</h1>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                @foreach ($chartData as $v)
                    <div id="{{ $v['element'] }}" style="height: 200;"></div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            @foreach ($chartData as $v)
            new Morris.Donut({
                element: '{{ $v['element'] }}',
                data: {!! json_encode($v['data']) !!},
                colors: {!! json_encode($v['colors']) !!},
                resize: {{ $v['resize'] ? 'true' : 'false' }}
            });
            @endforeach
        });
    </script>
@endsection
