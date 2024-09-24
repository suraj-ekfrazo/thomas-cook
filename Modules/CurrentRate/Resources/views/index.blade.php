@extends('layouts.admin.app')

@section('content')
<div class="w-100 bg-cover flickity-cell is-selected" style="background-image: url({{ asset('admin-assets/img/admin/heading.jpg') }}); transform: translateX(0%); opacity: 1;">
    <div class="bg-dark-20">
        <div class=" container  justify-content-between">
            <div class=" " style="min-height: 150px;">
                <div class="d-flex pt-5">
                    <a href="{{ route('dashboard.index') }}" class="D-icon">
                        <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                    </a>
                    <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Rate
                        Master
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row pt-5 pb-5 justify-content-center">
        <div class="col-md-6 col-lg-4 col-sm-3">
            <a href="{{ route('rate-master') }}">
                <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'ratemaster' && request()->segment(2) == '') active @endif">
                    <div class="card-body ">
                        <div class="media">
                            <span class="me-3">
                                <img src="{{ asset('admin-assets/svg/dashboard/ic_rate_master.svg') }}">
                            </span>
                            <div class="fw-bold">Rate Master</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-3">
            <a href="{{ route('currentrate') }}">
                <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'currentrate' && request()->segment(2) == '') active @endif">
                    <div class="card-body ">
                        <div class="media">
                            <span class="me-3">
                                <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                            </span>
                            <div class="fw-bold">XE Rate</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>


<div style="background-image: url({{ asset('admin-assets/img/main_bg.jpg') }});">
    <div class="container">
        @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
        @endif

        <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
            <div class="d-flex justify-content mb-4">
                <div class="border-1"></div>
                <div class="ps-1 fw-bold" style="color: #1E1E1E;"> Current Rate 
                </div>
            </div>
            <table id="data-datatable" class="table roundedTable table w-100 nowrap">
                <thead style="backgrounD-color: #F4F6F8;">
                    <tr>
                        <th style="color: #2565ab; font-weight: 800;  ">#</th>
                        <th style="color: #2565ab; font-weight: 800;  ">Currency Name </th>
                        <th style="color: #2565ab; font-weight: 800;  ">Buy</th>
                        <th style="color: #2565ab; font-weight: 800;  ">Sell</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>



<div class="addModals"></div>

@push('pagescript')
@include('stacks.js.datatables')
@include('stacks.js.modules.current_rate.index')
@endpush
@endsection
