<!-- css -->
@extends('layouts.admin.app')

@section('content')
@include('layouts.admin.sub-heading')
{!! Form::open([
// 'route' => ['subadmin.save'],
'class' => 'form form-vertical save-data-form',
'id' => 'save-data-form',
'data-toggle' => 'validator',
'enctype' => 'multipart/form-data',
'files' => true,
]) !!}

<div class="bg-white p-2" style="border-radius: 20px;">
    <input type="hidden" name="roles" value="Sub Admin">
    <input type="hidden" name="user_status" value="1">
    <div class="row mt-3 bgc m-2">
        <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('name') ? 'has-error' : '' }}">
            <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Name</label>
            <div class="input-group mb-3">
                <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                </span>
                <input type="text" name="name" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter UserName">
                @component('components.ajax-error', ['field' => 'name'])
                @endcomponent
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('user_code') ? 'has-error' : '' }}">
            <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Id</label>
            <div class="input-group mb-3">
                <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                </span>
                <input type="text" name="user_code" id="user_code" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter User Id" value="{{ old('user_code') }}">
                @component('components.ajax-error', ['field' => 'user_code'])
                @endcomponent
            </div>
        </div>

        {{-- <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('first_name') ? 'has-error' : '' }}">
        <label style="color: #ADAEB0; font-size: 14px;" for="first_name">First Name</label>
        <div class="input-group mb-3">
            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
            </span>
            <input type="text" id="first_name" name="first_name" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter First Name" maxlength="10" value="{{ old('first_name') }}">
            @component('components.ajax-error', ['field' => 'first_name'])
            @endcomponent
        </div>
    </div> --}}
    {{-- <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('last_name') ? 'has-error' : '' }}">
    <label style="color: #ADAEB0; font-size: 14px;" for="last_name">Last Name</label>
    <div class="input-group mb-3">
        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
        </span>
        <input type="text" id="last_name" name="last_name" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Last Name" maxlength="10" value="{{ old('last_name') }}">
        @component('components.ajax-error', ['field' => 'last_name'])
        @endcomponent
    </div>
</div> --}}

<div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label style="color: #ADAEB0; font-size: 14px; margin-right:5px">Gender</label>
    <div class="input-group mb-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="male" id="inlineRadio1" value="male">
            <label class="form-check-label" for="inlineRadio1">Male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="female" id="inlineRadio2" value="female">
            <label class="form-check-label" for="inlineRadio2">Female</label>
        </div>
        @component('components.ajax-error', ['field' => 'gender'])
        @endcomponent
    </div>
</div>

<div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('user_mobile') ? 'has-error' : '' }}">
    <label style="color: #ADAEB0; font-size: 14px;" for="user_mobile">Mobile Number</label>
    <div class="input-group mb-3">
        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
        </span>
        <input type="text" id="user_mobile" name="user_mobile" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Mobile Number" maxlength="10" value="{{ old('user_mobile') }}">
        @component('components.ajax-error', ['field' => 'user_mobile'])
        @endcomponent
    </div>
</div>

<div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('email') ? 'has-error' : '' }}">
    <label style="color: #ADAEB0; font-size: 14px;" for="email">Enter Email</label>
    <div class="input-group mb-3">
        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/email.svg') }}">
        </span>
        <input type="email" name="email" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Email" value="{{ old('email') }}">
        @component('components.ajax-error', ['field' => 'email'])
        @endcomponent
    </div>
</div>

{{-- <div class="col-lg-6 col-sm-6 mt-3 ">
                <label class="">Select Role</label>
                <div class="input-group mb-3">
                    <label class="input-group-text border-0 border-bottom " for="roles"><img
                            src="{{ asset('admin-assets/svg/6.svg') }}">
</label>
{!! Form::select('roles', $roles, null, [
'placeholder' => 'Select Role',
'class' => 'form-select fw-bold border-0 border-bottom pb-0 bg-transparent',
]) !!}
@component('components.ajax-error', ['field' => 'roles'])
@endcomponent
</div>
</div> --}}

<div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('password') ? 'has-error' : '' }}">
    <label style="color: #ADAEB0; font-size: 14px;" for="password">Enter Password</label>
    <div class="input-group mb-3">
        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/password.svg') }}">
        </span>
        <input type="password" id="password" name="password" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Password">
        @component('components.ajax-error', ['field' => 'password'])
        @endcomponent
    </div>
</div>

{{-- <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('emp_confirm_password') ? 'has-error' : '' }}">
<label style="color: #ADAEB0; font-size: 14px;" for="emp_confirm_password">Enter
    Confirm Password</label>
<div class="input-group mb-3">
    <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/password.svg') }}">
    </span>
    <input type="password" id="emp_confirm_password" name="emp_confirm_password" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Confirm Password">
    @component('components.ajax-error', ['field' => 'emp_confirm_password'])
    @endcomponent
</div>
</div> --}}

{{-- <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('user_status') ? 'has-error' : '' }}">
<label class="">Status</label>
<div class="input-group mb-3">
    <label class="input-group-text border-0 border-bottom " for="roles"><img src="{{ asset('admin-assets/svg/6.svg') }}">
    </label>
    <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent" name="user_status" id="user_status">
        <option value="">Select status</option>
        <option value="1">Active</option>
        <option value="2">Inactive
        </option>
    </select>
</div>
@component('components.ajax-error', ['field' => 'user_status'])
@endcomponent
</div> --}}
<div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('user_profile') ? 'has-error' : '' }}">
    <label style="color: #ADAEB0; font-size: 14px;" for="user_profile">Upload profile</label>
    <div class="input-group mb-3">
        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
        </span>
        <input type="file" accept="image/png, image/jpeg" id="user_profile" name="user_profile" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Confirm Password">
        @component('components.ajax-error', ['field' => 'user_profile'])
        @endcomponent
    </div>
</div>
</div>
</div>
<div class="d-flex">
    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
    <button type="submit" class="btn btn-primary mr-1 mb-1" id="saveBtn">Save
        <i class="loading-icon fa-lg fas fa-spinner fa-spin" style="display:none"></i></button>
    <button type="reset" class="btn btn-danger mr-1 mb-1">Reset</button>
</div>
</div>
{!! Form::close() !!}
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
        $('#saveBtn').attr("disabled", true);
        $('.loading-icon').show();
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var serializeData = $(this).serializeArray();
            var data = {};
            var fd = new FormData();
            var files = $('#user_profile')[0].files[0];
            fd.append('user_profile', files == undefined ? "" : files);

            $.each(serializeData, function(key, val) {
                fd.append(val['name'], val['value']);
            });

            $.ajax({
                url: "{{ route('subadmin.save') }}",
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
                        toastr.success(result.message);
                        $('#saveBtn').attr("disabled", false);
                        $('.loading-icon').hide();
                        var redirectUrl = "{{ route('subadmin.index') }}";
                        //toastr.options.onHidden = function() {
                        window.location.href = redirectUrl;
                        // }
                    } else {
                        toastr.error(result.message);
                        $('#saveBtn').attr("disabled", false);
                        $('.loading-icon').hide();
                    }
                },
                error: function(error) {
                    $(this).attr("disabled", false);
                    $('#saveBtn').attr("disabled", false);
                    $('.loading-icon').hide();
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
</script>
@endpush