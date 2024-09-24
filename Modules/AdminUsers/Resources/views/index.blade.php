@extends('layouts.admin.app')

@section('content')
    @include('layouts.admin.sub-heading')
    <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
        <table id="data-datatable" class="table roundedTable table w-100 nowrap">
            <thead style="backgrounD-color: #F4F6F8;">
                <tr>
                    <th style="color: #2565ab; font-weight: 800;  ">#</th>
                    <th style="color: #2565ab; font-weight: 800;  " class="noExport">Profile</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Name</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Email</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Role</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Create Date</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Status</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    </div>
    </div>

    <div class="addModals"></div>

    @push('pagescript')
        @include('stacks.js.datatables')
        @include('stacks.js.modules.admin-user.index')
    @endpush
@endsection
