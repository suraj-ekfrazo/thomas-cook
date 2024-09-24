@extends('layouts.admin.app')

@section('content')
    @include('layouts.admin.sub-heading')
    <form action="" method="POST">
        <div class="bg-white p-2" style="border-radius: 20px;">
            <div class="row mt-3 bgc m-2">
                <div class="col-lg-6 col-sm-6 mt-2">
                    <label style="color: #ADAEB0; font-size: 14px; ">User Name</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                        </span>
                        <input class="form-control border-0 border-bottom bg-transparent " type="text"
                            placeholder="Enter UserName">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 mt-3">
                    <label style="color: #ADAEB0; font-size: 14px; ">User Id</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                        </span>
                        <input class="form-control border-0 border-bottom bg-transparent " type="text"
                            placeholder="Enter User Id">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 mt-3">
                    <label style="color: #ADAEB0; font-size: 14px; ">Password</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                src="{{ asset('admin-assets/svg/popup/password.svg') }}">
                        </span>
                        <input class="form-control border-0 border-bottom bg-transparent " type="password"
                            placeholder="Enter Password">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 mt-3 ">
                    <label style="color: #ADAEB0; font-size: 14px; ">Contact No.</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                src="{{ asset('admin-assets/svg/popup/contect.svg') }}">
                        </span>
                        <input class="form-control border-0 border-bottom bg-transparent " type="text"
                            placeholder="Enter Number">
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6 mt-3">
                    <label style="color: #ADAEB0; font-size: 14px; ">Email Id</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                src="{{ asset('admin-assets/svg/popup/email.svg') }}">
                        </span>
                        <input class="form-control border-0 border-bottom bg-transparent" type="text"
                            placeholder="Enter registered Email">
                    </div>
                </div>


                <div class="col-lg-6 col-sm-6 mt-3 ">
                    <label class="">Select Type</label>
                    <div class="input-group mb-3">
                        <label class="input-group-text border-0 border-bottom " for="inputGroupSelect01"><img
                                src="{{ asset('admin-assets/svg/6.svg') }}">
                        </label>
                        <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent"
                            id="inputGroupSelect01">
                            <option selected style="color: #1E1E1E ;">Select</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-primary">Back</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection
