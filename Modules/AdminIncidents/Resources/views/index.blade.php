@extends('layouts.admin.app')

@section('content')
    <div class="w-100 bg-cover flickity-cell is-selected"
        style="background-image: url({{ asset('admin-assets/img/admin/heading.jpg') }}); transform: translateX(0%); opacity: 1;">
        <div class="bg-dark-20">
            <div class=" container  justify-content-between">
                <div class=" " style="min-height: 150px;">
                    <div class="d-flex pt-5">
                        <a href="{{ route('dashboard.index') }}" class="D-icon">
                            <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                        </a>
                        <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Report
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="background-image: url({{ asset('admin-assets/img/main_bg.jpg') }});">
        <div class="container">
            <!--Sub heading -->
            <div class="row pt-5 pb-5 justify-content-center">
                {{-- <div class="col-md-3 col-lg-3 col-sm-3">
                <a href="{{ route('admin-incidents.index') }}">
                    <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-incidents' && request()->segment(2) == '') active @endif ">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                </span>
                                <div class=" fw-bold">View All Reports </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div> --}}
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('admin-incidents.view-buy-report') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-incidents' && request()->segment(2) == 'view-buy-report') active @endif">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Buy</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('admin-incidents.view-sell-report') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-incidents' && request()->segment(2) == 'view-sell-report') active @endif ">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Sell</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('admin-incidents.view-tcuser-report') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-incidents' && request()->segment(2) == 'view-tcuser-report') active @endif ">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                    </span>
                                    <div class=" fw-bold">TC-User Reports</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('admin-incidents.view-agent-report') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-incidents' && request()->segment(2) == 'view-agent-report') active @endif ">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Agent Reportss</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!--End sub heading -->
            <div class="row mt-3">
                <div class="col-md-2">
                    <input type="date" name="from_date" id="from_date" class="form-control" />
                </div>
                <div class="col-md-2">
                    <input type="date" name="to_date" id="to_date" class="form-control" />
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success" id="filterBtn">Filter</button>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success m-0 ms-auto" onclick="exportExcel();"
                        style="background-color: #FEC948 !important; color: black; font-weight: 600;">Export
                    </button>
                </div>
            </div>

            <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
                <div class="d-flex justify-content mb-4">
                    <div class="border-1"></div>
                    <div class="ps-1 fw-bold" style="color: #1E1E1E;">View Report </div>

                </div>
                <table id="data-datatable" class="table roundedTable table w-100 nowrap">
                    <thead style="backgrounD-color: #F4F6F8;">
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">#</th>
                            <th style="color: #2565ab; font-weight: 800;">Incident Number</th>
                            <th style="color: #2565ab; font-weight: 800;">TC User Name</th>
                            <th style="color: #2565ab; font-weight: 800;">Agent Code</th>
                            {{-- th 4th end 5th Start --}}
                            <th style="color: #2565ab; font-weight: 800;">Agent Name</th>
                            <th style="color: #2565ab; font-weight: 800;">Card number</th>
                            <th style="color: #2565ab; font-weight: 800;">Passport No.</th>
                            <th style="color: #2565ab; font-weight: 800;">Transaction Type</th>
                            <th style="color: #2565ab; font-weight: 800;">International Currency</th>
                            <th style="color: #2565ab; font-weight: 800;">Amount</th>
                            <th style="color: #2565ab; font-weight: 800;">Indian Currency </th>
                            <th style="color: #2565ab; font-weight: 800;">Amount</th>
                            <th style="color: #2565ab; font-weight: 800;">Rate</th>
                            <th style="color: #2565ab; font-weight: 800;">With Documents?</th>
                            <th style="color: #2565ab; font-weight: 800;">Status</th>
                            <th style="color: #2565ab; font-weight: 800;">Travel Departure Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Comment</th>
                            <th style="color: #2565ab; font-weight: 800;">Bordx No.</th>
                            <th style="color: #2565ab; font-weight: 800;">Cashier</th>
                            <th style="color: #2565ab; font-weight: 800;">Booking Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Doc Upload Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Doc Upload Time</th>
                            <th style="color: #2565ab; font-weight: 800;">Completed Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Completed Time</th>
                            {{-- th 24th end 25th Start --}}
                            <th style="color: #2565ab; font-weight: 800;">Create Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="addModals"></div>

    @push('pagescript')
        @include('stacks.js.datatables')
        @include('stacks.js.modules.admin-incidents.index')
    @endpush
@endsection
