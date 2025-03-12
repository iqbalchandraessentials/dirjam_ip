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
            <div class="col-12">
                <div class="row">
                    @foreach ($chartData as $v)
                        <div class="col-4">
                            <div id="{{ $v['element'] }}" style="height: 200px;"></div>
                        </div>
                    @endforeach
                </div>
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
            colors: ["#14A2B8", "#213339"], // Warna dalam format string
            resize: true
        });
        @endforeach
    });
</script>
@endsection

