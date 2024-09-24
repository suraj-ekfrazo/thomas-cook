@extends('layouts.auth')
@section('content')
    <div class="position-absolute top-0 start-50 translate-middle-x ">
        <img src="{{ asset('assets/img/logo2.png') }}" class="logo-img">
    </div>
    <div class="wrapper-3">
        <div class="inner">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <h3 class="text-dark fw-bold" style="font-size: 20px;text-align: center;">Reset Your Password</h3>
                <p style="color: #000000; font-size: 13px;text-align: center;">Request an email reset link</p>
                <div>
                    <div class="col-12 col-sm-12 mt-5 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0; font-size: 14px; ">Email Id</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/login svg/msg.svg') }}">
                            </span>
                            <input class="form-control border-0 border-bottom @error('email') is-invalid @enderror"
                                type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="Enter registered Email">
                               
                            @error('email')
                                <span class="invalid-feedback error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn-sm btn-primary btn-block pe-4 ps-4"><span class="me-5 ms-5">Send Link
                        </span><i class="fa-solid fa-right-long"></i></button>

                    <div class="mt-4" style="font-size: 14px; text-align:center;">
                        <p class="text-dark">
                            <i class="fa-solid fa-angle-left"></i>
                            &nbsp;&nbsp;&nbsp;Back To<a href="{{ url('/login/admin') }}"
                                style="color: #2565ab; text-decoration: none; ">&nbsp;Sign In</a>
                        </p>
                    </div>
                </div>
            </form>
            <div class="position-absolute bottom-0 start-50 translate-middle-x ">
                <img src="{{ asset('admin-assets/img/group.png') }}" class="logo-img2">
            </div>
        </div>
    </div>
@endsection
