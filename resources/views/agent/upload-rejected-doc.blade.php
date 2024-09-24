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
                value="{{ $inci_id }}" readonly />
            <input type="hidden" name="agent_code" value="{{ $agentcode }}">
            <input type="hidden" name="upload_date" value="{{ date('Y-m-d',strtotime($agentdata->created_at)) }}">

        </div>
    </div>


	 @if (isset($selldata->passport_status) && ($selldata->passport_status == 2 || $selldata->passport_status == 3 ))
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1 ">
                <label class="form-attach-label" for="passport2">
                    <div class="text-dark fw-bold">Passport *</div>
                    <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg"> &nbsp;Browse or
                        drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="passport2" name="passport2" required>
            </div>
        </div>
        <p class="text-danger">{{ $selldata->passport_comment }}</p> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="passport2">
                <div class="text-dark fw-bold">Passport
                    @if($selldata->passport_status == 2)
                        <span class="text-danger">*</span>
                    @endif
                </div>
                <div class="col-md-12 text-end passport2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('passport2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="passport2" name="passport2"

                    @if($selldata->passport_status == 2)
                        required
                    @endif
            >
        </div>
    </div>
    <p class="text-danger">{{ $selldata->passport_comment }}</p>
    @endif
    @if (isset($selldata->visa_status) && ($selldata->visa_status == 2 || $selldata->visa_status == 3) &&
        ($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5))
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1 ">
                <label class="form-attach-label" for="visa2">
                    <div class="text-dark fw-bold">Visa *</div>
                    <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">&nbsp;Browse or
                        drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="visa2" name="visa2" required>
            </div>
        </div>
        <p class="text-danger">{{ $selldata->visa_comment }}</p> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="visa2">
                <div class="text-dark fw-bold">Visa

                    @if($selldata->visa_status == 2)
                        <span class="text-danger">*</span>
                    @endif


                </div>
                <div class="col-md-12 text-end visa2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('visa2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="visa2" name="visa2"

                @if($selldata->visa_status == 2)
                    required
                @endif

            >
        </div>
    </div>
    <p class="text-danger">{{ $selldata->visa_comment }}</p>
    @endif

    @if (isset($selldata->ticket_status) && ($selldata->ticket_status == 2 || $selldata->ticket_status == 3) &&
        ($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5))
	    <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="ticket2">
                    <div class="text-dark fw-bold">Ticket</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="ticket2" name="ticket2" required>
            </div>
        </div>
        <p class="text-danger">{{ $selldata->ticket_comment }}</p> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="ticket2">
                <div class="text-dark fw-bold">Ticket</div>
                <div class="col-md-12 text-end ticket2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('ticket2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="ticket2" name="ticket2" required>
        </div>
    </div>
    <p class="text-danger">{{ $selldata->ticket_comment }}</p>
    @endif

    @if (isset($selldata->pan_card_status) && ($selldata->pan_card_status == 2 || $selldata->pan_card_status == 3))
    <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="pan2">
                <div class="text-dark fw-bold">PAN

                    @if($selldata->pan_card_status == 2)
                        <span class="text-danger">*</span>
                    @endif


                </div>
                <div class="col-md-12 text-end pan2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('pan2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="pan2" name="pan2"
                @if($selldata->pan_card_status == 2)
                    required
                @endif
            >
        </div>
    </div>
    <p class="text-danger">{{ $selldata->pan_card_comment }}</p>
    @endif

    @if (isset($selldata->apply_status) && ($selldata->apply_status == 2 || $selldata->apply_status == 3))
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="application2">
                    <div class="text-dark fw-bold">Application</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="application2" name="application2" required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="application2">
                <div class="text-dark fw-bold">Application

                    @if($selldata->apply_status == 2)
                        <span class="text-danger">*</span>
                    @endif


                </div>
                <div class="col-md-12 text-end application2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('application2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="application2" name="application2"

            @if($selldata->apply_status == 2)
                rerquired
            @endif

            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->apply_comment }}</p>
    @endif
    <?php 
    
        
    ?>
    @if (isset($selldata->annex_status) && ($selldata->annex_status == 2 || $selldata->annex_status == 3))
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1 ">
                <label class="form-attach-label" for="annexure2">
                    <div class="text-dark fw-bold">Annexure *</div>
                    <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">&nbsp;Browse or
                        drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="annexure2" name="annexure2" required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="annexure2">
                <div class="text-dark fw-bold">Annexure

                    @if($selldata->annex_status == 2)
                        <span class="text-danger">*</span>
                    @endif

                </div>
                <div class="col-md-12 text-end annexure2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('annexure2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="annexure2" name="annexure2"

            @if($selldata->annex_status == 2)
                required
            @endif

            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->annex_comment }}</p>
    @endif
      @if (isset($selldata->bank_transfer_status) && ($selldata->bank_transfer_status == 2 || $selldata->bank_transfer_status == 3))
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="banktransfer2">
                    <div class="text-dark fw-bold">Bank Transfer Copy *</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="banktransfer2" name="banktransfer2" required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="banktransfer2">
                <div class="text-dark fw-bold">Bank Transfer Copy

                    @if($selldata->bank_transfer_status == 2)
                        <span class="text-danger">*</span>
                    @endif


                </div>
                <div class="col-md-12 text-end banktransfer2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('banktransfer2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="banktransfer2" name="banktransfer2"

                @if($selldata->bank_transfer_status == 2)
                    required
                @endif
            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->bank_transfer_comment }}</p>
    @endif

    @if (isset($selldata->sof_status) && ($selldata->sof_status == 2 || $selldata->sof_status == 3) &&
        ($travel_type == 1 || $travel_type == 3 || $travel_type == 4 || $travel_type == 5))
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="sof2">
                    <div class="text-dark fw-bold">SOF</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="sof2" name="sof2" required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="sof2">
                <div class="text-dark fw-bold">SOF
                    @if($selldata->sof_status == 2)
                        <span class="text-danger">*</span>
                    @endif

                </div>
                <div class="col-md-12 text-end sof2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('sof2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="sof2" name="sof2"

            @if($selldata->sof_status == 2)
                required
                @endif
            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->sof_comment }}</p>
    @endif

    @if (isset($selldata->lerms_letter_status) && ($selldata->lerms_letter_status == 2 || $selldata->lerms_letter_status == 3) && ($travel_type == 2 || $travel_type == 6))
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="lerms_letter2">
                    <div class="text-dark fw-bold">Lerms Letter</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="lerms_letter2" name="lerms_letter2" required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="lerms_letter2">
                <div class="text-dark fw-bold">Lerms Letter

                    @if($selldata->lerms_letter_status == 2)
                    <span class="text-danger">*</span>
                @endif


                </div>
                <div class="col-md-12 text-end lerms_letter2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('lerms_letter2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="lerms_letter2" name="lerms_letter2"
            @if($selldata->lerms_letter_status == 2)
            required
        @endif
            >
        </div>
    </div>

        <p class="text-danger">{{ $selldata->lerms_letter_comment }}</p>
    @endif

    @if (isset($selldata->university_letter_status) && ($selldata->university_letter_status == 2 || $selldata->university_letter_status == 3) && $travel_type == 4)
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="university_letter2">
                    <div class="text-dark fw-bold">University Letter *</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="university_letter2" name="university_letter2"
                    required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="university_letter2">
                <div class="text-dark fw-bold">University Lette

                    @if($selldata->university_letter_status == 2)
                    <span class="text-danger">*</span>
                @endif


                </div>
                <div class="col-md-12 text-end university_letter2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('university_letter2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="university_letter2"
            name="university_letter2"

            @if($selldata->university_letter_status == 2)
                required
        @endif

            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->university_letter_comment }}</p>
    @endif

    @if (isset($selldata->emp_letter_status) && ($selldata->emp_letter_status == 2 || $selldata->emp_letter_status == 3) && $travel_type == 3)
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="employment_letter2">
                    <div class="text-dark fw-bold">Employment Letter *</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="employment_letter2" name="employment_letter2"
                    required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="employment_letter2">
                <div class="text-dark fw-bold">Employment Letter

                    @if($selldata->emp_letter_status == 2)
                    <span class="text-danger">*</span>

            @endif


                </div>
                <div class="col-md-12 text-end employment_letter2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('employment_letter2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="employment_letter2"
            name="employment_letter2"

            @if($selldata->emp_letter_status == 2)
                required
            @endif

            >


        </div>
    </div>
        <p class="text-danger">{{ $selldata->emp_letter_comment }}</p>
    @endif
    @if (isset($selldata->emp_declaration_form_status) && ($selldata->emp_declaration_form_status == 2 || $selldata->emp_declaration_form_status == 3) && $travel_type == 3)
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="emp_declaration_form2">
                    <div class="text-dark fw-bold">Employment Declaration Form</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="emp_declaration_form2" name="emp_declaration_form2"
                    required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="emp_declaration_form2">
                <div class="text-dark fw-bold">Employment Declaration Form
                    @if($selldata->emp_declaration_form_status == 2)
                        <span class="text-danger">*</span>
                    @endif


                </div>
                <div class="col-md-12 text-end emp_declaration_form2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('emp_declaration_form2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="emp_declaration_form2"
            name="emp_declaration_form2"
            @if($selldata->emp_declaration_form_status == 2)
                       required
                    @endif
            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->emp_declaration_form_comment }}</p>
    @endif


    @if (isset($selldata->immigration_d_form_status) && ($selldata->immigration_d_form_status == 2 || $selldata->immigration_d_form_status == 3) && $travel_type == 5)
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="immigration_d_form2">
                    <div class="text-dark fw-bold">Immigration Declaration form</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="immigration_d_form2" name="immigration_d_form2"
                    required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="immigration_d_form2">
                <div class="text-dark fw-bold">Immigration Declaration form

                    @if($selldata->immigration_d_form_status == 2)
                    <span class="text-danger">*</span>
                 @endif


                </div>
                <div class="col-md-12 text-end immigration_d_form2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('immigration_d_form2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="immigration_d_form2"
            name="immigration_d_form2"

            @if($selldata->immigration_d_form_status == 2)
                   required
                 @endif
            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->immigration_d_form_comment }}</p>
    @endif

    @if (isset($selldata->medical_letter_status) && ($selldata->medical_letter_status == 2 || $selldata->medical_letter_status == 3) && $travel_type == 6)
        <!-- <div class="col-md-12">
            <div class="form-attach-file border-top pt-1 pb-1">
                <label class="form-attach-label" for="medical_letter2">
                    <div class="text-dark fw-bold">Medical Letter</div>
                    <span class="pe-5 me-3 ps-1">
                        <img src="../assets/svg/14.svg">
                        &nbsp;Browse or drag & drop</span>
                    <img src="../assets/svg/16.svg">
                </label>
                <input class="form-control" type="file" id="medical_letter2" name="medical_letter2" required>
            </div>
        </div> -->
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="medical_letter2">
                <div class="text-dark fw-bold">Medical Letter

                    @if($selldata->medical_letter_status == 2)
                    <span class="text-danger">*</span>
                 @endif



                </div>
                <div class="col-md-12 text-end medical_letter2View d-none">
                    <button type="button" class="btn btn-primary btn-sm"
                    onclick="readFile('medical_letter2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="medical_letter2" name="medical_letter2"

            @if($selldata->medical_letter_status == 2)
          required
         @endif
            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->medical_letter_comment }}</p>
    @endif

	  @if (isset($selldata->other_status) && ($selldata->other_status == 2 || $selldata->other_status == 3 ))
        <div class="col-md-12">
        <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
            <label class="form-attach-label row mb-1" for="other2">
                <div class="text-dark fw-bold">Other</div>
                <div class="col-md-12 text-end other2View d-none">
                    <button type="button" class="btn btn-primary btn-sm" onclick="readFile('other2')"><i class="fa-solid fa-eye"></i></button>
                </div>
            </label>
            <input class="form-control" type="file" id="other2" name="other2"
            @if($selldata->other_status == 2)
            required
           @endif

            >
        </div>
    </div>
        <p class="text-danger">{{ $selldata->other_comment }}</p>
    @endif

    @if (isset($selldata->surrender_letter_status) && ($selldata->surrender_letter_status == 2 || $selldata->surrender_letter_status == 3) && $selldata->surrender_letter != '')
        <div class="col-md-12">
            <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                <label class="form-attach-label row mb-1" for="surrender_letter2">
                    <div class="text-dark fw-bold">Surrender Letter</div>
                    <div class="col-md-12 text-end surrender_letter2View d-none">
                        <button type="button" class="btn btn-primary btn-sm" onclick="readFile('surrender_letter2')"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </label>
                <input class="form-control" type="file" id="surrender_letter2"
                name="surrender_letter2"

                @if($selldata->surrender_letter_status == 2)
                required
               @endif

                >
            </div>
        </div>
        <p class="text-danger">{{ $selldata->surrender_letter_comment }}</p>
    @endif

    @if (isset($selldata->refound_status) && ($selldata->refound_status == 2 || $selldata->refound_status == 3))
        <div class="col-md-12">
            <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                <label class="form-attach-label row mb-1" for="refound2">
                    <div class="text-dark fw-bold">Refund Form</div>
                    <div class="col-md-12 text-end refound2View d-none">
                        <button type="button" class="btn btn-primary btn-sm" onclick="readFile('refound2')"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </label>
                <input class="form-control" type="file" id="refound2" name="refound2" required>
            </div>
        </div>
        <p class="text-danger">{{ $selldata->refound_comment }}</p>
    @endif

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
	$('#surrender_letter2').change(function(e) {
            if (e.target.value) {
                $('.surrender_letter2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.surrender_letter2View').removeClass("d-block").addClass("d-none");
            }
        });
	$('#refound2').change(function(e) {
            if (e.target.value) {
                $('.refound2View').removeClass("d-none").addClass("d-block");
            } else {
                $('.refound2View').removeClass("d-block").addClass("d-none");
            }
        });
    });
</script>
