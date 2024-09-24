<?php $__env->startSection('content'); ?>
<!-- togoole button -->
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<!-- end toggel  -->

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

        .custom_export .dt-buttons {
            position: absolute !important;
            left: 16%;
            top: -1%;
        }

        .custom_export .dt-buttons button {
            background: #2565ab;
            padding: 2px 15px;
            color: #fff !important;
            border: 1px solid #2565ab;
        }

        .custom_export .dt-buttons button:hover {
            background: #2565ab !important;

        }
    </style>
    <?php echo csrf_field(); ?>
    <div class="" id="loading_div" style="display:none;">Loading&#8230;</div>
    <nav class="navbar navbar-expand-lg navbar-default rounded-top rounded-4 ">
        <div class="container-fluid px-0">
            <div class="d-flex">
                <!-- <a class="navbar-brand" href="index.html"><img src="../assets/img/logo2.png" class="img-fluid"
                        alt="Responsive image" /></a> -->
            <a class="navbar-brand" href="<?php echo e(url('/tcuser/dashboard')); ?>"><img src="../assets/images/LOGO.png" class="img-fluid"
            alt="Responsive image" /></a>
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
                        <img src="../tcuser-assets/svg/2.svg">
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
                        <a href="mailto:tcsales@thomascook.in" class="text-dark">tcsales@thomascook.in</a>
                    </div>
                </ul>
                <div class="ms-auto mt-3 mt-lg-0 text-center">
		    <label class="fw-bold" style="margin-right: 15px; font-size:15px;"><?php echo e($username); ?></label>
                    <a href="#"><i class="fe fe-shopping-cart fs-3 align-middle"></i>
                    </a>
                 
		
                    <input type="hidden" name="userid" id="userid" value="<?php echo e($userid); ?>">
                <input type="hidden" name="userid" id="userid" value="<?php echo e($login_status); ?>">

                <label class="switch" id="online_status">
                    <!-- <input type="checkbox"  checked> -->
                    <input class="form-check-input login_status" type="checkbox"
                                                                data-id="<?php echo e($userid); ?>"
                                                                value="on"
                                                                <?php echo e($login_status == 1 ? 'checked' : ''); ?>>
                    <span class="slider round"></span>
                
                </label>

                    <a href="<?php echo e(Route('tcuser.logout')); ?>"
                        class="btn btn-dark btn-sm ms-3 rounded-0 text-capitalize">&nbsp;&nbsp;&nbsp;Logout&nbsp;&nbsp;&nbsp;</a>
                    
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
		$current_date = date('Y-m-d');
                $currentHoliday = DB::table('holidays')->where('holiday_date',$current_date)->first();
                ?>

                <?php $__currentLoopData = $currencydata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $rate_margin = $value->rate_margin;
                    if (is_object($rate_margin)) {
                        switch ($current_time) {
                            case $current_time >= strtotime('10:00 am') && $current_time < strtotime('12:00 pm'):
                                $ratemargin = $rate_margin->sell_margin_10_12;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $ratemargin;
                                break;
                            case $current_time >= strtotime('12:00 pm') && $current_time < strtotime('02:00 pm'):
                                $ratemargin = $rate_margin->sell_margin_12_2;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $ratemargin;
                                break;
                            case $current_time >= strtotime('02:00 pm') && $current_time < strtotime('03:30 pm'):
                                $ratemargin = $rate_margin->sell_margin_2_3_30;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $ratemargin;
                                break;
                            case $current_time >= strtotime('03:30 pm'):
                                $ratemargin = $rate_margin->sell_margin_3_30_end;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $ratemargin;
                                break;
                            default:
                                $ratemargin = $rate_margin->sell_margin;
                                $final_margin = ($ratemargin * $value->cur_sell) / 100;
                                $final_rate = $value->cur_sell + $ratemargin;
                                break;
                        }
                    }else{
                        
                        $ratemargin = $rate_margin->holiday_margin;
                        $final_margin =   ($ratemargin * $value->cur_sell ) /100;
                        $final_rate = $value->cur_sell + $final_margin;
                    }



                    if($value->currency_name_key!='AED')
                    {
                        $buy_rate=$value->cur_bye-($rate_margin->buy_fix_margin + $rate_margin->buy_margin);
                    }
                    else{
                        $buy_rate=$value->cur_bye-($rate_margin->buy_fix_margin + $rate_margin->buy_margin);
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
                                <div class="row-font border-0 border-bottom"><?php if($value->currency_name_key=='JPY'): ?> <?php echo e(number_format((float) $buy_rate, 4, '.', '')); ?> <?php else: ?> <?php echo e(number_format((float) $buy_rate, 2, '.', '')); ?> <?php endif; ?></div>
                                <div class="row-font1"><?php if($value->currency_name_key=='JPY'): ?> <?php echo e(number_format((float) $final_rate, 4, '.', '')); ?> <?php else: ?> <?php echo e(number_format((float) $final_rate, 2, '.', '')); ?>  <?php endif; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Tabs navs -->
        <?php
            if ($userid != env('TC_USER_ID')) {
                $tab1_heading = 'Allocated Booking Request';
                $tab2_heading = 'View All Request';
            } else {
                $tab1_heading = 'Request for Mudra Post';
                $tab2_heading = 'View all request';
            }
        ?>
        <ul class="nav nav-tabs nav-justified  mt-4" id="ex1" role="tablist">
            <li class="nav-item tab1" role="presentation">
                <a class="nav-link fw-bold text-light mt-3 ms-3 me-3 active ex3-tab-1" id="ex3-tab-1" data-mdb-toggle="tab"
                    href="#ex3-tabs-1" role="tab" aria-controls="ex3-tabs-1" aria-selected="true"><i
                        class="fa-regular fa-eye"></i></i>
                    <span>&nbsp;<?php echo e($tab1_heading); ?></span></a>
            </li>
            <li class="nav-item tab2" role="presentation">
                <a class="nav-link fw-bold text-light mt-3 ms-3 me-3 ex3-tab-2" id="ex3-tab-2"data-mdb-toggle="tab"
                    href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2"aria-selected="false"><i
                        class="fa-solid fa-arrows-rotate"></i>
                    <span>&nbsp;<?php echo e($tab2_heading); ?></span></a>
            </li>
            
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->

        <div class="tab-content" id="ex3-content">
            
            <div class="tab-pane fade show active bg-white" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1">
                <div class="d-flex justify-content bg-white">
                    <div class="border-1"></div>
                    <div class="ps-1">Incident </div>
                    <div class="ps-1 fw-bold"> Request </div>
                </div>
                <div class="table-responsive table-striped pt-4 pb-3 ps-0 pe-0 mb-3 bg-white">
                    <table id="data-datatable" class="table roundedTable" style="width:100%">
                        <thead style="backgrounD-color: #F4F6F8;">
                            <tr>
                                <th style="color: #2565ab; font-weight: 800;">Sr.No</th>
                                <th style="color: #2565ab; font-weight: 800;">Incident Number</th>
                                <th style="color: #2565ab; font-weight: 800;">Agent Code</th>
                                <th style="color: #2565ab; font-weight: 800;">Block Request Date</th>
                                <th style="color: #2565ab; font-weight: 800;">Block Request time</th>
                                <th style="color: #2565ab; font-weight: 800;">FX Currency</th>
                                <th style="color: #2565ab; font-weight: 800;">Fx Value</th>
                                <th style="color: #2565ab; font-weight: 800;">Fx Rate</th>
                                <th style="color: #2565ab; font-weight: 800;">INR Value</th>
				<th style="color: #2565ab; font-weight: 800;">Card Number</th>
				<th style="color: #2565ab; font-weight: 800;">Passport Number</th>
                                
                                    <th style="color: #2565ab; font-weight: 800;">Mudra Posting</th>
                                
                            </tr>
                        </thead>
                        
                    </table>
                </div>
                
            </div>
            
            
            <div class="tab-pane fade bg-light" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                <div class="d-flex justify-content bg-white">
                    <div class="border-1"></div>
                    <div class="ps-1"> View All </div>
                    <div class="ps-1 fw-bold"> Request </div>
                </div>
                <div class="table-responsive table-striped pt-4 pb-3 ps-0 pe-0 mb-3 bg-white custom_export">
                    <table id="allReqTbl" class="table roundedTable table w-100 nowrap ">
                        <thead style="backgrounD-color: #F4F6F8;">
                            <tr>
                                <th style="color: #2565ab; font-weight: 800;">Sr.No</th>
                                <th style="color: #2565ab; font-weight: 800;">Incident Number</th>
                                <th style="color: #2565ab; font-weight: 800;">Agent Code</th>
				<th style="color: #2565ab; font-weight: 800;">Card Number</th>
                                <th style="color: #2565ab; font-weight: 800;">Passport Number</th>
				<th style="color: #2565ab; font-weight: 800;">FX Currency</th>
				<th style="color: #2565ab; font-weight: 800;">Fx Value</th>
                                <th style="color: #2565ab; font-weight: 800;">Fx Rate</th>
                                <th style="color: #2565ab; font-weight: 800;">INR Value</th>
                                <th style="color: #2565ab; font-weight: 800;">Incident Doc Status</th>
                                <th style="color: #2565ab; font-weight: 800;">Doc Upload Date</th>
                                <th style="color: #2565ab; font-weight: 800;">Doc Upload Time</th>
                                <th style="color: #2565ab; font-weight: 800;">Incident Allocated to</th>
                                <th style="color: #2565ab; font-weight: 800;">Incident Status</th>
				<?php if($userid != env('TC_USER_ID')): ?>
                                    <th style="color: #2565ab; font-weight: 800;">Passport Number</th>
                                    <th style="color: #2565ab; font-weight: 800;">Transaction Type</th>
                                    <th style="color: #2565ab; font-weight: 800;">Block Request Date</th>
                                    <th style="color: #2565ab; font-weight: 800;">Block Request time</th>
                                    <th style="color: #2565ab; font-weight: 800;">With Documents?</th>
                                    <th style="color: #2565ab; font-weight: 800;">Bordox Number</th>
                                    <th style="color: #2565ab; font-weight: 800;">Cashier</th>
                                    <th style="color: #2565ab; font-weight: 800;">Request Date</th>
                                    <th style="color: #2565ab; font-weight: 800;">Request Time</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count = 1;
                            ?>
                            <?php if($IncidentSellRequest): ?>
                                <?php $__currentLoopData = $IncidentSellRequest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inci_all_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php
                                        $ic_currency_type = '';
                                        $ic_frgn_curr_amount = '';
                                        $ic_inr_amount = '';
                                        $ic_currency_rate = '';
                                    ?>
                                    <?php $__currentLoopData = $inci_all_request->incidentCurrency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inci_currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $ic_currency_type .= $inci_currency->inci_currency_type . '<br>';
                                            $ic_frgn_curr_amount .= $inci_currency->inci_frgn_curr_amount . '<br>';
                                            $ic_inr_amount .= $inci_currency->inci_inr_amount . '<br>';
                                            $ic_currency_rate .= $inci_currency->inci_currency_rate . '<br>';
                                        ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    

                                    
                                    <?php
                                        $upload_doc_date = '';
                                        $upload_doc_time = '';
                                    ?>
                                    <?php $__currentLoopData = $inci_all_request->sellDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sell_doc_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            if ($sell_doc_data->created_at) {
                                                $upload_doc_date .= date('Y-m-d', strtotime($sell_doc_data->created_at));
                                                $upload_doc_time .= date('H:i:s', strtotime($sell_doc_data->created_at));
                                            }
                                        ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php
                                        if ($inci_all_request->inci_create_time) {
                                            $request_date = explode(' ', $inci_all_request->inci_create_time);
                                        }
                                        
                                        $transaction_type = '';
                                        if ($inci_all_request->transaction_type == 1) {
                                            $transaction_type = 'Activation';
                                        } elseif ($inci_all_request->transaction_type == 2) {
                                            $transaction_type = 'Reload';
                                        } elseif ($inci_all_request->transaction_type == 3) {
                                            $transaction_type = 'Activation + Reload';
                                        } elseif ($inci_all_request->transaction_type == 4) {
                                            $transaction_type = 'Encashment';
                                        }
                                        
                                        $document = '';
                                        if ($inci_all_request->doc_type == 0) {
                                            $document = 'No';
                                            $doc_status = 'Without Document';
                                        } else {
                                            $document = 'Yes';
                                            $doc_status = 'With Document';
                                        }
                                        
                                        // Incident Status
                                        $assign_status = '';
                                        $color = '';
                                        $badge_color = '';
                                        
                                        if ($inci_all_request->inci_status == '3') {
                                            $assign_status = 'Under Process';
                                            $color = '#FF9E2E';
                                            $badge_color = 'badge-warning';
                                        } elseif ($inci_all_request->inci_status == '2') {
                                            $assign_status = 'Expired';
                                            $color = '#2999bd';
                                            $badge_color = 'badge-info';
                                        } elseif ($inci_all_request->inci_status == '1') {
                                            $assign_status = 'Accepted';
                                            $color = '#0F9500';
                                            $badge_color = 'badge-success';
                                        } elseif ($inci_all_request->inci_status == '0') {
                                            $assign_status = 'Rejected';
                                            $color = '#EC0000';
                                            $badge_color = 'badge-danger';
                                        }
                                        
                                        //bg color for with doc listing
                                        $row_bgcolor = '';
                                        if ($inci_all_request->doc_type == 1) {
                                            $row_bgcolor = 'table-success';
                                        }
                                    ?>
					
                                    <tr class="<?php echo e($row_bgcolor); ?>">
                                        <td><?php echo e($count++); ?></td>
                                        <td>
						
                                            <a type="button" class="svg-bg m-0 fw-bold viewDoc" style=" color:#00B7FF;"
                                                data-id="<?php echo e($inci_all_request->inci_number); ?>">
                                                <i class="fa-solid fa-eye"></i>
                                                <?php echo e($inci_all_request->inci_number); ?> </a>
                                        </td>
					
						
                                        <td> <?php if(isset($inci_all_request->agent) &&  $inci_all_request->agent->agent_code!="" ): ?><?php echo e($inci_all_request->agent->agent_code); ?> <?php endif; ?></td>
					<td><?php echo e($inci_all_request->inci_forex_card_no); ?></td>
					<td><?php echo e($inci_all_request->inci_passport_number); ?></td>
					<td><b><?= $ic_currency_type ?></b></td>
                                        <td><b><?= $ic_frgn_curr_amount ?></b></td>
                                        <td><b><?= $ic_currency_rate ?></b></td>
                                        <td><b><?= $ic_inr_amount ?></b></td>
                                        <td><?php echo e($doc_status); ?></td>
                                        <td><?= $upload_doc_date ?></td>
                                        <td><?= $upload_doc_time ?></td>
					
                                        <td> <?php echo e(isset($inci_all_request->incidentAssign) ? $inci_all_request->incidentAssign->name : ''); ?>

                                        </td>
                                        <td>
                                            <li class="list-group-item d-flex align-items-center"> <span
                                                    class="badge <?php echo e($badge_color); ?> badge-pill me-3"><i
                                                        class="fa-solid fa-circle"
                                                        style=" color: <?php echo e($color); ?>; font-size: 9px; margin: -2px;"></i></span>
                                                <span style="color:<?php echo e($color); ?>; font-weight:700; ">
                                                    <?php echo e($assign_status); ?> </span>
                                            </li>
                                        </td>
					<?php if($userid != env('TC_USER_ID')): ?>
					
                                            <td></td>
                                            <td><?php echo e($transaction_type); ?></td>
                                            <td><?php echo e($request_date[0]); ?></td>
                                            <td><?php echo e($request_date[1]); ?></td>
                                            <td><?php echo e($document); ?></td>
						
                                            <td><?php echo e(isset($inci_all_request->bordox_no) ? $inci_all_request->bordox_no : ''); ?>

                                            </td>
                                            <td><?php echo e('Admin'); ?></td>
                                            <td><?php echo e($request_date[0]); ?></td>
                                            <td><?php echo e($request_date[1]); ?></td>
                                        <?php endif; ?>
					
                                       
					</tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
		
            
            <!-- End Tabs content -->
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

        
        <div class="modal fade" id="viewDocModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="background: rgba(6,39,75,0.5);">
            <div class="modal-dialog  modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel" style="color: #2565ab;">Document Detail
                        </h5>
                        <div type="button" class="btn-close docBtnClose" data-bs-dismiss="modal" aria-label="Close">
                        </div>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
        
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('pagescript'); ?>
	<?php echo $__env->make('stacks.js.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('stacks.js.tcuser-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.viewDoc', function() {

                    var id = $(this).data('id');
                    $.ajax({
                        type: "GET",
                        url: '<?php echo e(route('tcuser.view-document')); ?>',
                        data: {
                            id: id,
                        },
                        success: function(result) {
                            $(".modal-body").html(result)
                            $("#viewDocModal").modal("show");
                        }
                    });
                });
            });

            $(document).on('click', '.docBtnClose', function() {
                $(".modal-body").html('')
                $("#viewDocModal").modal("hide");
            });

            //mudra posting status
            //$(document).ready(function() {
                //$('.mudraposting').click(function() {
		$(document).on('click', '.mudraposting', function() {

		    //console.log("hii");
                    var inci_id = $(this).data('id');
                    var mudraposting = $(this).val();
                    if (mudraposting == 0) {
                        mudraposting = 1
                    } else {
                        mudraposting = 0
                    }
                    $.ajax({
                        type: "POST",
                        url: '<?php echo e(route('tcuser.mudra-posting-status')); ?>',
                        data: {
                            inci_id: inci_id,
                            mudraposting: mudraposting
                        },
                        success: function(result) {
				console.log(result);
                            if (result) {
                                toastr.success('Status updated successfully!');
                                //window.location.reload();
				$('#data-datatable').DataTable().ajax.reload();
                            }
                        }
                    });
                });
            //});


// Update  user login status
    $(document).on('change', '.login_status', function() {
      
      // var login_status = $(this).val();
      var userid = $("#userid").val();
       this.value = this.checked ? 1 : 0;
      //   alert(this.value);
       console.log(this.value);
      $.ajax({
          url: "<?php echo e(route('tcuser.online-status')); ?>",
          type: 'POST',
          data: {
             'userid':userid,
             'login_status':this.value
          },
      });
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

<?php echo $__env->make('layouts.tcuser.appmain', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/tcuser-dashboard.blade.php ENDPATH**/ ?>