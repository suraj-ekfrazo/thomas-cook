<!-- css -->


<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.sub-heading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo Form::open([
// 'route' => ['subadmin.save'],
'class' => 'form form-vertical save-data-form',
'id' => 'save-data-form',
'data-toggle' => 'validator',
'enctype' => 'multipart/form-data',
'files' => true,
]); ?>


<div class="bg-white p-2" style="border-radius: 20px;">
    <input type="hidden" name="roles" value="Sub Admin">
    <input type="hidden" name="user_status" value="1">
    <div class="row mt-3 bgc m-2">
        <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
            <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Name</label>
            <div class="input-group mb-3">
                <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                </span>
                <input type="text" name="name" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter UserName">
                <?php $__env->startComponent('components.ajax-error', ['field' => 'name']); ?>
                <?php echo $__env->renderComponent(); ?>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_code') ? 'has-error' : ''); ?>">
            <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Id</label>
            <div class="input-group mb-3">
                <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                </span>
                <input type="text" name="user_code" id="user_code" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter User Id" value="<?php echo e(old('user_code')); ?>">
                <?php $__env->startComponent('components.ajax-error', ['field' => 'user_code']); ?>
                <?php echo $__env->renderComponent(); ?>
            </div>
        </div>

        
    

<div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('gender') ? 'has-error' : ''); ?>">
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
        <?php $__env->startComponent('components.ajax-error', ['field' => 'gender']); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
</div>

<div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_mobile') ? 'has-error' : ''); ?>">
    <label style="color: #ADAEB0; font-size: 14px;" for="user_mobile">Mobile Number</label>
    <div class="input-group mb-3">
        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
        </span>
        <input type="text" id="user_mobile" name="user_mobile" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Mobile Number" maxlength="10" value="<?php echo e(old('user_mobile')); ?>">
        <?php $__env->startComponent('components.ajax-error', ['field' => 'user_mobile']); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
</div>

<div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
    <label style="color: #ADAEB0; font-size: 14px;" for="email">Enter Email</label>
    <div class="input-group mb-3">
        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/email.svg')); ?>">
        </span>
        <input type="email" name="email" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Email" value="<?php echo e(old('email')); ?>">
        <?php $__env->startComponent('components.ajax-error', ['field' => 'email']); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>
</div>



<div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
    <label style="color: #ADAEB0; font-size: 14px;" for="password">Enter Password</label>
    <div class="input-group mb-3">
        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/password.svg')); ?>">
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
        <input type="file" accept="image/png, image/jpeg" id="user_profile" name="user_profile" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Confirm Password">
        <?php $__env->startComponent('components.ajax-error', ['field' => 'user_profile']); ?>
        <?php echo $__env->renderComponent(); ?>
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
<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('pagescript'); ?>
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
                url: "<?php echo e(route('subadmin.save')); ?>",
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
                        var redirectUrl = "<?php echo e(route('subadmin.index')); ?>";
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/SubAdmin/Resources/views/modal/add.blade.php ENDPATH**/ ?>