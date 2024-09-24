<?php $__env->startSection('content'); ?>
    <div class="position-absolute top-0 start-50 translate-middle-x ">
        <!-- <img src="<?php echo e(asset('assets/img/logo2.png')); ?>" class="logo-img"> -->
        <img src="<?php echo e(asset('assets/images/TC-Logo.png')); ?>" class="logo-img">
    </div>
    <div class="wrapper">
        <?php if(session()->has('error')): ?>
            <div class="alert alert-danger"> <?php echo e(session()->get('error')); ?> </div>
        <?php endif; ?>
        <?php if(session('message')): ?>
            <?php echo e(session('message')); ?>

        <?php endif; ?>
        <div class="inner">
            <form action="<?php echo e(url('login/admin')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <h3 class="text-dark text-capitalize">Welcome Back !</h3>
                <p style="color: #ADAEB0;">Log in as an admin</p>
                <div>
                    <div class="col-12 col-sm-12 mt-5 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0;" class="login-required-field">Email</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="<?php echo e(asset('admin-assets/svg/login svg/username.svg')); ?>">
                            </span>
                            <input class="form-control border-0 border-bottom <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                                value="<?php echo e(old('email')); ?>" autocomplete="email" autofocus type="text" id="email"
                                name="email" placeholder="Enter Email">
                            <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 mt-4 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0;" class="login-required-field">Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="<?php echo e(asset('admin-assets/svg/login svg/password.svg')); ?>">
                            </span>
                            <input type="password" id="password" name="password"
                                class="form-control border-0 border-bottom <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                                placeholder="Enter password">
                            <div class="input-group-append login-password">
                                <div class="input-group-text">
                                    <i class="password-eye fas fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                        <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                            <span class="text-danger" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                </div>
                <?php if($message = Session::get('warning')): ?>
                    <div class="error">
                        <p class="text-danger"><?php echo e($message); ?></p>
                    </div>
                <?php endif; ?>

                <!-- 2 column grid layout for inline styling -->
                <div class="row">
                    
                    <div class="col ms-4" style="text-align:right">
                        <!-- Simple link -->
                        <!-- <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>" style="color: #BE0000; font-size: 14px;">Forgot
                                Password?
                            </a>
                        <?php endif; ?> -->
                    </div>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn-sm btn-primary btn-block pe-4 ps-4">
                    <span class="me-5 ms-5">Sign in</span>
                    <i class="fa-solid fa-right-long"></i>
                </button>
            </form>
            <div class="position-absolute bottom-0 start-50 translate-middle-x ">
                <img src="<?php echo e(asset('admin-assets/img/group.png')); ?>" class="logo-img2">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/auth/login.blade.php ENDPATH**/ ?>