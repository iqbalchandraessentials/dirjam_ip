@extends('layouts.auth')
@section('title', 'Login | Direktori Jabatan')
@push('addon-style')
    <style>
        .bg-custom {
            background: url('/img/bg-01.jpg') no-repeat center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        /* .no-gutters {
        margin-right: 0;
        margin-left: 50px;
    } */
    </style>
@endpush
@section('content')
<div class="container h-p100">
    <div class="row align-items-center justify-content-md-center h-p100">
        <div class="col-12">
            <div class="row no-gutters">
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="p-30 content-bottom rounded bg-img box-shadowed" data-overlay="9">

                        @if (session('login_error'))
                        <div class="alert alert-danger">
                            {{ session('login_error') }}
                        </div>
                    @endif

                        <form method="POST" action="{{ route('login.dirjab') }}">
                            @csrf
                            <div class="mb-4">
                                <img src="{{ asset('img/dirjab_logo2.png') }}" alt="Logo">
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent bt-0 bl-0 br-0 no-radius text-white">
                                            <i class="ti-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" id="user_id"
                                        class="form-control pl-15 bg-transparent bt-0 bl-0 br-0 text-white @error('user_id') is-invalid @enderror"
                                        name="user_id" value="{{ old('user_id') }}" required autocomplete="username"
                                        autofocus placeholder="Masukkan Username">
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent bt-0 bl-0 br-0 text-white">
                                            <i class="ti-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password" id="password"
                                        class="form-control pl-15 bg-transparent bt-0 bl-0 br-0 text-white"
                                        name="password" placeholder="Password" required
                                        autocomplete="current-password" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="checkbox text-white">
                                        <input type="checkbox" id="remember_me" name="remember">
                                        <label for="basic_checkbox_1">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-info btn-block margin-top-10">
                                        {{ __('Log in') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
