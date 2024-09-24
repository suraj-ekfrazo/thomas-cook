@extends('layouts.tcuser.app')

@section('content')
    <div class="wrapper">
        <div class="inner">
            <form action="{{ url('/tcuser/login') }}" method="POST">
                @csrf
                <h3 class="text-dark text-capitalize">Welcome Back !</h3>
                <p style="color: #ADAEB0;">Login in as a tc user</p>
                <div>
                    <div class="col-12 col-sm-12 mt-5 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0;">Username</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="../tcuser-assets/svg/login svg/username.svg">
                            </span>
                            <input class="form-control border-0 border-bottom " type="email" placeholder="Enter Username"
                                id="email" name="email" required="">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 mt-4 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0;">Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="../tcuser-assets/svg/login svg/password.svg">
                            </span>
                            <input class="form-control border-0 border-bottom " type="password" placeholder="Enter password"
                                id="password" name="password">
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @if ($message = Session::get('warning'))
                        <div class="error">
                            <p class="text-danger">{{ $message }}</p>
                        </div>
                    @endif

                    <!-- 2 column grid layout for inline styling -->
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form2Example31"
                                    checked />
                                <label class="form-check-label text-dark" for="form2Example31"
                                    style="font-size: 14px;">Remember</label>
                            </div>
                        </div>

                        <div class="col pe-0 ms-4">
                            <!-- Simple link -->
                             @if (Route::has('password.request'))
                            <a href="{{ route('forget.password.tc.get') }}" style="color: #BE0000; font-size: 14px;">Forgot
                                Password?
                            </a>
                        @endif
                        </div>
                    </div>


                    <!-- Submit button -->

                    <button type="submit" class="btn-sm btn-primary btn-block pe-4 ps-4"><span class="me-5 ms-5">Sign in
                        </span><i class="fa-solid fa-right-long"></i></button>

                </div>
        </div>
        </form>

        <div class="position-absolute bottom-0 start-50 translate-middle-x ">
            <img src="../assets/img/group.png" class="logo-img2">
        </div>
    </div>
    </div>
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script defer=""
        src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194"
        integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw=="
        data-cf-beacon="{&quot;rayId&quot;:&quot;742abde259e48563&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;,&quot;version&quot;:&quot;2022.8.0&quot;,&quot;si&quot;:100}"
        crossorigin="anonymous"></script>
