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
                        <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Incident Summary</div>
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
                                    <div class=" fw-bold">Agent Reports</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
		<div class="col-md-2 col-lg-3 col-sm-3">
                <a href="{{ route('admin-incidents.report-summary') }}">
                    <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-incidents' && request()->segment(2) == 'report-summary') active @endif ">
                        <div class="card-body ">
                            <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                    </span>
                                <div class=" fw-bold">Incident Summary</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
		<div class="col-md-2 col-lg-3 col-sm-3">
                    <a href="{{ route('admin-incidents.view-tcuser-summary-report') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'admin-incidents' && request()->segment(2) == 'view-tcuser-summary-report') active @endif ">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                    </span>
                                    <div class=" fw-bold">TC User Summary</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div  id="report" class="row mt-2">
                
                <div class="col-md-2">
                    <input type="date" name="from_date" id="from_date" class="form-control" />
                </div>
                <div class="col-md-2">
                    <input type="date" name="to_date" id="to_date" class="form-control" />
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100" id="filterBtn">Filter</button>
                </div>
                 <div class="col-md-2">
                    <input type="reset" id="reset" value="Reset">
                </div>
                  
            </div>
            <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
                <div class="d-flex justify-content mb-4">
                    <div class="border-1"></div>
                    <div class="ps-1 fw-bold" style="color: #1E1E1E;">Incident Summary</div>
                    <div id="buttons"></div>
                </div>
                <table id="repoer_table" class="table roundedTable table w-100 nowrap">
                    <tbody id="tbody_data">
                        <tr>
                            <th style="font-weight: 800;">Type of Booking</th>
                            <th style="font-weight: 800;">Incident Count</th>
                        </tr>
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">Buy</th>
                            <td>{{ $IncidentBuy }}</td>
                        </tr>
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">Sell(Block Rate)</th>
                            <td>{{ $IncidentSellBlockRate }}</td>
                        </tr>
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">Sell(With doc)</th>
                            <td>{{ $IncidentSellWithDoc }}</td>
                        </tr>
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">Accepted</th>
                            <td>{{ $IncidentAccepted }}</td>
                        </tr>
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">Rejected</th>
                            <td>{{ $IncidentDeclined }}</td>
                        </tr>
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">Reinitiated</th>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">Under Progress</th>
                            <td>{{ $IncidentPending }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
@push('pagescript')
    <script>
     $('#reset').click(function() {
       $('#from_date').val('');
       $('#to_date').val('');
    });
    
    var start = document.getElementById('from_date');
var to_date = document.getElementById('to_date');
to_date.addEventListener('change', function() {
    if (to_date.value)
        start.max = to_date.value;
}, false);

start.addEventListener('change', function() {
    if (start.value)
        to_date.min = start.value;
}, false);



        $('#filterBtn').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            $.ajax({
                url: "{{ route('admin-incidents.report-summary-table') }}",
                type: 'GET',
                data: {
                    from_date: from_date,
                    to_date: to_date
                },
                success: function(result) {
                    $('#tbody_data').empty();
                    $('#tbody_data').html(result);
                }
            });
        });
    </script>
@endpush
