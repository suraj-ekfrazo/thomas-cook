<?php $__env->startSection('content'); ?>
    <style>
        label.error {
            width: 100%;
            color: red;
        }

        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

            background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 150ms infinite linear;
            -moz-animation: spinner 150ms infinite linear;
            -ms-animation: spinner 150ms infinite linear;
            -o-animation: spinner 150ms infinite linear;
            animation: spinner 150ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes  spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
          rel="stylesheet"/>
    <?php echo csrf_field(); ?>

    
    <div id="loading_divs"></div>
    <nav class="navbar navbar-expand-lg navbar-default rounded-top rounded-4 ">
        <div class="container-fluid px-0">
            <div class="d-flex">
                <!-- <a class="navbar-brand" href="index.html"><img src="../assets/img/logo2.png" class="img-fluid"
                                                               alt="Responsive image"/></a> -->
                <a class="navbar-brand" href="<?php echo e(url('/agent/dashboard')); ?>"><img src="../assets/images/LOGO.png" class="img-fluid"
                                                                                  alt="Responsive image"/></a>
                <div class="dropdown"></div>
            </div>
            <!-- Button -->
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="icon-bar top-bar mt-0"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbar-default">
                <ul class="navbar-nav ms-auto">
                    <div class="mt-2 me-2 ms-3">
                        <img src="../agent-assets/svg/2.svg">
                    </div>
                    <div class="ms-3">
                        <div class="fw-bold">Phone</div>
                        <a class="text-dark" href="tel:8828763483">8828763483</a>
                    </div>
                    <div class="mt-2 me-2 ms-3">
                        <img src="../assets/svg/1.svg">
                    </div>
                    <div class="ms-3">
                        <div class="fw-bold">Email</div>
                        <a href="mailto:tcsales@thomascook.in"
                           class="text-dark">tcsales@thomascook.in</a>
                    </div>
                </ul>

                <div class="ms-auto mt-3 mt-lg-0 text-center">
                    <a href="#"><i class="fe fe-shopping-cart fs-3 align-middle"></i></a>
                    <a class="text-bold text-decoration-none fw-bold" href="<?php echo e(Route('employee.profile')); ?>" style="color:#4f4f4f !important;"><?php echo e(ucwords(Auth::user()->first_name)); ?></a>
                    <a href="<?php echo e(Route('agent.logout')); ?>"
                       class="btn btn-dark btn-sm ms-3 rounded-0 text-capitalize ">&nbsp;&nbsp;&nbsp;Logout&nbsp;&nbsp;&nbsp;</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- section -->
    <section class="py-lg-16 img-responsive"
             style="background-image: url('../assets/img/web.jpg');background-repeat: no-repeat;background-size:cover;margin-top: -85px;">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row align-items-center">
                <!-- col -->
                <div class="col-lg-8 mb-8 mb-lg-0">
                    <div class="" style="margin-top:10rem">
                        <!-- heading -->
                        <h2 class=" mb-2" style="color: #ffffff;">NEVER STOP</h2>
                        <!-- heading -->
                        <h1 class="display-3 fw-bold mb-3" style="color: #00B7FF;">EXPLORING THE WORLD</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-team" id="refresh">
        <div class="container" id="time">
        
        <!-- / End Header Section -->

            <div class="btn-buy">
                <button class="btn5 border-0">Buy</button>
                <br>
                <button class="btn6 border-0">Sell</button>
            </div>

            <div class="flex-container currency-feed-info-wrap">
                <!-- Start Single Person -->
                <?php
                date_default_timezone_set('Asia/Kolkata');
                $current_time = strtotime('now');

                ?>
                <?php $__currentLoopData = $currencydata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $rate_margin = $value->rate_margin;
                    if (is_object($rate_margin)) {
                        //echo $current_time."===>".strtotime('10:00 am');
                        switch ($current_time) {
                            case $current_time >= strtotime('10:00 am') && $current_time < strtotime('12:00 pm'):

                                $ratemargin = $rate_margin->sell_margin_10_12;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $final_margin;
                                break;
                            case $current_time >= strtotime('12:00 pm') && $current_time < strtotime('02:00 pm'):
                                $ratemargin = $rate_margin->sell_margin_12_2;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $final_margin;
                                break;
                            case $current_time >= strtotime('02:00 pm') && $current_time < strtotime('03:30 pm'):
                                $ratemargin = $rate_margin->sell_margin_2_3_30;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $final_margin;
                                break;
                            case $current_time >= strtotime('03:30 pm'):
                                $ratemargin = $rate_margin->sell_margin_3_30_end;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $final_margin;
                                break;
                            default:
                                $ratemargin = $rate_margin->sell_margin;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $final_margin;
                                break;
                        }
                    }
                    if ($value->currency_name_key != 'AED') {
                        $buy_rate = $value->cur_bye - 0.10;
                    } else {
                        $buy_rate = $value->cur_bye - 0.13;
                    }
                    ?>
                    <div class="me-3">
                        <div class="single-person">
                            <div class="person-image">
                                <span class="icon">
                                    <img src="../assets/img/<?php echo e($value->flag); ?>">
                                </span>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold"><?php echo e($value->currency_name_key); ?></div>
                                <div class="row-font border-0 border-bottom"><?php echo e(number_format((float) $buy_rate, 2, '.', '')); ?></div>
                                <div class="row-font1"><?php echo e(number_format((float) $final_rate, 2, '.', '')); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Tabs navs -->
        <ul class="nav nav-tabs nav-justified  mt-4" id="ex1" role="tablist">
            <li class="nav-item tab1" role="presentation">
                <a class="nav-link fw-bold text-light mt-3 ms-3 me-3 active" id="ex3-tab-1" data-mdb-toggle="tab"
                   href="#ex3-tabs-1" role="tab" aria-controls="ex3-tabs-1" aria-selected="true"><i
                        class="fa-regular fa-square-plus"></i>
                    <span>&nbsp;Profile</span></a>
            </li>
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->
        <div class="tab-content" id="ex3-content">

            <div class="tab-pane fade show active bg-white" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1">
                <div id="main_frm">
                    <form id="profileForm" name="profileForm" enctype="multipart/form-data"
                          novalidate="novalidate">
                        <?php echo csrf_field(); ?>
                        <div class="row mt-3">

                            <div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">First Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="firstName" name="firstName" class="form-control border-0 border-bottom p-2" placeholder="First Name" value="<?php echo e($AgentData->first_name); ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">Last Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="lastName" name="lastName" class="form-control border-0 border-bottom p-2" placeholder="Last Name" value="<?php echo e($AgentData->last_name); ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">Mobile Number</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="mobileNumber" name="mobileNumber" class="form-control border-0 border-bottom p-2" placeholder="Mobile Number" value="<?php echo e($AgentData->mobile_number); ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">Email</label>
                                <div class="input-group mb-3">
                                    <input type="email" id="email" name="email" class="form-control border-0 border-bottom p-2" placeholder="Email" value="<?php echo e($AgentData->email); ?>" required disabled>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">Password</label>
                                <div class="input-group mb-3">
                                    <input class="form-control border-0 border-bottom p-2 " type="text" placeholder="Enter password" id="password" name="password" minlength="6" >
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="text-center pt-5">
                        <button type="submit" form="profileForm"
                                class="btn btn-secondary px-5 fw-bold text-capitalize">Submit
                        </button>
                    </div>
                </div>
                <!--Msg Box-->
                <div class="bgc mt-3 pt-5 pb-5" id="thankyou_box" style="display:none;">
<!--                    <div class="">
                        <div style="font-weight: 500; font-size: 23px;color: #0A0A0A; text-align: center;">
                            Incident Number <span
                                style="color: #2565ab; font-weight: bolder; font-size: 23px; text-align: center;"
                                id="incident_number_new"></span>
                        </div>
                    </div>-->
                    <div class="fw-bold text-center" style="font-size: 26px; color: #0A0A0A;">Profile Updated successfully!
                    </div>
                    <div class="text-center pt-5">
                        <a href="<?php echo e(route('employee.dashboard')); ?>"
                           class="btn btn-secondary px-5 fw-bold text-capitalize">Done</a>
                        
                    </div>
                </div>

                <!--End Msg Box-->
            </div>

        </div>
        <!-- Tabs content -->
    </div>


    <!-- footer -->
    <div class="pt-lg-12 pt-5 footer bg-white">
        <div class="container">
            <div class="row align-items-center g-0 border-top py-2 mt-6">
                <!-- Desc -->
                <div class="col-lg-12 col-12">
                    <div class="d-lg-flex justify-content-center align-items-center">
                        <img src="../assets/img/group.png">
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('pagescript'); ?>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.js">
    </script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js">
    </script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $("#profileForm").validate({
            errorPlacement: function (error, element) {
                if (element.attr("name") == "incident_agree") {
                    error.appendTo('.inciAgreeError');
                    return;
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: ".ignore",
            rules: {
                firstName: "required",
                lastName: "required",
                mobileNUmber: "required",
                email: "required",
            },
            messages: {

            },
            submitHandler: function (form) {
                //currency validation
                $('.type_error').remove();

                $('body #loading_divs').addClass("loading");
                //get current time
                var currentTime = new Date().getHours();
                var doc_type = $('#documentStatus option:selected').val();

                // if (currentTime >= 10 && currentTime <= 16 && doc_type == 0) {
                setTimeout(() => {
                    $.ajax({
                        url: "<?php echo e(url('update-password')); ?>",
                        type: 'POST',
                        async: false,
                        data: new FormData(document.getElementById('profileForm')),
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        success: function (response) {
                            if(response.success=='True') {
                                //alert("True");
                                $('body #loading_divs').removeClass("loading");
                                $('#thankyou_box').show();
                                $('#main_frm').hide();
                                $('#loading_divs').css("display", "none");
                                $('#loading_divs').removeClass("loading");
                            }
                            else{
                                //alert(response.errMessage);
                                $('body #loading_divs').removeClass("loading");
                                $('#loading_divs').css("display", "none");
                                //alert("Flase");

                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Sorry!',
                                    text: response.errMessage,
                                    footer: ''
                                });
                                return false;
                            }
                        },
                    });
                }, 200);

            }
        });

    </script>

    <script type="text/javascript">
        setInterval("my_function();", 60000);

        function my_function() {
            console.log("refresh");
            $('#refresh').load(location.href + ' #time');
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.agent.appmain', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/agent/profile.blade.php ENDPATH**/ ?>