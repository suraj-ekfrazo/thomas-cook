<?php $__env->startSection('content'); ?>
<!-- togoole button -->
    <?php echo csrf_field(); ?>
      <?php   $count = 1; ?>
    <div class="" id="loading_div" style="display:none;">Loading&#8230;</div>


    <nav class="navbar navbar-expand-lg navbar-default rounded-top rounded-4 ">
        <div class="container-fluid px-0">
            <div class="d-flex">
                <a class="navbar-brand" href="<?php echo e(route('tcuser.dashboard')); ?>"><img src="../assets/images/LOGO.png" class="img-fluid"
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
                  <input type="hidden" name="userid" id="userid" value="<?php echo e($userid); ?>">
                    <input type="hidden" name="userid" id="userid" value="<?php echo e($login_status); ?>">
                    <div class="ms-auto mt-3 mt-lg-0 text-center">

                    <label class="fw-bold" style="margin-right: 15px; font-size:15px;"><?php echo e($username); ?></label>

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
                    }
                    if($value->currency_name_key!='AED')
                    {
                        //$buy_rate=$value->cur_bye-0.10;
			$buy_rate=$value->cur_bye-($rate_margin->buy_fix_margin + $rate_margin->buy_margin);
                    }
                    else{
                        //$buy_rate=$value->cur_bye-0.13;
			$buy_rate=$value->cur_bye-($rate_margin->buy_fix_margin + $rate_margin->buy_margin);
                    }
			//echo $final_rate;
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


    <div style="background-color: #F4F6F8;">
        <div class="container">
            <!-- Tabs content -->
            <div class="d-flex justify-content bg-white mt-4 mb-2">
                <div class="border-1"></div>
                <div class="ps-1">Automation </div>
                <div class="ps-1 fw-bold"> Scorecard & Documents </div>
            </div>

            <?php if($bookingDetail && ($bookingDetail->doc_type == 1 )): ?>
		<?php if($bookingDetail): ?>
		<div class="bgc">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Incident Number</label>
                            <div class="input-group mb-3">
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    placeholder="Enter Incident Number" readonly
                                    value="<?php echo e($bookingDetail->inci_number ? $bookingDetail->inci_number : ''); ?>">
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Card Number</label>
                            <div class="input-group mb-3">
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    placeholder="Enter Card Number" readonly
                                    value="<?php echo e($bookingDetail->inci_forex_card_no ? $bookingDetail->inci_forex_card_no : ''); ?>">
                            </div>
                        </div>
			<div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Agent BPC ID</label>
                            <div class="input-group mb-3">
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                        readonly
                                       value="<?php echo e($bookingDetail['agentDetail'] ? $bookingDetail['agentDetail']['agent_code'] : ''); ?>">
                            </div>
                        </div>

                        
                        <div class="col-lg-4 col-sm-4 mt-3 ">
                            <label class="">Transaction Type</label>
                            <div class="input-group mb-3">

                                <?php
                                    $transaction_type = '';
                                    if ($bookingDetail->transaction_type == 1) {
                                        $transaction_type = 'Activation';
                                    } elseif ($bookingDetail->transaction_type == 2) {
                                        $transaction_type = 'Reload';
                                    } elseif ($bookingDetail->transaction_type == 3) {
                                        $transaction_type = 'Activation + Reload';
                                    } elseif ($bookingDetail->transaction_type == 4) {
                                        $transaction_type = 'Encashment';
                                    }

                                ?>
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    readonly value="<?php echo e($transaction_type); ?>">
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Buy/Sell</label>
                            <div class="input-group mb-3">
                                <?php
                                    $document = '';
                                    if ($bookingDetail->inci_buy_sell_req == 0) {
                                        $document = 'Buy';
                                    } else {
                                        $document = 'Sell';
                                    }
                                ?>
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    readonly value="<?php echo e($document); ?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Travel Type</label>
                            <div class="input-group mb-3">
                                <?php
                                    $traveltype = '';
                                    if ($bookingDetail->travel_type == 1) {
                                        $traveltype = 'BTQ';
                                    } elseif ($bookingDetail->travel_type == 2) {
                                        $traveltype = 'BT';
                                    } elseif ($bookingDetail->travel_type == 3) {
                                        $traveltype = 'Employment';
                                    } elseif ($bookingDetail->travel_type == 4) {
                                        $traveltype = 'Student';
                                    } elseif ($bookingDetail->travel_type == 5) {
                                        $traveltype = 'Immigration';
                                    } elseif ($bookingDetail->travel_type == 6) {
                                        $traveltype = 'Medical';
                                    }

                                    $departure_date = '';
                                    if (!empty($bookingDetail->inci_departure_date) && $bookingDetail->inci_departure_date != '0000-00-00'):
                                        $departure_date = date('d-m-Y', strtotime($bookingDetail->inci_departure_date));
                                    endif;
                                ?>
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    readonly value="<?php echo e($traveltype); ?>">
                            </div>
                        </div>
                        <?php if ($bookingDetail->inci_buy_sell_req == 1){ ?>
                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Date of Departure</label>
                            <div class="input-group mb-3">

                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    readonly value="<?php echo e($departure_date); ?>">
                            </div>
                        </div>
                        <?php } ?>

			<div class="col-lg-12 col-sm-12 mt-3">
                            <label class="">Document Comment</label>
                            <div class="input-group mb-3">

                                <textarea class="form-control border-0 border-bottom p-2 bg-transparent" name="upload_doc_comment" id="upload_doc_comment"
                                          readonly ><?php echo e($bookingDetail->upload_doc_comment); ?></textarea>
                            </div>
                        </div>
			<div class="col-lg-12 col-sm-12 mt-3">
                            <label class="">Agent Comment</label>
                            <div class="input-group mb-3">

                                <textarea class="form-control border-0 border-bottom p-2 bg-transparent" name="incident_comment" id="incident_comment"
                                          readonly ><?php echo e($bookingDetail->comment); ?></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <?php if($InciCurrency): ?>
                    <div class="table-responsive bgc mt-3">
                        <table class="table border-none">
                            <thead class="rounded-5" style="background-color:#2565ab;">
                                <tr class="text-light">
                                    <th scope="col" style="border-radius: 10px 0px 0px 10px ;">Currency</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col" style="border-radius:0px 10px 10px 0px  ;">Calculate</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold ">
                                <?php if($InciCurrency): ?>
                                    <?php
                                        $total_amount = 0;
                                    ?>
                                    <?php $__currentLoopData = $InciCurrency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curreny_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $total_amount += $curreny_val->iia;
                                        ?>
                                        <tr>
                                            <td scope="row" style="background-color: #DDE4ED; border-radius: 10px;  ">
                                                <?php echo e(isset($curreny_val->icy) ? $curreny_val->icy : ''); ?>

                                            </td>
                                            <td style="background-color: #DDE4ED; border-radius: 10px; ">
                                                <?php echo e(isset($curreny_val->ifca) ? $curreny_val->ifca : ''); ?>

                                            </td>
                                            <td style="background-color: #DDE4ED; border-radius: 10px;   ">
                                                <?php echo e(isset($curreny_val->icr) ? $curreny_val->icr : ''); ?>

                                            </td>
                                            <td style="background-color: #DDE4ED; border-radius: 10px;   ">
                                                <?php echo e(isset($curreny_val->iia) ? $curreny_val->iia : ''); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> </th>
                                    <th> </th>
                                    <th
                                        style="background-color:
                                    #F3D9B9; border-radius: 10px; font-weight: 900; color: black; ">
                                        Total</th>
                                    <th
                                        style="background-color: #F3D9B9; border-radius: 10px;  font-weight: 900; color: black;">
                                        <?php echo e(number_format($total_amount, 2)); ?>

                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>


                <div class="d-flex mt-3 mb-3">
                    <div class="border-1"></div>
                    <div class="ps-1 "> Block </div>
                    <div class="ps-1 fw-bold">Rate</div>
                    
                </div>

                <?php

                    $count = 0;
                ?>

                

                <?php  //echo json_encode($bookingDetail); exit;?>
                <form action="" novalidate="novalidate" id="updateDocForm">

                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="inci_number" value="<?php echo e($bookingDetail->inci_number); ?>">

                    <input type="hidden" name="id" value="<?php echo e($bookingDetail->doc_temp_type==1 ? $bookingDetail->incedent_doc->id : ''); ?>">

                    <input type="hidden" name="inci_type" id="inci_type" value="<?php echo e($bookingDetail->inci_buy_sell_req); ?>">
                    <div class="table-responsive-sm table-striped pb-3 ps-0 pe-0 mb-3  ">

                        <table id="example1" class="table roundedTable" style="width:100%">
                            <thead style="backgrounD-color: #F4F6F8;">
                                <tr>
                                    <th style="color: #2565ab; font-weight: 800;"><input type="checkbox" id="checkAll"></th>
                                    <th style="color: #2565ab; font-weight: 800;">Document</th>
                                    <th style="color: #2565ab; font-weight: 800;">Requirement</th>
                                    <th style="color: #2565ab; font-weight: 800;">Uploaded File</th>
                                    
                                    
                                    <th style="color: #2565ab; font-weight: 800;"> Comment</th>
                                    

                                </tr>
                            </thead>

                              <tbody>

                                
                                <tr>
                                    <?php $count++; ?>
                                    <td>
                                    	<input type="checkbox" class="checkoc_check" name="chk_annexure" id="chk_annexure" <?php if($bookingDetail->incedent_doc->annex_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                    	<input type="hidden" value="1" name="annexure_file" id="annexure_file">
                                    </td>
                                    <td>Annexure</td>
                                    <td>Mandatory</td>
                                    <td>
                                        <?php
                                            $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->annex);
                                        ?>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                            target="_blank"><i class="fa-solid fa-eye"></i> View &nbsp;</a>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;"
                                            download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                    </td>
                                    

                                    <?php if(isset($bookingDetail->incedent_doc->annex_status)): ?>
                                        <?php if($bookingDetail->incedent_doc->annex_status == 4 || $bookingDetail->incedent_doc->annex_status == 1): ?>
                                            
                                            <td>
                                                <textarea name="annex_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->annex_comment ? $bookingDetail->incedent_doc->annex_comment : ''); ?></textarea>
                                            </td>
                                            <td>
                                                
                                                
                                            </td>
                                        <?php else: ?>
                                            
                                            <td>
                                                <textarea name="annex_comment" class="form-control comment <?php if ($errors->has('annex_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('annex_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->annex_comment ? $bookingDetail->incedent_doc->annex_comment : ''); ?> </textarea>
                                                <?php if ($errors->has('annex_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('annex_comment'); ?>
                                                    <div class="text-danger"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                            </td>
                                            <td>
                                                

                                                
                                            </td>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                </tr>

                                
                                <?php if($bookingDetail->inci_buy_sell_req==1): ?>
                                <tr>
                                    <?php $count++; ?>
                                    <td>
                                        <input class="checkoc_check" type="checkbox" name="chk_application" id="chk_application" <?php if($bookingDetail->incedent_doc->apply_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                        <input type="hidden" value="1" name="application_file" id="application_file">
                                    </td>
                                    <td>Application</td>
                                    <td>Mandatory</td>
                                    <td>
                                        <?php
                                            $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->apply);
                                        ?>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                            style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i> View
                                            &nbsp;</a>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                            style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i>
                                            Download </a>
                                    </td>
                                    

                                    <?php if(isset($bookingDetail->incedent_doc->apply_status)): ?>
                                        <?php if($bookingDetail->incedent_doc->apply_status == 4 || $bookingDetail->incedent_doc->apply_status == 1): ?>
                                            
                                            <td>
                                                <textarea name="application_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->apply_comment ? $bookingDetail->incedent_doc->apply_comment : ''); ?></textarea>
                                            </td>
                                            <td>
                                                

                                                
                                            </td>
                                        <?php else: ?>
                                            
                                            <td>
                                                <textarea name="application_comment" class="form-control comment <?php if ($errors->has('application_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('application_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->apply_comment ? $bookingDetail->incedent_doc->apply_comment : ''); ?></textarea>
                                                <?php if ($errors->has('application_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('application_comment'); ?>
                                                    <div class="text-danger"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                            </td>
                                            <td>
                                                
                                                
                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </tr>
                                <?php endif; ?>

                                
                                <?php if($bookingDetail->inci_buy_sell_req==1): ?>
                                <tr>
                                    <?php $count++; ?>
                                    <td>
                                        <input class="checkoc_check" type="checkbox" name="chk_pan_card" id="chk_pan_card" <?php if($bookingDetail->incedent_doc->pan_card_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                        <input type="hidden" value="1" name="pan_card_file" id="pan_card_file">
                                    </td>
                                    <td>Pan</td>
                                    <td>Mandatory</td>
                                    <td>
                                        <?php
                                            $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->pan_card);
                                        ?>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                            target="_blank"><i class="fa-solid fa-eye"></i> View &nbsp;</a>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;"
                                            download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                    </td>
                                    
                                    <?php if(isset($bookingDetail->incedent_doc->pan_card_status)): ?>
                                        <?php if($bookingDetail->incedent_doc->pan_card_status == 4 || $bookingDetail->incedent_doc->pan_card_status == 1): ?>
                                            
                                            <td>
                                                <textarea name="pan_card_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->pan_card_comment ? $bookingDetail->incedent_doc->pan_card_comment : ''); ?></textarea>
                                            </td>
                                            <td>
                                                

                                                
                                            </td>
                                        <?php else: ?>
                                            
                                            <td>
                                                <textarea name="pan_card_comment" class="form-control comment <?php if ($errors->has('pan_card_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('pan_card_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->pan_card_comment ? $bookingDetail->incedent_doc->pan_card_comment : ''); ?></textarea>
                                                <?php if ($errors->has('pan_card_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('pan_card_comment'); ?>
                                                    <div class="text-danger"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                            </td>
                                            <td>
                                               
                                                

                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </tr>
                                <?php endif; ?>

                                
                                <?php if(($bookingDetail->travel_type == 2 || $bookingDetail->travel_type == 6) && $bookingDetail->inci_buy_sell_req==1): ?>
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_lerms_letter" id="chk_lerms_letter" <?php if($bookingDetail->incedent_doc->lerms_letter_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="lerms_letter_file" id="lerms_letter_file">
                                        </td>
                                        <td>Lerms Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->lerms_letter);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->lerms_letter_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->lerms_letter_status == 4 || $bookingDetail->incedent_doc->lerms_letter_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="lerms_letter_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->lerms_letter_comment ? $bookingDetail->incedent_doc->lerms_letter_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="lerms_letter_comment"
                                                        class="form-control comment <?php if ($errors->has('lerms_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('lerms_letter_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->lerms_letter_comment ? $bookingDetail->incedent_doc->lerms_letter_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('lerms_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('lerms_letter_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>


                                

                                <tr>
                                    <?php $count++; ?>
                                    <td>
                                        <input class="checkoc_check" type="checkbox" name="chk_passport" id="chk_passport" <?php if($bookingDetail->incedent_doc->passport_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                        <input type="hidden" value="1" name="passport_file" id="passport_file">
                                    </td>
                                    <td>Passport</td>
                                    <td>Mandatory</td>
                                    <td>
                                        <?php
                                            $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->passport);
                                        ?>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                            target="_blank"><i class="fa-solid fa-eye"></i> View &nbsp;</a>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;"
                                            download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                    </td>
                                    

                                    <?php if(isset($bookingDetail->incedent_doc->passport_status)): ?>
                                        <?php if($bookingDetail->incedent_doc->passport_status == 4 || $bookingDetail->incedent_doc->passport_status == 1): ?>
                                            
                                            <td>
                                                <textarea name="passport_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->passport_comment ? $bookingDetail->incedent_doc->passport_comment : ''); ?></textarea>
                                            </td>
                                            <td>
                                                

                                                
                                            </td>
                                        <?php else: ?>
                                            
                                            <td>
                                                <textarea name="passport_comment" class="form-control comment <?php if ($errors->has('passport_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('passport_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->passport_comment ? $bookingDetail->incedent_doc->passport_comment : ''); ?></textarea>
                                                <?php if ($errors->has('passport_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('passport_comment'); ?>
                                                    <div class="text-danger"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                            </td>
                                            <td>
                                                

                                                
                                            </td>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                </tr>


                                
                                <?php if(($bookingDetail->travel_type == 1 ||
                                    $bookingDetail->travel_type == 3 ||
                                    $bookingDetail->travel_type == 4 ||
                                    $bookingDetail->travel_type == 5) && ($bookingDetail->inci_buy_sell_req==1)): ?>
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_ticket" id="chk_ticket" <?php if($bookingDetail->incedent_doc->ticket_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="ticket_file" id="ticket_file">
                                        </td>
                                        <td>Ticket</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->ticket);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->ticket_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->ticket_status == 4 || $bookingDetail->incedent_doc->ticket_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="ticket_comment" class="form-control comment"><?php echo e($bookingDetail->incedent_doc->ticket_comment ? $bookingDetail->incedent_doc->ticket_comment : ''); ?></textarea>
                                                </td>
                                               
                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="ticket_comment" class="form-control comment <?php if ($errors->has('ticket_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('ticket_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->ticket_comment ? $bookingDetail->incedent_doc->ticket_comment : ''); ?></textarea>
                                                    <?php if ($errors->has('ticket_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('ticket_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>


                                <?php if(($bookingDetail->travel_type == 1 ||
                                    $bookingDetail->travel_type == 3 ||
                                    $bookingDetail->travel_type == 4 ||
                                    $bookingDetail->travel_type == 5) && ($bookingDetail->inci_buy_sell_req==1)): ?>
                                    
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_visa" id="chk_visa" <?php if($bookingDetail->incedent_doc->visa_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="visa_file" id="visa_file" >
                                        </td>
                                        <td>Visa</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->visa);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->visa_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->visa_status == 4 || $bookingDetail->incedent_doc->visa_status == 1): ?>
                                               
                                                <td>
                                                    <textarea name="visa_comment" class="form-control comment"><?php echo e($bookingDetail->incedent_doc->visa_comment ? $bookingDetail->incedent_doc->visa_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="visa_comment" class="form-control comment <?php if ($errors->has('visa_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('visa_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->visa_comment ? $bookingDetail->incedent_doc->visa_comment : ''); ?></textarea>
                                                    <?php if ($errors->has('visa_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('visa_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>

                                <?php if(($bookingDetail->travel_type == 1 ||
                                    $bookingDetail->travel_type == 3 ||
                                    $bookingDetail->travel_type == 4 ||
                                    $bookingDetail->travel_type == 5) && ($bookingDetail->inci_buy_sell_req==1)): ?>
                                    
                                    <tr>
                                        <?php $count++; ?>

					                    <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_sof" id="chk_sof" <?php if($bookingDetail->incedent_doc->sof_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="sof_file" id="sof_file">
                                        </td>
                                        <td>SOF</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->sof);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View
                                                &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i>
                                                Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->sof_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->sof_status == 4 || $bookingDetail->incedent_doc->sof_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="sof_comment" class="form-control comment"><?php echo e($bookingDetail->incedent_doc->sof_comment ? $bookingDetail->incedent_doc->sof_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="sof_comment" class="form-control comment  <?php if ($errors->has('sof_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('sof_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->sof_comment ? $bookingDetail->incedent_doc->sof_comment : ''); ?></textarea>
                                                    <?php if ($errors->has('sof_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('sof_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>



                                <?php if(($bookingDetail->travel_type == 1 || $bookingDetail->travel_type == 2 ) && $bookingDetail->incedent_doc->bank_transfer!=''): ?>
                                    
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_bank_transfer" id="chk_bank_transfer" <?php if($bookingDetail->incedent_doc->bank_transfer_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="bank_transfer_file" id="bank_transfer_file">
                                        </td>
                                        <td>Bank Transfer</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->bank_transfer);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View
                                                &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i>
                                                Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->bank_transfer_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->bank_transfer_status == 4 || $bookingDetail->incedent_doc->bank_transfer_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="bank_transfer_comment" class="form-control comment"><?php echo e($bookingDetail->incedent_doc->bank_transfer_comment ? $bookingDetail->incedent_doc->bank_transfer_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="bank_transfer_comment"
                                                        class="form-control comment <?php if ($errors->has('bank_transfer_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('bank_transfer_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->bank_transfer_comment ? $bookingDetail->incedent_doc->bank_transfer_comment : ''); ?></textarea>
                                                    <?php if ($errors->has('bank_transfer_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('bank_transfer_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>

                                
                                <?php if($bookingDetail->travel_type == 4 && $bookingDetail->inci_buy_sell_req==1): ?>
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_university_letter" id="chk_university_letter" <?php if($bookingDetail->incedent_doc->university_letter_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="university_letter_file" id="university_letter_file">
                                        </td>
                                        <td>University Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->university_letter);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->university_letter_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->university_letter_status == 4 || $bookingDetail->incedent_doc->university_letter_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="university_letter_comment" class="form-control comment"><?php echo e($bookingDetail->incedent_doc->university_letter_comment ? $bookingDetail->incedent_doc->university_letter_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="university_letter_comment"
                                                        class="form-control comment <?php if ($errors->has('university_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('university_letter_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->university_letter_comment ? $bookingDetail->incedent_doc->university_letter_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('university_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('university_letter_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>


                                
                                <?php if($bookingDetail->travel_type == 3 && $bookingDetail->inci_buy_sell_req==1): ?>
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_employment_letter" id="chk_employment_letter" <?php if($bookingDetail->incedent_doc->emp_letter_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="employment_letter_file" id="employment_letter_file">
                                        </td>
                                        <td>Employment Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->incident_number . '/' . $bookingDetail->incedent_doc->employment_letter);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->emp_letter_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->emp_letter_status == 4 || $bookingDetail->incedent_doc->emp_letter_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="emp_letter_comment" class="form-control comment"><?php echo e($bookingDetail->incedent_doc->emp_letter_comment ? $bookingDetail->incedent_doc->emp_letter_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="emp_letter_comment" class="form-control comment <?php if ($errors->has('emp_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('emp_letter_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->emp_letter_comment ? $bookingDetail->incedent_doc->emp_letter_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('emp_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('emp_letter_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>

                                    
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="chk_employment_declaration" id="chk_employment_declaration" <?php if($bookingDetail->incedent_doc->emp_declaration_form_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="employment_declaration_file" id="employment_declaration_file">
                                        </td>
                                        <td>Employment Declaration Form</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->emp_declaration_form);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->emp_declaration_form_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->emp_declaration_form_status == 4 ||
                                                $bookingDetail->incedent_doc->emp_declaration_form_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="emp_form_comment" class="form-control comment"><?php echo e($bookingDetail->incedent_doc->emp_declaration_form_comment ? $bookingDetail->incedent_doc->emp_declaration_form_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="emp_form_comment"
                                                        class="form-control comment <?php if ($errors->has('emp_declaration_form_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('emp_declaration_form_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->emp_declaration_form_comment ? $bookingDetail->incedent_doc->emp_declaration_form_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('emp_declaration_form_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('emp_declaration_form_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>


                                
                                <?php if($bookingDetail->travel_type == 5 && $bookingDetail->inci_buy_sell_req==1): ?>
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_immigration_declaration" id="chk_immigration_declaration" <?php if($bookingDetail->incedent_doc->immigration_d_form_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="immigration_declaration_file" id="immigration_declaration_file">
                                        </td>
                                        <td>Immigration Declaration Form</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->immigration_d_form);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->immigration_d_form_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->immigration_d_form_status == 4 || $bookingDetail->incedent_doc->immigration_d_form_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="immigration_d_form_comment" class="form-control comment"><?php echo e($bookingDetail->incedent_doc->immigration_d_form_comment ? $bookingDetail->incedent_doc->immigration_d_form_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="immigration_d_form_comment"
                                                        class="form-control comment <?php if ($errors->has('immigration_d_form_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('immigration_d_form_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->immigration_d_form_comment ? $bookingDetail->incedent_doc->immigration_d_form_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('immigration_d_form_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('immigration_d_form_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>

                                
                                <?php if($bookingDetail->travel_type == 6 && $bookingDetail->inci_buy_sell_req==1): ?>
                                    <tr>
                                        <?php $count++; ?>
					                    <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_medical_letter" id="chk_medical_letter" <?php if($bookingDetail->incedent_doc->medical_letter_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="medical_letter_file" id="medical_letter_file">
                                        </td>

                                        <td>Medical Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->medical_letter);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->medical_letter_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->medical_letter_status == 4 || $bookingDetail->incedent_doc->medical_letter_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="medical_letter_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->medical_letter_comment ? $bookingDetail->incedent_doc->medical_letter_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    

                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="medical_letter_comment"
                                                        class="form-control comment <?php if ($errors->has('medical_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('medical_letter_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->medical_letter_comment ? $bookingDetail->incedent_doc->medical_letter_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('medical_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('medical_letter_comment'); ?>
                                                        <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>

                                
                                <?php if($bookingDetail->inci_buy_sell_req==0): ?>
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check"  type="checkbox" name="chk_refund_form" id="chk_refund_form" <?php if($bookingDetail->incedent_doc->refound_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="refund_form_file" id="refund_form_file">
                                        </td>
                                        <td>Refund Form</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->refound);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                               style=" color:#686cad;" download>&nbsp;<i
                                                        class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->refound_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->refound_status == 4 || $bookingDetail->incedent_doc->refound_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="refund_letter_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->refound_comment ? $bookingDetail->incedent_doc->refound_comment : ''); ?></textarea>

                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="refund_letter_comment"
                                                              class="form-control comment <?php if ($errors->has('refund_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('refund_letter_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->refound_comment ? $bookingDetail->incedent_doc->refound_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('refund_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('refund_letter_comment'); ?>
                                                    <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>

                                
                                <?php if($bookingDetail->travel_type == 2 && $bookingDetail->inci_buy_sell_req==0): ?>
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_surrender_letter" id="chk_surrender_letter" <?php if($bookingDetail->incedent_doc->surrender_letter_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="surrender_letter_file" id="surrender_letter_file">
                                        </td>
                                        <td>Surrender Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->surrender_letter);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                               style=" color:#686cad;" download>&nbsp;<i
                                                        class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->surrender_letter_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->surrender_letter_status == 4 || $bookingDetail->incedent_doc->surrender_letter_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="surrender_letter_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->surrender_letter_comment ? $bookingDetail->incedent_doc->surrender_letter_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="surrender_letter_comment"
                                                              class="form-control comment <?php if ($errors->has('surrender_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('surrender_letter_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->surrender_letter_comment ? $bookingDetail->incedent_doc->surrender_letter_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('surrender_letter_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('surrender_letter_comment'); ?>
                                                    <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>


                                
				                <?php if($bookingDetail->incedent_doc->other !=""): ?>
                                <?php if($bookingDetail->travel_type !== 6 && $bookingDetail->inci_buy_sell_req== 1): ?>
                                    <tr>
                                        <?php $count++; ?>
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_other" id="chk_other" <?php if($bookingDetail->incedent_doc->other_status==4): ?> <?php echo e('checked'); ?> <?php endif; ?>>
                                            <input type="hidden" value="1" name="other_file" id="other_file">
                                        </td>
                                        <td>Other</td>
                                        <td>Mandatory</td>
                                        <td>
                                            <?php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->other);
                                            ?>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold"
                                               style=" color:#686cad;" download>&nbsp;<i
                                                        class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        

                                        <?php if(isset($bookingDetail->incedent_doc->other_status)): ?>
                                            <?php if($bookingDetail->incedent_doc->other_status == 4 || $bookingDetail->incedent_doc->other_status == 1): ?>
                                                
                                                <td>
                                                    <textarea name="other_comment" class="form-control comment" ><?php echo e($bookingDetail->incedent_doc->other_comment ? $bookingDetail->incedent_doc->other_comment : ''); ?></textarea>
                                                </td>
                                                <td>
                                                    
                                                    
                                                </td>
                                            <?php else: ?>
                                                
                                                <td>
                                                    <textarea name="other_comment"
                                                              class="form-control comment <?php if ($errors->has('other_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('other_comment'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"><?php echo e($bookingDetail->incedent_doc->other_comment ? $bookingDetail->incedent_doc->other_comment : ''); ?> </textarea>
                                                    <?php if ($errors->has('other_comment')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('other_comment'); ?>
                                                    <div class="text-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </td>
                                                <td>

                                                    

                                                    
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>
								<?php endif; ?>
                            </tbody>
                        </table>
                        


                        <div class="bgc mt-3">
                            <div class="row mt-3 ">
                                <div class="col-lg-4 col-sm-3 mt-3">
                                    <label class="">Bordeaux Number</label>
                                    <div class="input-group mb-3">
                                        <input id="bordox_no" disabled
                                            class="form-control border-0 border-bottom p-2 bg-transparent <?php if ($errors->has('bordox_no')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('bordox_no'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                                            type="text" name="bordox_no" placeholder="Enter Bordeaux Number"
                                            value="<?php echo e(!empty($bookingDetail->bordox_no) ? $bookingDetail->bordox_no : old('bordox_no')); ?>">
                                    </div>
                                    <?php if ($errors->has('bordox_no')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('bordox_no'); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>

                                </div>

                                <div class="col-lg-4 col-sm-3 mt-3">
                                    <label class="">Comment</label>
                                    <div class="input-group mb-3">
                                        <input
                                            class="form-control border-0 border-bottom p-2 bg-transparent  <?php if ($errors->has('inci_status_message')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('inci_status_message'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                                            type="text" name="inci_status_message" placeholder="Enter Comment"
                                            value="<?php echo e($bookingDetail->inci_comment); ?>">
                                    </div>
                                    <?php if ($errors->has('inci_status_message')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('inci_status_message'); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                </div>

                                <?php
                                    $doc_status_array = [];
                                    $approve_status = false;
                                    //Travel type BTQ
                                    if ($bookingDetail->travel_type == 1) {
                                        if ($bookingDetail->incedent_doc->passport_status == 4 && $bookingDetail->incedent_doc->visa_status == 4 && $bookingDetail->incedent_doc->pan_card_status == 4 && $bookingDetail->incedent_doc->ticket_status == 4 && $bookingDetail->incedent_doc->apply_status == 4 && $bookingDetail->incedent_doc->annex_status == 4 && $bookingDetail->incedent_doc->bank_transfer_status == 4 && $bookingDetail->incedent_doc->sof_status == 4 &&  $bookingDetail->incedent_doc->other_status == 4) {
                                            $approve_status = true;
                                        }
                                        $doc_status_array = [$bookingDetail->incedent_doc->passport_status, $bookingDetail->incedent_doc->visa_status, $bookingDetail->incedent_doc->pan_card_status, $bookingDetail->incedent_doc->ticket_status, $bookingDetail->incedent_doc->apply_status, $bookingDetail->incedent_doc->annex_status, $bookingDetail->incedent_doc->bank_transfer_status, $bookingDetail->incedent_doc->sof_status , $bookingDetail->incedent_doc->other_status];
                                    }
                                    //Travel Type BT
                                    if ($bookingDetail->travel_type == 2) {
                                        if ($bookingDetail->incedent_doc->passport_status == 4 && $bookingDetail->incedent_doc->pan_card_status == 4 && $bookingDetail->incedent_doc->apply_status == 4 && $bookingDetail->incedent_doc->annex_status == 4 && $bookingDetail->incedent_doc->lerms_letter_status == 4 &&  $bookingDetail->incedent_doc->other_status == 4 && $bookingDetail->incedent_doc->bank_transfer_status == 4 ) {
                                            $approve_status = true;
                                        }
                                        $doc_status_array = [$bookingDetail->incedent_doc->passport_status, $bookingDetail->incedent_doc->pan_card_status, $bookingDetail->incedent_doc->apply_status, $bookingDetail->incedent_doc->annex_status, $bookingDetail->incedent_doc->lerms_letter_status , $bookingDetail->incedent_doc->other_status, $bookingDetail->incedent_doc->bank_transfer_status];
                                    }

                                    //Travel type  student
                                    if ($bookingDetail->travel_type == 4) {
                                        if ($bookingDetail->incedent_doc->passport_status == 4 && $bookingDetail->incedent_doc->visa_status == 4 && $bookingDetail->incedent_doc->pan_card_status == 4 && $bookingDetail->incedent_doc->ticket_status == 4 && $bookingDetail->incedent_doc->apply_status == 4 && $bookingDetail->incedent_doc->annex_status == 4 && $bookingDetail->incedent_doc->sof_status == 4 && $bookingDetail->incedent_doc->university_letter_status == 4 &&  $bookingDetail->incedent_doc->other_status == 4) {
                                            $approve_status = true;
                                        }
                                        $doc_status_array = [$bookingDetail->incedent_doc->passport_status, $bookingDetail->incedent_doc->visa_status, $bookingDetail->incedent_doc->pan_card_status, $bookingDetail->incedent_doc->ticket_status, $bookingDetail->incedent_doc->apply_status, $bookingDetail->incedent_doc->annex_status, $bookingDetail->incedent_doc->sof_status, $bookingDetail->incedent_doc->university_letter_status , $bookingDetail->incedent_doc->other_status];
                                    }

                                    //Travel type  Employment
                                    if ($bookingDetail->travel_type == 3) {
                                        if ($bookingDetail->incedent_doc->passport_status == 4 && $bookingDetail->incedent_doc->visa_status == 4 && $bookingDetail->incedent_doc->pan_card_status == 4 && $bookingDetail->incedent_doc->ticket_status == 4 && $bookingDetail->incedent_doc->apply_status == 4 && $bookingDetail->incedent_doc->annex_status == 4 && $bookingDetail->incedent_doc->sof_status == 4 && $bookingDetail->incedent_doc->emp_letter_status == 4 && $bookingDetail->incedent_doc->emp_declaration_form_status == 4 &&  $bookingDetail->incedent_doc->other_status == 4) {
                                            $approve_status = true;
                                        }
                                        $doc_status_array = [$bookingDetail->incedent_doc->passport_status, $bookingDetail->incedent_doc->visa_status, $bookingDetail->incedent_doc->pan_card_status, $bookingDetail->incedent_doc->ticket_status, $bookingDetail->incedent_doc->apply_status, $bookingDetail->incedent_doc->annex_status, $bookingDetail->incedent_doc->sof_status, $bookingDetail->incedent_doc->emp_letter_status, $bookingDetail->incedent_doc->emp_declaration_form_status , $bookingDetail->incedent_doc->other_status];
                                    }

                                    //Travel type Immigration
                                    if ($bookingDetail->travel_type == 5) {
                                        if ($bookingDetail->incedent_doc->passport_status == 4 && $bookingDetail->incedent_doc->visa_status == 4 && $bookingDetail->incedent_doc->pan_card_status == 4 && $bookingDetail->incedent_doc->ticket_status == 4 && $bookingDetail->incedent_doc->apply_status == 4 && $bookingDetail->incedent_doc->annex_status == 4 && $bookingDetail->incedent_doc->sof_status == 4 && $bookingDetail->incedent_doc->immigration_d_form_status == 4 &&  $bookingDetail->incedent_doc->other_status == 4) {
                                            $approve_status = true;
                                        }
                                        $doc_status_array = [$bookingDetail->incedent_doc->passport_status, $bookingDetail->incedent_doc->visa_status, $bookingDetail->incedent_doc->pan_card_status, $bookingDetail->incedent_doc->ticket_status, $bookingDetail->incedent_doc->apply_status, $bookingDetail->incedent_doc->annex_status, $bookingDetail->incedent_doc->sof_status, $bookingDetail->incedent_doc->immigration_d_form_status , $bookingDetail->incedent_doc->other_status];
                                    }

                                    //Travel Type medical
                                    if ($bookingDetail->travel_type == 6) {
                                        if ($bookingDetail->incedent_doc->passport_status == 4 && $bookingDetail->incedent_doc->pan_card_status == 4 && $bookingDetail->incedent_doc->apply_status == 4 && $bookingDetail->incedent_doc->annex_status == 4 && $bookingDetail->incedent_doc->lerms_letter_status == 4 && $bookingDetail->incedent_doc->medical_letter_status == 4 &&  $bookingDetail->incedent_doc->other_status == 4) {
                                            $approve_status = true;
                                        }
                                        $doc_status_array = [$bookingDetail->incedent_doc->passport_status, $bookingDetail->incedent_doc->pan_card_status, $bookingDetail->incedent_doc->apply_status, $bookingDetail->incedent_doc->annex_status, $bookingDetail->incedent_doc->lerms_letter_status, $bookingDetail->incedent_doc->medical_letter_status , $bookingDetail->incedent_doc->other_status];
                                    }

                                ?>

                                <div class="col-lg-4 col-sm-3 mt-3">
                                    <label class="">Status</label>
                                    <div class="input-group my-2">
                                        <div class="col-sm-4">
                                            <label class="radio-inline">
                                                <!--<input type="radio" class="form-check-input" name="inci_status"
                                                    value="1"
                                                    <?php echo e($bookingDetail->inci_status == 1 ? 'checked' : ''); ?>

                                                     <?php if (in_array(2, $doc_status_array)) {
                                                        echo ' disabled';
                                                    }else if (in_array(3, $doc_status_array)) {
                                                        echo ' disabled';
                                                    }
                                                    else{
                                                        echo '';
                                                    } ?>>Approve-->
						                            <input type="radio" class="form-check-input" name="inci_status"
                                                    value="1"
                                                    <?php if($bookingDetail->inci_status==1 ): ?> <?php echo e('checked'); ?>

                                                    <?php elseif($bookingDetail->inci_status==0): ?>

                                                    <?php else: ?>
                                                        disabled
                                                    <?php endif; ?>
                                                    >Approve
                                            </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="radio-inline">
                                                <!--<input type="radio" class="form-check-input" name="inci_status"
                                                    value="0"
                                                    <?php echo e($bookingDetail->inci_status == 0 ? 'checked' : ''); ?><?php if ($approve_status) {
                                                        echo ' disabled';
                                                    }
												    else if (in_array(3, $doc_status_array)) {
                                                        echo ' disabled';
                                                    }
                                                    else{
                                                        echo '';
                                                    }?>>Reject-->
						                            <input type="radio" disabled class="form-check-input" name="inci_status"
                                                    value="0"

                                                    <?php if($bookingDetail->inci_status==0): ?> <?php echo e('checked'); ?>

                                                    <?php elseif($bookingDetail->inci_status==1): ?>

                                                    <?php else: ?>
                                                    <?php echo e('checked'); ?>

                                                    <?php endif; ?>
                                                    >Reject

                                            </label>
                                            <input type="hidden" value="" name="inci_status" class="inci_status">
                                        </div>
                                    </div>

                                    <div class="text-danger status_error"></div>
                                </div>

                            </div>
                            <div class="col-lg-12 col-sm-12 mt-3">
                                <div class="text-center  ">
				                        <button class="btn btn-primary" type="button" id="btn_loader" disabled style="display: none;">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </button>
                                    <button type="submit"
                                        class="btn btn-secondary px-5 fw-bold text-capitalize m-0">Update</button>
                                    <a href="<?php echo e(route('tcuser.dashboard')); ?>"
                                        class="btn btn-secondary px-5 fw-bold text-capitalize m-0">Back</a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="fw-bold mt-3 mb-5 text-center" style="color: #858585;">
                            <p>Document Not Available.</p>
                            <a href="<?php echo e(route('tcuser.dashboard')); ?>"
                                class="btn btn-secondary px-5 fw-bold text-capitalize m-0">Back</a>
                        </div>
                        


                    </div>

                    <input type="hidden" value="<?php echo e($count); ?>"  name="document_count"  id="document_count">

                </form>
            <?php endif; ?>
	    <?php else: ?>
                <div class="fw-bold mt-3 mb-5 text-center" style="color: #858585;">
                    <p>Document Not Available.</p>
                    <a href="<?php echo e(route('tcuser.dashboard')); ?>"
                       class="btn btn-secondary px-5 fw-bold text-capitalize m-0">Back</a>
                </div>
            <?php endif; ?>
            <!-- Tabs content -->
        </div>
	 <div class="container">
                <div class="col-md-12" id="fbcomment">
                    <div class="body_comment">
                        <h5>Rejection Summary</h5>
                        <div class="row">
                            <ul id="list_comment" class="col-md-12">
                                <!-- Start List Comment 1 -->
                                <!-- <?php if(isset($bookingDetail['comments']) && $bookingDetail['comments']): ?>
                                <?php $__currentLoopData = $bookingDetail['comments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="box_result row">
                                    <div class="avatar_comment col-md-1">
                                        <img src="<?php echo e($value['tcuser'] ? url('users/admin/profile').'/'.$value['tcuser']->user_profile : url('users/admin/profile/1660019563.png')); ?>" alt="avatar"/>
                                    </div>
                                    <div class="result_comment col-md-11">
                                        <h4><?php echo e($value['tcuser'] ? $value['tcuser']->name : "Admin"); ?></h4>
                                        <p><?php echo e($value['comment']); ?></p>
                                        <div class="tools_comment">
                                            <i class="fa fa-calendar" style="font-size:13px"></i>
                                            <span><?php echo e(date('d-m-Y h:i:s A',strtotime($value['created_at']))); ?></span>
                                        </div>

                                    </div>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <h6 class="text-center">No comments Found!</h6>
                                <?php endif; ?> -->


                                
                                <?php
                                    $comments = DB::table('incident_document_comments')
                                    ->where('incident_id',$bookingDetail->inci_number)
                                    ->orderBy('id','desc')
                                    ->simplePaginate(7);
                                ?>

                                <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


                                <li class="box_result row">
                                    <div class="avatar_comment col-md-1">
                                        <?php
                                            $user = App\User::where('id',$value->user_id)->first();
					    $keyData = ucFirst(str_replace('_', ' ', $value->key));

                                        ?>
                                        <img src="<?php echo e(isset($user) && $user ? url('users/admin/profile').'/'.$user->user_profile : url('users/admin/profile/1660019563.png')); ?>" alt="avatar"/>
                                    </div>

                                    <div class="result_comment col-md-11">
                                        <h4><?php echo e(isset($user) && $user  ? $user->name : "Admin"); ?></h4>
                                        <p>Document :- <?php echo e(ucFirst(str_replace('status', ' ', $keyData))); ?></p>
                                        <p>Comment :- <?php echo e($value->comment); ?></p>

                                        <div class="tools_comment">
                                            <i class="fa fa-calendar" style="font-size:13px"></i>
                                            <span><?php echo e(date('d-m-Y h:i:s A',strtotime($value->created_at))); ?></span>
                                        </div>
                                    </div>
                                </li>


                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <h6 class="text-center">No comments Found!</h6>
                                <?php endif; ?>

                                <hr>
                                <h5> <?php echo e($comments->onEachSide(5)->links()); ?></h5>


                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        <footer class="text-center pt-3 pb-3">
            <a href="#">
                <img src="../assets/img/group.png">
            </a>
        </footer>
    </div>

    <input type="hidden" value="<?php echo e($count); ?>"  name="document_no"  id="document_no">

<?php $__env->stopSection(); ?>

<?php $__env->startPush('pagescript'); ?>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.js">
    </script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js">
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".updateDoc", function(e) {



                e.preventDefault();

                var tr = $(this).closest("tr");
                var id = $(this).data("id");
                var doc_type = $(this).data("doc_type");
                var inci_type = $("#inci_type").val();

                $(".has_error").remove();
                $(".status_error").text('');
                $.ajax({
                    type: "GET",
                    url: '<?php echo e(route('tcuser.tcuser-update-document-status')); ?>',
                    data: {
                        status: $(this).val(),
                        comment: tr.find(".comment").val(),
                        id: id,
                        doc_type: doc_type,
                        inci_type: inci_type
                    },
                    success: function(result) {
                        //console.log(result);
                        // window.location.reload();
                    }
                }).fail(function(response, status, error) {
                    var data = response.responseJSON;
                    if (status === 'error') {
                        $.each(data.errors, function(i, val) {
                            $("textarea[name=" + i + "]").after(
                                '<div class="text-danger has_error">' + val + '</div>');
                        });
                    }
                });
            })
        });

        //Update Doc form (common update )
        $("#updateDocForm").validate({
            submitHandler: function(form) {
                $(".has_error").remove();
                $(".status_error").text('');
                $.ajax({
                    url: "<?php echo e(route('tcuser.tcuser-update-document')); ?>",
                    type: 'POST',
                    async: true,
                    data: new FormData(document.getElementById('updateDocForm')),
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
	  	    beforeSend : function(){
                        // Show image container
                        $("#btn_loader").show();
                        $("#btn_submit").hide();
                    },
                    success: function(response) {
			            $( "#btn_loader" ).hide();
                        $( "#btn_submit" ).show();
                        toastr.success(response.message);
			window.location.href = "<?php echo e(URL::to('/tcuser/dashboard')); ?>"

                    },
                }).fail(function(response, status, error) {
		            $( "#btn_loader" ).hide();
                    $( "#btn_submit" ).show();

                    var data = response.responseJSON;
                    if (status === 'error') {
                        $.each(data.errors, function(i, val) {
                            console.log(i);
                            if (i == 'inci_status') {
                                $(".status_error").text(val);
                            } else {
                                $("textarea[name=" + i + "], input[name=" + i + "]").after(
                                    '<div class="col-12 text-danger has_error">' + val +
                                    '</div>');
                            }

                        });
                    }
                });
            }
        });

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

    $("#checkAll").click(function () {
        var check = $('#document_no').val();
        if($('.checkoc_check:checked').length == check){
            $('input[value="1"]').prop('checked',true);
            $('.inci_status').val(1);
            $('#bordox_no').prop('disabled',false);
        }else{
            $('#bordox_no').val('');
            $('input[value="0"]').prop('checked',true);
            $('.inci_status').val(0);
            $('#bordox_no').prop('disabled',false);
        }
            $('input:checkbox').not(this).prop('checked', this.checked);
    });


    $("input:checkbox").click(function () {
      checkbox();




    });


checkbox();

	function checkbox(){
	var check = $('#document_no').val();

        if($('.checkoc_check:checked').length == check){

            $('input[value="1"]').prop('checked',true);
            $('#bordox_no').prop('disabled',false);
            
            $('.inci_status').val(1);
        }else{

            $('#bordox_no').val('');
            $('#bordox_no').prop('disabled',true);
            $('input[value="0"]').prop('checked',true);
            $('.inci_status').val(0);
        }

	}




</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tcuser.appmain', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/tcuser/update-booking-request.blade.php ENDPATH**/ ?>