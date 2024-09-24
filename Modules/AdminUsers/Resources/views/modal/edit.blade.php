<div class="modal fade" id="editData" tabindex="-1" aria-hidden="true" style="background: rgba(6,39,75,0.5);">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
        {!! Form::open([
            'route' => ['admin-users.update'],
            'class' => 'update-data-form',
            'id' => 'update-data-form',
            'data-toggle' => 'validator',
            'enctype' => 'multipart/form-data',
            'files' => true,
        ]) !!}
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: #2565ab;">Edit Detail</h5>
                <div type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="{{ $data['id'] }}">
                <input type="hidden" name="user_status" value="{{ $data['status'] }}">
                <div class="row mt-3 bgc m-2">
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="name" id="name"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter UserName"
                                value="{{ $data['name'] }}">
                            @component('components.ajax-error', ['field' => 'name'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('user_code') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Id</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="user_code" id="user_code"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter User Id"
                                value="{{ $data['user_code'] }}">
                            @component('components.ajax-error', ['field' => 'user_code'])
                            @endcomponent
                        </div>
                    </div>

                    {{-- <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="first_name">First Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" id="first_name" name="first_name"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter First Name" value="{{ $data['first_name'] }}" maxlength="10">
                            @component('components.ajax-error', ['field' => 'first_name'])
                            @endcomponent
                        </div>
                    </div> --}}
                    {{-- <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="last_name">Last Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" id="last_name" name="last_name"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Last Name"
                                value="{{ $data['last_name'] }}" maxlength="10">
                            @component('components.ajax-error', ['field' => 'last_name'])
                            @endcomponent
                        </div>
                    </div> --}}


                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('gender') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; margin-right:5px">Gender</label>
                        <div class="input-group mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="male"
                                    id="inlineRadio1" value="male" {{ $data['gender'] == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inlineRadio1">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="female"
                                    id="inlineRadio2" value="female"
                                    {{ $data['gender'] == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inlineRadio2">Female</label>
                            </div>
                            @component('components.ajax-error', ['field' => 'gender'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('user_mobile') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="user_mobile">Mobile Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" id="user_mobile" name="user_mobile"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Mobile Number" value="{{ $data['user_mobile'] }}" maxlength="10">
                            @component('components.ajax-error', ['field' => 'user_mobile'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="email">Enter Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="email" id="email" name="email"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Email"
                                value="{{ $data['email'] }}">
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
                            <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent"
                                id="roles" name="roles">
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}"
                                        @if ($role == $userRole) selected @endif>
                                        {{ $role }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error', ['field' => 'roles'])
                            @endcomponent
                        </div>
                    </div> --}}

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="password">Enter Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="password" id="password" name="password"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Password">
                            @component('components.ajax-error', ['field' => 'password'])
                            @endcomponent
                        </div>
                    </div>

                    {{-- <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('emp_confirm_password') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="emp_confirm_password">Enter
                            Confirm Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="password" id="emp_confirm_password" name="emp_confirm_password"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Confirm Password">
                            @component('components.ajax-error', ['field' => 'emp_confirm_password'])
                            @endcomponent
                        </div>
                    </div> --}}

                    {{-- <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label class="">Status</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text border-0 border-bottom " for="user_status"><img
                                    src="{{ asset('admin-assets/svg/6.svg') }}">
                            </label>
                            <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent"
                                id="user_status" name="user_status">
                                <option value="">Select status...</option>
                                <option value="1" {{ $data['status'] == '1' ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ $data['status'] == '2' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @component('components.ajax-error', ['field' => 'user_status'])
                            @endcomponent
                        </div>
                    </div> --}}
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('user_profile') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="user_profile">Upload profile</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input accept="image/png, image/jpeg" type="file" id="user_profile" name="user_profile"
                                class="form-control border-0 border-bottom bg-transparent"
                                value="{{ old('user_profile') }}">
                            @component('components.ajax-error', ['field' => 'user_profile'])
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                <button type="reset" class="btn btn-danger mr-1 mb-1">Reset</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
    /* Datepicker */
    $('#validity_from,#validity_till').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        language: 'en',
        autoclose: true
    });

    //Close edit model
    $(document).on('click', '.btn-close ', function() {
        $('#editData').modal('hide');
    });

    /* Reset Btn */
    $(document).on('click', '.update-data-form button[type="reset"] ', function() {
        $('.ajax-error strong').html('');
    });


    //-------Update admin record----------
    //$(document).on('submit', '.update-data-form', function(event) {
    $('.update-data-form').submit(function(e){
        var status = document.activeElement.innerHTML;
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
            // fd.append('name',$('#is_name').val() ? $('#is_name').val() : "");
            $.ajax({
                url: $(this).attr('action'),
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
                        $('#editData').modal('hide');
                        $('#data-datatable').DataTable().ajax.reload();

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
</script>
