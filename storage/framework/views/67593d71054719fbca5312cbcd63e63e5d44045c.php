<div class="modal fade" id="editData" tabindex="-1" aria-hidden="true" style="background: rgba(6,39,75,0.5);">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
        <?php echo Form::open([
            'route' => ['tcuser.update'],
            'class' => 'update-data-form',
            'id' => 'update-data-form',
            'data-toggle' => 'validator',
            'enctype' => 'multipart/form-data',
            'files' => true,
        ]); ?>

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: #2565ab;">Edit Detail</h5>
                <div type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="<?php echo e($data['id']); ?>">

                <div class="row mt-3 bgc m-2">
                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="text" name="name" id="name"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter UserName"
                                value="<?php echo e($data['name']); ?>">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'name']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                        <p id="warning-message" style="color:red" ></p>
                    <div id="uname_response"></div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_code') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Id </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="text" name="user_code" id="user_code"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter User Id"
                                value="<?php echo e($data['user_code']); ?>">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'user_code']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="first_name">First Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="text" id="first_name" name="first_name"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter First Name" value="<?php echo e($data['first_name']); ?>" maxlength="10">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'first_name']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="last_name">Last Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="text" id="last_name" name="last_name"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Last Name"
                                value="<?php echo e($data['last_name']); ?>" maxlength="10">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'last_name']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('gender') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px; margin-right:5px">Gender</label>
                        <div class="input-group mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="male"
                                    id="inlineRadio1" value="male" <?php echo e($data['gender'] == 'male' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="inlineRadio1">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="female"
                                    id="inlineRadio2" value="female"
                                    <?php echo e($data['gender'] == 'female' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="inlineRadio2">Female</label>
                            </div>
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'gender']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_mobile') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="user_mobile">Mobile Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="text" id="user_mobile" name="user_mobile"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Mobile Number" value="<?php echo e($data['user_mobile']); ?>" maxlength="10">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'user_mobile']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="email">Enter Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="email" id="email" name="email"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Email"
                                value="<?php echo e($data['email']); ?>">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'email']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>


                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="password">Enter Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="password" id="password" name="password"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Password">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'password']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="user_status">Status</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text border-0 border-bottom " for="user_status"><img
                                    src="<?php echo e(asset('admin-assets/svg/6.svg')); ?>">
                            </label>
                            <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent"
                                id="user_status" name="user_status">
                                <option value="">Select status...</option>
                                <option value="1" <?php echo e($data['status'] == '1' ? 'selected' : ''); ?>>Active</option>
                                <option value="2" <?php echo e($data['status'] == '2' ? 'selected' : ''); ?>>Inactive
                                </option>
                            </select>
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'user_status']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_profile') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="user_profile">Upload profile</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="file" accept="image/png, image/jpeg" id="user_profile" name="user_profile"
                                class="form-control border-0 border-bottom bg-transparent"
                                value="<?php echo e(old('user_profile')); ?>">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'user_profile']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('tc_type') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="tc_type">Booking Type</label>
                        <div class="input-group mb-3">
                            <?php
                                $tc_type = explode(',', $data['tc_type']);
                            ?>
                            <div class="row">
                                <div class="d-flex">
                                    <div class="form-check  me-3 fw-bold">
                                        <input type="checkbox" class="form-check-input tc_checkbox" id="check1"
                                            name="tc_type[]" value="0"
                                            <?php echo e(in_array('0', $tc_type) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="check1">Buy</label>
                                    </div>
                                    <div class="form-check  me-3 fw-bold">
                                        <input type="checkbox" class="form-check-input tc_checkbox" id="check2"
                                            name="tc_type[]" value="1"
                                            <?php echo e(in_array('1', $tc_type) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="check2"> Sell</label>
                                    </div>
                                    <div class="form-check  me-3 fw-bold">
                                        <input type="checkbox" class="form-check-input tc_checkbox" id="check3"
                                            name="tc_type[]" value="2"
                                            <?php echo e(in_array('2', $tc_type) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="check3">Rate Block</label>
                                    </div>
                                </div>
                                <p style="color:#FF3838 ; font-weight: 600;">Note: you can select only 2 value</p>
                            </div>
                        </div>
                        <?php $__env->startComponent('components.ajax-error', ['field' => 'tc_type']); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                <button type="reset" class="btn btn-danger mr-1 mb-1">Reset</button>
            </div>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div>

<script>
        $(document).ready(function() {

            $("#name").keyup(function() {

                var minlength = 5;
                var maxlength = 10;
                    var char = $(this).val();
                    var charLength = $(this).val().length;
                    if(charLength != ''){

                        if (charLength < minlength) {
                        $('#warning-message').text('Length is short, minimum ' + minlength + ' required.');
                    } else if (charLength > maxlength) {
                        $('#warning-message').text('Length is not valid, maximum ' + maxlength + ' allowed.');
                        $(this).val(char.substring(0, maxlength));
                    } else {
                        $('#warning-message').text('');
                    }

                    }else{
                        $("#warning-message").html("");
                    }

                // console.log("hi");

                var username = $(this).val().trim();

                if (username != '') {
                    $.ajax({
                        url: "<?php echo e(route('name.post')); ?>",
                        type: 'POST',
                        data: {
                            name: username
                        },
                        success: function(response) {
                            console.log("conl");
                            // Show response
                            $("#uname_response").html(response);

                        }
                    });
                } else {
                    $("#uname_response").html("");
                }

            });

        });
    </script>

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
   // $(document).on('submit', '.update-data-form', function(event) {
        $('.update-data-form').submit(function(event) {
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

    // tc type checkbox limit
    var limit = 3;
    $('input.tc_checkbox').on('change', function(evt) {
        if ($('input[name="tc_type[]"]:checked').length >= limit) {
            this.checked = false;
        }
    });
</script>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/TcUser/Resources/views/modal/edit.blade.php ENDPATH**/ ?>