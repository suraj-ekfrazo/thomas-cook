@extends('layouts.auth')
@section('content')
    <div class="position-absolute top-0 start-50 translate-middle-x ">
        <img src="{{ asset('assets/img/logo2.png') }}" class="logo-img">
    </div>
    <div class="wrapper-3">
        <div class="inner">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
               
                <input type="hidden" name="token" value="{{ $token }}">
                <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus
                    placeholder="{{ __('Email') }}">
                    
                    
                <h3 class="text-dark fw-bold" style="font-size: 20px;text-align: center;">Reset Your Password</h3>
                <p style="color: #000000; font-size: 13px;text-align: center;">set your new password</p>
                <div>
                    <div class="col-12 col-sm-12 mt-5 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0; font-size: 14px; ">New Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/login svg/unlock.svg') }}">
                            </span>

                            <input id="password" type="password"
                                class="form-control border-0 border-bottom @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" placeholder="Enter New password">
                            <div class="input-group-append login-password">
                                <div class="input-group-text">
                                    <i class="password-eye fas fa-eye-slash"></i>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0; font-size: 14px; ">Confirm Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/login svg/password.svg') }}">
                            </span>
                            <input id="password-confirm" type="password" class="form-control border-0 border-bottom"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Enter Confirm password">

                            <div class="input-group-append confirm-password">
                                <div class="input-group-text">
                                    <i class="password-eye-c fas fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn-sm btn-primary btn-block pe-4 ps-4"><span class="me-5 ms-5">Set
                            Password </span><i class="fa-solid fa-right-long"></i>
                    </button>
                </div>
            </form>
            <div class="position-absolute bottom-0 start-50 translate-middle-x ">
                <img src="{{ asset('admin-assets/img/group.png') }}" class="logo-img2">
            </div>
        </div>
    </div>
@endsection
