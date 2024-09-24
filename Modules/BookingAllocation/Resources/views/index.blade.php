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
                        <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Booking
                            Allocation
                        </div>
                    </div>
                </div>
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

	    <div class="row mt-5">
                <div class="col-md-2">
		    <label style="color: #ADAEB0; font-size: 14px; " for="from_date">FROM DATE</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" />
                </div>
                <div class="col-md-2">
		    <label style="color: #ADAEB0; font-size: 14px; " for="to_date">TO DATE</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" />
                </div>
                <div class="col-md-2">
		    <label style="color: #ADAEB0; font-size: 14px; " for="to_date">SELECT BOOKING TYPE</label>
                    <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent" name="booking_type" id="booking_type">
                        <option value="">Select Booking Type</option>
                        <option value="0">Buy</option>
                        <option value="1">Sell</option>
                    </select>
                </div>
		
		<div class="col-md-2">
		    <label style="color: #ADAEB0; font-size: 14px; " for="to_date">SELECT Agent CODE</label>
                    <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent" name="agent_id" id="agent_id">
                        <option value="">Select Agent</option>
                        @foreach ($data_agent as $item)
                            <option value="{{ $item['id'] }}">
                                {{ $item['agent_code'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-success" id="filterBtn">Filter</button>
                </div>
            </div>

            <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
                <div class="d-flex justify-content mb-4">
                    <div class="border-1"></div>
                    <div class="ps-1 fw-bold" style="color: #1E1E1E;">Booking Allocation
                    </div>
                </div>
                <table id="data-datatable" class="table roundedTable table w-100 nowrap">
                    <thead style="backgrounD-color: #F4F6F8;">
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;  ">#</th>
				
                            <th style="color: #2565ab; font-weight: 800;  ">Incident No</th>
			    <th style="color: #2565ab; font-weight: 800;  ">Agent Code</th>
			    <th style="color: #2565ab; font-weight: 800;">Booking Type</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Date of Departure</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Issued TC-User</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Allocate TC-User</th>
                            {{-- <th style="color: #2565ab; font-weight: 800;  ">Allocated By</th> --}}
                            {{-- <th style="color: #2565ab; font-weight: 800;  ">Action</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="addModals"></div>

    @push('pagescript')
        @include('stacks.js.datatables')
        @include('stacks.js.modules.booking-allocation.index')
    @endpush
@endsection
