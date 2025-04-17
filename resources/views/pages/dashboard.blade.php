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
            <div class="row">
                @foreach($progres as $data)
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="flexbox flex-justified text-center mb-30 {{ $data->jenis_pembangkit == 'IndonesiaPower' ? 'bg-primary' : 'bg-danger' }}">
                        <div class="no-shrink py-30 text-white">
                            <span class="ti-briefcase font-size-50"></span>
                        </div>
                        <div class="py-30 bg-white text-dark">
                            <div class="font-size-30">{{ round($data->persen) }}<span class="font-size-18"> %</span></div>
                            <div class="text-uppercase font-weight-bold">{{ $data->jenis_pembangkit }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        

@endsection