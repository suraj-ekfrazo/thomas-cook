@extends('layouts.auth')
@section('content')
    <div class="position-absolute top-0 start-50 translate-middle-x ">
        <!-- <img src="{{ asset('assets/img/logo2.png') }}" class="logo-img"> -->
        <img src="{{ asset('assets/images/TC-Logo.png') }}" class="logo-img">
    </div>
    <div class="wrapper">
        @if (session()->has('error'))
            <div class="alert alert-danger"> {{ session()->get('error') }} </div>
        @endif
        @if (session('message'))
            {{ session('message') }}
        @endif
        <div class="inner">
            <form action="{{ url('login/admin') }}" method="POST">
                @csrf
                <h3 class="text-dark text-capitalize">Welcome Back !</h3>
                <p style="color: #ADAEB0;">Log in as an admin</p>
                <div>
                    <div class="col-12 col-sm-12 mt-5 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0;" class="login-required-field">Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/login svg/username.svg') }}">
                            </span>
                            <input class="form-control border-0 border-bottom @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" autocomplete="email" autofocus type="text" id="email"
                                name="email" placeholder="Enter Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 mt-4 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0;" class="login-required-field">Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/login svg/password.svg') }}">
                            </span>
                            <input type="password" id="password" name="password"
                                class="form-control border-0 border-bottom @error('password') is-invalid @enderror"
                                placeholder="Enter password">
                            <div class="input-group-append login-password">
                                <div class="input-group-text">
                                    <i class="password-eye fas fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @if ($message = Session::get('warning'))
                    <div class="error">
                        <p class="text-danger">{{ $message }}</p>
                    </div>
                @endif

                <!-- 2 column grid layout for inline styling -->
                <div class="row">
                    {{-- <div class="col d-flex justify-content-between">
                        <!-- Checkbox -->
                        <div class="form-check fw-bold">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" checked
                                {{ old('remember') ? 'checked' : '' }} />
                            <label class="form-check-label" for="remember" style="font-size: 14px;">Remember</label>
                        </div>
                    </div> --}}
                    <div class="col ms-4" style="text-align:right">
                        <!-- Simple link -->
                        <!-- @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="color: #BE0000; font-size: 14px;">Forgot
                                Password?
                            </a>
                        @endif -->
                    </div>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn-sm btn-primary btn-block pe-4 ps-4">
                    <span class="me-5 ms-5">Sign in</span>
                    <i class="fa-solid fa-right-long"></i>
                </button>
            </form>
            <div class="position-absolute bottom-0 start-50 translate-middle-x ">
                <img src="{{ asset('admin-assets/img/group.png') }}" class="logo-img2">
            </div>
        </div>
    </div>
@endsection
