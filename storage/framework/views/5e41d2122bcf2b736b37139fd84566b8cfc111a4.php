<?php isset($incidentImageDetails['inci_number']) ? $incidentImageDetails['inci_number'] : $incidentImageDetails['incident_number'] ?>
<div class="row mt-3 bgc m-2">
    <div class="col-lg-6 col-sm-6 mt-2">
        <div class="d-flex justify-content  ">
            <div class="border-1"></div>
            <div class="ps-1 fw-bold"> Document Lists </div>
        </div>
    </div>
   <div class="col-lg-12 col-sm-12 mt-3">
        <label style="color: #ADAEB0; font-size: 14px; ">Incident Number</label>
        <div class="input-group mb-3">
            <input name="inci_id" class="form-control border-0 border-bottom bg-transparent" type="text"
                value="<?php echo e($incidentImageDetails['inci_number']); ?>" readonly />
        </div>
    </div>
    <?php
     //echo $incidentImageDetails['passport'];exit;
    //echo "<pre>";
    //print_r(json_encode($incidentImageDetails));
    //exit;
    $travel_type=$incidentImageDetails_single['travel_type'];
    $doc_url = url("allDocuments/" . date('Y-m-d',strtotime($incidentImageDetails['created_at'])) . "/" . $incidentImageDetails['inci_number'].'/');
    ?>
    <div class="col-md-12">
        <div class="row">
            
            <?php if($travel_type == 1 || $travel_type == 2 || $travel_type == 3 || $travel_type == 4 || $travel_type == 4 || $travel_type == 5 || $travel_type == 6): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1" for="passport2">
                        <div class="text-dark fw-bold">Passport&nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if(isset($incidentImageDetails['incedent_doc']->passport) && $incidentImageDetails['incedent_doc']->passport==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end passport2View">
                            <a href="<?php echo e(isset($incidentImageDetails['incedent_doc']->passport) && $incidentImageDetails['incedent_doc']->passport ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->passport : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>

            <?php if(($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5) && ($incidentImageDetails['inci_buy_sell_req']==1) ): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1" >
                        <div class="text-dark fw-bold">Visa &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->visa==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->visa ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->visa : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if(($travel_type == 1 || $travel_type == 2 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5 || $travel_type == 6) && ($incidentImageDetails['inci_buy_sell_req']==1)): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">PAN &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->pan_card==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->pan_card ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->pan_card : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if(($travel_type == 1 || $travel_type == 2 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5 || $travel_type == 6) && ($incidentImageDetails['inci_buy_sell_req']==1)): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Application &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->apply==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->apply ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->apply : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if(($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5) && ($incidentImageDetails['inci_buy_sell_req']==1)): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Ticket &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->ticket==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->ticket ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->ticket : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if($travel_type == 1 || $travel_type == 2 || $travel_type == 3 || $travel_type == 5 || $travel_type == 6): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Annexure &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->annex==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->annex ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->annex : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if(($travel_type = 1 || $travel_type = 2 ) && $incidentImageDetails['incedent_doc']->refound !=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Refund Form &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->refound==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->refound ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->refound : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
             <?php if(($travel_type = 1 || $travel_type = 2 ) && $incidentImageDetails['incedent_doc']->surrender_letter !=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Surrender Letter &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->surrender_letter==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->surrender_letter ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->surrender_letter : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if(($travel_type == 1 || $travel_type == 2 ) && $incidentImageDetails['incedent_doc']->bank_transfer !=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Bank Transfer Copy &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->bank_transfer==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->bank_transfer ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->bank_transfer : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if(($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5) && ($incidentImageDetails['inci_buy_sell_req']==1) && ($incidentImageDetails['incedent_doc']->sof!='')): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">SOF &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->sof==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->sof ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->sof : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if(($travel_type == 2 || $travel_type == 6) && ($incidentImageDetails['inci_buy_sell_req']==1) && $incidentImageDetails['incedent_doc']->lerms_letter!=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Lerms Letter &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->lerms_letter==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->lerms_letter ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->lerms_letter : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if($travel_type == 4 && ($incidentImageDetails['inci_buy_sell_req']==1) && $incidentImageDetails['incedent_doc']->university_letter!=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">University Letter &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->university_letter==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->university_letter ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->university_letter : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>

            <?php if($travel_type == 3 && ($incidentImageDetails['inci_buy_sell_req']==1) && $incidentImageDetails['incedent_doc']->employment_letter!=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Employment Letter &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->employment_letter==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->employment_letter ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->employment_letter : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if($travel_type == 3 && ($incidentImageDetails['inci_buy_sell_req']==1) && $incidentImageDetails['incedent_doc']->emp_declaration_form!=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Employment Declaration Form &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->emp_declaration_form==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->emp_declaration_form ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->emp_declaration_form : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if($travel_type == 5 && ($incidentImageDetails['inci_buy_sell_req']==1) && $incidentImageDetails['incedent_doc']->immigration_d_form!=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Immigration Declaration form &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->immigration_d_form==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->immigration_d_form ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->immigration_d_form : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if($travel_type == 6 && ($incidentImageDetails['inci_buy_sell_req']==1) && $incidentImageDetails['incedent_doc']->medical_letter!=''): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Medical Letter &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->medical_letter==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->medical_letter ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->medical_letter : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
            <?php if(($travel_type == 1 || $travel_type == 2 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5) && ($incidentImageDetails['inci_buy_sell_req']==1)): ?>
            <div class="col-md-6">
                <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                    <label class="form-attach-label row mb-1">
                        <div class="text-dark fw-bold">Other &nbsp;&nbsp;&nbsp;<span class="text-danger"><?php if($incidentImageDetails['incedent_doc']->other==''): ?> Document Not Found! <?php endif; ?></span></div>
                        <div class="col-md-12 text-end">
                            <a href="<?php echo e($incidentImageDetails['incedent_doc']->other ? $doc_url.'/'.$incidentImageDetails['incedent_doc']->other : '#'); ?>" target="_blank">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>
                            </a>
                        </div>
                    </label>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#passport2').change(function(e) {
            if (e.target.value) {
                $('.passport2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.passport2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#visa2').change(function(e) {
            if (e.target.value) {
                $('.visa2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.visa2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#ticket2').change(function(e) {
            if (e.target.value) {
                $('.ticket2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.ticket2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#pan2').change(function(e) {
            if (e.target.value) {
                $('.pan2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.pan2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#application2').change(function(e) {
            if (e.target.value) {
                $('.application2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.application2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#annexure2').change(function(e) {
            if (e.target.value) {
                $('.annexure2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.annexure2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#banktransfer2').change(function(e) {
            if (e.target.value) {
                $('.banktransfer2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.banktransfer2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#sof2').change(function(e) {
            if (e.target.value) {
                $('.sof2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.sof2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#lerms_letter2').change(function(e) {
            if (e.target.value) {
                $('.lerms_letter2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.lerms_letter2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#university_letter2').change(function(e) {
            if (e.target.value) {
                $('.university_letter2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.university_letter2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#employment_letter2').change(function(e) {
            if (e.target.value) {
                $('.employment_letter2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.employment_letter2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#emp_declaration_form2').change(function(e) {
            if (e.target.value) {
                $('.emp_declaration_form2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.emp_declaration_form2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#immigration_d_form2').change(function(e) {
            if (e.target.value) {
                $('.immigration_d_form2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.immigration_d_form2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#medical_letter2').change(function(e) {
            if (e.target.value) {
                $('.medical_letter2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.medical_letter2View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#other2').change(function(e) {
            if (e.target.value) {
                $('.other2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.other2View').removeClass("d-block").addClass("d-none");
            }
        });
    });
</script>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/agent/view-doc.blade.php ENDPATH**/ ?>