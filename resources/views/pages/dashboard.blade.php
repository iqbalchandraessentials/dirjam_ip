@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('title', 'Dashboard | Direktori Jabatan')

@section('content')
<div class="box shadow">
    <div class="box-header">
        <div class="row">
            <div class="box-title text-center">
                <h1>Dashboard</h1>
            </div>
            <hr>
        </div>
    </div>
        <div class="box-body">
            {{-- Tampilan untuk Indonesia Power --}}
            <div class="row">
            <div class="col-12 col-md-8 col-xl-3">
                    <div class="flexbox flex-justified text-center mb-30 bg-primary">
                        <div class="no-shrink py-30">
                            <span class="ti-bolt font-size-50"></span>
                        </div>
                        <div class="py-30 bg-white text-dark">
                            <div class="font-size-30">{{ $persen_indonesia_power }}/<span class="font-size-18">{{ $sisa_persen_indonesia_power }}</span></div>
                            <span>Indonesia Power</span>
                        </div>
                    </div>
                </div>
                {{-- Tampilan untuk Jenis Progres lainnya --}}
                @foreach($dataPersen as $data)
                    @if ($data['jenis'] !== 'Indonesia Power')
                    <div class="col-12 col-md-6 col-xl-3">
                    <div class="flexbox flex-justified text-center mb-30 bg-danger">
                        <a href=" {{route('cluster.detail', $data['jenis'])}} ">
                            <div class="no-shrink py-30 text-white">
                                <span class="ti-briefcase font-size-50"></span>
                            </div>
                        </a>
                        <div class="py-30 bg-white text-dark">
                            <div class="font-size-30">{{  $data['persen'] }}/<span class="font-size-18">{{ $data['sisa_persen'] }}</span></div>
                            <span>{{ $data['jenis'] }}</span>
                        </div>
                    </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection


