@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('title', 'Dashboard | Direktori Jabatan')

@section('content')
            <div id="indonesia-power" style="height: 300px;"></div>
            <div class="row text-center" id="cluster">
                <div class="col-md-4">
                    <a href="{{ route('cluster.detail', 1) }}">
                        <div id="cluster1" style="height: 250px;"></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('cluster.detail', 2) }}">
                        <div id="cluster2" style="height: 250px;"></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('cluster.detail', 3) }}">
                        <div id="cluster3" style="height: 250px;"></div>
                    </a>
                </div>
            </div>
@endsection

@section('script')

    <script>
      $(document).ready(function() {

        new Morris.Donut({
            element: 'indonesia-power',
            data: [{
                label: "Indonesia Power",
                value: 100
            }],
            colors: ['#14A2B8'],
            resize: true
        });

        new Morris.Donut({
            element: 'cluster1',
            data: [{
                label: "Cluster 1",
                value: 100
            }],
            colors: ['#14A2B8'],
            resize: true
        });

        new Morris.Donut({
            element: 'cluster2',
            data: [{
                label: "Cluster 2",
                value: 100
            }],
            colors: ['#14A2B8'],
            resize: true
        });

        new Morris.Donut({
            element: 'cluster3',
            data: [{
                label: "Cluster 3",
                value: 100
            }],
            colors: ['#14A2B8'],
            resize: true
        });
    });
    </script>
@endsection
