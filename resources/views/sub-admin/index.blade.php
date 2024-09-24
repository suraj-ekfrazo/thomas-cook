@extends('layouts.admin.app')

@section('content')
    @include('layouts.admin.sub-heading')
    <div class="table-responsive-sm table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
        <table id="example1" class="table roundedTable">
            <thead style="backgrounD-color: #F4F6F8;">
                <tr>
                    <th style="color: #2565ab; font-weight: 800;  ">Sr.No</th>
                    <th style="color: #2565ab; font-weight: 800;  ">User ID</th>
                    <th style="color: #2565ab; font-weight: 800;  ">User Name</th>
                    <th style="color: #2565ab; font-weight: 800;  "> rContact No.</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Email Id</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Status</th>
                    <th style="color: #2565ab; font-weight: 800;  ">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>A02543BS</td>
                    <td>george wagner</td>
                    <td>(489)501-4450</td>
                    <td>nic***pa@mail.com</td>
                    <td><label class="switch">
                            <input type="checkbox" class="switch-input">
                            <!--<i class="icon-play"></i>-->
                            <span class="switch-label" data-on="Enalble" data-off="Disable"></span>
                            <span class="switch-handle"></span>
                        </label></td>
                    <td>

                        <a type="button" class="svg-bg m-0" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            style="background-color: rgba(37,101,171,0.14); color:#2565ab">
                            <i class="fa-solid fa-pen" style="font-size: 14px;"> </i>
                        </a>
                        <a class="delete svg-bg" title="Delete" style="background-color: rgba(236,0,0,0.07); color:#EC0000">
                            <i class="fa-solid fa-trash-can" style="font-size: 14px;"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>A02543BS</td>
                    <td> Andreea Fisher</td>
                    <td>(489)501-4450</td>
                    <td>den***65@mail.com</td>
                    <td><label class="switch">
                            <input type="checkbox" class="switch-input">
                            <!--<i class="icon-play"></i>-->
                            <span class="switch-label" data-on="Enalble" data-off="Disable"></span>
                            <span class="switch-handle"></span>
                        </label></td>
                    <td>
                        <a type="button" class="svg-bg m-0" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            style="background-color: rgba(37,101,171,0.14); color:#2565ab">
                            <i class="fa-solid fa-pen" style="font-size: 14px;"> </i></a>

                        <a class="delete svg-bg" title="Delete" data-toggle="tooltip"
                            style="background-color: rgba(236,0,0,0.07); color:#EC0000">
                            <i class="fa-solid fa-trash-can" style="font-size: 14px;"></i>
                        </a>

                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>3</th>
                    <th>A02543BS</th>
                    <th>Carol Jackson</th>
                    <th>(489)501-4450</th>
                    <th>sar***hl@mail.com</th>
                    <th><label class="switch">
                            <input type="checkbox" class="switch-input">
                            <!--<i class="icon-play"></i>-->
                            <span class="switch-label" data-on="Enalble" data-off="Disable"></span>
                            <span class="switch-handle"></span>
                        </label></th>
                    <td>
                        <a type="button" class="svg-bg m-0" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            style="background-color: rgba(37,101,171,0.14); color:#2565ab">
                            <i class="fa-solid fa-pen" style="font-size: 14px;"> </i>
                        </a>
                        <a class="delete svg-bg" title="Delete" data-toggle="tooltip"
                            style="background-color: rgba(236,0,0,0.07); color:#EC0000">
                            <i class="fa-solid fa-trash-can" style="font-size: 14px;"></i>
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="background: rgba(6,39,75,0.5);">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel" style="color: #2565ab;">Edit Detail</h5>
                <div type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></div>
            </div>
            <div class="modal-body">
                <div class="row mt-3 bgc m-2">
                    <div class="col-lg-6 col-sm-6 mt-2">
                        <label style="color: #ADAEB0; font-size: 14px; ">User Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1">
                                <img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter UserName">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3">
                        <label style="color: #ADAEB0; font-size: 14px; ">User Id</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter User Id">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3">
                        <label style="color: #ADAEB0; font-size: 14px; ">Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/password.svg') }}">
                            </span>
                            <input class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 ">
                        <label style="color: #ADAEB0; font-size: 14px; ">Contact No.</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/contect.svg') }}">
                            </span>
                            <input class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Number">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3">
                        <label style="color: #ADAEB0; font-size: 14px; ">Email Id</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/email.svg') }}">
                            </span>
                            <input class="form-control border-0 border-bottom bg-transparent" type="text"
                                placeholder="Enter registered Email">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
