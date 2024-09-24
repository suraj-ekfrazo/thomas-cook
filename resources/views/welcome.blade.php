@extends('layouts.admin.app')
@section('content')
    <div class="w-100 bg-cover flickity-cell is-selected banner">
        <div class="bg-dark-20">
            <div class=" container d-flex  ">
                <div class="row align-items-center justify-content-end height-text">
                    <div class=" col-12  ">
                        <!-- Preheading -->
                        <!-- Heading -->
                        <h1 class="h1">
                            Welcome Back!
                        </h1>
                        {{-- <h2 class="h2">Tridha Patel</h2> --}}
                        <!-- Links -->
                        <p class="mb-0">

                        <h1 class="p1">It's Time To Explore The<br>World</h1>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div style="background-image: url({{ asset('admin-assets/img/main_bg.jpg') }});">
        <div class="container">
            <div class="row pb-5">

	@if(auth()->user()->getRoleNames()[0] != 'Sub Admin')

                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('admin-users.index') }}">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_sub_admin.svg') }}">
                                    </span>
                                    <div class="fw-bold">Admin</div>
                                    <div class="media-body text-white text-end">
                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('agent.index') }}">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_travel_agent.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Travel-Agent</div>
                                    <div class="media-body text-white text-end">
                                        <h3 style="color: #2565ab;"><i class="fa-solid fa-angle-right"></i></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('tcuser.index') }}">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Tc-user</div>
                                    <div class="media-body text-white text-end">

                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_rate_master.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Rate Master</div>
                                    <div class="media-body text-white text-end">
                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('admin-incidents.report-summary') }}">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_report.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Report</div>
                                    <div class="media-body text-white text-end">
                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!--<div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="#">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_automation_report.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Automation Report</div>
                                    <div class="media-body text-white text-end">
                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>-->
                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('rate-master') }}">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_rate_master.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Rate Master</div>
                                    <div class="media-body text-white text-end">
                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="">
                        <a href="{{ route('history-backup.create') }}">
                            <div class="widget-stat card bg-dashboard m-3">
                                <div class="card-body ">
                                    <div class="media">
                                        <span class="me-3">
                                            <img src="{{ asset('admin-assets/svg/dashboard/ic_history_backup.svg') }}">
                                        </span>
                                        <div class=" fw-bold">History Backup</div>
                                        <div class="media-body text-white text-end">
                                            <h3 class="" style="color: #2565ab;">
                                                <i class="fa-solid fa-angle-right"></i>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </a>
                </div> --}}

                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('booking-allocation') }}">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_booking_allocation.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Booking Allocation</div>
                                    <div class="media-body text-white text-end">
                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
		@endif
                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('admin-incident-requests.index') }}">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_view_request.svg') }}">
                                    </span>
                                    <div class=" fw-bold">View All Request</div>
                                    <div class="media-body text-white text-end">
                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

		@if(auth()->user()->getRoleNames()[0] != 'Sub Admin')

                <div class="col-md-6 col-lg-4 col-sm-12">
                    <a href="{{ route('under-process-request.index') }}">
                        <div class="widget-stat card bg-dashboard m-3">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_view_request.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Under Process Booking Request</div>
                                    <div class="media-body text-white text-end">
                                        <h3 class="" style="color: #2565ab;">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

		@endif
            </div>
        </div>
    </div>
@endsection
