@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Login')
@endsection

@section('body')

    <body>
    @endsection

    @section('content')
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary-subtle">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome User !</h5>
                                            <p>Log in with user credentials</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('build/images/profile-img.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="auth-logo">
                                    <a href="#" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('build/images/logo_xl_size.png') }}" alt=""
                                                    class="rounded-circle" height="50">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="#" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">

                                                <img src="{{ isset(Configurations::getConfig('site')->site_icon) ? URL::asset(Configurations::getConfig('site')->site_icon) : '' }}"
                                                    alt="" class="rounded-circle" height="75">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    {{ Form::open([
                                        'url' => route('dobackendlogin'),
                                        'method' => 'post',
                                        'class' => 'form-horizontal',
                                        'autocomplete' => 'off',
                                    ]) }}


                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username"
                                            placeholder="Enter username" name="username" autocomplete="off"
                                            value="{{ old('username') }}">
                                    </div>



                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Enter password"
                                                aria-label="Password" aria-describedby="password-addon" name="password"
                                                autocomplete="off">
                                            <button class="btn btn-light " type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>



                                    {{-- <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-check">
                                    <label class="form-check-label" for="remember-check">
                                        Remember me
                                    </label>
                                </div> --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-2">

                                            {{ implode('', $errors->all(':message')) }}

                                        </div>
                                    @endif

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>

                                    <div class="mt-4 text-center d-none">
                                        <h5 class="font-size-14 mb-3">Sign in with</h5>

                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="javascript::void()"
                                                    class="social-list-item bg-primary text-white border-primary">
                                                    <i class="mdi mdi-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript::void()"
                                                    class="social-list-item bg-info text-white border-info">
                                                    <i class="mdi mdi-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript::void()"
                                                    class="social-list-item bg-danger text-white border-danger">
                                                    <i class="mdi mdi-google"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-4 text-center d-none">
                                        <a href="auth-recoverpw" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot
                                            your password?</a>
                                    </div>
                                    {{ Form::close() }}
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <div>
                                {{-- <p>Don't have an account ? <a href="auth-register" class="fw-medium text-primary">
                                    Signup now </a> </p> --}}
                                <p>Copyrights {{ date('Y') }} | Powered by
                                    <span>{{ isset(Configurations::getConfig('site')->site_name)
                                        ? Configurations::getConfig('site')->site_name
                                        : 'Laravel Cms' }}</span>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
    @endsection
