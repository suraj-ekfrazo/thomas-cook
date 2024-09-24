@extends('layouts.tcuser.appmain')
@section('content')
<!-- togoole button -->
    @csrf
      <?php   $count = 1; ?>
    <div class="" id="loading_div" style="display:none;">Loading&#8230;</div>


    <nav class="navbar navbar-expand-lg navbar-default rounded-top rounded-4 ">
        <div class="container-fluid px-0">
            <div class="d-flex">
                <a class="navbar-brand" href="{{ route('tcuser.dashboard')  }}"><img src="../assets/images/LOGO.png" class="img-fluid"
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
                  <input type="hidden" name="userid" id="userid" value="{{ $userid }}">
                    <input type="hidden" name="userid" id="userid" value="{{ $login_status}}">
                    <div class="ms-auto mt-3 mt-lg-0 text-center">

                    <label class="fw-bold" style="margin-right: 15px; font-size:15px;">{{$username}}</label>

                <label class="switch" id="online_status">
                    <!-- <input type="checkbox"  checked> -->
                    <input class="form-check-input login_status" type="checkbox"
                                                                data-id="{{$userid}}"
                                                                value="on"
                                                                {{ $login_status == 1 ? 'checked' : '' }}>
                    <span class="slider round"></span>

                </label>
                    <a href="{{ Route('tcuser.logout') }}"
                        class="btn btn-dark btn-sm ms-3 rounded-0 text-capitalize">&nbsp;&nbsp;&nbsp;Logout&nbsp;&nbsp;&nbsp;</a>
                    {{-- <!-- <a href="#" class="btn btn-dark btn-sm ms-3 rounded-0 text-capitalize">&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;</a>
                                                                                                                                                                                                                                                <a href="#" class="btn btn-outline btn-sm ms-3 rounded-0 text-capitalize">Sign up</a> --> --}}
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
            {{--  <div class="btn-buy">
                    <div class="btn5">Buy</div>
                    <div class="btn6">Buy</div>
                </div> --}}
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
                @foreach ($currencydata as $value)
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
                                    <img src="../assets/img/{{ $value->flag }}">
                                </span>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold">{{ $value->currency_name_key }}</div>
                                <div class="row-font border-0 border-bottom">@if($value->currency_name_key=='JPY') {{ number_format((float) $buy_rate, 4, '.', '') }} @else {{ number_format((float) $buy_rate, 2, '.', '') }} @endif</div>
                                <div class="row-font1">@if($value->currency_name_key=='JPY') {{ number_format((float) $final_rate, 4, '.', '') }} @else {{ number_format((float) $final_rate, 2, '.', '') }}  @endif</div>
                            </div>
                        </div>
                    </div>
                @endforeach

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

            @if ($bookingDetail && ($bookingDetail->doc_type == 1 ))
		@if ($bookingDetail)
		<div class="bgc">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Incident Number</label>
                            <div class="input-group mb-3">
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    placeholder="Enter Incident Number" readonly
                                    value="{{ $bookingDetail->inci_number ? $bookingDetail->inci_number : '' }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Card Number</label>
                            <div class="input-group mb-3">
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    placeholder="Enter Card Number" readonly
                                    value="{{ $bookingDetail->inci_forex_card_no ? $bookingDetail->inci_forex_card_no : '' }}">
                            </div>
                        </div>
			<div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Agent BPC ID</label>
                            <div class="input-group mb-3">
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                        readonly
                                       value="{{ $bookingDetail['agentDetail'] ? $bookingDetail['agentDetail']['agent_code'] : '' }}">
                            </div>
                        </div>

                        {{-- <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Entity Number</label>
                            <div class="input-group mb-3">
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    placeholder="Enter Card Number">
                            </div>
                        </div> --}}
                        <div class="col-lg-4 col-sm-4 mt-3 ">
                            <label class="">Transaction Type</label>
                            <div class="input-group mb-3">

                                @php
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

                                @endphp
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    readonly value="{{ $transaction_type }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Buy/Sell</label>
                            <div class="input-group mb-3">
                                @php
                                    $document = '';
                                    if ($bookingDetail->inci_buy_sell_req == 0) {
                                        $document = 'Buy';
                                    } else {
                                        $document = 'Sell';
                                    }
                                @endphp
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    readonly value="{{ $document }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Travel Type</label>
                            <div class="input-group mb-3">
                                @php
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
                                @endphp
                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    readonly value="{{ $traveltype }}">
                            </div>
                        </div>
                        <?php if ($bookingDetail->inci_buy_sell_req == 1){ ?>
                        <div class="col-lg-4 col-sm-4 mt-3">
                            <label class="">Date of Departure</label>
                            <div class="input-group mb-3">

                                <input class="form-control border-0 border-bottom p-2 bg-transparent" type="text"
                                    readonly value="{{ $departure_date }}">
                            </div>
                        </div>
                        <?php } ?>

			<div class="col-lg-12 col-sm-12 mt-3">
                            <label class="">Document Comment</label>
                            <div class="input-group mb-3">

                                <textarea class="form-control border-0 border-bottom p-2 bg-transparent" name="upload_doc_comment" id="upload_doc_comment"
                                          readonly >{{ $bookingDetail->upload_doc_comment }}</textarea>
                            </div>
                        </div>
			<div class="col-lg-12 col-sm-12 mt-3">
                            <label class="">Agent Comment</label>
                            <div class="input-group mb-3">

                                <textarea class="form-control border-0 border-bottom p-2 bg-transparent" name="incident_comment" id="incident_comment"
                                          readonly >{{ $bookingDetail->comment }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>

                @if ($InciCurrency)
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
                                @if ($InciCurrency)
                                    @php
                                        $total_amount = 0;
                                    @endphp
                                    @foreach ($InciCurrency as $curreny_val)
                                        @php
                                            $total_amount += $curreny_val->iia;
                                        @endphp
                                        <tr>
                                            <td scope="row" style="background-color: #DDE4ED; border-radius: 10px;  ">
                                                {{ isset($curreny_val->icy) ? $curreny_val->icy : '' }}
                                            </td>
                                            <td style="background-color: #DDE4ED; border-radius: 10px; ">
                                                {{ isset($curreny_val->ifca) ? $curreny_val->ifca : '' }}
                                            </td>
                                            <td style="background-color: #DDE4ED; border-radius: 10px;   ">
                                                {{ isset($curreny_val->icr) ? $curreny_val->icr : '' }}
                                            </td>
                                            <td style="background-color: #DDE4ED; border-radius: 10px;   ">
                                                {{ isset($curreny_val->iia) ? $curreny_val->iia : '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
                                        {{ number_format($total_amount, 2) }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif


                <div class="d-flex mt-3 mb-3">
                    <div class="border-1"></div>
                    <div class="ps-1 "> Block </div>
                    <div class="ps-1 fw-bold">Rate</div>
                    {{-- <div class="ms-auto d-flex">
                        <div class="    align-items-center ps-1"> </span> <span
                                style="color: #FF9E2E; font-weight:700; background-color: #FFF2D1;  padding: 7px; border-radius: 10px;">
                                Document Update By Agent </span></div>
                        <div class="   align-items-center ps-1"> </span> <span
                                style="color: #0F9500; font-weight:700; background-color: #D4FFDD; padding: 7px; border-radius: 10px;">
                                Document Approved </span></div>
                        <div class="   align-items-center ps-1"> </span> <span
                                style="color: #EC0000; font-weight:700; background-color: #FFE1E1; padding: 7px; border-radius: 10px;">
                                Document Rejected </span></div>
                    </div> --}}
                </div>

                @php

                    $count = 0;
                @endphp

                {{-- @php
                    $count = 1;
                    //Passport
                    $pass_light_color = '';
                    $pass_action = '';
                    $pass_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->passport_status)) {
                        if ($bookingDetail->incedent_doc->passport_status == 2) {
                            $pass_light_color = '#FFE1E1';
                            $pass_action = 'Rejected';
                            $pass_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->passport_status == 3) {
                            $pass_light_color = '#FFF2D1';
                            $pass_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->passport_status == 4) {
                            $pass_light_color = '#D4FFDD';
                            $pass_action = 'Approved';
                            $pass_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->passport_status == 1) {
                            $pass_light_color = '#f2f0f9';
                            $pass_action = 'In-Progress';
                            $pass_dark_color = '#acaab1';
                        }
                    }
                    //Visa
                    $visa_light_color = '';
                    $visa_action = '';
                    $visa_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->visa_status)) {
                        if ($bookingDetail->incedent_doc->visa_status == 2) {
                            $visa_light_color = '#FFE1E1';
                            $visa_action = 'Rejected';
                            $visa_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->visa_status == 3) {
                            $visa_light_color = '#FFF2D1';
                            $visa_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->visa_status == 4) {
                            $visa_light_color = '#D4FFDD';
                            $visa_action = 'Approved';
                            $visa_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->visa_status == 1) {
                            $visa_light_color = '#f2f0f9';
                            $visa_action = 'In-Progress';
                            $visa_dark_color = '#acaab1';
                        }
                    }

                    //pan_card_status
                    $pan_light_color = '';
                    $pan_action = '';
                    $pan_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->pan_card_status)) {
                        if ($bookingDetail->incedent_doc->pan_card_status == 2) {
                            $pan_light_color = '#FFE1E1';
                            $pan_action = 'Rejected';
                            $pan_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->pan_card_status == 3) {
                            $pan_light_color = '#FFF2D1';
                            $pan_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->pan_card_status == 4) {
                            $pan_light_color = '#D4FFDD';
                            $pan_action = 'Approved';
                            $pan_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->pan_card_status == 1) {
                            $pan_light_color = '#f2f0f9';
                            $pan_action = 'In-Progress';
                            $pan_dark_color = '#acaab1';
                        }
                    }

                    //annex_status
                    $annex_light_color = '';
                    $annex_action = '';
                    $annex_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->annex_status)) {
                        if ($bookingDetail->incedent_doc->annex_status == 2) {
                            $annex_light_color = '#FFE1E1';
                            $annex_action = 'Rejected';
                            $annex_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->annex_status == 3) {
                            $annex_light_color = '#FFF2D1';
                            $annex_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->annex_status == 4) {
                            $annex_light_color = '#D4FFDD';
                            $annex_action = 'Approved';
                            $annex_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->annex_status == 1) {
                            $annex_light_color = '#f2f0f9';
                            $annex_action = 'In-Progress';
                            $annex_dark_color = '#acaab1';
                        }
                    }

                    //ticket
                    $ticket_light_color = '';
                    $ticket_action = '';
                    $ticket_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->ticket_status)) {
                        if ($bookingDetail->incedent_doc->ticket_status == 2) {
                            $ticket_light_color = '#FFE1E1';
                            $ticket_action = 'Rejected';
                            $ticket_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->ticket_status == 3) {
                            $ticket_light_color = '#FFF2D1';
                            $ticket_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->ticket_status == 4) {
                            $ticket_light_color = '#D4FFDD';
                            $ticket_action = 'Approved';
                            $ticket_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->ticket_status == 1) {
                            $ticket_light_color = '#f2f0f9';
                            $ticket_action = 'In-Progress';
                            $ticket_dark_color = '#acaab1';
                        }
                    }

                    //Application
                    $application_light_color = '';
                    $application_action = '';
                    $application_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->apply_status)) {
                        if ($bookingDetail->incedent_doc->apply_status == 2) {
                            $application_light_color = '#FFE1E1';
                            $application_action = 'Rejected';
                            $application_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->apply_status == 3) {
                            $application_light_color = '#FFF2D1';
                            $application_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->apply_status == 4) {
                            $application_light_color = '#D4FFDD';
                            $application_action = 'Approved';
                            $application_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->apply_status == 1) {
                            $application_light_color = '#f2f0f9';
                            $application_action = 'In-Progress';
                            $application_dark_color = '#acaab1';
                        }
                    }

                    //Bank Transfer
                    $bank_transfer_light_color = '';
                    $bank_transfer_action = '';
                    $bank_transfer_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->bank_transfer_status)) {
                        if ($bookingDetail->incedent_doc->bank_transfer_status == 2) {
                            $bank_transfer_light_color = '#FFE1E1';
                            $bank_transfer_action = 'Rejected';
                            $bank_transfer_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->bank_transfer_status == 3) {
                            $bank_transfer_light_color = '#FFF2D1';
                            $bank_transfer_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->bank_transfer_status == 4) {
                            $bank_transfer_light_color = '#D4FFDD';
                            $bank_transfer_action = 'Approved';
                            $bank_transfer_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->bank_transfer_status == 1) {
                            $bank_transfer_light_color = '#f2f0f9';
                            $bank_transfer_action = 'In-Progress';
                            $bank_transfer_dark_color = '#acaab1';
                        }
                    }

                    //SOF
                    $sof_light_color = '';
                    $sof_action = '';
                    $sof_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->sof_status)) {
                        if ($bookingDetail->incedent_doc->sof_status == 2) {
                            $sof_light_color = '#FFE1E1';
                            $sof_action = 'Rejected';
                            $sof_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->sof_status == 3) {
                            $sof_light_color = '#FFF2D1';
                            $sof_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->sof_status == 4) {
                            $sof_light_color = '#D4FFDD';
                            $sof_action = 'Approved';
                            $sof_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->sof_status == 1) {
                            $sof_light_color = '#f2f0f9';
                            $sof_action = 'In-Progress';
                            $sof_dark_color = '#acaab1';
                        }
                    }

                    //letter
                    $letter_light_color = '';
                    $letter_action = '';
                    $letter_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->lerms_letter_status)) {
                        if ($bookingDetail->incedent_doc->lerms_letter_status == 2) {
                            $letter_light_color = '#FFE1E1';
                            $letter_action = 'Rejected';
                            $letter_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->lerms_letter_status == 3) {
                            $letter_light_color = '#FFF2D1';
                            $letter_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->lerms_letter_status == 4) {
                            $letter_light_color = '#D4FFDD';
                            $letter_action = 'Approved';
                            $letter_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->lerms_letter_status == 1) {
                            $letter_light_color = '#f2f0f9';
                            $letter_action = 'In-Progress';
                            $letter_dark_color = '#acaab1';
                        }
                    }

                    //university letter
                    $university_light_color = '';
                    $university_action = '';
                    $university_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->university_letter_status)) {
                        if ($bookingDetail->incedent_doc->university_letter_status == 2) {
                            $university_light_color = '#FFE1E1';
                            $university_action = 'Rejected';
                            $university_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->university_letter_status == 3) {
                            $university_light_color = '#FFF2D1';
                            $university_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->university_letter_status == 4) {
                            $university_light_color = '#D4FFDD';
                            $university_action = 'Approved';
                            $university_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->university_letter_status == 1) {
                            $university_light_color = '#f2f0f9';
                            $university_action = 'In-Progress';
                            $university_dark_color = '#acaab1';
                        }
                    }

                    //employment letter
                    $emp_letter_light_color = '';
                    $emp_letter_action = '';
                    $emp_letter_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->emp_letter_status)) {
                        if ($bookingDetail->incedent_doc->emp_letter_status == 2) {
                            $emp_letter_light_color = '#FFE1E1';
                            $emp_letter_action = 'Rejected';
                            $emp_letter_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->emp_letter_status == 3) {
                            $emp_letter_light_color = '#FFF2D1';
                            $emp_letter_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->emp_letter_status == 4) {
                            $emp_letter_light_color = '#D4FFDD';
                            $emp_letter_action = 'Approved';
                            $emp_letter_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->emp_letter_status == 1) {
                            $emp_letter_light_color = '#f2f0f9';
                            $emp_letter_action = 'In-Progress';
                            $emp_letter_dark_color = '#acaab1';
                        }
                    }

                    //employment declaration form
                    $emp_form_light_color = '';
                    $emp_form_action = '';
                    $emp_form_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->emp_declaration_form_status)) {
                        if ($bookingDetail->incedent_doc->emp_declaration_form_status == 2) {
                            $emp_form_light_color = '#FFE1E1';
                            $emp_form_action = 'Rejected';
                            $emp_form_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->emp_declaration_form_status == 3) {
                            $emp_form_light_color = '#FFF2D1';
                            $emp_form_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->emp_declaration_form_status == 4) {
                            $emp_form_light_color = '#D4FFDD';
                            $emp_form_action = 'Approved';
                            $emp_form_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->emp_declaration_form_status == 1) {
                            $emp_form_light_color = '#f2f0f9';
                            $emp_form_action = 'In-Progress';
                            $emp_form_dark_color = '#acaab1';
                        }
                    }

                    //Immigration declaration form
                    $immi_form_light_color = '';
                    $immi_form_action = '';
                    $immi_form_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->immigration_d_form_status)) {
                        if ($bookingDetail->incedent_doc->immigration_d_form_status == 2) {
                            $immi_form_light_color = '#FFE1E1';
                            $immi_form_action = 'Rejected';
                            $immi_form_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->immigration_d_form_status == 3) {
                            $immi_form_light_color = '#FFF2D1';
                            $immi_form_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->immigration_d_form_status == 4) {
                            $immi_form_light_color = '#D4FFDD';
                            $immi_form_action = 'Approved';
                            $immi_form_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->immigration_d_form_status == 1) {
                            $immi_form_light_color = '#f2f0f9';
                            $immi_form_action = 'In-Progress';
                            $immi_form_dark_color = '#acaab1';
                        }
                    }
                    //Medical letter
                    $medical_light_color = '';
                    $medical_action = '';
                    $medical_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->medical_letter_status)) {
                        if ($bookingDetail->incedent_doc->medical_letter_status == 2) {
                            $medical_light_color = '#FFE1E1';
                            $medical_action = 'Rejected';
                            $medical_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->medical_letter_status == 3) {
                            $medical_light_color = '#FFF2D1';
                            $medical_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->medical_letter_status == 4) {
                            $medical_light_color = '#D4FFDD';
                            $medical_action = 'Approved';
                            $medical_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->medical_letter_status == 1) {
                            $medical_light_color = '#f2f0f9';
                            $medical_action = 'In-Progress';
                            $medical_dark_color = '#acaab1';
                        }
                    }

                    //Refund letter
                    $refund_letter_light_color = '';
                    $refund_letter_action = '';
                    $refund_letter_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->refound_status)) {
                        if ($bookingDetail->incedent_doc->refound_status == 2) {
                            $refund_letter_light_color = '#FFE1E1';
                            $refund_letter_action = 'Rejected';
                            $refund_letter_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->refound_status == 3) {
                            $refund_letter_light_color = '#FFF2D1';
                            $refund_letter_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->refound_status == 4) {
                            $refund_letter_light_color = '#D4FFDD';
                            $refund_letter_action = 'Approved';
                            $refund_letter_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->refound_status == 1) {
                            $refund_letter_light_color = '#f2f0f9';
                            $refund_letter_action = 'In-Progress';
                            $refund_letter_dark_color = '#acaab1';
                        }
                    }

                    //Surrender letter
                    $surrender_letter_light_color = '';
                    $surrender_letter_action = '';
                    $surrender_letter_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->surrender_letter_status)) {
                        if ($bookingDetail->incedent_doc->surrender_letter_status == 2) {
                            $surrender_letter_light_color = '#FFE1E1';
                            $surrender_letter_action = 'Rejected';
                            $surrender_letter_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->surrender_letter_status == 3) {
                            $surrender_letter_light_color = '#FFF2D1';
                            $surrender_letter_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->surrender_letter_status == 4) {
                            $surrender_letter_light_color = '#D4FFDD';
                            $surrender_letter_action = 'Approved';
                            $surrender_letter_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->surrender_letter_status == 1) {
                            $surrender_letter_light_color = '#f2f0f9';
                            $surrender_letter_action = 'In-Progress';
                            $surrender_letter_dark_color = '#acaab1';
                        }
                    }
                   //Other
                    $other_light_color = '';
                    $other_action = '';
                    $other_dark_color = '';
                    if (isset($bookingDetail->incedent_doc->other_status)) {
                        if ($bookingDetail->incedent_doc->other_status == 2) {
                            $other_light_color = '#FFE1E1';
                            $other_action = 'Rejected';
                            $other_dark_color = '#EC0000';
                        } elseif ($bookingDetail->incedent_doc->other_status == 3) {
                            $other_light_color = '#FFF2D1';
                            $other_dark_color = '#FF9E2E';
                        } elseif ($bookingDetail->incedent_doc->other_status == 4) {
                            $other_light_color = '#D4FFDD';
                            $other_action = 'Approved';
                            $other_dark_color = '#0F9500';
                        } elseif ($bookingDetail->incedent_doc->other_status == 1) {
                            $other_light_color = '#f2f0f9';
                            $other_action = 'In-Progress';
                            $other_dark_color = '#acaab1';
                        }
                    }


                @endphp --}}

                <?php  //echo json_encode($bookingDetail); exit;?>
                <form action="" novalidate="novalidate" id="updateDocForm">

                    @csrf
                    <input type="hidden" name="inci_number" value="{{ $bookingDetail->inci_number }}">

                    <input type="hidden" name="id" value="{{ $bookingDetail->doc_temp_type==1 ? $bookingDetail->incedent_doc->id : '' }}">

                    <input type="hidden" name="inci_type" id="inci_type" value="{{ $bookingDetail->inci_buy_sell_req }}">
                    <div class="table-responsive-sm table-striped pb-3 ps-0 pe-0 mb-3  ">

                        <table id="example1" class="table roundedTable" style="width:100%">
                            <thead style="backgrounD-color: #F4F6F8;">
                                <tr>
                                    <th style="color: #2565ab; font-weight: 800;"><input type="checkbox" id="checkAll"></th>
                                    <th style="color: #2565ab; font-weight: 800;">Document</th>
                                    <th style="color: #2565ab; font-weight: 800;">Requirement</th>
                                    <th style="color: #2565ab; font-weight: 800;">Uploaded File</th>
                                    {{-- <th style="color: #2565ab; font-weight: 800;">Automation Scorecard</th> --}}
                                    {{--<th style="color: #2565ab; font-weight: 800;"> Status</th>--}}
                                    <th style="color: #2565ab; font-weight: 800;"> Comment</th>
                                    {{--<th style="color: #2565ab; font-weight: 800;"> Action</th>--}}

                                </tr>
                            </thead>

                              <tbody>

                                {{-- annex --}}
                                <tr>
                                    @php $count++; @endphp
                                    <td>
                                    	<input type="checkbox" class="checkoc_check" name="chk_annexure" id="chk_annexure" @if($bookingDetail->incedent_doc->annex_status==4) {{'checked'}} @endif>
                                    	<input type="hidden" value="1" name="annexure_file" id="annexure_file">
                                    </td>
                                    <td>Annexure</td>
                                    <td>Mandatory</td>
                                    <td>
                                        @php
                                            $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->annex);
                                        @endphp
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                            target="_blank"><i class="fa-solid fa-eye"></i> View &nbsp;</a>
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;"
                                            download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                    </td>
                                    {{-- <td>
                                        <span style=" background-color: {{ $annex_dark_color }};  padding: 2px 38px;">
                                        </span>
                                    </td> --}}

                                    @if (isset($bookingDetail->incedent_doc->annex_status))
                                        @if ($bookingDetail->incedent_doc->annex_status == 4 || $bookingDetail->incedent_doc->annex_status == 1)
                                            {{--<td>
                                                <span class="btn btn-sm fw-bold"
                                                    style="color:{{ $annex_dark_color }} ; background-color: {{ $annex_light_color }}; ">{{ $annex_action }}
                                                </span>
                                            </td>--}}
                                            <td>
                                                <textarea name="annex_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->annex_comment ? $bookingDetail->incedent_doc->annex_comment : '' }}</textarea>
                                            </td>
                                            <td>
                                                {{--<div class="btn-group">
                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="annex" name="annex_options" id="annex_options_approve" autocomplete="off" value="4"/>
                                                    <label class="btn btn-success" for="annex_options_approve">Approved</label>

                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="annex" name="annex_options" id="annex_options_reject" autocomplete="off" value="2"/>
                                                    <label class="btn btn-danger" for="annex_options_reject">Reject</label>

                                                </div>--}}
                                                {{--<button type="button" class="btn btn-sm updateDoc"
                                                    data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="annex"
                                                    disabled><i class="fa-solid fa-edit text-info"></i></button>--}}
                                            </td>
                                        @else
                                            {{--<td>
                                                <select class="form-control status" name="annex_status"
                                                    id="annex_status">
                                                    <option value="">Select
                                                        Status</option>
                                                    <option value="4">Approve</option>
                                                    <option value="2"
                                                        {{ $bookingDetail->incedent_doc->annex_status == 2 ? 'selected' : '' }}>
                                                        Reject</option>
                                                    <option value="3"
                                                        {{ $bookingDetail->incedent_doc->annex_status == 3 ? 'selected' : '' }}>
                                                        Manual Validation</option>
                                                </select>
                                            </td>--}}
                                            <td>
                                                <textarea name="annex_comment" class="form-control comment @error('annex_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->annex_comment ? $bookingDetail->incedent_doc->annex_comment : '' }} </textarea>
                                                @error('annex_comment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                {{--<div class="btn-group">
                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="annex" name="annex_options" id="annex_options_approve" autocomplete="off" value="4"/>
                                                    <label class="btn btn-success" for="annex_options_approve">Approved</label>

                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="annex" name="annex_options" id="annex_options_reject" autocomplete="off" value="2"/>
                                                    <label class="btn btn-danger" for="annex_options_reject">Reject</label>

                                                </div>--}}

                                                {{--<button type="button" class="btn btn-sm updateDoc"
                                                    data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="annex"><i
                                                        class="fa-solid fa-edit text-info"></i></button>--}}
                                            </td>

                                        @endif
                                    @endif
                                </tr>

                                {{-- Application --}}
                                @if($bookingDetail->inci_buy_sell_req==1)
                                <tr>
                                    @php $count++; @endphp
                                    <td>
                                        <input class="checkoc_check" type="checkbox" name="chk_application" id="chk_application" @if($bookingDetail->incedent_doc->apply_status==4) {{'checked'}} @endif>
                                        <input type="hidden" value="1" name="application_file" id="application_file">
                                    </td>
                                    <td>Application</td>
                                    <td>Mandatory</td>
                                    <td>
                                        @php
                                            $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->apply);
                                        @endphp
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                            style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i> View
                                            &nbsp;</a>
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                            style=" color:#686cad;" download>&nbsp;<i class="fa-solid fa-download"></i>
                                            Download </a>
                                    </td>
                                    {{-- <td>
                                        <span
                                            style=" background-color: {{ $application_dark_color }};  padding: 2px 38px;">
                                        </span>
                                    </td> --}}

                                    @if (isset($bookingDetail->incedent_doc->apply_status))
                                        @if ($bookingDetail->incedent_doc->apply_status == 4 || $bookingDetail->incedent_doc->apply_status == 1)
                                            {{--<td>
                                                <span class="btn btn-sm fw-bold"
                                                    style="color:{{ $application_dark_color }} ; background-color: {{ $application_light_color }}; ">{{ $application_action }}
                                                </span>
                                            </td>--}}
                                            <td>
                                                <textarea name="application_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->apply_comment ? $bookingDetail->incedent_doc->apply_comment : '' }}</textarea>
                                            </td>
                                            <td>
                                                {{--<div class="btn-group">
                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="application" name="application_options" id="application_options_approve" autocomplete="off" value="4"/>
                                                    <label class="btn btn-success" for="application_options_approve">Approved</label>

                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="application" name="application_options" id="application_options_reject" autocomplete="off" value="2"/>
                                                    <label class="btn btn-danger" for="application_options_reject">Reject</label>
                                                </div>--}}

                                                {{--<button type="button" class="btn btn-sm updateDoc"
                                                    data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="application"
                                                    disabled><i class="fa-solid fa-edit text-info"></i></button>--}}
                                            </td>
                                        @else
                                            {{--<td>
                                                <select class="form-control status" name="application_status"
                                                    id="ticket_status">
                                                    <option value="">Select Status</option>
                                                    <option value="4">Approve</option>
                                                    <option value="2"
                                                        {{ $bookingDetail->incedent_doc->apply_status == 2 ? 'selected' : '' }}>
                                                        Reject</option>
                                                    <option value="3"
                                                        {{ $bookingDetail->incedent_doc->apply_status == 3 ? 'selected' : '' }}>
                                                        Manual Validation</option>
                                                </select>
                                            </td>--}}
                                            <td>
                                                <textarea name="application_comment" class="form-control comment @error('application_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->apply_comment ? $bookingDetail->incedent_doc->apply_comment : '' }}</textarea>
                                                @error('application_comment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                {{--<div class="btn-group">
                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="application" name="application_options" id="application_options_approve" autocomplete="off" value="4"/>
                                                    <label class="btn btn-success" for="application_options_approve">Approved</label>

                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="application" name="application_options" id="application_options_reject" autocomplete="off" value="2"/>
                                                    <label class="btn btn-danger" for="application_options_reject">Reject</label>
                                                </div>--}}
                                                {{--<button type="button" class="btn btn-sm updateDoc"
                                                    data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                    data-doc_type="application"><i
                                                        class="fa-solid fa-edit text-info"></i></button>--}}
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                                @endif

                                {{-- Pan --}}
                                @if($bookingDetail->inci_buy_sell_req==1)
                                <tr>
                                    @php $count++; @endphp
                                    <td>
                                        <input class="checkoc_check" type="checkbox" name="chk_pan_card" id="chk_pan_card" @if($bookingDetail->incedent_doc->pan_card_status==4) {{'checked'}} @endif>
                                        <input type="hidden" value="1" name="pan_card_file" id="pan_card_file">
                                    </td>
                                    <td>Pan</td>
                                    <td>Mandatory</td>
                                    <td>
                                        @php
                                            $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->pan_card);
                                        @endphp
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                            target="_blank"><i class="fa-solid fa-eye"></i> View &nbsp;</a>
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;"
                                            download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                    </td>
                                    {{-- <td>
                                        <span style=" background-color: {{ $pan_dark_color }};  padding: 2px 38px;">
                                        </span>
                                    </td> --}}
                                    @if (isset($bookingDetail->incedent_doc->pan_card_status))
                                        @if ($bookingDetail->incedent_doc->pan_card_status == 4 || $bookingDetail->incedent_doc->pan_card_status == 1)
                                            {{--<td>
                                                <span class="btn btn-sm fw-bold"
                                                    style="color:{{ $pan_dark_color }} ; background-color: {{ $pan_light_color }}; ">{{ $pan_action }}
                                                </span>
                                            </td>--}}
                                            <td>
                                                <textarea name="pan_card_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->pan_card_comment ? $bookingDetail->incedent_doc->pan_card_comment : '' }}</textarea>
                                            </td>
                                            <td>
                                                {{--<div class="btn-group">
                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="pan_card" name="pan_card_options" id="pan_card_options_approve" autocomplete="off" value="4"/>
                                                    <label class="btn btn-success" for="pan_card_options_approve">Approved</label>

                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="pan_card" name="pan_card_options" id="pan_card_options_reject" autocomplete="off" value="2"/>
                                                    <label class="btn btn-danger" for="pan_card_options_reject">Reject</label>
                                                </div>--}}

                                                {{--<button type="button" class="btn btn-sm updateDoc"
                                                    data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="pan_card"
                                                    disabled><i class="fa-solid fa-edit text-info"></i></button>--}}
                                            </td>
                                        @else
                                            {{--<td>
                                                <select class="form-control status" name="pan_card_status"
                                                    id="pan_card_status">
                                                    <option value="">Select Status</option>
                                                    <option value="4">Approve</option>
                                                    <option value="2"
                                                        {{ $bookingDetail->incedent_doc->pan_card_status == 2 ? 'selected' : '' }}>
                                                        Reject</option>
                                                    <option value="3"
                                                        {{ $bookingDetail->incedent_doc->pan_card_status == 3 ? 'selected' : '' }}>
                                                        Manual Validation</option>
                                                </select>
                                            </td>--}}
                                            <td>
                                                <textarea name="pan_card_comment" class="form-control comment @error('pan_card_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->pan_card_comment ? $bookingDetail->incedent_doc->pan_card_comment : '' }}</textarea>
                                                @error('pan_card_comment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                               {{-- <button type="button" class="btn btn-sm updateDoc"
                                                    data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="pan_card"><i
                                                        class="fa-solid fa-edit text-info"></i></button>--}}
                                                {{--<div class="btn-group">
                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="pan_card" name="pan_card_options" id="pan_card_options_approve" autocomplete="off" value="4"/>
                                                    <label class="btn btn-success" for="pan_card_options_approve">Approved</label>

                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="pan_card" name="pan_card_options" id="pan_card_options_reject" autocomplete="off" value="2"/>
                                                    <label class="btn btn-danger" for="pan_card_options_reject">Reject</label>
                                                </div>--}}

                                            </td>
                                        @endif
                                    @endif
                                </tr>
                                @endif

                                {{-- Lerms letter --}}
                                @if (($bookingDetail->travel_type == 2 || $bookingDetail->travel_type == 6) && $bookingDetail->inci_buy_sell_req==1)
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_lerms_letter" id="chk_lerms_letter" @if($bookingDetail->incedent_doc->lerms_letter_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="lerms_letter_file" id="lerms_letter_file">
                                        </td>
                                        <td>Lerms Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->lerms_letter);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                style=" background-color: {{ $letter_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->lerms_letter_status))
                                            @if ($bookingDetail->incedent_doc->lerms_letter_status == 4 || $bookingDetail->incedent_doc->lerms_letter_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $letter_dark_color }} ; background-color: {{ $letter_light_color }}; ">{{ $letter_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="lerms_letter_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->lerms_letter_comment ? $bookingDetail->incedent_doc->lerms_letter_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="lerms_letter" name="lerms_letter_options" id="lerms_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="lerms_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="lerms_letter" name="lerms_letter_options" id="lerms_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="lerms_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="lerms_letter" disabled><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="lerms_letter_status"
                                                        id="annex_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->lerms_letter_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->lerms_letter_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="lerms_letter_comment"
                                                        class="form-control comment @error('lerms_letter_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->lerms_letter_comment ? $bookingDetail->incedent_doc->lerms_letter_comment : '' }} </textarea>
                                                    @error('lerms_letter_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="lerms_letter" name="lerms_letter_options" id="lerms_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="lerms_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="lerms_letter" name="lerms_letter_options" id="lerms_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="lerms_letter_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="lerms_letter"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endif


                                {{-- Passport --}}

                                <tr>
                                    @php $count++; @endphp
                                    <td>
                                        <input class="checkoc_check" type="checkbox" name="chk_passport" id="chk_passport" @if($bookingDetail->incedent_doc->passport_status==4) {{'checked'}} @endif>
                                        <input type="hidden" value="1" name="passport_file" id="passport_file">
                                    </td>
                                    <td>Passport</td>
                                    <td>Mandatory</td>
                                    <td>
                                        @php
                                            $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->passport);
                                        @endphp
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#00B7FF;"
                                            target="_blank"><i class="fa-solid fa-eye"></i> View &nbsp;</a>
                                        <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold" style=" color:#686cad;"
                                            download>&nbsp;<i class="fa-solid fa-download"></i> Download </a>
                                    </td>
                                    {{-- <td>
                                        <span style=" background-color: {{ $pass_dark_color }}; padding: 2px 38px;">
                                        </span>
                                    </td> --}}

                                    @if (isset($bookingDetail->incedent_doc->passport_status))
                                        @if ($bookingDetail->incedent_doc->passport_status == 4 || $bookingDetail->incedent_doc->passport_status == 1)
                                            {{--<td>
                                                <span class="btn btn-sm fw-bold"
                                                    style="color:{{ $pass_dark_color }} ; background-color: {{ $pass_light_color }}; ">{{ $pass_action }}
                                                </span>
                                            </td>--}}
                                            <td>
                                                <textarea name="passport_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->passport_comment ? $bookingDetail->incedent_doc->passport_comment : '' }}</textarea>
                                            </td>
                                            <td>
                                                {{--<div class="btn-group">
                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="passport" name="passport_options" id="passport_options_approve" autocomplete="off" value="4"/>
                                                    <label class="btn btn-success" for="passport_options_approve">Approved</label>

                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="passport" name="passport_options" id="passport_options_reject" autocomplete="off" value="2"/>
                                                    <label class="btn btn-danger" for="passport_options_reject">Reject</label>
                                                </div>--}}

                                                {{--<button type="button" class="btn btn-sm updateDoc"
                                                    data-id="{{ $bookingDetail->id }}" data-doc_type="passport"
                                                    disabled><i class="fa-solid fa-edit text-info"></i></button>--}}
                                            </td>
                                        @else
                                            {{--<td>
                                                <select class="form-control status" name="passport_status"
                                                    id="passport_status">
                                                    <option selected value="">Select Status</option>
                                                    <option value="4">Approve</option>
                                                    <option value="2"
                                                        {{ $bookingDetail->incedent_doc->passport_status == 2 ? 'selected' : '' }}>
                                                        Reject</option>
                                                    <option value="3"
                                                        {{ $bookingDetail->incedent_doc->passport_status == 3 ? 'selected' : '' }}>
                                                        Manual Validation</option>
                                                </select>
                                            </td>--}}
                                            <td>
                                                <textarea name="passport_comment" class="form-control comment @error('passport_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->passport_comment ? $bookingDetail->incedent_doc->passport_comment : '' }}</textarea>
                                                @error('passport_comment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                {{--<div class="btn-group">
                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="passport" name="passport_options" id="passport_options_approve" autocomplete="off" value="4"/>
                                                    <label class="btn btn-success" for="passport_options_approve">Approved</label>

                                                    <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="passport" name="passport_options" id="passport_options_reject" autocomplete="off" value="2"/>
                                                    <label class="btn btn-danger" for="passport_options_reject">Reject</label>
                                                </div>--}}

                                                {{--<button type="button" class="btn btn-sm updateDoc"
                                                    data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="passport"><i
                                                        class="fa-solid fa-edit text-info"></i></button>--}}
                                            </td>

                                        @endif
                                    @endif
                                </tr>


                                {{-- Ticket --}}
                                @if (($bookingDetail->travel_type == 1 ||
                                    $bookingDetail->travel_type == 3 ||
                                    $bookingDetail->travel_type == 4 ||
                                    $bookingDetail->travel_type == 5) && ($bookingDetail->inci_buy_sell_req==1))
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_ticket" id="chk_ticket" @if($bookingDetail->incedent_doc->ticket_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="ticket_file" id="ticket_file">
                                        </td>
                                        <td>Ticket</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->ticket);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                style=" background-color: {{ $ticket_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->ticket_status))
                                            @if ($bookingDetail->incedent_doc->ticket_status == 4 || $bookingDetail->incedent_doc->ticket_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $ticket_dark_color }} ; background-color: {{ $ticket_light_color }}; ">{{ $ticket_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="ticket_comment" class="form-control comment">{{ $bookingDetail->incedent_doc->ticket_comment ? $bookingDetail->incedent_doc->ticket_comment : '' }}</textarea>
                                                </td>
                                               {{-- <td>
                                                    <div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="ticket" name="ticket_options" id="ticket_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="ticket_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="ticket" name="ticket_options" id="ticket_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="ticket_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="ticket"
                                                        disabled><i class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="ticket_status"
                                                        id="ticket_status">
                                                        <option value="">Select Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->ticket_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->ticket_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="ticket_comment" class="form-control comment @error('ticket_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->ticket_comment ? $bookingDetail->incedent_doc->ticket_comment : '' }}</textarea>
                                                    @error('ticket_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="ticket" name="ticket_options" id="ticket_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="ticket_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="ticket" name="ticket_options" id="ticket_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="ticket_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="ticket"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>

                                            @endif
                                        @endif
                                    </tr>
                                @endif


                                @if (($bookingDetail->travel_type == 1 ||
                                    $bookingDetail->travel_type == 3 ||
                                    $bookingDetail->travel_type == 4 ||
                                    $bookingDetail->travel_type == 5) && ($bookingDetail->inci_buy_sell_req==1))
                                    {{-- Visa --}}
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_visa" id="chk_visa" @if($bookingDetail->incedent_doc->visa_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="visa_file" id="visa_file" >
                                        </td>
                                        <td>Visa</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->visa);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span style=" background-color: {{ $visa_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->visa_status))
                                            @if ($bookingDetail->incedent_doc->visa_status == 4 || $bookingDetail->incedent_doc->visa_status == 1)
                                               {{-- <td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $visa_dark_color }} ; background-color: {{ $visa_light_color }}; ">{{ $visa_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="visa_comment" class="form-control comment">{{ $bookingDetail->incedent_doc->visa_comment ? $bookingDetail->incedent_doc->visa_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="visa" name="visa_options" id="visa_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="visa_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="visa" name="visa_options" id="visa_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="visa_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="visa"
                                                        disabled><i class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="visa_status"
                                                        id="visa_status">
                                                        <option value="">Select Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->visa_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->visa_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="visa_comment" class="form-control comment @error('visa_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->visa_comment ? $bookingDetail->incedent_doc->visa_comment : '' }}</textarea>
                                                    @error('visa_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="visa" name="visa_options" id="visa_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="visa_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="visa" name="visa_options" id="visa_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="visa_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="visa"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>

                                            @endif
                                        @endif
                                    </tr>
                                @endif

                                @if (($bookingDetail->travel_type == 1 ||
                                    $bookingDetail->travel_type == 3 ||
                                    $bookingDetail->travel_type == 4 ||
                                    $bookingDetail->travel_type == 5) && ($bookingDetail->inci_buy_sell_req==1))
                                    {{-- SOF --}}
                                    <tr>
                                        @php $count++; @endphp

					                    <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_sof" id="chk_sof" @if($bookingDetail->incedent_doc->sof_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="sof_file" id="sof_file">
                                        </td>
                                        <td>SOF</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->sof);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View
                                                &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i>
                                                Download </a>
                                        </td>
                                        {{-- <td>
                                            <span style=" background-color: {{ $sof_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->sof_status))
                                            @if ($bookingDetail->incedent_doc->sof_status == 4 || $bookingDetail->incedent_doc->sof_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $sof_dark_color }} ; background-color: {{ $sof_light_color }}; ">{{ $sof_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="sof_comment" class="form-control comment">{{ $bookingDetail->incedent_doc->sof_comment ? $bookingDetail->incedent_doc->sof_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="sof" name="sof_options" id="sof_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="sof_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="sof" name="sof_options" id="sof_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="sof_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="sof"
                                                        disabled><i class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="sof_status"
                                                        id="sof_status">
                                                        <option value="">Select Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->sof_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->sof_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="sof_comment" class="form-control comment  @error('sof_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->sof_comment ? $bookingDetail->incedent_doc->sof_comment : '' }}</textarea>
                                                    @error('sof_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="sof" name="sof_options" id="sof_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="sof_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="sof" name="sof_options" id="sof_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="sof_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="sof"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>

                                            @endif
                                        @endif
                                    </tr>
                                @endif



                                @if (($bookingDetail->travel_type == 1 || $bookingDetail->travel_type == 2 ) && $bookingDetail->incedent_doc->bank_transfer!='')
                                    {{-- Bank Transfer --}}
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_bank_transfer" id="chk_bank_transfer" @if($bookingDetail->incedent_doc->bank_transfer_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="bank_transfer_file" id="bank_transfer_file">
                                        </td>
                                        <td>Bank Transfer</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->bank_transfer);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View
                                                &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i>
                                                Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                style=" background-color: {{ $bank_transfer_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->bank_transfer_status))
                                            @if ($bookingDetail->incedent_doc->bank_transfer_status == 4 || $bookingDetail->incedent_doc->bank_transfer_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $bank_transfer_dark_color }} ; background-color: {{ $bank_transfer_light_color }}; ">{{ $bank_transfer_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="bank_transfer_comment" class="form-control comment">{{ $bookingDetail->incedent_doc->bank_transfer_comment ? $bookingDetail->incedent_doc->bank_transfer_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="bank_transfer" name="bank_transfer_options" id="bank_transfer_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="bank_transfer_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="bank_transfer" name="bank_transfer_options" id="bank_transfer_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="bank_transfer_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="bank_transfer" disabled><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="bank_transfer_status"
                                                        id="ticket_status">
                                                        <option value="">Select Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->bank_transfer_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->bank_transfer_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="bank_transfer_comment"
                                                        class="form-control comment @error('bank_transfer_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->bank_transfer_comment ? $bookingDetail->incedent_doc->bank_transfer_comment : '' }}</textarea>
                                                    @error('bank_transfer_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="bank_transfer" name="bank_transfer_options" id="bank_transfer_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="bank_transfer_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="bank_transfer" name="bank_transfer_options" id="bank_transfer_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="bank_transfer_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="bank_transfer"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>

                                            @endif
                                        @endif
                                    </tr>
                                @endif

                                {{-- University letter --}}
                                @if ($bookingDetail->travel_type == 4 && $bookingDetail->inci_buy_sell_req==1)
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_university_letter" id="chk_university_letter" @if($bookingDetail->incedent_doc->university_letter_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="university_letter_file" id="university_letter_file">
                                        </td>
                                        <td>University Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->university_letter);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                style=" background-color: {{ $university_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->university_letter_status))
                                            @if ($bookingDetail->incedent_doc->university_letter_status == 4 || $bookingDetail->incedent_doc->university_letter_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $university_dark_color }} ; background-color: {{ $university_light_color }}; ">{{ $university_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="university_letter_comment" class="form-control comment">{{ $bookingDetail->incedent_doc->university_letter_comment ? $bookingDetail->incedent_doc->university_letter_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="university_letter" name="university_letter_options" id="university_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="university_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="university_letter" name="university_letter_options" id="university_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="university_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="university_letter" disabled><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="university_letter_status"
                                                        id="annex_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->university_letter_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->university_letter_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="university_letter_comment"
                                                        class="form-control comment @error('university_letter_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->university_letter_comment ? $bookingDetail->incedent_doc->university_letter_comment : '' }} </textarea>
                                                    @error('university_letter_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="university_letter" name="university_letter_options" id="university_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="university_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="university_letter" name="university_letter_options" id="university_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="university_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="university_letter"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>

                                            @endif
                                        @endif
                                    </tr>
                                @endif


                                {{-- Employment  letter --}}
                                @if ($bookingDetail->travel_type == 3 && $bookingDetail->inci_buy_sell_req==1)
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_employment_letter" id="chk_employment_letter" @if($bookingDetail->incedent_doc->emp_letter_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="employment_letter_file" id="employment_letter_file">
                                        </td>
                                        <td>Employment Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->incident_number . '/' . $bookingDetail->incedent_doc->employment_letter);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                style=" background-color: {{ $emp_letter_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->emp_letter_status))
                                            @if ($bookingDetail->incedent_doc->emp_letter_status == 4 || $bookingDetail->incedent_doc->emp_letter_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $emp_letter_dark_color }} ; background-color: {{ $emp_letter_light_color }}; ">{{ $emp_letter_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="emp_letter_comment" class="form-control comment">{{ $bookingDetail->incedent_doc->emp_letter_comment ? $bookingDetail->incedent_doc->emp_letter_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="employment_letter" name="employment_letter_options" id="employment_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="employment_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="employment_letter" name="employment_letter_options" id="employment_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="employment_letter_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="employment_letter" disabled><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="emp_letter_status"
                                                        id="emp_letter_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->emp_letter_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->emp_letter_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="emp_letter_comment" class="form-control comment @error('emp_letter_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->emp_letter_comment ? $bookingDetail->incedent_doc->emp_letter_comment : '' }} </textarea>
                                                    @error('emp_letter_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="employment_letter" name="employment_letter_options" id="employment_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="employment_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="employment_letter" name="employment_letter_options" id="employment_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="employment_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="employment_letter"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @endif
                                        @endif
                                    </tr>

                                    {{-- Employment Declaration form --}}
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="chk_employment_declaration" id="chk_employment_declaration" @if($bookingDetail->incedent_doc->emp_declaration_form_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="employment_declaration_file" id="employment_declaration_file">
                                        </td>
                                        <td>Employment Declaration Form</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->emp_declaration_form);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                style=" background-color: {{ $emp_form_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->emp_declaration_form_status))
                                            @if ($bookingDetail->incedent_doc->emp_declaration_form_status == 4 ||
                                                $bookingDetail->incedent_doc->emp_declaration_form_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $emp_form_dark_color }} ; background-color: {{ $emp_form_light_color }}; ">{{ $emp_form_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="emp_form_comment" class="form-control comment">{{ $bookingDetail->incedent_doc->emp_declaration_form_comment ? $bookingDetail->incedent_doc->emp_declaration_form_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="employment_form" name="employment_form_options" id="employment_form_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="employment_form_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="employment_form" name="employment_form_options" id="employment_form_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="employment_form_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="employment_form" disabled><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="emp_form_status"
                                                        id="emp_form_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->emp_declaration_form_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->emp_declaration_form_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="emp_form_comment"
                                                        class="form-control comment @error('emp_declaration_form_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->emp_declaration_form_comment ? $bookingDetail->incedent_doc->emp_declaration_form_comment : '' }} </textarea>
                                                    @error('emp_declaration_form_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="employment_form" name="employment_form_options" id="employment_form_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="employment_form_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="employment_form" name="employment_form_options" id="employment_form_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="employment_form_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="emp_declaration_form"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endif


                                {{-- Immigration Declaration form --}}
                                @if ($bookingDetail->travel_type == 5 && $bookingDetail->inci_buy_sell_req==1)
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_immigration_declaration" id="chk_immigration_declaration" @if($bookingDetail->incedent_doc->immigration_d_form_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="immigration_declaration_file" id="immigration_declaration_file">
                                        </td>
                                        <td>Immigration Declaration Form</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->immigration_d_form);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                style=" background-color: {{ $immi_form_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->immigration_d_form_status))
                                            @if ($bookingDetail->incedent_doc->immigration_d_form_status == 4 || $bookingDetail->incedent_doc->immigration_d_form_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $immi_form_dark_color }} ; background-color: {{ $immi_form_light_color }}; ">{{ $immi_form_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="immigration_d_form_comment" class="form-control comment">{{ $bookingDetail->incedent_doc->immigration_d_form_comment ? $bookingDetail->incedent_doc->immigration_d_form_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="immigration_d_form" name="immigration_d_form_options" id="immigration_d_form_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="immigration_d_form_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="immigration_d_form" name="immigration_d_form_options" id="immigration_d_form_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="immigration_d_form_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="immigration_d_form" disabled><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="immigration_d_form_status"
                                                        id="immigration_d_form_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->immigration_d_form_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->immigration_d_form_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="immigration_d_form_comment"
                                                        class="form-control comment @error('immigration_d_form_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->immigration_d_form_comment ? $bookingDetail->incedent_doc->immigration_d_form_comment : '' }} </textarea>
                                                    @error('immigration_d_form_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="immigration_d_form" name="immigration_d_form_options" id="immigration_d_form_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="immigration_d_form_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="immigration_d_form" name="immigration_d_form_options" id="immigration_d_form_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="immigration_d_form_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="immigration_d_form"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>

                                            @endif
                                        @endif
                                    </tr>
                                @endif

                                {{-- Medical letter --}}
                                @if ($bookingDetail->travel_type == 6 && $bookingDetail->inci_buy_sell_req==1)
                                    <tr>
                                        @php $count++; @endphp
					                    <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_medical_letter" id="chk_medical_letter" @if($bookingDetail->incedent_doc->medical_letter_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="medical_letter_file" id="medical_letter_file">
                                        </td>

                                        <td>Medical Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->medical_letter);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                                style=" color:#686cad;" download>&nbsp;<i
                                                    class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                style=" background-color: {{ $medical_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->medical_letter_status))
                                            @if ($bookingDetail->incedent_doc->medical_letter_status == 4 || $bookingDetail->incedent_doc->medical_letter_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                        style="color:{{ $medical_dark_color }} ; background-color: {{ $medical_light_color }}; ">{{ $medical_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="medical_letter_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->medical_letter_comment ? $bookingDetail->incedent_doc->medical_letter_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="medical_letter" name="medical_letter_options" id="medical_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="medical_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="medical_letter" name="medical_letter_options" id="medical_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="medical_letter_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="medical_letter" disabled><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="medical_letter_status"
                                                        id="annex_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                            {{ $bookingDetail->incedent_doc->medical_letter_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                            {{ $bookingDetail->incedent_doc->medical_letter_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="medical_letter_comment"
                                                        class="form-control comment @error('medical_letter_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->medical_letter_comment ? $bookingDetail->incedent_doc->medical_letter_comment : '' }} </textarea>
                                                    @error('medical_letter_comment')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="medical_letter" name="medical_letter_options" id="medical_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="medical_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="medical_letter" name="medical_letter_options" id="medical_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="medical_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                        data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                        data-doc_type="medical_letter"><i
                                                            class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>

                                            @endif
                                        @endif
                                    </tr>
                                @endif

                                {{-- Refund Form --}}
                                @if ($bookingDetail->inci_buy_sell_req==0)
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check"  type="checkbox" name="chk_refund_form" id="chk_refund_form" @if($bookingDetail->incedent_doc->refound_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="refund_form_file" id="refund_form_file">
                                        </td>
                                        <td>Refund Form</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->refound);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                               style=" color:#686cad;" download>&nbsp;<i
                                                        class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                    style=" background-color: {{ $refund_letter_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->refound_status))
                                            @if ($bookingDetail->incedent_doc->refound_status == 4 || $bookingDetail->incedent_doc->refound_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                          style="color:{{ $refund_letter_dark_color }} ; background-color: {{ $refund_letter_light_color }}; ">{{ $refund_letter_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="refund_letter_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->refound_comment ? $bookingDetail->incedent_doc->refound_comment : '' }}</textarea>

                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="refund_letter" name="refund_letter_options" id="refund_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="refund_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="refund_letter" name="refund_letter_options" id="refund_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="refund_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                            data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                            data-doc_type="refund_letter" disabled><i
                                                                class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="refund_letter_status"
                                                            id="annex_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                                {{ $bookingDetail->incedent_doc->refound_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                                {{ $bookingDetail->incedent_doc->refound_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="refund_letter_comment"
                                                              class="form-control comment @error('refund_letter_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->refound_comment ? $bookingDetail->incedent_doc->refound_comment : '' }} </textarea>
                                                    @error('refund_letter_comment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="refund_letter" name="refund_letter_options" id="refund_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="refund_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="refund_letter" name="refund_letter_options" id="refund_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="refund_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                            data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                            data-doc_type="refund_letter"><i
                                                                class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endif

                                {{-- Surrender Letter --}}
                                @if ($bookingDetail->travel_type == 2 && $bookingDetail->inci_buy_sell_req==0)
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_surrender_letter" id="chk_surrender_letter" @if($bookingDetail->incedent_doc->surrender_letter_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="surrender_letter_file" id="surrender_letter_file">
                                        </td>
                                        <td>Surrender Letter</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->surrender_letter);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                               style=" color:#686cad;" download>&nbsp;<i
                                                        class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                    style=" background-color: {{ $surrender_letter_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->surrender_letter_status))
                                            @if ($bookingDetail->incedent_doc->surrender_letter_status == 4 || $bookingDetail->incedent_doc->surrender_letter_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                          style="color:{{ $surrender_letter_dark_color }} ; background-color: {{ $surrender_letter_light_color }}; ">{{ $surrender_letter_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="surrender_letter_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->surrender_letter_comment ? $bookingDetail->incedent_doc->surrender_letter_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="surrender_letter" name="surrender_letter_options" id="surrender_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="surrender_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="surrender_letter" name="surrender_letter_options" id="surrender_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="surrender_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                            data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                            data-doc_type="surrender_letter" disabled><i
                                                                class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="surrender_letter_status"
                                                            id="annex_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                                {{ $bookingDetail->incedent_doc->surrender_letter_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                                {{ $bookingDetail->incedent_doc->surrender_letter_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="surrender_letter_comment"
                                                              class="form-control comment @error('surrender_letter_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->surrender_letter_comment ? $bookingDetail->incedent_doc->surrender_letter_comment : '' }} </textarea>
                                                    @error('surrender_letter_comment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="surrender_letter" name="surrender_letter_options" id="surrender_letter_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="surrender_letter_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="surrender_letter" name="surrender_letter_options" id="surrender_letter_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="surrender_letter_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                            data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                            data-doc_type="surrender_letter"><i
                                                                class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endif


                                {{--  Other --}}
				                @if ($bookingDetail->incedent_doc->other !="")
                                @if ($bookingDetail->travel_type !== 6 && $bookingDetail->inci_buy_sell_req== 1)
                                    <tr>
                                        @php $count++; @endphp
                                        <td>
                                            <input class="checkoc_check" type="checkbox" name="chk_other" id="chk_other" @if($bookingDetail->incedent_doc->other_status==4) {{'checked'}} @endif>
                                            <input type="hidden" value="1" name="other_file" id="other_file">
                                        </td>
                                        <td>Other</td>
                                        <td>Mandatory</td>
                                        <td>
                                            @php
                                                $file_path = asset('allDocuments/' . date('Y-m-d', strtotime($bookingDetail->created_at)) . '/' . $bookingDetail->inci_number . '/' . $bookingDetail->incedent_doc->other);
                                            @endphp
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                               style=" color:#00B7FF;" target="_blank"><i class="fa-solid fa-eye"></i>
                                                View &nbsp;</a>
                                            <a href="{{ $file_path }}" class="svg-bg m-0 fw-bold"
                                               style=" color:#686cad;" download>&nbsp;<i
                                                        class="fa-solid fa-download"></i> Download </a>
                                        </td>
                                        {{-- <td>
                                            <span
                                                    style=" background-color: {{ $other_dark_color }};  padding: 2px 38px;">
                                            </span>
                                        </td> --}}

                                        @if (isset($bookingDetail->incedent_doc->other_status))
                                            @if ($bookingDetail->incedent_doc->other_status == 4 || $bookingDetail->incedent_doc->other_status == 1)
                                                {{--<td>
                                                    <span class="btn btn-sm fw-bold"
                                                          style="color:{{ $other_dark_color }} ; background-color: {{ $other_light_color }}; ">{{ $other_action }}
                                                    </span>
                                                </td>--}}
                                                <td>
                                                    <textarea name="other_comment" class="form-control comment" >{{ $bookingDetail->incedent_doc->other_comment ? $bookingDetail->incedent_doc->other_comment : '' }}</textarea>
                                                </td>
                                                <td>
                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="other" name="other_options" id="other_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="other_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="other" name="other_options" id="other_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="other_options_reject">Reject</label>
                                                    </div>--}}
                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                            data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                            data-doc_type="other" disabled><i
                                                                class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @else
                                                {{--<td>
                                                    <select class="form-control status" name="other_status"
                                                            id="annex_status">
                                                        <option value="">Select
                                                            Status</option>
                                                        <option value="4">Approve</option>
                                                        <option value="2"
                                                                {{ $bookingDetail->incedent_doc->other_status == 2 ? 'selected' : '' }}>
                                                            Reject</option>
                                                        <option value="3"
                                                                {{ $bookingDetail->incedent_doc->other_status == 3 ? 'selected' : '' }}>
                                                            Manual Validation</option>
                                                    </select>
                                                </td>--}}
                                                <td>
                                                    <textarea name="other_comment"
                                                              class="form-control comment @error('other_comment') is-invalid @enderror">{{ $bookingDetail->incedent_doc->other_comment ? $bookingDetail->incedent_doc->other_comment : '' }} </textarea>
                                                    @error('other_comment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>

                                                    {{--<div class="btn-group">
                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="other" name="other_options" id="other_options_approve" autocomplete="off" value="4"/>
                                                        <label class="btn btn-success" for="other_options_approve">Approved</label>

                                                        <input type="radio" class="btn-check updateDoc" data-id="{{ $bookingDetail->incedent_doc->id }}" data-doc_type="other" name="other_options" id="other_options_reject" autocomplete="off" value="2"/>
                                                        <label class="btn btn-danger" for="other_options_reject">Reject</label>
                                                    </div>--}}

                                                    {{--<button type="button" class="btn btn-sm updateDoc"
                                                            data-id="{{ $bookingDetail->incedent_doc->id }}"
                                                            data-doc_type="other"><i
                                                                class="fa-solid fa-edit text-info"></i></button>--}}
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endif
								@endif
                            </tbody>
                        </table>
                        {{-- End Doc Table --}}


                        <div class="bgc mt-3">
                            <div class="row mt-3 ">
                                <div class="col-lg-4 col-sm-3 mt-3">
                                    <label class="">Bordeaux Number</label>
                                    <div class="input-group mb-3">
                                        <input id="bordox_no" disabled
                                            class="form-control border-0 border-bottom p-2 bg-transparent @error('bordox_no') is-invalid @enderror"
                                            type="text" name="bordox_no" placeholder="Enter Bordeaux Number"
                                            value="{{ !empty($bookingDetail->bordox_no) ? $bookingDetail->bordox_no : old('bordox_no') }}">
                                    </div>
                                    @error('bordox_no')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="col-lg-4 col-sm-3 mt-3">
                                    <label class="">Comment</label>
                                    <div class="input-group mb-3">
                                        <input
                                            class="form-control border-0 border-bottom p-2 bg-transparent  @error('inci_status_message') is-invalid @enderror"
                                            type="text" name="inci_status_message" placeholder="Enter Comment"
                                            value="{{ $bookingDetail->inci_comment }}">
                                    </div>
                                    @error('inci_status_message')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @php
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

                                @endphp

                                <div class="col-lg-4 col-sm-3 mt-3">
                                    <label class="">Status</label>
                                    <div class="input-group my-2">
                                        <div class="col-sm-4">
                                            <label class="radio-inline">
                                                <!--<input type="radio" class="form-check-input" name="inci_status"
                                                    value="1"
                                                    {{ $bookingDetail->inci_status == 1 ? 'checked' : '' }}
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
                                                    @if($bookingDetail->inci_status==1 ) {{ 'checked' }}
                                                    @elseif($bookingDetail->inci_status==0)

                                                    @else
                                                        disabled
                                                    @endif
                                                    >Approve
                                            </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="radio-inline">
                                                <!--<input type="radio" class="form-check-input" name="inci_status"
                                                    value="0"
                                                    {{ $bookingDetail->inci_status == 0 ? 'checked' : '' }}<?php if ($approve_status) {
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

                                                    @if($bookingDetail->inci_status==0) {{ 'checked' }}
                                                    @elseif($bookingDetail->inci_status==1)

                                                    @else
                                                    {{ 'checked' }}
                                                    @endif
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
                                    <a href="{{ route('tcuser.dashboard') }}"
                                        class="btn btn-secondary px-5 fw-bold text-capitalize m-0">Back</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="fw-bold mt-3 mb-5 text-center" style="color: #858585;">
                            <p>Document Not Available.</p>
                            <a href="{{ route('tcuser.dashboard') }}"
                                class="btn btn-secondary px-5 fw-bold text-capitalize m-0">Back</a>
                        </div>
                        {{-- <div class="fw-bold mt-3" style="color: #858585;">
                <p class="m-0">Please activate Mr Ravi Teja Travel Card as soon as possible and
                    confirm</p>
                <p class="m-0"> @Agent: 2022-09-06 23:30:14</p>
            </div> --}}


                    </div>

                    <input type="hidden" value="{{$count}}"  name="document_count"  id="document_count">

                </form>
            @endif
	    @else
                <div class="fw-bold mt-3 mb-5 text-center" style="color: #858585;">
                    <p>Document Not Available.</p>
                    <a href="{{ route('tcuser.dashboard') }}"
                       class="btn btn-secondary px-5 fw-bold text-capitalize m-0">Back</a>
                </div>
            @endif
            <!-- Tabs content -->
        </div>
	 <div class="container">
                <div class="col-md-12" id="fbcomment">
                    <div class="body_comment">
                        <h5>Rejection Summary</h5>
                        <div class="row">
                            <ul id="list_comment" class="col-md-12">
                                <!-- Start List Comment 1 -->
                                <!-- @if(isset($bookingDetail['comments']) && $bookingDetail['comments'])
                                @foreach($bookingDetail['comments'] as $key=>$value)
                                <li class="box_result row">
                                    <div class="avatar_comment col-md-1">
                                        <img src="{{$value['tcuser'] ? url('users/admin/profile').'/'.$value['tcuser']->user_profile : url('users/admin/profile/1660019563.png')}}" alt="avatar"/>
                                    </div>
                                    <div class="result_comment col-md-11">
                                        <h4>{{$value['tcuser'] ? $value['tcuser']->name : "Admin"}}</h4>
                                        <p>{{$value['comment']}}</p>
                                        <div class="tools_comment">
                                            <i class="fa fa-calendar" style="font-size:13px"></i>
                                            <span>{{date('d-m-Y h:i:s A',strtotime($value['created_at']))}}</span>
                                        </div>

                                    </div>
                                </li>
                                @endforeach
                                @else
                                    <h6 class="text-center">No comments Found!</h6>
                                @endif -->


                                
                                @php
                                    $comments = DB::table('incident_document_comments')
                                    ->where('incident_id',$bookingDetail->inci_number)
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

                                <hr>
                                <h5> {{ $comments->onEachSide(5)->links() }}</h5>


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

    <input type="hidden" value="{{$count}}"  name="document_no"  id="document_no">

@endsection

@push('pagescript')
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
                    url: '{{ route('tcuser.tcuser-update-document-status') }}',
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
                    url: "{{ route('tcuser.tcuser-update-document') }}",
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
			window.location.href = "{{URL::to('/tcuser/dashboard')}}"

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
          url: "{{ route('tcuser.online-status') }}",
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
@endpush
