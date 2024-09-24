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
        <!--  Start Container  -->
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
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'agent' && request()->segment(2) == '') active @endif">
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
            <!-- Start Form-->
            {!! Form::open([
                'route' => ['subagent.save'],
                'class' => 'form form-vertical save-data-form',
                'id' => 'save-data-form',
                'data-toggle' => 'validator',
                'enctype' => 'multipart/form-data',
                'files' => true,
            ]) !!}
            <div class="bg-white p-2 shadow" style="border-radius: 20px; ">
                <input type="hidden" name="agent_type" value="sub-agent">

                <div class="row mt-3 m-2">
                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; ">User Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="user_name" id="user_name"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter User Name" autocomplete="off">

                            @component('components.ajax-error', ['field' => 'user_name'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label class="">Parent Agent</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text border-0 border-bottom " for="parent_agent"><img
                                    src="{{ asset('admin-assets/svg/travel agent/agent-code.svg') }}">
                            </label>
                            <select name="parent_agent" id="parent_agent"
                                class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent" id="parent_agent">
                                <option value="">Select Parent</option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}">
                                        {{ $parent->agent_key . '(' . $parent->user_name . ')' }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error', ['field' => 'parent_agent'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 mt-3 ">
                        <label style="color: #ADAEB0; font-size: 14px; ">BPC ID</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="agent_code" id="agent_code"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter BPC Id" value="" autocomplete="off" readonly>
                        </div>
                    </div>
                     <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('mudra_code') ? 'has-error' : '' }}">
                    <label style="color: #ADAEB0; font-size: 14px; ">Euronet ID</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                        </span>
                        <input name="euronet_id" id="euronet_id" class="form-control border-0 border-bottom bg-transparent " type="text" placeholder="Enter Euronet Id" value="{{ old('euronet_id') }}" autocomplete="off">

                        @component('components.ajax-error', ['field' => 'euronet_id'])
                        @endcomponent
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('mudra_code') ? 'has-error' : '' }}">
                    <label style="color: #ADAEB0; font-size: 14px; ">Mudra Code</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                        </span>
                        <input name="mudra_code" id="mudra_code" class="form-control border-0 border-bottom bg-transparent " type="text" placeholder="Enter Mudra Code" value="{{ old('mudra_code') }}" autocomplete="off">

                        @component('components.ajax-error', ['field' => 'mudra_code'])
                        @endcomponent
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('sap_code') ? 'has-error' : '' }}">
                    <label style="color: #ADAEB0; font-size: 14px; ">SAP Code</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                        </span>
                        <input name="sap_code" id="sap_code" class="form-control border-0 border-bottom bg-transparent " type="text" placeholder="Enter sap Code" value="{{ old('sap_code') }}" autocomplete="off">

                        @component('components.ajax-error', ['field' => 'sap_code'])
                        @endcomponent
                    </div>
                </div>

                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('gender') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; margin-right:5px">Gender </label>

                        <div class="input-group mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="male"
                                    id="inlineRadio1" value="male">
                                <label class="form-check-label" for="inlineRadio1">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="female"
                                    id="inlineRadio2" value="female">
                                <label class="form-check-label" for="inlineRadio2">Female</label>
                            </div>
                            @component('components.ajax-error', ['field' => 'gender'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label class=""> Status</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text border-0 border-bottom " for="sub_agent_status"><img
                                    src="{{ asset('admin-assets/svg/popup/status.svg') }}">
                            </label>
                            <select name="sub_agent_status" id="sub_agent_status"
                                class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent"
                                id="sub_agent_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            @component('components.ajax-error', ['field' => 'sub_agent_status'])
                            @endcomponent
                        </div>
                    </div>

                    {{-- Validity from Till --}}
                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('date_of_joining') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="validity_from">Validity From</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/18.svg') }}">
                            </span>
                            <input name="validity_from" id="validity_from"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Validity From" value="{{ old('validity_from') }}" autocomplete="off">

                            @component('components.ajax-error', ['field' => 'validity_from'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('validity_till') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="validity_till">Validity Till</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/18.svg') }}">
                            </span>
                            <input name="validity_till" id="validity_till"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Validity Till" value="{{ old('validity_till') }}" autocomplete="off">
                            @component('components.ajax-error', ['field' => 'validity_till'])
                            @endcomponent
                        </div>
                    </div>

                    {{-- Buy Margin / Sell Margin --}}
                    <div class="col-lg-4 col-sm-4 mt-3">
                        <label style="color: #ADAEB0; font-size: 14px;" for="buy_margin">Buy Margin</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/12.svg') }}">
                            </span>
                            <input name="buy_margin" id="buy_margin"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Buy Margin" value="" autocomplete="off" readonly>

                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 mt-3 ">
                        <label style="color: #ADAEB0; font-size: 14px;" for="sell_margin">Sell Margin</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/12.svg') }}">
                            </span>
                            <input name="sell_margin" id="sell_margin"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Sell Margin" value="" autocomplete="off" readonly>

                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="first_name">First Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="first_name" id="first_name"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter First Name" autocomplete="off" value="{{ old('first_name') }}">

                            @component('components.ajax-error', ['field' => 'first_name'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="last_name">Last Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="last_name" id="last_name"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Last Name" autocomplete="off" value="{{ old('last_name') }}">

                            @component('components.ajax-error', ['field' => 'last_name'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('mobile_number') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="mobile_number">Mobile Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/contect.svg') }}">
                            </span>
                            <input name="mobile_number" id="mobile_number"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Mobile Number" autocomplete="off" maxlength="10"
                                value="{{ old('mobile_number') }}">

                            @component('components.ajax-error', ['field' => 'mobile_number'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="email">Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/email.svg') }}">
                            </span>
                            <input name="email" id="email"
                                class="form-control border-0 border-bottom bg-transparent " type="email"
                                placeholder="Enter Email" autocomplete="off" value="{{ old('email') }}">

                            @component('components.ajax-error', ['field' => 'email'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="password">Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/password.svg') }}">
                            </span>
                            <input name="password" id="password"
                                class="form-control border-0 border-bottom bg-transparent " type="password"
                                placeholder="Enter Password" autocomplete="off">

                            @component('components.ajax-error', ['field' => 'password'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('emp_confirm_password') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="emp_confirm_password">Confirm
                            Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/password.svg') }}">
                            </span>
                            <input name="emp_confirm_password" id="emp_confirm_password"
                                class="form-control border-0 border-bottom bg-transparent " type="password"
                                placeholder="Enter Confirm Password" autocomplete="off">

                            @component('components.ajax-error', ['field' => 'emp_confirm_password'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-4 mt-3 {{ $errors->has('profile') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="profile">Upload profile</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="file" id="profile" name="profile"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Confirm Password" value="{{ old('profile') }}">
                            @component('components.ajax-error', ['field' => 'profile'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="d-flex mb-2">
                        <button type="submit" class="btn-lg btn-primary ">Save</button>
                        <button type="reset" class="btn-lg btn-primary  ">Reset</button>
                    </div>
                </div>
            </div>

        </div>
        <!--  End Container  -->
    </div>
    {!! Form::close() !!}
    <!-- End Form-->
@endsection

@push('pagescript')
    <script>
        /* Reset Btn */
        $('.save-data-form button[type="reset"]').click(function() {
            $('.ajax-error strong').html('');
        });

        /* Datepicker */
        $('#validity_from,#validity_till').datepicker({
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            language: 'en',
            autoclose: true
        });

        /* Add Form */
        $('.save-data-form').submit(function(event) {
            var status = document.activeElement.innerHTML;
            event.preventDefault();
            if (status) {
                $('.ajax-error').html('');
                var serializeData = $(this).serializeArray();
                var data = {};
                var fd = new FormData();
                var files = $('#profile')[0].files[0];
                fd.append('profile', files == undefined ? "" : files);
                $.each(serializeData, function(key, val) {
                    fd.append(val['name'], val['value']);
                });

                $.ajax({
                    url: $(this).attr("action"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: fd,
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        $(this).attr("disabled", false);
                        if (result.type === 'SUCCESS') {
                            var redirectUrl = "{{ route('subagent.index') }}";
                            toastr.success(result.message);
                            window.location.href = redirectUrl;
                            // $('#data-datatable').DataTable().ajax.reload();
                        } else {
                            toastr.error(result.message);
                        }
                    },
                    error: function(error) {
                        $(this).attr("disabled", false);
                        let errors = error.responseJSON.errors,
                            errorsHtml = '';
                        $.each(errors, function(key, value) {
                            errorsHtml = '<strong>' + value[0] + '</strong>';
                            $('.' + key).html(errorsHtml);
                        });
                    }
                });
            }
        });


        // Get agent detail
        $("#parent_agent").on('change', function() {
            var parent_id = $(this).val();
            $.ajax({
                type: 'GET',
                url: "{{ route('subagent.get-agent-data') }}",
                data: {
                    parent_id: parent_id
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data) {
                        $('#agent_code').val(data.agent_key);
                        $('#buy_margin').val(data.agent_buy);
                        $('#sell_margin').val(data.agent_sell);
                    } else {
                        $('#agent_code').val('');
                        $('#buy_margin').val('');
                        $('#sell_margin').val('');
                    }
                }
            });
        });
    </script>
@endpush
