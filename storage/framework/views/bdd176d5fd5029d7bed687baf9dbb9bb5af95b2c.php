<?php $__env->startSection('content'); ?>
<div class="w-100 bg-cover flickity-cell is-selected" style="background-image: url(<?php echo e(asset('admin-assets/img/admin/heading.jpg')); ?>); transform: translateX(0%); opacity: 1;">
    <div class="bg-dark-20">
        <div class=" container  justify-content-between">
            <div class=" " style="min-height: 150px;">
                <div class="d-flex pt-5">
                    <a href="<?php echo e(route('dashboard.index')); ?>" class="D-icon">
                        <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                    </a>

                    <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;"><a class="text-light" href="<?php echo e(route('admin-incident-requests.index')); ?>">View All Request</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="background-image: url(<?php echo e(asset('admin-assets/img/main_bg.jpg')); ?>);">
    <div class="container">
        <?php if(\Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo \Session::get('error'); ?>

        </div>
        <?php endif; ?>
        <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo \Session::get('success'); ?>

        </div>
        <?php endif; ?>
        <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
            <div class="d-flex justify-content mb-4">
                <div class="border-1"></div>
                <div class="ps-1 fw-bold" style="color: #1E1E1E;">View Document
                </div>
            </div>

            <table class="table roundedTable table w-100 nowrap">
                <thead style="backgrounD-color: #F4F6F8;">
                    <tr>
                        <th style="color: #2565ab; font-weight: 800;">Passport No. :
                            <?php echo e($incidentDetails->inci_passport_number); ?>

                        </th>
                        <th style="color: #2565ab; font-weight: 800;">Departure Date :
                            <?php echo e($incidentDetails->inci_departure_date=="" && $incidentDetails->inci_departure_date=="1970-01-01" ? '' : date('d-m-Y', strtotime($incidentDetails->inci_departure_date))); ?>

                        </th>
                        <th style="color: #2565ab; font-weight: 800;">Buy/Sell :
                            <?php if($incidentDetails->inci_buy_sell_req == '0'): ?>
                            Buy
                            <?php else: ?>
                            Sell
                            <?php endif; ?>
                        </th>
                    </tr>
                </thead>
            </table>

            <table class="table roundedTable table w-100 nowrap">
                <thead style="backgrounD-color: #F4F6F8;">
                    <tr>
                        <th style="color: #2565ab; font-weight: 800;">Card No. :
                            <?php echo e($incidentDetails->inci_forex_card_no); ?>

                        </th>
                        <th style="color: #2565ab; font-weight: 800;">Incident Number :
                            <?php echo e($incidentDetails->inci_number); ?>

                        </th>
                        <th style="color: #2565ab; font-weight: 800;">Transaction Type :
                            <?php if($incidentDetails->transaction_type == '0'): ?>
                            Reload
                            <?php else: ?>
                            Activation
                            <?php endif; ?>
                        </th>
                    </tr>
                </thead>
            </table>
            <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
                <table class="table roundedTable table w-100 nowrap">
                    <thead style="backgrounD-color: #F4F6F8;">
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">Currency</th>
                            <th style="color: #2565ab; font-weight: 800;">Rate</th>
                            <th style="color: #2565ab; font-weight: 800;">Amount</th>
                            <th style="color: #2565ab; font-weight: 800;">Calculate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $currencyRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($currency->inci_currency_type); ?></td>
                            <td><?php echo e($currency->inci_currency_rate); ?></td>
                            <td><?php echo e($currency->inci_frgn_curr_amount); ?></td>
                            <td><?php echo e($currency->inci_inr_amount); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th><b>Total</b></th>
                            <th id="total" data-total="0.0"><?php echo e($currencyRecords->sum('inci_inr_amount')); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 view-booking">
                <div class="d-flex justify-content mb-4">
                    <div class="border-1"></div>
                    <div class="ps-1 fw-bold" style="color: #1E1E1E;"> Document Details
                    </div>
                </div>
                <?php if($incidentImageDetails->count() == 0): ?>
                <?php
               
                //Passport'/'
                /*$passport = incidentImageDetails->inci_up_pass;
                $pos = strrpos($passport, '/');
                $passportFileName = $pos === false ? $passport : substr($passport, $pos + 1);
                $PassportName = explode('_', $passportFileName);
                array_shift($PassportName);
                //print_r($PassportName);die;
                $Passport = implode('_', $PassportName);*/

                $count = 1;
                ?>
                <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
                    <table class="table roundedTable table w-100 nowrap">
                        <thead style="backgrounD-color: #F4F6F8;">
                            <tr>
                                <th style="color: #2565ab; font-weight: 800;">Sr No.</th>
                                <th style="color: #2565ab; font-weight: 800;">Document</th>
                                <th style="color: #2565ab; font-weight: 800;">Requirement</th>
                                <th style="color: #2565ab; font-weight: 800;">Files</th>
                                <th style="color: #2565ab; font-weight: 800;">Action</th>
                            </tr>
                        </thead>
                        <!--<tbody>
                            <tr>
                                <td>1</td>
                                <td>Passport</td>
                                <td>Mandatory</td>
                                <td>
                                    <a href="<?php echo e(asset('public/allDocuments/' . $incidentUpdateDetails->inci_recived_date . '/' . $incidentDetails->inci_number )); ?>" target="_blank" download="<?php //echo $Passport; ?>">
                                        
                                        <img src="#" alt="img">
                                    </a>
                                </td>
                                <td><i class="fas fa-check"></i></td>
                            </tr>
                        </tbody>-->
                    </table>
                </div>
                <?php else: ?>
                <div class="document-status my-2">
                    <span class="btn btn-warning info-document-update">Document Update by Agent</span>
                    <span class="btn btn-success info-document-approved">Document Approved</span>
                    <span class="btn btn-danger info-document-rejected">Document Rejected</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Document</th>
                                <th>Requirement</th>
                                <th>Files</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
				//print_r($incidentImageDetails);
				//echo $incidentImageDetails[0]->passport_status;
                            ?>
				
                            <?php $__currentLoopData = $incidentImageDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if($incidentDetails->inci_buy_sell_req == 1): ?>
                            <?php
                            $passStatus = $incidentImageDetails[0]->passport_status;
                            $passStatusClass = '';
                            $visaStatus = $document->visa_status;
                            $visaStatusClass = '';
                            $tiketStatus = $document->ticket_status;
                            $tiketStatusClass = '';
                            $panStatus = $document->pan_card_status;
                            $panStatusClass = '';
                            $appliStatus = $document->apply_status;
                            $appliStatusClass = '';
                            $annexStatus = $document->annex_status;
                            $annexStatusClass = '';
                            $bankStatus = $document->bank_transfer_status;
                            $bankStatusClass = '';
                            $businessStatus = $document->business_status;
                            $businessStatusClass = '';
                            $sofStatus = $document->sof_status;
                            $sofStatusClass = '';
                            $otherStatus = $document->other_status;
                            $otherStatusClass = '';
                            $lermsStatus = $document->lerms_letter_status;
                            $lermsStatusClass = '';
                            $universityStatus = $document->university_letter_status;
                            $universityStatusClass = '';
                            $employmentStatus = $document->emp_letter_status;
                            $employmentStatusClass = '';
                            $immigrationStatus = $document->immigration_d_form_status;
                            $immigrationStatusClass = '';
                            $medicalStatus = $document->medical_letter_status;
                            $medicalStatusClass = '';

                           

                            if ($passStatus == 2) {
                            $passStatusClass = 'document-rejected';
                            } elseif ($passStatus == 3) {
                            $passStatusClass = 'document-update';
                            } elseif ($passStatus == 4) {
                            $passStatusClass = 'document-approved';
                            }

                            if ($visaStatus == 2) {
                            $visaStatusClass = 'document-rejected';
                            } elseif ($visaStatus == 3) {
                            $visaStatusClass = 'document-update';
                            } elseif ($visaStatus == 4) {
                            $visaStatusClass = 'document-approved';
                            }

                            if ($tiketStatus == 2) {
                            $tiketStatusClass = 'document-rejected';
                            } elseif ($tiketStatus == 3) {
                            $tiketStatusClass = 'document-update';
                            } elseif ($tiketStatus == 4) {
                            $tiketStatusClass = 'document-approved';
                            }

                            if ($panStatus == 2) {
                            $panStatusClass = 'document-rejected';
                            } elseif ($panStatus == 3) {
                            $panStatusClass = 'document-update';
                            } elseif ($panStatus == 4) {
                            $panStatusClass = 'document-approved';
                            }
                            if ($appliStatus == 2) {
                            $appliStatusClass = 'document-rejected';
                            } elseif ($appliStatus == 3) {
                            $appliStatusClass = 'document-update';
                            } elseif ($appliStatus == 4) {
                            $appliStatusClass = 'document-approved';
                            }
                            if ($annexStatus == 2) {
                            $annexStatusClass = 'document-rejected';
                            } elseif ($annexStatus == 3) {
                            $annexStatusClass = 'document-update';
                            } elseif ($annexStatus == 4) {
                            $annexStatusClass = 'document-approved';
                            }
                            if ($bankStatus == 2) {
                            $bankStatusClass = 'document-rejected';
                            } elseif ($bankStatus == 3) {
                            $bankStatusClass = 'document-update';
                            } elseif ($bankStatus == 4) {
                            $bankStatusClass = 'document-approved';
                            }
                            if ($businessStatus == 2) {
                            $businessStatusClass = 'document-rejected';
                            } elseif ($businessStatus == 3) {
                            $businessStatusClass = 'document-update';
                            } elseif ($businessStatus == 4) {
                            $businessStatusClass = 'document-approved';
                            }
                            if ($sofStatus == 2) {
                            $sofStatusClass = 'document-rejected';
                            } elseif ($sofStatus == 3) {
                            $sofStatusClass = 'document-update';
                            } elseif ($sofStatus == 4) {
                            $sofStatusClass = 'document-approved';
                            }
                            if ($otherStatus == 2) {
                            $otherStatusClass = 'document-rejected';
                            } elseif ($otherStatus == 3) {
                            $otherStatusClass = 'document-update';
                            } elseif ($otherStatus == 4) {
                            $otherStatusClass = 'document-approved';
                            }
                            if ($lermsStatus == 2) {
                            $lermsStatusClass = 'document-rejected';
                            } elseif ($lermsStatus == 3) {
                            $lermsStatusClass = 'document-update';
                            } elseif ($lermsStatus == 4) {
                            $lermsStatusClass = 'document-approved';
                            }
                            if ($universityStatus == 2) {
                            $universityStatusClass = 'document-rejected';
                            } elseif ($universityStatus == 3) {
                            $universityStatusClass = 'document-update';
                            } elseif ($universityStatus == 4) {
                            $universityStatusClass = 'document-approved';
                            }
                            if ($employmentStatus == 2) {
                            $employmentStatusClass = 'document-rejected';
                            } elseif ($employmentStatus == 3) {
                            $employmentStatusClass = 'document-update';
                            } elseif ($employmentStatus == 4) {
                            $employmentStatusClass = 'document-approved';
                            }
                            if ($immigrationStatus == 2) {
                            $immigrationStatusClass = 'document-rejected';
                            } elseif ($immigrationStatus == 3) {
                            $immigrationStatusClass = 'document-update';
                            } elseif ($immigrationStatus == 4) {
                            $immigrationStatusClass = 'document-approved';
                            }
                            if ($medicalStatus == 2) {
                            $medicalStatusClass = 'document-rejected';
                            } elseif ($medicalStatus == 3) {
                            $medicalStatusClass = 'document-update';
                            } elseif ($medicalStatus == 4) {
                            $medicalStatusClass = 'document-approved';
                            }
			   ?>
                            <?php if(isset($document->passport) && $document->passport != ''): ?>
                            <tr class="<?php echo e($passStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>Passport</td>
                                <td>Mandatory</td>
                               
                                <td>
                                    <?php

                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->passport);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>

                                    <?php if($passStatus == 2 || $passStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[pass_status]" id="option1" value="4" autocomplete="off" <?php if($passStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[pass_status]" id="option2" value="2" autocomplete="off" <?php if($passStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>> Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->visa) && $document->visa != ''): ?>
                            <tr class="<?php echo e($visaStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>Visa</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->visa);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($visaStatus == 2 || $visaStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[visa_status]" id="option1" value="4" autocomplete="off" <?php if($visaStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[visa_status]" id="option2" value="2" autocomplete="off" <?php if($visaStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->ticket) && $document->ticket != ''): ?>
                            <tr class="<?php echo e($tiketStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>Tiket</td>
                                <td>Mandatory</td>
                               
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->ticket);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($tiketStatus == 2 || $tiketStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[tiket_status]" id="option1" value="4" autocomplete="off" <?php if($tiketStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[tiket_status]" id="option2" value="2" autocomplete="off" <?php if($tiketStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->pan_card) && $document->pan_card != ''): ?>
                            <tr class="<?php echo e($panStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>Pan</td>
                                <td>Mandatory</td>
                               
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->pan_card);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($panStatus == 2 || $panStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[pan_status]" id="option1" value="4" autocomplete="off" <?php if($panStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[pan_status]" id="option2" value="2" autocomplete="off" <?php if($panStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?> 
                        <?php if(isset($document->apply) && $document->apply != ''): ?> 
                            <tr class="<?php echo e($appliStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>Application</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->apply);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($appliStatus == 2 || $appliStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[appli_status]" id="option1" value="4" autocomplete="off" <?php if($appliStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[appli_status]" id="option2" value="2" autocomplete="off" <?php if($appliStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>

                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php if(isset($document->annex) && $document->annex != ''): ?> 
                            <tr class="<?php echo e($annexStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>annex</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->annex);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>

                                    <?php if($annexStatus == 2 || $annexStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[annex_status]" id="option1" value="4" autocomplete="off" <?php if($annexStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?> > Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[annex_status]" id="option2" value="2" autocomplete="off" <?php if($annexStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->bank_transfer) && $document->bank_transfer != ''): ?> 
                            <tr class="<?php echo e($bankStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>bank_transfer</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->bank_transfer);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                            
                                <td>
                                    <?php if($bankStatus == 2 || $bankStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[bank_status]" id="option1" value="4" autocomplete="off" <?php if($bankStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[bank_status]" id="option2" value="2" autocomplete="off" <?php if($bankStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->inci_up_business) && $document->inci_up_business != ''): ?>
                            <tr class="<?php echo e($businessStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>business</td>
                                <td>Mandatory</td>
                               
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->business);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($businessStatus == 2 || $businessStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[business_status]" id="option1" value="4" autocomplete="off" <?php if($businessStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[business_status]" id="option2" value="2" autocomplete="off" <?php if($businessStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->sof) && $document->sof != ''): ?>
                            <tr class="<?php echo e($sofStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>sof</td>
                                <td>Mandatory</td> 
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->sof);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($sofStatus == 2 || $sofStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[sof_status]" id="option1" value="4" autocomplete="off" <?php if($sofStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[sof_status]" id="option2" value="2" autocomplete="off" <?php if($sofStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                       
                        <?php if(isset($document->lerms_letter) && $document->lerms_letter != ''): ?>
                            <tr class="<?php echo e($lermsStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>Lerms Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->lerms_letter);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($lermsStatus == 2 || $lermsStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[lerms_status]" id="option1" value="4" autocomplete="off" <?php if($lermsStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[lerms_status]" id="option2" value="2" autocomplete="off" <?php if($lermsStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->university_letter) && $document->university_letter != ''): ?>
                            <tr class="<?php echo e($universityStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>university Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->university_letter);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($universityStatus == 2 || $universityStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[university_status]" id="option1" value="4" autocomplete="off" <?php if($universityStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[university_status]" id="option2" value="2" autocomplete="off" <?php if($universityStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->employment_letter) && $document->employment_letter != ''): ?>
                            <tr class="<?php echo e($employmentStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>employment Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->employment_letter);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($employmentStatus == 2 || $employmentStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[employment_status]" id="option1" value="4" autocomplete="off" <?php if($employmentStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[employment_status]" id="option2" value="2" autocomplete="off" <?php if($employmentStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>


                        <?php if(isset($document->immigration_d_form) && $document->immigration_d_form != ''): ?>
                            <tr class="<?php echo e($immigrationStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>immigration Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->immigration_d_form);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($immigrationStatus == 2 || $immigrationStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[immigration_status]" id="option1" value="4" autocomplete="off" <?php if($immigrationStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[immigration_status]" id="option2" value="2" autocomplete="off" <?php if($immigrationStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($document->medical_letter) && $document->medical_letter != ''): ?>
                            <tr class="<?php echo e($medicalStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>medical Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->medical_letter);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($medicalStatus == 2 || $medicalStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[medical_status]" id="option1" value="4" autocomplete="off" <?php if($medicalStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[medical_status]" id="option2" value="2" autocomplete="off" <?php if($medicalStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
			<?php if(isset($document->other) && $document->other != ''): ?>
                            <tr class="<?php echo e($otherStatusClass); ?>">
                                <td><?php echo e($count++); ?></td>
                                <td>Other</td>
                                <td>Not Mandatory</td>
                                <td>
                                    <?php
                                        $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentUpdateDetails->inci_recived_date)) . '/' . $incidentDetails->inci_number . '/' . $document->other);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($otherStatus == 2 || $otherStatus == 4): ?>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn bg-olive active">
                                                <input type="radio" name="document[other_status]" id="option1" value="4" autocomplete="off" <?php if($otherStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                                Approved
                                            </label>
                                            <label class="btn bg-danger">
                                                <input type="radio" name="document[other_status]" id="option2" value="2" autocomplete="off" <?php if($otherStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                                Reject
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                            <?php else: ?>
                            <?php
                            $passStatus = $document->pass_status;
                            $passStatusClass = '';
                            $refoundStatus = $document->refound_status;
                            $refoundStatusClass = '';
                            $annexStatus = $document->annex_status;
                            $annexStatusClass = '';
                            $otherStatus = $document->other_status;
                            $otherStatusClass = '';
                            $surrenderStatus = $document->surrender_status;
                            $surrenderStatusClass = '';

                            if ($passStatus == 2) {
                            $passStatusClass = 'document-rejected';
                            } elseif ($passStatus == 3) {
                            $passStatusClass = 'document-update';
                            } elseif ($passStatus == 4) {
                            $passStatusClass = 'document-approved';
                            }
                            if ($annexStatus == 2) {
                            $annexStatusClass = 'document-rejected';
                            } elseif ($annexStatus == 3) {
                            $annexStatusClass = 'document-update';
                            } elseif ($annexStatus == 4) {
                            $annexStatusClass = 'document-approved';
                            }
                            if ($refoundStatus == 2) {
                            $refoundStatusClass = 'document-rejected';
                            } elseif ($refoundStatus == 3) {
                            $refoundStatusClass = 'document-update';
                            } elseif ($refoundStatus == 4) {
                            $refoundStatusClass = 'document-approved';
                            }
                            if ($otherStatus == 2) {
                            $otherStatusClass = 'document-rejected';
                            } elseif ($otherStatus == 3) {
                            $otherStatusClass = 'document-update';
                            } elseif ($otherStatus == 4) {
                            $otherStatusClass = 'document-approved';
                            }
                            if ($surrenderStatus == 2) {
                            $surrenderStatusClass = 'document-rejected';
                            } elseif ($surrenderStatus == 3) {
                            $surrenderStatusClass = 'document-update';
                            } elseif ($surrenderStatus == 4) {
                            $surrenderStatusClass = 'document-approved';
                            }


                            $doc_count = 1;
                            ?>

                            <tr class="<?php echo e($passStatusClass); ?>">
                                <td><?php echo e($doc_count++); ?></td>
                                <td>Passport </td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->passport);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($passStatus == 2 || $passStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[pass_status]" id="option1" value="4" autocomplete="off" <?php if($passStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[pass_status]" id="option2" value="2" autocomplete="off" <?php if($passStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr class="<?php echo e($refoundStatusClass); ?>">
                                <td><?php echo e($doc_count++); ?></td>
                                <td>Refound</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->refound);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($refoundStatus == 2 || $refoundStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[refound_status]" id="option1" value="4" autocomplete="off" <?php if($refoundStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[refound_status]" id="option2" value="2" autocomplete="off" <?php if($refoundStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr class="<?php echo e($annexStatusClass); ?>">
                                <td><?php echo e($doc_count++); ?></td>
                                <td>Annex</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->annex);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    <?php if($annexStatus == 2 || $annexStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[annex_status]" id="option1" value="4" autocomplete="off" <?php if($annexStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[annex_status]" id="option2" value="2" autocomplete="off" <?php if($annexStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php if(isset($document->surrender_letter) && $document->surrender_letter != ''): ?>
                            <tr class="<?php echo e($surrenderStatusClass); ?>">
                                <td><?php echo e($doc_count++); ?></td>
                                <td>Surrender Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    <?php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->surrender_letter);
                                    ?>
                                    <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <?php
                                echo ($document->surrender_letter);
                                ?>
                                <td>
                                    <?php if($surrenderStatus == 2 || $surrenderStatus == 4): ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[surrender_status]" id="option1" value="4" autocomplete="off" <?php if($surrenderStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[surrender_status]" id="option2" value="2" autocomplete="off" <?php if($surrenderStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                            Reject
                                        </label>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                            <?php if(isset($document->inci_up_other) && $document->inci_up_other != ''): ?>
                                <tr class="<?php echo e($otherStatusClass); ?>">
                                    <td><?php echo e($doc_count++); ?></td>
                                    <td>Other</td>
                                    <td>Mandatory</td>
                                
                                    <td>
                                        <?php
                                        $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->other);
                                        ?>
                                        <a href="<?php echo e($file_path); ?>" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                    </td>
                                    <td>
                                        <?php if($otherStatus == 2 || $otherStatus == 4): ?>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn bg-olive active">
                                                <input type="radio" name="document[other_status]" id="option1" value="4" autocomplete="off" <?php if($otherStatus==4): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                                Approved
                                            </label>
                                            <label class="btn bg-danger">
                                                <input type="radio" name="document[other_status]" id="option2" value="2" autocomplete="off" <?php if($otherStatus==2): ?> <?php echo e("checked"); ?> <?php endif; ?>>
                                                Reject
                                            </label>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php
                            $count++;
                            ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php if($documentComments->count() >= 1): ?>
                <div id="document-comment">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="comment-list-wrap">
                                <ul class="list-group">
                                    <?php if($documentComments->count() >= 1): ?>
                                    <?php $__currentLoopData = $documentComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($comments->tc_key != ''): ?>
                                    <?php if($comments->tc_key == 'Admin'): ?>
                                    <li class="list-group-item tc-comment admin-comment">
                                        <p><?php echo e($comments->comment); ?>

                                        <p>
                                            <span>@ADMIN:
                                                <?php echo e($comments->created_at); ?></span>
                                            <span></span>
                                    </li>
                                    <?php else: ?>
                                    <li class="list-group-item tc-comment">
                                        <p><?php echo e($comments->comment); ?>

                                        <p>
                                            <span>@TC:
                                                <?php echo e($comments->created_at); ?></span>
                                            <span></span>
                                    </li>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <li class="list-group-item agent-comment">
                                        <p><?php echo e($comments->comment); ?>

                                        <p>
                                            <span>@Agent:
                                                <?php echo e($comments->created_at); ?></span>
                                            <span></span>
                                    </li>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <li class="list-group-item">No Comment Added by agent</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>


                <div class="container">
                <div class="col-md-12" id="fbcomment">
                    <div class="body_comment">
                        <h5>Rejection Summary</h5>
                        <div class="row">
                            <ul id="list_comment" class="col-md-12">
                               

                                <?php
                                    $comments = DB::table('incident_document_comments')
                                    ->where('incident_id',$incidentDetails->inci_number)
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

                            </ul>

                        </div>
                    </div>
                </div>
            </div>


               
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/AdminIncidentRequest/Resources/views/documents.blade.php ENDPATH**/ ?>