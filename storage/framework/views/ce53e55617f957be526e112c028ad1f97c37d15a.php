<div class="modal fade" id="editData" tabindex="-1" aria-hidden="true" style="background: rgba(6,39,75,0.5);">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
        <?php echo Form::open([
        'route' => ['subadmin.update'],
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
                <input type="hidden" name="user_status" value="<?php echo e($data['status']); ?>">
                <div class="row mt-3 bgc m-2">
                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"  id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="text" readonly name="name" id="name" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter UserName" value="<?php echo e($data['name']); ?>">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'name']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_code') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Id </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"  id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="text" readonly name="user_code" id="user_code" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter User Id" value="<?php echo e($data['user_code']); ?>">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'user_code']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('gender') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px; margin-right:5px">Gender</label>
                        <div class="input-group mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="male" id="inlineRadio1" value="male" <?php echo e($data['gender'] == 'male' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="inlineRadio1">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="female" id="inlineRadio2" value="female" <?php echo e($data['gender'] == 'female' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="inlineRadio2">Female</label>
                            </div>
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'gender']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_mobile') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="user_mobile">Mobile Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="text" id="user_mobile" name="user_mobile" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Mobile Number" value="<?php echo e($data['user_mobile']); ?>" maxlength="10">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'user_mobile']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="email">Enter Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="email" readonly id="email" name="email" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Email" value="<?php echo e($data['email']); ?>">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'email']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>


                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="password">Enter Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="password" id="password" name="password" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Password">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'password']); ?>
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_profile') ? 'has-error' : ''); ?>">
                        <label style="color: #ADAEB0; font-size: 14px;" for="user_profile">Upload profile</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                            </span>
                            <input type="file" id="user_profile" name="user_profile" accept="image/png, image/jpeg" class="form-control border-0 border-bottom bg-transparent" value="<?php echo e(old('user_profile')); ?>">
                            <?php $__env->startComponent('components.ajax-error', ['field' => 'user_profile']); ?>
                            <?php echo $__env->renderComponent(); ?>
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
        <?php echo Form::close(); ?>

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
</script><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/SubAdmin/Resources/views/modal/edit.blade.php ENDPATH**/ ?>