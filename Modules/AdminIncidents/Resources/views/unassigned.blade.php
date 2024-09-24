@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Unassigned Incidents</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Unassigned Incidents</h4>
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
                                    <th>Agent Name</th>
                                    <th>Agent Code</th>
                                    <th>Incident Number</th>
                                    <th>Card Number</th>
                                    {{-- 5th Start --}}
                                    <th>Currency Details</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Buy/Sell</th>
                                    <th>Agent Margin</th>
                                    <th>Create Date</th>
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

    <div class="modal fade" id="incident-details-model" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Details</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-content">
                    <div id="incident-details" style="padding:20px">
                    </div>
                    <div id="currency-list" style="padding:20px">
                        <table class="table table-bordered" id="selected-currency">
                            <thead>
                                <tr>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>Rate</th>
                                    <th>Calculate</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th id="total">Calculate</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('pagescript')
        @include('stacks.js.datatables')
        @include('stacks.js.modules.admin-incidents-unassigned.index')
    @endpush
@endsection
