<!-- css -->


<?php $__env->startSection('content'); ?>
<div class="w-100 bg-cover flickity-cell is-selected" style="background-image: url(<?php echo e(asset('admin-assets/img/admin/heading.jpg')); ?>); transform: translateX(0%); opacity: 1;">
    <div class="bg-dark-20">
        <div class=" container  justify-content-between">
            <div class=" " style="min-height: 150px;">
                <div class="d-flex pt-5">
                    <a href="<?php echo e(route('dashboard.index')); ?>" class="D-icon">
                        <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                    </a>
                    <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Tc User
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="background-image: url(<?php echo e(asset('admin-assets/img/main_bg.jpg')); ?>);">
    <div class="container">
        <!--Sub heading -->
        <div class="row pt-5 pb-5 justify-content-center">
            <div class="col-md-6 col-lg-4 col-sm-3">
                <a href="<?php echo e(route('tcuser.add')); ?>">
                    <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'tcuser' && request()->segment(2) == 'create'): ?> active <?php endif; ?>">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="<?php echo e(asset('admin-assets/svg/dashboard/ic_tc_user.svg')); ?>">
                                </span>
                                <div class=" fw-bold">Create
                                    Tc User</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-3">
                <a href="<?php echo e(route('tcuser.index')); ?>">
                    <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'tcuser' && request()->segment(2) == ''): ?> active <?php endif; ?> ">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="<?php echo e(asset('admin-assets/svg/dashboard/ic_rate_master.svg')); ?>">
                                </span>
                                <div class=" fw-bold">Tc User List</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!--End sub heading -->
        <?php echo Form::open([
        // 'route' => ['tcuser.save'],
        'class' => 'form form-vertical save-data-form',
        'id' => 'save-data-form',
        'data-toggle' => 'validator',
        'enctype' => 'multipart/form-data',
        'files' => true,
        ]); ?>


        <div class="bg-white p-2" style="border-radius: 20px;">
            <input type="hidden" name="roles" value="Tc User">
            <div class="row mt-3 bgc m-2">
                <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                    <label style="color: #ADAEB0; font-size: 14px; " for="user_code">User Name</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                        </span>
                        <input type="text"  id="name" name="name" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter UserName">
                        <?php $__env->startComponent('components.ajax-error', ['field' => 'name']); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                    <p id="warning-message" style="color:red" ></p>
                    <div id="uname_response"></div>
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
                <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
                    <label style="color: #ADAEB0; font-size: 14px;" for="first_name">First Name</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                        </span>
                        <input type="text" id="first_name" name="first_name" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter First Name" maxlength="10" value="<?php echo e(old('first_name')); ?>">
                        <?php $__env->startComponent('components.ajax-error', ['field' => 'first_name']); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
                    <label style="color: #ADAEB0; font-size: 14px;" for="last_name">Last Name</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                        </span>
                        <input type="text" id="last_name" name="last_name" class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Last Name" maxlength="10" value="<?php echo e(old('last_name')); ?>">
                        <?php $__env->startComponent('components.ajax-error', ['field' => 'last_name']); ?>
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
                <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_status') ? 'has-error' : ''); ?>">
                    <label class="">Status</label>
                    <div class="input-group mb-3">
                        <label class="input-group-text border-0 border-bottom " for="roles"><img src="<?php echo e(asset('admin-assets/svg/6.svg')); ?>">
                        </label>
                        <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent" name="user_status" id="user_status">
                            <option value="">Select status</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive
                            </option>
                        </select>
                    </div>
                    <?php $__env->startComponent('components.ajax-error', ['field' => 'user_status']); ?>
                    <?php echo $__env->renderComponent(); ?>
                </div>

                <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('user_profile') ? 'has-error' : ''); ?>">
                    <label style="color: #ADAEB0; font-size: 14px;" for="user_profile">Upload profile</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                        </span>
                        <input type="file" accept="image/png, image/jpeg" id="user_profile" name="user_profile" class="form-control border-0 border-bottom bg-transparent">
                        <?php $__env->startComponent('components.ajax-error', ['field' => 'user_profile']); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6 mt-3 <?php echo e($errors->has('tc_type') ? 'has-error' : ''); ?>">
                    <label style="color: #ADAEB0; font-size: 14px;" for="tc_type">Booking Type</label>
                    <div class="row">
                        <div class="d-flex">
                            <div class="form-check  me-3 fw-bold">
                                <input type="checkbox" class="form-check-input tc_checkbox" id="check1" name="tc_type[]" value="0">
                                <label class="form-check-label" for="check1">Buy</label>
                            </div>
                            <div class="form-check  me-3 fw-bold">
                                <input type="checkbox" class="form-check-input tc_checkbox" id="check2" name="tc_type[]" value="1">
                                <label class="form-check-label" for="check2"> Sell</label>
                            </div>
                           <div class="form-check  me-3 fw-bold">
                                <input type="checkbox" class="form-check-input tc_checkbox" id="check3" name="tc_type[]" value="2">
                                <label class="form-check-label" for="check3">Rate Block</label>
                            </div>
			
                        </div>
                        <p style="color:#FF3838 ; font-weight: 600;">Note: you can select only 2 value</p>
                    </div>
                    <?php $__env->startComponent('components.ajax-error', ['field' => 'tc_type']); ?>
                    <?php echo $__env->renderComponent(); ?>
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
                    url: "<?php echo e(route('tcuser.save')); ?>",
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
                            var redirectUrl = "<?php echo e(route('tcuser.index')); ?>";
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

        var limit = 3;
        $('input.tc_checkbox').on('change', function(evt) {
            if ($('input[name="tc_type[]"]:checked').length >= limit) {
                this.checked = false;
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/TcUser/Resources/views/modal/add.blade.php ENDPATH**/ ?>