<?php $__env->startSection('content'); ?>
    <div class="position-absolute top-0 start-50 translate-middle-x ">
        <!-- <img src="<?php echo e(asset('assets/img/logo2.png')); ?>" class="logo-img"> -->
    </div>
    <div class="wrapper-3">
        <div class="inner">
        <?php if(Session::has('message')): ?>
            <div class="alert alert-success" role="alert">
             <?php echo e(Session::get('message')); ?>

            </div>
        <?php endif; ?>
            <form action="<?php echo e(route('forget.password.tc.post')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <h3 class="text-dark fw-bold" style="font-size: 20px;text-align: center;">Reset Your Password</h3>
                <p style="color: #000000; font-size: 13px;text-align: center;">Request an email reset link</p>
                <div>
                    <div class="col-12 col-sm-12 mt-5 p-0" style="width: 313px;">
                        <label style="color: #ADAEB0; font-size: 14px; ">Email Id</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="<?php echo e(asset('admin-assets/svg/login svg/msg.svg')); ?>">
                            </span>
                            <input class="form-control border-0 border-bottom <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                                type="email" name="email" id="email" value="<?php echo e(old('email')); ?>"
                                placeholder="Enter registered Email">
                               
                            <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                <span class="invalid-feedback error_msg" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn-sm btn-primary btn-block pe-4 ps-4"><span class="me-5 ms-5">Send Link
                        </span><i class="fa-solid fa-right-long"></i></button>

                    <div class="mt-4" style="font-size: 14px; text-align:center;">
                        <p class="text-dark">
                            <i class="fa-solid fa-angle-left"></i>
                            &nbsp;&nbsp;&nbsp;Back To<a href="<?php echo e(url('/tcuser/login')); ?>"
                                style="color: #2565ab; text-decoration: none; ">&nbsp;Sign In</a>
                        </p>
                    </div>
                </div>
            </form>
            <div class="position-absolute bottom-0 start-50 translate-middle-x ">
                <img src="<?php echo e(asset('admin-assets/img/group.png')); ?>" class="logo-img2">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.tcuser.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/tcuser/passwords/email.blade.php ENDPATH**/ ?>