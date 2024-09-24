@extends('layouts.admin.app')
@section('content')
<div class="w-100 bg-cover flickity-cell is-selected" style="background-image: url({{ asset('admin-assets/img/admin/heading.jpg') }}); transform: translateX(0%); opacity: 1;">
    <div class="bg-dark-20">
        <div class=" container  justify-content-between">
            <div class=" " style="min-height: 150px;">
                <div class="d-flex pt-5">
                    <a href="{{ route('dashboard.index') }}" class="D-icon">
                        <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                    </a>

                    <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;"><a class="text-light" href="{{ route('admin-incident-requests.index') }}">View All Request</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="background-image: url({{ asset('admin-assets/img/main_bg.jpg') }});">
    <div class="container">
        @if (\Session::has('error'))
        <div class="alert alert-danger">
            {!! \Session::get('error') !!}
        </div>
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success">
            {!! \Session::get('success') !!}
        </div>
        @endif
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
                            {{ $incidentDetails->inci_passport_number }}
                        </th>
                        <th style="color: #2565ab; font-weight: 800;">Departure Date :
                            {{ $incidentDetails->inci_departure_date=="" && $incidentDetails->inci_departure_date=="1970-01-01" ? '' : date('d-m-Y', strtotime($incidentDetails->inci_departure_date)) }}
                        </th>
                        <th style="color: #2565ab; font-weight: 800;">Buy/Sell :
                            @if ($incidentDetails->inci_buy_sell_req == '0')
                            Buy
                            @else
                            Sell
                            @endif
                        </th>
                    </tr>
                </thead>
            </table>

            <table class="table roundedTable table w-100 nowrap">
                <thead style="backgrounD-color: #F4F6F8;">
                    <tr>
                        <th style="color: #2565ab; font-weight: 800;">Card No. :
                            {{ $incidentDetails->inci_forex_card_no }}
                        </th>
                        <th style="color: #2565ab; font-weight: 800;">Incident Number :
                            {{ $incidentDetails->inci_number }}
                        </th>
                        <th style="color: #2565ab; font-weight: 800;">Transaction Type :
                            @if ($incidentDetails->transaction_type == '0')
                            Reload
                            @else
                            Activation
                            @endif
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
                        @foreach ($currencyRecords as $currency)
                        <tr>
                            <td>{{ $currency->inci_currency_type }}</td>
                            <td>{{ $currency->inci_currency_rate }}</td>
                            <td>{{ $currency->inci_frgn_curr_amount }}</td>
                            <td>{{ $currency->inci_inr_amount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th><b>Total</b></th>
                            <th id="total" data-total="0.0">{{ $currencyRecords->sum('inci_inr_amount') }}</th>
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
                @if ($incidentImageDetails->count() == 0)
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
                                    <a href="{{ asset('public/allDocuments/' . $incidentUpdateDetails->inci_recived_date . '/' . $incidentDetails->inci_number ) }}" target="_blank" download="<?php //echo $Passport; ?>">
                                        {{-- Download <i class="fas fa-download"></i> --}}
                                        <img src="#" alt="img">
                                    </a>
                                </td>
                                <td><i class="fas fa-check"></i></td>
                            </tr>
                        </tbody>-->
                    </table>
                </div>
                @else
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
                            @php
                            $count = 1;
				//print_r($incidentImageDetails);
				//echo $incidentImageDetails[0]->passport_status;
                            @endphp
				
                            @foreach ($incidentImageDetails as $document)

                            @if ($incidentDetails->inci_buy_sell_req == 1)
                            @php
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
			   @endphp
                            @if (isset($document->passport) && $document->passport != '')
                            <tr class="{{ $passStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>Passport</td>
                                <td>Mandatory</td>
                               
                                <td>
                                    @php

                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->passport);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>

                                    @if ($passStatus == 2 || $passStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[pass_status]" id="option1" value="4" autocomplete="off" @if($passStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[pass_status]" id="option2" value="2" autocomplete="off" @if($passStatus==2) {{"checked"}} @endif> Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->visa) && $document->visa != '')
                            <tr class="{{ $visaStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>Visa</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->visa);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($visaStatus == 2 || $visaStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[visa_status]" id="option1" value="4" autocomplete="off" @if($visaStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[visa_status]" id="option2" value="2" autocomplete="off" @if($visaStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->ticket) && $document->ticket != '')
                            <tr class="{{ $tiketStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>Tiket</td>
                                <td>Mandatory</td>
                               
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->ticket);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($tiketStatus == 2 || $tiketStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[tiket_status]" id="option1" value="4" autocomplete="off" @if($tiketStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[tiket_status]" id="option2" value="2" autocomplete="off" @if($tiketStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->pan_card) && $document->pan_card != '')
                            <tr class="{{ $panStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>Pan</td>
                                <td>Mandatory</td>
                               
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->pan_card);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($panStatus == 2 || $panStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[pan_status]" id="option1" value="4" autocomplete="off" @if($panStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[pan_status]" id="option2" value="2" autocomplete="off" @if($panStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif 
                        @if (isset($document->apply) && $document->apply != '') 
                            <tr class="{{ $appliStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>Application</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->apply);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($appliStatus == 2 || $appliStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[appli_status]" id="option1" value="4" autocomplete="off" @if($appliStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[appli_status]" id="option2" value="2" autocomplete="off" @if($appliStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif

                                </td>
                            </tr>
                            @endif
                        @if (isset($document->annex) && $document->annex != '') 
                            <tr class="{{ $annexStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>annex</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->annex);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>

                                    @if ($annexStatus == 2 || $annexStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[annex_status]" id="option1" value="4" autocomplete="off" @if($annexStatus==4) {{"checked"}} @endif > Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[annex_status]" id="option2" value="2" autocomplete="off" @if($annexStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->bank_transfer) && $document->bank_transfer != '') 
                            <tr class="{{ $bankStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>bank_transfer</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->bank_transfer);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                            
                                <td>
                                    @if ($bankStatus == 2 || $bankStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[bank_status]" id="option1" value="4" autocomplete="off" @if($bankStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[bank_status]" id="option2" value="2" autocomplete="off" @if($bankStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->inci_up_business) && $document->inci_up_business != '')
                            <tr class="{{ $businessStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>business</td>
                                <td>Mandatory</td>
                               
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->business);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($businessStatus == 2 || $businessStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[business_status]" id="option1" value="4" autocomplete="off" @if($businessStatus==4) {{"checked"}} @endif>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[business_status]" id="option2" value="2" autocomplete="off" @if($businessStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->sof) && $document->sof != '')
                            <tr class="{{ $sofStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>sof</td>
                                <td>Mandatory</td> 
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->sof);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($sofStatus == 2 || $sofStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[sof_status]" id="option1" value="4" autocomplete="off" @if($sofStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[sof_status]" id="option2" value="2" autocomplete="off" @if($sofStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                       
                        @if (isset($document->lerms_letter) && $document->lerms_letter != '')
                            <tr class="{{ $lermsStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>Lerms Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->lerms_letter);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($lermsStatus == 2 || $lermsStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[lerms_status]" id="option1" value="4" autocomplete="off" @if($lermsStatus==4) {{"checked"}} @endif>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[lerms_status]" id="option2" value="2" autocomplete="off" @if($lermsStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->university_letter) && $document->university_letter != '')
                            <tr class="{{ $universityStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>university Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->university_letter);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($universityStatus == 2 || $universityStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[university_status]" id="option1" value="4" autocomplete="off" @if($universityStatus==4) {{"checked"}} @endif>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[university_status]" id="option2" value="2" autocomplete="off" @if($universityStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->employment_letter) && $document->employment_letter != '')
                            <tr class="{{ $employmentStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>employment Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->employment_letter);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($employmentStatus == 2 || $employmentStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[employment_status]" id="option1" value="4" autocomplete="off" @if($employmentStatus==4) {{"checked"}} @endif>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[employment_status]" id="option2" value="2" autocomplete="off" @if($employmentStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif


                        @if (isset($document->immigration_d_form) && $document->immigration_d_form != '')
                            <tr class="{{ $immigrationStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>immigration Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->immigration_d_form);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($immigrationStatus == 2 || $immigrationStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[immigration_status]" id="option1" value="4" autocomplete="off" @if($immigrationStatus==4) {{"checked"}} @endif>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[immigration_status]" id="option2" value="2" autocomplete="off" @if($immigrationStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if (isset($document->medical_letter) && $document->medical_letter != '')
                            <tr class="{{ $medicalStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>medical Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->medical_letter);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($medicalStatus == 2 || $medicalStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[medical_status]" id="option1" value="4" autocomplete="off" @if($medicalStatus==4) {{"checked"}} @endif>
                                            Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[medical_status]" id="option2" value="2" autocomplete="off" @if($medicalStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
			@if (isset($document->other) && $document->other != '')
                            <tr class="{{ $otherStatusClass }}">
                                <td>{{ $count++ }}</td>
                                <td>Other</td>
                                <td>Not Mandatory</td>
                                <td>
                                    @php
                                        $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentUpdateDetails->inci_recived_date)) . '/' . $incidentDetails->inci_number . '/' . $document->other);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($otherStatus == 2 || $otherStatus == 4)
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn bg-olive active">
                                                <input type="radio" name="document[other_status]" id="option1" value="4" autocomplete="off" @if($otherStatus==4) {{"checked"}} @endif>
                                                Approved
                                            </label>
                                            <label class="btn bg-danger">
                                                <input type="radio" name="document[other_status]" id="option2" value="2" autocomplete="off" @if($otherStatus==2) {{"checked"}} @endif>
                                                Reject
                                            </label>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                            @else
                            @php
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
                            @endphp

                            <tr class="{{ $passStatusClass }}">
                                <td>{{ $doc_count++ }}</td>
                                <td>Passport </td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->passport);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($passStatus == 2 || $passStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[pass_status]" id="option1" value="4" autocomplete="off" @if($passStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[pass_status]" id="option2" value="2" autocomplete="off" @if($passStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <tr class="{{ $refoundStatusClass }}">
                                <td>{{ $doc_count++ }}</td>
                                <td>Refound</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->refound);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($refoundStatus == 2 || $refoundStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[refound_status]" id="option1" value="4" autocomplete="off" @if($refoundStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[refound_status]" id="option2" value="2" autocomplete="off" @if($refoundStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <tr class="{{ $annexStatusClass }}">
                                <td>{{ $doc_count++ }}</td>
                                <td>Annex</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->annex);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <td>
                                    @if ($annexStatus == 2 || $annexStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[annex_status]" id="option1" value="4" autocomplete="off" @if($annexStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[annex_status]" id="option2" value="2" autocomplete="off" @if($annexStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @if (isset($document->surrender_letter) && $document->surrender_letter != '')
                            <tr class="{{ $surrenderStatusClass }}">
                                <td>{{ $doc_count++ }}</td>
                                <td>Surrender Letter</td>
                                <td>Mandatory</td>
                                <td>
                                    @php
                                    $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->surrender_letter);
                                    @endphp
                                    <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                </td>
                                <?php
                                echo ($document->surrender_letter);
                                ?>
                                <td>
                                    @if ($surrenderStatus == 2 || $surrenderStatus == 4)
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn bg-olive active">
                                            <input type="radio" name="document[surrender_status]" id="option1" value="4" autocomplete="off" @if($surrenderStatus==4) {{"checked"}} @endif> Approved
                                        </label>
                                        <label class="btn bg-danger">
                                            <input type="radio" name="document[surrender_status]" id="option2" value="2" autocomplete="off" @if($surrenderStatus==2) {{"checked"}} @endif>
                                            Reject
                                        </label>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                            @if (isset($document->inci_up_other) && $document->inci_up_other != '')
                                <tr class="{{ $otherStatusClass }}">
                                    <td>{{ $doc_count++ }}</td>
                                    <td>Other</td>
                                    <td>Mandatory</td>
                                
                                    <td>
                                        @php
                                        $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($incidentDetails->created_at)) . '/' . $incidentDetails->inci_number . '/' . $document->other);
                                        @endphp
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                    </td>
                                    <td>
                                        @if ($otherStatus == 2 || $otherStatus == 4)
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn bg-olive active">
                                                <input type="radio" name="document[other_status]" id="option1" value="4" autocomplete="off" @if($otherStatus==4) {{"checked"}} @endif>
                                                Approved
                                            </label>
                                            <label class="btn bg-danger">
                                                <input type="radio" name="document[other_status]" id="option2" value="2" autocomplete="off" @if($otherStatus==2) {{"checked"}} @endif>
                                                Reject
                                            </label>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            @endif
                            @php
                            $count++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($documentComments->count() >= 1)
                <div id="document-comment">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="comment-list-wrap">
                                <ul class="list-group">
                                    @if ($documentComments->count() >= 1)
                                    @foreach ($documentComments as $comments)
                                    @if ($comments->tc_key != '')
                                    @if ($comments->tc_key == 'Admin')
                                    <li class="list-group-item tc-comment admin-comment">
                                        <p>{{ $comments->comment }}
                                        <p>
                                            <span>@ADMIN:
                                                {{ $comments->created_at }}</span>
                                            <span></span>
                                    </li>
                                    @else
                                    <li class="list-group-item tc-comment">
                                        <p>{{ $comments->comment }}
                                        <p>
                                            <span>@TC:
                                                {{ $comments->created_at }}</span>
                                            <span></span>
                                    </li>
                                    @endif
                                    @else
                                    <li class="list-group-item agent-comment">
                                        <p>{{ $comments->comment }}
                                        <p>
                                            <span>@Agent:
                                                {{ $comments->created_at }}</span>
                                            <span></span>
                                    </li>
                                    @endif
                                    @endforeach
                                    @else
                                    <li class="list-group-item">No Comment Added by agent</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif


                <div class="container">
                <div class="col-md-12" id="fbcomment">
                    <div class="body_comment">
                        <h5>Rejection Summary</h5>
                        <div class="row">
                            <ul id="list_comment" class="col-md-12">
                               

                                @php
                                    $comments = DB::table('incident_document_comments')
                                    ->where('incident_id',$incidentDetails->inci_number)
                                    ->orderBy('id','desc')
                                    ->simplePaginate(7);
                                @endphp

                                @forelse($comments as $key=>$value)


                                <li class="box_result row">
                                    <div class="avatar_comment col-md-1">
                                        @php
                                            $user = App\User::where('id',$value->user_id)->first();
					    $keyData = ucFirst(str_replace('_', ' ', $value->key));
                                        @endphp
                                        <img src="{{isset($user) && $user ? url('users/admin/profile').'/'.$user->user_profile : url('users/admin/profile/1660019563.png')}}" alt="avatar"/>
                                    </div>

                                    <div class="result_comment col-md-11">
                                        <h4>{{isset($user) && $user  ? $user->name : "Admin"}}</h4>
					

                                        <p>Document :- {{ucFirst(str_replace('status', ' ', $keyData))}}</p>
                                        <p>Comment :- {{$value->comment}}</p>

                                        <div class="tools_comment">
                                            <i class="fa fa-calendar" style="font-size:13px"></i>
                                            <span>{{date('d-m-Y h:i:s A',strtotime($value->created_at))}}</span>
                                        </div>
                                    </div>
                                </li>


                                @empty
                                <h6 class="text-center">No comments Found!</h6>
                                @endforelse 

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
{{-- <style>
        a,
        a:hover {
            color: #0e52c1
        }
    </style> --}}
@endsection