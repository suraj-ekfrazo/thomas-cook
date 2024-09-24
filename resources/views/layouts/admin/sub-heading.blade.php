<div class="w-100 bg-cover flickity-cell is-selected"
    style="background-image: url({{ asset('admin-assets/img/admin/heading.jpg') }}); transform: translateX(0%); opacity: 1;">
    <div class="bg-dark-20">
        <div class=" container  justify-content-between">
            <div class=" " style="min-height: 150px;">
                <div class="d-flex pt-5">
                    <a href="{{ route('dashboard.index') }}" class="D-icon">
                        <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                    </a>

                    <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;"> @if (request()->segment(1) == 'subadmin') SubAdmin  @endif @if (request()->segment(1) == 'admin-users') Admin  @endif </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="background-image: url({{ asset('admin-assets/img/main_bg.jpg') }});">
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="col-md-6 col-lg-3 col-sm-3">
                <a href="{{ route('admin-users.index') }}">
                    <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-users' && request()->segment(2) == '') active @endif">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="{{ asset('admin-assets/svg/dashboard/ic_sub_admin.svg') }}">
                                </span>
                                <div class="fw-bold">Admin List</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 col-sm-3">
                <a href="{{ route('admin-users.add') }}">
                    <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-users' && request()->segment(2) == 'create') active @endif">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="{{ asset('admin-assets/svg/dashboard/ic_travel_agent.svg') }}">
                                </span>
                                <div class=" fw-bold">Create Admin </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 col-sm-3">
                <a href="{{ route('subadmin.index') }}">
                    <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'subadmin' && request()->segment(2) == '') active @endif">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                </span>
                                <div class=" fw-bold">Sub Admin List</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 col-sm-3">
                <a href="{{ route('subadmin.add') }}">
                    <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'subadmin' && request()->segment(2) == 'create') active @endif">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="{{ asset('admin-assets/svg/dashboard/ic_rate_master.svg') }}">
                                </span>
                                <div class=" fw-bold">Create Sub Admin</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
