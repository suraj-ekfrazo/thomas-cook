@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">holiday</li>
                        </ol>
                    </div>
                    <h4 class="page-title">holiday</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right">
                            <button onclick="openAddModal()" class="btn btn-success">Create New Holiday</button>
                        </div>
                        <div class="table-responsive">
                            <table id="holiday-datatable" class="table w-100 nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Holiday Date</th>
                                    <th>Create Date</th>
                                    <th>Update Date</th>
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
        @include('stacks.js.modules.holiday.index')
    @endpush
@endsection
