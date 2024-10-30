@extends('layouts.auth')
@section('title', 'Login | Dirjab')
@push('addon-style')
<style>
.bg-custom {
    background: url('/img/bg-01.jpg')
        no-repeat center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
.no-gutters {
    margin-right: 0;
    margin-left: 50px;
}
</style>
@endpush
@section('content')
    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">
            <div class="col-12">
                <div class="row no-gutters">
                    <div class="col-lg-4 col-md-5 col-12">
                        <div class="p-30 content-bottom rounded bg-img box-shadowed" style="" data-overlay="9">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-4">
                                    <img src="{{ asset('img/dirjab_logo2.png') }}" alt="Logo">
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text bg-transparent bt-0 bl-0 br-0 no-radius text-white"><i
                                                    class="ti-email"></i></span>
                                        </div>
                                        <input type="text" id="email"
                                            class="form-control pl-15 bg-transparent bt-0 bl-0 br-0 text-white @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            autofocus placeholder="Email address">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  bg-transparent bt-0 bl-0 br-0 text-white"><i
                                                    class="ti-lock"></i></span>
                                        </div>
                                        <input type="password" id="password"
                                            class="form-control pl-15 bg-transparent bt-0 bl-0 br-0 text-white"
                                            type="password" name="password" placeholder="Pasword" required
                                            autocomplete="current-password" />

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="checkbox text-white">
                                            <input type="checkbox" id="remember_me" name="remember">
                                            <label for="basic_checkbox_1">Remember Me</label>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    @if (Route::has('password.request'))
                                        <div class="col-6">
                                            <div class="fog-pwd text-right">
                                                <a class="text-white hover-info" href="{{ route('password.request') }}">
                                                    <i class="ion ion-locked"></i> {{ __('Forgot your password?') }}
                                                </a>
                                                <br>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- /.col -->
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-info btn-block margin-top-10">
                                            {{ __('Log in') }}
                                        </button>
                                    </div>
                                    <!-- /.col -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
