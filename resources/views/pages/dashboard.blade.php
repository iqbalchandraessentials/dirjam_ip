@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('title', 'Dashboard | Direktori Jabatan')

@section('content')
<div class="">
<div class="row">
        <div class="col-xl-4">
            <!--begin::Stats Widget 13-->
            <a href="{{ url('dashboard/registration/detail/daily') }}" class="card card-custom bg-hover-state-danger card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                        <i class="ti-bolt display-4"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">
                        Indonesia Power
                    </div>
                    <div class="font-weight-bold text-inverse-danger font-size-lg" id="todayData">
                        99%
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Stats Widget 13-->
        </div>
        <div class="col-xl-4">
            <!--begin::Stats Widget 13-->
            <a href="#" class="card card-custom bg-hover-state-warning card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                      <i class="ti-bar-chart display-5"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="text-inverse-warning font-weight-bolder font-size-h5 mb-2 mt-5">
                        CMU
                    </div>
                    <div class="font-weight-bold text-inverse-warning font-size-lg" id="weekData">
                        100%
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Stats Widget 13-->
        </div>
        <div class="col-xl-4">
            <!--begin::Stats Widget 13-->
            <a href="#" class="card card-custom  bg-hover-state-primary card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                      <i class="ti-bar-chart display-5"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="text-inverse-primary font-weight-bolder font-size-h5 mb-2 mt-5">
                        KP
                    </div>
                    <div class="font-weight-bold text-inverse-primary font-size-lg" id="monthData">
                        99%
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Stats Widget 13-->
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <!--begin::Stats Widget 13-->
            <a href="#" class="card card-custom  bg-hover-state-success card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                      <i class="ti-bar-chart display-5"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="text-inverse-success font-weight-bolder font-size-h5 mb-2 mt-5">
                        MSU
                    </div>
                    <div class="font-weight-bold text-inverse-success font-size-lg" id="yearData">
                        100%
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Stats Widget 13-->
        </div>
        <div class="col-xl-4">
            <!--begin::Stats Widget 16-->
            <a href="#" class="card card-custom card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-info">
                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                      <i class="ti-bar-chart display-5"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="text-inverse-white font-weight-bolder font-size-h5 mb-2 mt-5">
                        PGU
                    </div>
                    <div class="font-weight-bold text-inverse-white font-size-sm" id="activationData">
                        100%
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Stats Widget 16-->
        </div>

        <div class="col-xl-4">
            <!--begin::Stats Widget 16-->
            <a href="#" class="card card-custom card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-info">
                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                      <i class="ti-bar-chart display-5"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="text-inverse-white font-weight-bolder font-size-h5 mb-2 mt-5">
                        POMU
                    </div>
                    <div class="font-weight-bold text-inverse-white font-size-sm" id="activeData">
                        100%
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Stats Widget 16-->
        </div>
        <div class="col-xl-4">
            <!--begin::Stats Widget 16-->
            <a href="#" class="card card-custom card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-info">
                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                      <i class="ti-bar-chart display-5"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="text-inverse-white font-weight-bolder font-size-h5 mb-2 mt-5">
                        UPK
                    </div>
                    <div class="font-weight-bold text-inverse-white font-size-sm" id="activeData">
                        100%
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Stats Widget 16-->
        </div>
        <div class="col-xl-4">
            <!--begin::Stats Widget 16-->
            <a href="#" class="card card-custom card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body">
                    <span class="svg-icon svg-icon-2x svg-icon-info">
                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                      <i class="ti-bar-chart display-5"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <div class="text-inverse-white font-weight-bolder font-size-h5 mb-2 mt-5">
                        UPDK
                    </div>
                    <div class="font-weight-bold text-inverse-white font-size-sm" id="activeData">
                        100%
                    </div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Stats Widget 16-->
        </div>
    </div>
</div>
    @endsection
