<!-- Sub Agent -->
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
                        <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Sub
                            Agent
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
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('agent.add') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'agent' && request()->segment(2) == 'create') active @endif">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/travel agent/travel-agent-create.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Create
                                        Travel Agent</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('agent.index') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'agent' && request()->segment(2) == '') active @endif ">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/travel agent/travel-agent-list.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Travel Agent List</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('subagent.add') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'subagent' && request()->segment(2) == 'create') active @endif">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/travel agent/travel-agent-list.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Create Sub Agent </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('subagent.index') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'subagent' && request()->segment(2) == '') active @endif">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/travel agent/travel-agent-list.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Sub Agent List</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="{{ route('agent.importView') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'agent' && request()->segment(2) == 'importView') active @endif">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/travel agent/travel-agent-list.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Import Agent</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!--End sub heading -->
			 <a class="btn btn-warning" href="{{ route('subagent_export') }}">Export SubAgent Data</a>
            <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
                <table id="data-datatable" class="table roundedTable">
                    <thead style="backgrounD-color: #F4F6F8;">
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">#</th>
                            <th style="color: #2565ab; font-weight: 800;">User name</th>
                            <th style="color: #2565ab; font-weight: 800;">Code</th>
                            <th style="color: #2565ab; font-weight: 800;">Email</th>
                            <th style="color: #2565ab; font-weight: 800;">Validity From</th>
                            <th style="color: #2565ab; font-weight: 800;">Validity To</th>
                            <th style="color: #2565ab; font-weight: 800;">Mobile Number</th>
                            <th style="color: #2565ab; font-weight: 800;">Parent</th>
                            <th style="color: #2565ab; font-weight: 800;">Create Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Status</th>
                            <th style="color: #2565ab; font-weight: 800;">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="addModals"></div>

    @push('pagescript')
        @include('stacks.js.datatables')
        @include('stacks.js.modules.sub-agent.index')
    @endpush
@endsection
