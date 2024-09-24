@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Deleted Agents</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Deleted Agents</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-datatable" class="table w-100 nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User name</th>
                                    <th>Code</th>
                                    <th>Email</th>
                                    <th>Validity From</th>
                                    <th>Validity To</th>
                                    <th>Mobile Number</th>
                                    <th>Create Date</th>
                                    <th>Created By</th>
                                    <th>Updated By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>

    <div class="addModals"></div>

    @push('pagescript')
        @include('stacks.js.datatables')
        @include('stacks.js.modules.agent.deleted')
    @endpush
@endsection
