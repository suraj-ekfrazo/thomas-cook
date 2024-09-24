<?php $__env->startSection('content'); ?>
<div class="wrapper">
  <div class="inner">
    <form action="<?php echo e(url('/agent/login')); ?>"  method="POST">
      <?php echo csrf_field(); ?>
      <h3 class="text-dark text-capitalize">Welcome Back !</h3>
      <p style="color: #ADAEB0;">Login in as an agent</p>
      <div>
     
        <div class="col-12 col-sm-12 mt-5 p-0" style="width: 313px;">
          <label style="color: #ADAEB0;" class="login-required-field" >Username</label>
          <div class="input-group mb-3">
            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="../agent-assets/svg/login svg/username.svg">
            </span>
            <input class="form-control border-0 border-bottom <?php if ($errors->has('user_name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('user_name'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
              value="<?php echo e(old('user_name')); ?>" required autocomplete="user_name" autofocus type="text" id="user_name"
              name="user_name" placeholder="Enter Username">
            
            <?php if ($errors->has('user_name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('user_name'); ?>
            <span class="invalid-feedback" role="alert">
                <strong><?php echo e($message); ?></strong>
            </span>
            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
          </div>
        </div>

        <div class="col-lg-12 col-sm-12 mt-4 p-0" style="width: 313px;">
          <label style="color: #ADAEB0;" class="login-required-field" >Password</label>
          <div class="input-group mb-3">
            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="../agent-assets/svg/login svg/password.svg">
            </span>
            <input class="form-control border-0 border-bottom <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" required type="password" placeholder="Enter password" id="password" name="password">
          </div>
          <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
          <span class="invalid-feedback" role="alert">
              <strong><?php echo e($message); ?></strong>
          </span>
          <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>

        <?php if($message = Session::get('warning')): ?>
            <div class="error">
              <p class="text-danger"><?php echo e($message); ?></p>
            </div>
        <?php endif; ?>

        <!-- 2 column grid layout for inline styling -->
        <div class="row">
          <div class="col d-flex justify-content-between">
            <!-- Checkbox -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
              <label class="form-check-label text-dark" for="form2Example31" style="font-size: 14px;">Remember</label>
            </div>
          </div>

          <div class="col pe-0 ms-4">
            <!-- Simple link -->
            <?php if(Route::has('password.request')): ?>
                <a href="<?php echo e(route('forget.password.get')); ?>" style="color: #BE0000; font-size: 14px;">Forgot
                    Password?
                </a>
            <?php endif; ?>
          </div>
        </div>


        <!-- Submit button -->

        <button type="submit" class="btn-sm btn-primary btn-block pe-4 ps-4"><span class="me-5 ms-5">Sign in </span><i class="fa-solid fa-right-long"></i></button>

      </div>
  </div>
  </form>
 
  <div class="position-absolute bottom-0 start-50 translate-middle-x ">
    <img src="../assets/img/group.png" class="logo-img2">
  </div>
</div>
</div>
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194" integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw==" data-cf-beacon="{&quot;rayId&quot;:&quot;742abde259e48563&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;,&quot;version&quot;:&quot;2022.8.0&quot;,&quot;si&quot;:100}" crossorigin="anonymous"></script>

<?php echo $__env->make('layouts.agent.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/thomas-cook/resources/views/agent/auth/login.blade.php ENDPATH**/ ?>