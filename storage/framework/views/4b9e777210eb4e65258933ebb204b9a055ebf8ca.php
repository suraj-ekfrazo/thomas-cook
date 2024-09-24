<div class="row mt-3 bgc m-2">
    <div class="col-lg-6 col-sm-6 mt-2">
        <div class="d-flex justify-content  ">
            <div class="border-1"></div>
            <div class="ps-1 fw-bold"> Document List </div>
        </div>
    </div>
    <div class="d-flex"></div>
    <div class="col-lg-6 col-sm-6 mt-3">
        <label style="color: #ADAEB0; font-size: 14px; ">Incident Number</label>
        <div class="input-group mb-3">
            <input name="inci_id" class="form-control border-0 border-bottom bg-transparent" type="text"
                value="<?php echo e($inci_id); ?>" readonly />
            <input type="hidden" name="agent_code" value="<?php echo e($agentcode); ?>">
	    <input type="hidden" name="upload_date" value="<?php echo e(date('Y-m-d',strtotime($agentdata->created_at))); ?>">
        </div>
    </div>
	
    <div class="col-lg-6 col-sm-6 mt-3">
        <label style="color: #ADAEB0; font-size: 14px; ">Passport Number</label>
        <div class="input-group mb-3">
            <input class="form-control border-0 border-bottom p-2" type="text"
                   placeholder="Enter passport number" id="passport_number"
                   name="passport_number" maxlength="12" minlength="8" value="<?php echo e($passport_no); ?>" required >
        </div>
    </div>

     <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="annexure1">
            <div class="text-dark fw-bold">Annexure *</div>
                <div class="col-md-12 text-end annexure1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('annexure1')"><i class="fa-solid fa-eye"></i></button>
                </div>

            </label>
            <input class="form-control" type="file" id="annexure1" name="annexure1" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="application1">
            <div class="text-dark fw-bold">Application *</div>
                <div class="col-md-12 text-end application1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('application1')"><i class="fa-solid fa-eye"></i></button>
                </div>

            </label>
            <input class="form-control" type="file" id="application1" name="application1" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="pan1">
            <div class="text-dark fw-bold">PAN *</div>
                <div class="col-md-12 text-end pan1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('pan1')"><i class="fa-solid fa-eye"></i></button>
                </div>

            </label>
            <input class="form-control" type="file" id="pan1" name="pan1" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="passport1">
            <div class="text-dark fw-bold">Passport *</div>
                <div class="col-md-12 text-end passport1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('passport1')"><i class="fa-solid fa-eye"></i></button>
                </div>

            </label>
            <input class="form-control" type="file" id="passport1" name="passport1" required>
        </div>
    </div>
    <?php if($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="ticket1">
            <div class="text-dark fw-bold">Ticket *</div>
                <div class="col-md-12 text-end ticket1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('ticket1')"><i class="fa-solid fa-eye"></i></button>
                </div>

            </label>
            <input class="form-control" type="file" id="ticket1" name="ticket1" required>
        </div>
    </div>
    <?php endif; ?>
    <?php if($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="visa1">
            <div class="text-dark fw-bold">Visa *</div>
                <div class="col-md-12 text-end visa1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('visa1')"><i class="fa-solid fa-eye"></i></button>
                </div>

            </label>
            <input class="form-control" type="file" id="visa1" name="visa1" required>
        </div>
    </div>
    <?php endif; ?>
    <?php if($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="sof1">
            <div class="text-dark fw-bold">SOF *</div>
                <div class="col-md-12 text-end sof1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('sof1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="sof1" name="sof1" required>
        </div>
    </div>
    <?php endif; ?> 
     <?php if($travel_type == 1 ||  $travel_type == 2): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="banktransfer1">
            <div class="text-dark fw-bold">Bank Transfer Copy *</div>
                <div class="col-md-12 text-end banktransfer1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('banktransfer1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="banktransfer1" name="banktransfer1" required>
        </div>
    </div>
    <?php endif; ?>
    <?php if($travel_type == 2 || $travel_type == 6): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="lerms_letter1">
            <div class="text-dark fw-bold">Lerms Letter</div>
                <div class="col-md-12 text-end lerms_letter1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('lerms_letter1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="lerms_letter1" name="lerms_letter1" required>
        </div>
    </div>
    <?php endif; ?>

    <?php if($travel_type == 4): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="university_letter1">
            <div class="text-dark fw-bold">University Letter</div>
                <div class="col-md-12 text-end university_letter1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('university_letter1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="university_letter1" name="university_letter1" required>
        </div>
    </div>
    <?php endif; ?>

    <?php if($travel_type == 3): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="employment_letter1">
            <div class="text-dark fw-bold">Employment Letter</div>
                <div class="col-md-12 text-end employment_letter1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('employment_letter1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="employment_letter1" name="employment_letter1" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="emp_declaration_form1">
            <div class="text-dark fw-bold">Employment Declaration Form</div>
                <div class="col-md-12 text-end emp_declaration_form1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('emp_declaration_form1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="emp_declaration_form1" name="emp_declaration_form1" required>
        </div>
    </div>
    <?php endif; ?>


    <?php if($travel_type == 5): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="immigration_d_form1">
            <div class="text-dark fw-bold">Immigration Declaration form</div>
                <div class="col-md-12 text-end immigration_d_form1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('immigration_d_form1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="immigration_d_form1" name="immigration_d_form1" required>
        </div>
    </div>
    <?php endif; ?>

    <?php if($travel_type == 6): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="medical_letter1">
            <div class="text-dark fw-bold">Medical Letter</div>
                <div class="col-md-12 text-end medical_letter1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('medical_letter1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="medical_letter1" name="medical_letter1" required>
        </div>
    </div>
    <?php endif; ?>

    <?php if($travel_type != 6): ?>
    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="other1">
            <div class="text-dark fw-bold">other</div>
                <div class="col-md-12 text-end other1View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('other1')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="other1" name="other1">
        </div>
    </div>
    <?php endif; ?>

    <div class="col-md-6">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="upload_doc_comment">
                <div class="text-dark fw-bold">Comment</div>
            </label>
            <textarea class="form-control border-0 border-bottom p-2" id="upload_doc_comment" name="upload_doc_comment"></textarea>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {

        $('#passport1').change(function(e) {
            if (e.target.value) {
                $('.passport1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.passport1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#visa1').change(function(e) {
            if (e.target.value) {
                $('.visa1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.visa1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#ticket1').change(function(e) {
            if (e.target.value) {
                $('.ticket1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.ticket1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#pan1').change(function(e) {
            if (e.target.value) {
                $('.pan1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.pan1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#application1').change(function(e) {
            if (e.target.value) {
                $('.application1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.application1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#annexure1').change(function(e) {
            if (e.target.value) {
                $('.annexure1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.annexure1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#banktransfer1').change(function(e) {
            if (e.target.value) {
                $('.banktransfer1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.banktransfer1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#sof1').change(function(e) {
            if (e.target.value) {
                $('.sof1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.sof1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#lerms_letter1').change(function(e) {
            if (e.target.value) {
                $('.lerms_letter1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.lerms_letter1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#university_letter1').change(function(e) {
            if (e.target.value) {
                $('.university_letter1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.university_letter1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#employment_letter1').change(function(e) {
            if (e.target.value) {
                $('.employment_letter1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.employment_letter1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#emp_declaration_form1').change(function(e) {
            if (e.target.value) {
                $('.emp_declaration_form1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.emp_declaration_form1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#immigration_d_form1').change(function(e) {
            if (e.target.value) {
                $('.immigration_d_form1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.immigration_d_form1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#medical_letter1').change(function(e) {
            if (e.target.value) {
                $('.medical_letter1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.medical_letter1View').removeClass("d-block").addClass("d-none");
            }
        });
        $('#other1').change(function(e) {
            if (e.target.value) {
                $('.other1View').removeClass("d-none").addClass("d-block");
            } else {
                $('.other1View').removeClass("d-block").addClass("d-none");
            }
        });
    });
</script>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/agent/upload-doc.blade.php ENDPATH**/ ?>