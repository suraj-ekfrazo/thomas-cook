@if ($inciDoc)
    @php
	//echo "<pre>";
	//count($inciDoc)>0 ? "somthing" : "else" ;
	//print_r($inciDoc); exit;
       	
	$passport_file_path = isset($inciDoc->incedent_doc->passport) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->passport) : "";

        $visa_file_path = isset($inciDoc->incedent_doc->visa) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->visa) : "";
        $pan_file_path = isset($inciDoc->incedent_doc->pan_card) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->pan_card) : "";
        $annex_file_path = isset($inciDoc->incedent_doc->annex) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->annex) : "";
        $ticket_file_path = isset($inciDoc->incedent_doc->ticket) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->ticket) : "";
        
        $sof_file_path = isset($inciDoc->incedent_doc->sof) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->sof) : "";
        $bank_transfer_file_path = isset($inciDoc->incedent_doc->bank_transfer) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->bank_transfer) : "";
        $apply_file_path = isset($inciDoc->incedent_doc->apply) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->apply) : "";
        $lerms_file_path = isset($inciDoc->incedent_doc->lerms_letter) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->lerms_letter) : "";
        $university_file_path = isset($inciDoc->incedent_doc->university_letter) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->university_letter) : "";
        $emp_letter_file_path = isset($inciDoc->incedent_doc->employment_letter) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->employment_letter) : "";
        $emp_form_file_path = isset($inciDoc->incedent_doc->emp_declaration_form) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->emp_declaration_form) : "";
        $immigration_form_file_path = isset($inciDoc->incedent_doc->immigration_d_form) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->immigration_d_form) : "";
        $medical_letter_file_path = isset($inciDoc->incedent_doc->medical_letter) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->medical_letter) : "";
        $refund_form_file_path = isset($inciDoc->incedent_doc->refound) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->refound) : "";
        $surrender_letter_file_path = isset($inciDoc->incedent_doc->surrender_letter) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->surrender_letter) : "";
 	$other_file_path = isset($inciDoc->incedent_doc->other) ? asset('allDocuments/' . date('Y-m-d', strtotime($inciDoc->created_at)) . '/' . $inciDoc->inci_number . '/' . $inciDoc->incedent_doc->other) : "";
        
        $pass = isset($inciDoc->incedent_doc->passport) ? explode('_', $inciDoc->incedent_doc->passport) : "";
        $visa = isset($inciDoc->incedent_doc->visa) ? explode('_', $inciDoc->incedent_doc->visa) : "" ;
        $pan = isset($inciDoc->incedent_doc->pan_card) ? explode('_', $inciDoc->incedent_doc->pan_card) : "";
        $annx = isset($inciDoc->incedent_doc->annex) ? explode('_', $inciDoc->incedent_doc->annex) : "";
        $ticket = isset($inciDoc->incedent_doc->ticket) ? explode('_', $inciDoc->incedent_doc->ticket) : "";
        $sof = isset($inciDoc->incedent_doc->sof) ? explode('_', $inciDoc->incedent_doc->sof) : "";
        $bank_transfer = isset($inciDoc->incedent_doc->bank_transfer) ? explode('_', $inciDoc->incedent_doc->bank_transfer) : "";
        $apply = isset($inciDoc->incedent_doc->apply) ? explode('_', $inciDoc->incedent_doc->apply) : "";
        $lerms = isset($inciDoc->incedent_doc->lerms_letter) ? explode('_', $inciDoc->incedent_doc->lerms_letter) : "";
        $emp_letter = isset($inciDoc->incedent_doc->employment_letter) ? explode('_', $inciDoc->incedent_doc->employment_letter) : "";
        $emp_form = isset($inciDoc->incedent_doc->emp_declaration_form) ? explode('_', $inciDoc->incedent_doc->emp_declaration_form) : "";
        $immigration_form = isset($inciDoc->incedent_doc->immigration_d_form) ? explode('_', $inciDoc->incedent_doc->immigration_d_form) : "";
        $medical = isset($inciDoc->incedent_doc->medical_letter) ? explode('_', $inciDoc->incedent_doc->medical_letter) : "";
        $refund_form = isset($inciDoc->incedent_doc->refound) ? explode('_', $inciDoc->incedent_doc->refound) : "";
        $surrender_letter = isset($inciDoc->incedent_doc->surrender_letter) ? explode('_', $inciDoc->incedent_doc->surrender_letter) : "";
        $other = isset($inciDoc->incedent_doc->other) ? explode('_', $inciDoc->incedent_doc->other) : "";
        
    @endphp
    <div class="row bgc m-3">
        <div class="col-lg-12 col-sm-12">
            <div class="d-flex justify-content  ">
                <div class="border-1"></div>
                {{-- <div class="ps-1">BIQ </div> --}}
                <div class="ps-1 fw-bold"> View Document </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 mt-3">
                <label style="color: #ADAEB0; font-size: 14px; ">Incident
                    Number</label>
                <div class="input-group mb-3">
                    <input class="form-control border-0 border-bottom bg-transparent " type="text"
                        value="{{ $inciDoc->inci_number }}" readonly>
                </div>
            </div>
        </div>
	
	@if(count( (array)$inciDoc->incedent_doc)  > 0)
	{{-- Passport --}}
        <div class="col-md-6">
            <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                <label class="form-attach-label" for="formFile">
                    <div class="d-flex mb-3 ">
                        <div class="text-dark fw-bold">Passport
                        </div>
                    </div>
                    <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                        &nbsp;<?= isset($pass[2]) ? substr($pass[2], 0, 4) . '...' : 'Not Found' ?></span>
                    @if (isset($pass[2]))
                        <a href="{{ $passport_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                            target="_blank"><i class="fa-solid fa-eye"></i></a>
                    @endif
                </label>
            </div>
            @if ($inciDoc->incedent_doc->passport_status == 2)

                <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->passport_comment }}</p>
            @endif

        </div>

        {{-- Lerms Letter --}}
        @if (($inciDoc->travel_type == 2 || $inciDoc->travel_type == 6) && ($inciDoc->inci_buy_sell_req == 1))
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Lerms Letter
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($lerms[2]) ? substr($lerms[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($lerms[2]))
                            <a href="{{ $lerms_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if (isset($inciDoc->incedent_doc->lerms_letter_status) && $inciDoc->incedent_doc->lerms_letter_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->lerms_letter_comment }}</p>
                @endif
            </div>
        @endif

        {{-- Visa --}}
        @if (($inciDoc->travel_type == 1 ||
            $inciDoc->travel_type == 3 ||
            $inciDoc->travel_type == 4 ||
            $inciDoc->travel_type == 5) && ($inciDoc->inci_buy_sell_req == 1) )
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Visa
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($visa[2]) ? substr($visa[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($visa[2]))
                            <a href="{{ $visa_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->visa_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->visa_comment }}</p>
                @endif
            </div>
        @endif

        {{-- Pan Card --}}
        @if($inciDoc->inci_buy_sell_req == 1)
        <div class="col-md-6">
            <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                <label class="form-attach-label" for="formFile">
                    <div class="d-flex mb-3 ">
                        <div class="text-dark fw-bold">Pan Card
                        </div>
                    </div>
                    <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                        &nbsp;<?= isset($pan[2]) ? substr($pan[2], 0, 4) . '...' : 'Not Found' ?></span>
                    @if (isset($pan[2]))
                        <a href="{{ $pan_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                            target="_blank"><i class="fa-solid fa-eye"></i></a>
                    @endif
                </label>
            </div>
            @if ($inciDoc->incedent_doc->pan_card_status == 2)
                <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->pan_card_comment }}</p>
            @endif
        </div>
        @endif
        {{-- Annexure --}}
        <div class="col-md-6">
            <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                <label class="form-attach-label" for="formFile">
                    <div class="d-flex mb-3 ">
                        <div class="text-dark fw-bold">Annexure
                        </div>
                    </div>
                    <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                        &nbsp;<?= isset($annx[2]) ? substr($annx[2], 0, 4) . '...' : 'Not Found' ?></span>
                    @if (isset($annx[2]))
                        <a href="{{ $annex_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                            target="_blank"><i class="fa-solid fa-eye"></i></a>
                    @endif
                </label>
            </div>
            @if ($inciDoc->incedent_doc->annex_status == 2)
                <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->annex_comment }}</p>
            @endif
        </div>

        {{-- Ticket --}}
        @if (($inciDoc->travel_type == 1 ||
            $inciDoc->travel_type == 3 ||
            $inciDoc->travel_type == 4 ||
            $inciDoc->travel_type == 5) && ($inciDoc->inci_buy_sell_req == 1))
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Ticket
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($ticket[2]) ? substr($ticket[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($ticket[2]))
                            <a href="{{ $ticket_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->ticket_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->ticket_comment }}</p>
                @endif
            </div>
        @endif

        {{-- Application --}}
        @if($inciDoc->inci_buy_sell_req == 1)
        <div class="col-md-6">
            <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                <label class="form-attach-label" for="formFile">
                    <div class="d-flex mb-3 ">
                        <div class="text-dark fw-bold">Application
                        </div>
                    </div>
                    <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                        &nbsp;<?= isset($apply[2]) ? substr($apply[2], 0, 4) . '...' : 'Not Found' ?></span>
                    @if (isset($apply[2]))
                        <a href="{{ $apply_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                            target="_blank"><i class="fa-solid fa-eye"></i></a>
                    @endif
                </label>
            </div>
            @if ($inciDoc->incedent_doc->apply_status == 2)
                <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->apply_comment }}</p>
            @endif
        </div>
        @endif

        {{-- Sof --}}
        @if (($inciDoc->travel_type == 1 ||
            $inciDoc->travel_type == 3 ||
            $inciDoc->travel_type == 4 ||
            $inciDoc->travel_type == 5) && ($inciDoc->inci_buy_sell_req == 1))
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Sof
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($sof[2]) ? substr($sof[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($sof[2]))
                            <a href="{{ $sof_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->sof_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->sof_comment }}</p>
                @endif
            </div>
        @endif

        {{-- Bank Transfer --}}
       @if (($inciDoc->travel_type != 1 || $inciDoc->travel_type != 2) && $inciDoc->incedent_doc->bank_transfer!='')
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Bank Transfer
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($bank_transfer[2]) ? substr($bank_transfer[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($bank_transfer[2]))
                            <a href="{{ $bank_transfer_file_path }}" class="svg-bg m-0 fw-bold"
                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->bank_transfer_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->bank_transfer_comment }}</p>
                @endif
            </div>
        @endif

        {{-- University Letter --}}
        @if ($inciDoc->travel_type == 4 && $inciDoc->inci_buy_sell_req == 1)
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">University Letter
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($university[2]) ? substr($university[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($university[2]))
                            <a href="{{ $university_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->university_letter_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->university_letter_comment }}</p>
                @endif
            </div>
        @endif
        {{-- Employment Letter --}}
        @if ($inciDoc->travel_type == 3 && $inciDoc->inci_buy_sell_req == 1)
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Employment Letter
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($emp_letter[2]) ? substr($emp_letter[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($emp_letter[2]))
                            <a href="{{ $emp_letter_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->emp_letter_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->emp_letter_comment }}</p>
                @endif
            </div>

            {{-- Employment Declaration Form --}}
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Employment Declaration Form
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($emp_form[2]) ? substr($emp_form[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($emp_form[2]))
                            <a href="{{ $emp_form_file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->emp_declaration_form_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->emp_declaration_form_comment }}</p>
                @endif
            </div>
        @endif
        {{-- Immigration Declararion Form --}}
        @if ($inciDoc->travel_type == 5 && $inciDoc->inci_buy_sell_req == 1)
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Immigration Declararion Form
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($immigration_form[2]) ? substr($immigration_form[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($immigration_form[2]))
                            <a href="{{ $immigration_form_file_path }}" class="svg-bg m-0 fw-bold"
                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->immigration_d_form_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->immigration_d_form_comment }}</p>
                @endif
            </div>
        @endif

        {{-- Medical Letter --}}
        @if ($inciDoc->travel_type == 6 && $inciDoc->inci_buy_sell_req == 1)
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Medical Letter
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($medical[2]) ? substr($medical[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($medical[2]))
                            <a href="{{ $medical_letter_file_path }}" class="svg-bg m-0 fw-bold"
                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->medical_letter_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->medical_letter_comment }}</p>
                @endif
            </div>
        @endif

        {{-- Refund Letter --}}
        @if ($inciDoc->inci_buy_sell_req == 0)
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Refund Form
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($refund_form[2]) ? substr($refund_form[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($refund_form[2]))
                            <a href="{{ $refund_form_file_path }}" class="svg-bg m-0 fw-bold"
                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->refound_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->refound_comment }}</p>
                @endif
            </div>
        @endif

        {{-- Surrender Letter --}}
        @if ($inciDoc->inci_buy_sell_req == 0 && $inciDoc->travel_type == 2)
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Surrender Letter
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($surrender_letter[2]) ? substr($surrender_letter[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($surrender_letter[2]))
                            <a href="{{ $surrender_letter_file_path }}" class="svg-bg m-0 fw-bold"
                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->surrender_letter_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->surrender_letter_comment }}</p>
                @endif
            </div>
        @endif
{{-- Other --}}
        @if ($inciDoc->inci_buy_sell_req == 1 && $inciDoc->travel_type !== 6 )
            <div class="col-md-6">
                <div class="form-attach-file border-bottom pt-1 pb-1 mt-4 ">
                    <label class="form-attach-label" for="formFile">
                        <div class="d-flex mb-3 ">
                            <div class="text-dark fw-bold">Other
                            </div>
                        </div>
                        <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">
                            &nbsp;<?= isset($other[2]) ? substr($other[2], 0, 4) . '...' : 'Not Found' ?></span>
                        @if (isset($other[2]))
                            <a href="{{ $other_file_path }}" class="svg-bg m-0 fw-bold"
                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i></a>
                        @endif
                    </label>
                </div>
                @if ($inciDoc->incedent_doc->other_status == 2)
                    <p class="text-danger mb-0">{{ $inciDoc->incedent_doc->other_comment }}</p>
                @endif
            </div>
        @endif
	@else
    <div class="row mt-3 bgc mb-5">
        <div class="col-lg-12 col-sm-12 mb-2">
            <div class="text-dark fw-bold text-center">Document not found
            </div>
        </div>
    </div>
@endif



    </div>
@else
    <div class="row mt-3 bgc mb-5">
        <div class="col-lg-12 col-sm-12 mb-2">
            <div class="text-dark fw-bold text-center">Document not found
            </div>
        </div>
    </div>
@endif
