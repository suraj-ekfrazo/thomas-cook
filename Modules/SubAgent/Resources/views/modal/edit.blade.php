<!-- Sub Agent -->
<div class="modal fade" id="editData" tabindex="-1" aria-hidden="true" style="background: rgba(6,39,75,0.5);">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
        {!! Form::open([
            'route' => ['subagent.update'],
            'class' => 'form form-vertical update-data-form',
            'id' => 'update-data-form',
            'data-toggle' => 'validator',
            'enctype' => 'multipart/form-data',
            'files' => true,
        ]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: #2565ab;">Update Sub Agent</h5>
                <div type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="{{ $data['id'] }}">
                <div class="row mt-3 bgc m-2">
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('agent_code') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; ">User Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="user_name" id="user_name"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter User Name" autocomplete="off" value="{{ $data['user_name'] }}">
                            @component('components.ajax-error', ['field' => 'user_name'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('parent_agent') ? 'has-error' : '' }}">
                        <label class="">Parent Agent</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text border-0 border-bottom " for="parent_agent"><img
                                    src="{{ asset('admin-assets/svg/travel agent/agent-code.svg') }}">
                            </label>
                            <select name="parent_agent" id="parent_agent"
                                class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent"
                                id="parent_agent">
                                <option value="">Select Parent</option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}"
                                        @if ($data['parent_id'] == $parent->id) selected @endif>
                                        {{ $parent->agent_key . '(' . $parent->user_name . ')' }}</option>
                                @endforeach
                            </select>
                            @component('components.ajax-error', ['field' => 'parent_agent'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 ">
                        <label style="color: #ADAEB0; font-size: 14px; ">BPC ID</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="agent_code" id="agent_code"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter BPC Id" value="{{ $data['agent_key'] }}" autocomplete="off"
                                readonly>
                        </div>
                    </div>
					 <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('euronet_id') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; ">Euronet ID</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="euronet_id" id="euronet_id"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Euronet ID" value="{{ $data['euronet_id'] }}" autocomplete="off"
                                value="{{ $data['euronet_id'] }}">
                            @component('components.ajax-error', ['field' => 'euronet_id'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('mudra_code') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; ">Mudra Code</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="mudra_code" id="mudra_code"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Euronet ID" value="{{ $data['mudra_code'] }}" autocomplete="off"
                                value="{{ $data['mudra_code'] }}">
                            @component('components.ajax-error', ['field' => 'mudra_code'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('sap_code') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; ">SAP Code</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="sap_code" id="sap_code"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter SAP ID" value="{{ $data['sap_code'] }}" autocomplete="off"
                                value="{{ $data['sap_code'] }}">
                            @component('components.ajax-error', ['field' => 'sap_code'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('agent_status') ? 'has-error' : '' }}">
                        <label class=""> Status</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text border-0 border-bottom " for="agent_status"><img
                                    src="{{ asset('admin-assets/svg/popup/status.svg') }}">
                            </label>
                            <select name="agent_status" id="agent_status"
                                class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent"
                                id="agent_status">
                                <option value="">Select Status</option>
                                <option value="1" {{ $data['status'] == '1' ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ $data['status'] == '2' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @component('components.ajax-error', ['field' => 'agent_status'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('gender') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; margin-right:5px">Gender </label>
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


                    {{-- Validity from Till --}}
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('validity_from') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="validity_from">Validity From</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/18.svg') }}">
                            </span>
                            <input name="validity_from" id="validity_from"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Validity From" value="{{ $data['agent_form'] }}"
                                autocomplete="off">

                            @component('components.ajax-error', ['field' => 'validity_from'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('validity_till') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="validity_till">Validity Till</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/18.svg') }}">
                            </span>
                            <input name="validity_till" id="validity_till"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Validity Till" value="{{ $data['agent_to'] }}"
                                autocomplete="off">
                            @component('components.ajax-error', ['field' => 'validity_till'])
                            @endcomponent
                        </div>
                    </div>

                    {{-- Buy Margin / Sell Margin --}}
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('buy_margin') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="buy_margin">Buy Margin</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/12.svg') }}">
                            </span>
                            <input name="buy_margin" id="buy_margin"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Buy Margin" value="{{ $data['agent_buy'] }}" autocomplete="off"
                                readonly>
                            @component('components.ajax-error', ['field' => 'buy_margin'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('sell_margin') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="sell_margin">Sell Margin</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/12.svg') }}">
                            </span>
                            <input name="sell_margin" id="sell_margin"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Sell Margin"value="{{ $data['agent_sell'] }}" autocomplete="off"
                                readonly>
                            @component('components.ajax-error', ['field' => 'sell_margin'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="first_name">First Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="first_name" id="first_name"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter First Name" autocomplete="off" maxlength="10"
                                value="{{ $data['first_name'] }}">

                            @component('components.ajax-error', ['field' => 'first_name'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="last_name">Last Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input name="last_name" id="last_name"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Last Name" autocomplete="off" maxlength="10"
                                value="{{ $data['last_name'] }}">

                            @component('components.ajax-error', ['field' => 'last_name'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('mobile_number') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="mobile_number">Mobile Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/contect.svg') }}">
                            </span>
                            <input name="mobile_number" id="mobile_number"
                                class="form-control border-0 border-bottom bg-transparent " type="text"
                                placeholder="Enter Mobile Number" autocomplete="off" maxlength="10"
                                value="{{ $data['mobile_number'] }}">

                            @component('components.ajax-error', ['field' => 'mobile_number'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="email">Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/email.svg') }}">
                            </span>
                            <input name="email" id="email"
                                class="form-control border-0 border-bottom bg-transparent " type="email"
                                placeholder="Enter Email" autocomplete="off" value="{{ $data['email'] }}">

                            @component('components.ajax-error', ['field' => 'email'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="password">Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/password.svg') }}">
                            </span>
                            <input name="password" id="password"
                                class="form-control border-0 border-bottom bg-transparent " type="password"
                                placeholder="Enter Password" autocomplete="off">

                            @component('components.ajax-error', ['field' => 'password'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('emp_confirm_password') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="emp_confirm_password">Confirm
                            Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/password.svg') }}">
                            </span>
                            <input name="emp_confirm_password" id="emp_confirm_password"
                                class="form-control border-0 border-bottom bg-transparent " type="password"
                                placeholder="Enter Confirm Password" autocomplete="off">

                            @component('components.ajax-error', ['field' => 'emp_confirm_password'])
                            @endcomponent
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('profile') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px;" for="profile">Upload profile</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="file" id="profile" name="profile"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Confirm Password" value="{{ old('profile') }}">
                            @component('components.ajax-error', ['field' => 'profile'])
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                <button type="reset" class="btn btn-primary mr-1 mb-1">Reset</button>
            </div>
        </div>
    </div>
</div>



<script>
    /* Reset Btn */
    $('.update-data-form button[type="reset"]').click(function() {
        $('.ajax-error strong').html('');
    });

    /* Close model */
    $(document).on('click', '.btn-close', function() {
        $('#editData').modal('hide');
    })

    /* Datepicker */
    $('#validity_from,#validity_till').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        language: 'en',
        autoclose: true
    });

    /* Update form */
    $('.update-data-form').submit(function(event) {
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
            // fd.append('name',$('#is_name').val() ? $('#is_name').val() : "");
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
