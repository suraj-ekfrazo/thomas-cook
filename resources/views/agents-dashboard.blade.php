@extends('layouts.agent.appmain')
@section('content')
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

        @keyframes spinner {
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
    @csrf

    {{-- <div class="" id="loading_div" style="display:none;">Loading&#8230;</div> --}}
    <div id="loading_divs"></div>
    <nav class="navbar navbar-expand-lg navbar-default rounded-top rounded-4 ">
        <div class="container-fluid px-0">
            <div class="d-flex">
                <!-- <a class="navbar-brand" href="index.html"><img src="../assets/img/logo2.png" class="img-fluid"
                                                               alt="Responsive image"/></a> -->
                <a class="navbar-brand" href="{{ url('/agent/dashboard') }}"><img src="../assets/images/LOGO.png" class="img-fluid"
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
                    <a href="#"><i class="fe fe-shopping-cart fs-3 align-middle"></i>
                    </a>
		    <a class="text-bold text-decoration-none fw-bold" href="{{ Route('employee.profile') }}" style="color:#4f4f4f !important;">{{ ucwords(Auth::user()->first_name) }}</a>	
                    <a href="{{ Route('agent.logout') }}"
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
        {{-- <!-- <div class="btn-buy">
            <div class="btn5">Buy</div>
            <div class="btn6">Buy</div>
             </div> --> --}}
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
                @foreach ($currencydata as $value)
                    <?php
                    $rate_margin = $value->rate_margin;
                    if (is_object($rate_margin)) {
                        //echo $current_time."===>".strtotime('10:00 am');
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

                    /*if ($value->currency_name_key != 'AED') {
                        $buy_rate = $value->cur_bye - 0.10;
                    } else {
                        $buy_rate = $value->cur_bye - 0.13;
                    }*/
		    $buy_rate = $value->cur_bye - ($rate_margin->buy_fix_margin + $rate_margin->buy_margin);

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

    <div class="container">
        <!-- Tabs navs -->
        <ul class="nav nav-tabs nav-justified  mt-4" id="ex1" role="tablist">
            <li class="nav-item tab1" role="presentation">
                <a class="nav-link fw-bold text-light mt-3 ms-3 me-3 active" id="ex3-tab-1" data-mdb-toggle="tab"
                   href="#ex3-tabs-1" role="tab" aria-controls="ex3-tabs-1" aria-selected="true"><i
                            class="fa-regular fa-square-plus"></i>
                    <span>&nbsp;Create New Incident</span></a>
            </li>
            <li class="nav-item tab2" role="presentation">
                <a class="nav-link fw-bold text-light mt-3 ms-3 me-3 " id="ex3-tab-2" data-mdb-toggle="tab"
                   href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2" aria-selected="false"><i
                            class="fa-solid fa-arrows-rotate"></i>
                    <span>&nbsp;Update&nbsp;Incident</span></a>
            </li>
            <li class="nav-item tab3" role="presentation">
                <a class="nav-link fw-bold text-light mt-3 ms-3 me-3" id="ex3-tab-3" data-mdb-toggle="tab"
                   href="#ex3-tabs-3" role="tab" aria-controls="ex3-tabs-3" aria-selected="false"><i
                            class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>&nbsp;Check Incident Status</span></a>
            </li>
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->
        <div class="tab-content" id="ex3-content">

            <div class="tab-pane fade show active bg-white" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1">
                <div id="main_frm">
                    <div class="d-flex justify-content   mt-3 pt-4 pb-3">
                        <div class="border-1"></div>
                        <div class="ps-1">
                            Booking
                        </div>
                        <div class="ps-1 fw-bold">Details</div>
                    </div>
                    <form id="insedentInsertForm" name="insedentInsertForm" enctype="multipart/form-data"
                          novalidate="novalidate">
                        @csrf
                        <input type="hidden" value="" name="blockBuy" id="blockBuy">
                        <input type="hidden" value="" name="blockSell" id="blockSell">
                        <input type="hidden" value="" name="agentMargin" id="agentMargin">
                        <input type="hidden" value="" name="currencyFullName" id="currencyFullName">
                        <input type="hidden" value="" name="holiDayDate" id="holiDayDate">
                        <input type="hidden" value="" name="currencyRate" id="currencyRate">
			<input type="hidden" value="" name="buyfixRate" id="buyfixRate">
                        <input type="hidden" value="" name="buyMargin" id="buyMargin">
                        <input type="hidden" id="agentCodeDetails" name="agentCodeDetails"
                               value="{{ $AgentData->agent_code }}">
                        <input type="hidden" id="agentCode" name="agentCode" value="{{ $AgentData->agent_code }}">
                        <input type="hidden" value="{{ $AgentData->agent_buy }}" name="agentBuy" id="agentBuy">
                        <input type="hidden" value="{{ $AgentData->agent_sell }}" name="agentSell" id="agentSell">
                        <input type="hidden" value="0.00" name="sellMargin" id="sellMargin">

                        <div class="row mt-3">
                            <div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">Buy/Sell</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text border-0 border-bottom " for="BuySell"><img
                                                src="../assets/svg/6.svg">
                                    </label>
                                    <select class="form-select border-0 border-bottom pb-0" id="BuySell"
                                            name="BuySell">
                                        <option selected value="">Select</option>
                                        <option value="0">Buy</option>
                                        <option value="1">Sell</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">Forex Card Number</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text  border-0 border-bottom" id="customerNumberName"><img
                                                src="../assets/svg/7.svg">
                                    </span>
                                    <input class="form-control border-0 border-bottom p-2 creditCardText" type="text"
                                           placeholder="Enter Forex Card Number" id="customerNumberName"
                                           name="customerNumberName" maxlength="19" minlength="19"
                                           onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                </div>
                                <input type="hidden" name="incidentType" value="1"/>
                            </div>
							<div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">Passport Number</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text  border-0 border-bottom" id="passport_number"><img
                                                src="../assets/svg/7.svg">
                                    </span>
                                    <input class="form-control border-0 border-bottom p-2" type="text"
                                           placeholder="Enter passport number" id="passport_number"
                                           name="passport_number" maxlength="12" minlength="8">
                                </div>
                                <input type="hidden" name="incidentType" value="1"/>
                            </div>
                            <div class="col-lg-4 col-sm-4 mt-3">
                                <label class="">Document Status</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text border-0 border-bottom " for="documentStatus"><img
                                                src="../assets/svg/8.svg">
                                    </label>
                                    <select class="form-select border-0 border-bottom pb-0" id="documentStatus"
                                            name="documentStatus">
                                        <option selected value="">Select Document Type</option>
                                        <option value="0">Without Document</option>
                                        <option value="1">With Document</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 mt-3 ">
                                <label class="">Transaction Type</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text border-0 border-bottom " for="transaction_type"><img
                                                src="../assets/svg/9.svg">
                                    </label>
                                    <select class="form-select border-0 border-bottom pb-0" id="transaction_type"
                                            name="transaction_type">
                                        <option selected value="">Select Transaction Type</option>
                                        <option value="1">Activation</option>
                                        <option value="2">Reload</option>
                                        <option value="3">Activation + Reload</option>
                                        <option value="4">Encashment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 mt-3" id="traveltype_section">
                                <label class="">Travel Type</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text border-0 border-bottom " for="traveltype"><img
                                                src="../assets/svg/10.svg">
                                    </label>
                                    <select class="form-select border-0 border-bottom pb-0" id="traveltype"
                                            name="traveltype">
                                        <option selected value="">Select Travel type</option>
                                        <option value="1">BTQ</option>
                                        <option value="2">BT</option>
                                        <option value="3">Employment</option>
                                        <option value="4">Student</option>
                                        <option value="5">Immigration</option>
                                        <option value="6"> Medical</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 mt-3" id="date_of_departure_section">
                                <label class="">Date of Departure</label>
                                <div class="input-group mb-3">
                                    {{-- <span class="input-group-text  border-0 border-bottom" id=""><img --}}
                                    {{-- src="../assets/svg/7.svg"> --}}
                                    {{-- </span> --}}
                                    {{-- <input class="form-control border-0 border-bottom p-2" type="date" --}}
                                    {{-- placeholder="Enter Forex Card Number" id="date_of_departure" --}}
                                    {{-- name="date_of_departure"> --}}
                                    <div class="input-group date" id="datepicker">
                                        <input type="text" class="form-control border-0 border-bottom p-2"
                                               id="date_of_departure" name="date_of_departure"
                                               placeholder="Date of Departure" readonly/>
                                        <span class="input-group-append">
                                            <span class="input-group-text bg-light d-block border-0 border-bottom p-2">
                                                <img src="../assets/svg/7.svg">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="bgc mt-3 pt-4 pb-3">
                                <div class="d-flex  pb-3 ">
                                    <div class="border-1"></div>
                                    <div class="ps-1 ">
                                        Block
                                    </div>
                                    <div class="ps-1 fw-bold">Rate</div>
                                    <div class="ms-auto">
                                        <button type="button" class="btn-sm btn-outline-primary rounded-pill p-0 ps-1"
                                                id="addCurrency">
                                            <span class="align-middle fw-bold">Add Currency</span>
                                            <i class="fa-solid fa-plus b-icon align-middle fw-bold"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-sm-4 mt-3">
                                        <label class="">Currency</label>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text border-0 border-bottom "
                                                   for="inputGroupSelect01"><img src="../assets/svg/6.svg">
                                            </label>
                                            <select class="form-select border-0 border-bottom pb-0 bgc"
                                                    id="selected-currency-type" name="selected-currency-type"
                                                    onchange="return getBlockRate(this.value)">
                                                <option selected value="">Currency</option>
                                                <option value="1" id="option_1" class="currency_op">USD/INR
                                                </option>
                                                <option value="2" id="option_2" class="currency_op">EUR/INR
                                                </option>
                                                <option value="3" id="option_3" class="currency_op">GBP/INR
                                                </option>
                                                <option value="4" id="option_4" class="currency_op">AUD/INR
                                                </option>
                                                <option value="5" id="option_5" class="currency_op">CAD/INR
                                                </option>
                                                <option value="6" id="option_6" class="currency_op">JPY/INR
                                                </option>
                                                <option value="7" id="option_7" class="currency_op">SGD/INR
                                                </option>
                                                <option value="8" id="option_8" class="currency_op">CHF/INR
                                                </option>
                                                <option value="9" id="option_9" class="currency_op">AED/INR
                                                </option>
                                                <option value="10" id="option_10" class="currency_op">THB/INR
                                                </option>
                                                 <option value="11" id="option_11" class="currency_op">NZD/INR
                                                </option>
                                                <option value="12" id="option_12" class="currency_op">SAR/INR
                                                </option>
                                                <option value="13" id="option_13" class="currency_op">ZAR/INR
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 mt-3">
                                        <label class="">Forex Value</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text border-0 border-bottom" id="amount_new"><img
                                                        src="../assets/svg/12.svg">
                                            </span>
                                            <input class="form-control border-0 border-bottom p-2 bgc" type="text"
                                                   placeholder="Enter Amount" id="amount" name="amount"
                                                   onkeyup="validateFxValueInput(this);">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 mt-3">
                                        <label class="">INR Amount</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text border-0 border-bottom" id="inr_amount"><img
                                                        src="../assets/svg/13.svg">
                                            </span>
                                            <input class="form-control border-0 border-bottom p-2 bgc fw-bold"
                                                   type="text" placeholder="Auto Calculate in INR" id="inrAmount"
                                                   name="inrAmount" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive-sm pt-4 pb-3 ps-0 pe-0">
                                <table class="table roundedTable " style="padding: 25px 12px;" id="selected-currency">
                                    <tr class="bgc row-font1">
                                        <th scope="col" class="fw-bold">Sr.No</th>
                                        <th scope="col" class="fw-bold">Currency</th>
                                        <th scope="col" class="fw-bold">Fx Amount</th>
                                        <th scope="col" class="fw-bold"> Fx Rate</th>
                                        <th scope="col" class="fw-bold"> INR Amount</th>
                                        <th scope="col" class="fw-bold">Action</th>
                                        <th scope="col"></th>
                                    </tr>
                                    <tbody class="currencyTable">


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>

                                        <th>Total</th>
                                        <th></th>
                                        <th id="total" data-total="0.0">0.0</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            {{-- Travel-type-1 BTQ Doc --}}
                            <div class="bgc  pt-4 pb-4" id="sell-document-block" style="display:none;">
                                <div class="d-flex justify-content ">
                                    <div class="border-1"></div>
                                    <div class="ps-1">Upload</div>
                                    <div class="ps-1 fw-bold">Documents</div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-2 d-none d-md-block">
                                        <img src="../assets/svg/15.svg" class="mt-3 ms-5">
                                    </div>
                                    <div class="col-md-10  p-3">
                                        <div class="form-style">
                                            <div class="row">
												<div class="col-md-6 fx_annexure">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1" for="annexure">
                                                            <div class="text-dark fw-bold col-md-6">Annexure *</div>
                                                            <div class="col-md-6 text-end annexureView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('annexure')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('annexure')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="annexure"
                                                               name="annexure">
                                                    </div>
                                                </div>
												 <div class="col-md-6 fx_application">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1" for="application">
                                                            <div class="text-dark fw-bold col-md-6">Application *</div>
                                                            {{-- <span class="pe-5 me-3 ps-1"> --}}
                                                            {{-- <img src="../assets/svg/14.svg"> --}}
                                                            {{-- Browse or drag & drop</span> --}}
                                                            <div class="col-md-6 text-end applicationView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('application')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('application')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="application"
                                                               name="application">
                                                    </div>
                                                </div>
												<div class="col-md-6 fx_pan">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1" for="pan">
                                                            <div class="text-dark fw-bold col-md-6" id="pan_txt">PAN *</div>
                                                            <div class="col-md-6 text-end panView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('pan')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('pan')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="pan"
                                                               name="pan">
                                                    </div>
                                                </div>
												
                                                <div class="col-md-6 fx_passport">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                                                        <label class="form-attach-label row mb-1" for="passport">
                                                            <div class="text-dark fw-bold col-md-6">Passport *</div>
                                                            {{-- <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg"> &nbsp;Browse or drag & drop</span> --}}

                                                            <div class="col-md-6 text-end passportView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('passport')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('passport')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="passport"
                                                               name="passport">
                                                    </div>
                                                </div>
												 <div class="col-md-6 fx_ticket">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                                                        <label class="form-attach-label row mb-1" for="ticket">
                                                            <div class="text-dark fw-bold col-md-6">Ticket *</div>
                                                            {{-- <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">&nbsp;Browse or drag & drop</span> --}}
                                                            {{-- <img src="../assets/svg/16.svg"> --}}
                                                            <div class="col-md-6 text-end ticketView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('ticket')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('ticket')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="ticket"
                                                               name="ticket">
                                                    </div>
                                                </div>
												 <div class="col-md-6 fx_visa">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                                                        <label class="form-attach-label row mb-1" for="visa">
                                                            <div class="text-dark fw-bold col-md-6">Visa *</div>
                                                            {{-- <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">&nbsp;Browse or drag & drop</span> --}}
                                                            {{-- <img src="../assets/svg/16.svg"> --}}
                                                            <div class="col-md-6 text-end visaView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('visa')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('visa')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="visa"
                                                               name="visa">
                                                    </div>
                                                </div>
												 <div class="col-md-6 fx_sof">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1" for="sof">
                                                            <div class="text-dark fw-bold col-md-6">SOF *</div>
                                                            <div class="col-md-6 text-end sofView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('sof')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('sof')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="sof"
                                                               name="sof">
                                                    </div>
                                                </div>
												 <div class="col-md-6 fx_bank_transfer">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1" for="bankTransfer">
                                                            <div class="text-dark fw-bold col-md-6">Bank Transfer Copy *
                                                            </div>
                                                            <div class="col-md-6 text-end bankTransferView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('bankTransfer')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('bankTransfer')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="bankTransfer"
                                                               name="bankTransfer">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 fx_letter">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                                                        <label class="form-attach-label row mb-1" for="lerms_letter">
                                                            <div class="text-dark fw-bold col-md-6">Lerms Letter *</div>
                                                            {{-- <span class="pe-5 me-3 ps-1"><img src="../assets/svg/14.svg">&nbsp;Browse or drag & drop</span> --}}
                                                            {{-- <img src="../assets/svg/16.svg"> --}}
                                                            <div class="col-md-6 text-end lerms_letterView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('lerms_letter')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('lerms_letter')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="lerms_letter"
                                                               name="lerms_letter">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 fx_refund_form">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1" for="refund_form">
                                                            <div class="text-dark fw-bold col-md-6">Refund Form *</div>
                                                            {{-- <span class="pe-5 me-3 ps-1"> --}}
                                                            {{-- <img src="../assets/svg/14.svg"> --}}
                                                            {{-- Browse or drag & drop</span> --}}
                                                            <div class="col-md-6 text-end refund_formView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('refund_form')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('refund_form')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="refund_form"
                                                               name="refund_form">
                                                    </div>
                                                </div>

                                                
                                               
                                               
                                                <div class="col-md-6 fx_university">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1"
                                                               for="university_letter">
                                                            <div class="text-dark fw-bold col-md-6">University Letter *
                                                            </div>
                                                            <div class="col-md-6 text-end university_letterView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('university_letter')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('university_letter')">
                                                                    <i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="university_letter"
                                                               name="university_letter">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 fx_employment_letter">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                                                        <label class="form-attach-label row mb-1"
                                                               for="employment_letter">
                                                            <div class="text-dark fw-bold col-md-6">Employment Letter*
                                                            </div>
                                                            <div class="col-md-6 text-end employment_letterView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('employment_letter')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('employment_letter')">
                                                                    <i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="employment_letter"
                                                               name="employment_letter">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 fx_emp_declaration_form">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                                                        <label class="form-attach-label row mb-1"
                                                               for="emp_declaration_form">
                                                            <div class="text-dark fw-bold col-md-6">Employment
                                                                Declaration
                                                                Form *
                                                            </div>
                                                            <div class="col-md-6 text-end emp_declaration_formView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('emp_declaration_form')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('emp_declaration_form')">
                                                                    <i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file"
                                                               id="emp_declaration_form" name="emp_declaration_form">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 fx_immigration_d_form">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                                                        <label class="form-attach-label row mb-1"
                                                               for="immigration_d_form">
                                                            <div class="text-dark fw-bold col-md-6">Immigration
                                                                Declaration
                                                                Form*
                                                            </div>
                                                            <div class="col-md-6 text-end immigration_d_formView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('immigration_d_form')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('immigration_d_form')">
                                                                    <i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file"
                                                               id="immigration_d_form" name="immigration_d_form">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 fx_medical_letter">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1 ">
                                                        <label class="form-attach-label row mb-1" for="medical_letter">
                                                            <div class="text-dark fw-bold col-md-6">Medical Letter*
                                                            </div>
                                                            <div class="col-md-6 text-end medical_letterView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('medical_letter')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('medical_letter')">
                                                                    <i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="medical_letter"
                                                               name="medical_letter">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 fx_surrender_letter">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1" for="surrender_letter">
                                                            <div class="text-dark fw-bold col-md-6">Surrender Letter *</div>
                                                            {{-- <span class="pe-5 me-3 ps-1"> --}}
                                                            {{-- <img src="../assets/svg/14.svg"> --}}
                                                            {{-- Browse or drag & drop</span> --}}
                                                            <div class="col-md-6 text-end surrender_letterView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('surrender_letter')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('surrender_letter')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="surrender_letter"
                                                               name="surrender_letter">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 fx_other">
                                                    <div class="form-attach-file border-bottom border-top pt-1 pb-1 mt-1">
                                                        <label class="form-attach-label row mb-1" for="other">
                                                            <div class="text-dark fw-bold col-md-6">Other</div>
                                                            {{-- <span class="pe-5 me-3 ps-1"> --}}
                                                            {{-- <img src="../assets/svg/14.svg"> --}}
                                                            {{-- Browse or drag & drop</span> --}}
                                                            <div class="col-md-6 text-end otherView d-none">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        onclick="readFile('other')"><i
                                                                            class="fa-solid fa-eye"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeSelectedFile('other')"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                            </div>
                                                        </label>
                                                        <input class="form-control" type="file" id="other"
                                                               name="other">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

			    <div class="col-lg-12 col-sm-12 mt-3">
                                <label class="">Comment</label>
                                <div class="input-group mb-3">

                                    <textarea class="form-control border-0 border-bottom p-2" type="text"
                                           placeholder="Enter comment" id="comment"
                                              name="comment" rows="5" style="height: 100px;"></textarea>
                                </div>
                            </div>


                            {{-- Checkbox for agree condition --}}
                            <div class="inciAgreeError">
                                <input type="checkbox" name="incident_agree" id="incident_agree"
                                       class="form-check-input">
                                <label class="fw-bold">I do ensure that maker entry will be done on the Euronet portal.</label>
                            </div>
                        </div>

                    </form>
                    <div class="text-center pt-5">
                        <button type="submit" form="insedentInsertForm"
                                class="btn btn-secondary px-5 fw-bold text-capitalize">Submit
                        </button>
                    </div>
                </div>
                <!--Msg Box-->
                <div class="bgc mt-3 pt-5 pb-5" id="thankyou_box" style="display:none;">
                    <div class="">
                        <div style="font-weight: 500; font-size: 23px;color: #0A0A0A; text-align: center;">
                            Incident Number <span
                                    style="color: #2565ab; font-weight: bolder; font-size: 23px; text-align: center;"
                                    id="incident_number_new"></span>
                        </div>
                    </div>
                    <div class="fw-bold text-center" style="font-size: 26px; color: #0A0A0A;">Thank You For Your Booking
                    </div>
                    <div class="text-center pt-5">
                        <a href="{{ route('employee.dashboard') }}"
                           class="btn btn-secondary px-5 fw-bold text-capitalize">Done</a>
                        {{-- <input type="button" form="insedentInsertForm" class="btn btn-secondary px-5 fw-bold text-capitalize" value="Done" href="{{ url('/agent/agentthankyou') }}"  > --}}
                    </div>
                </div>

                <!--End Msg Box-->
            </div>


            <!-- Update Incident Tab 2 -->
            <div class="tab-pane fade bg-light" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                {{-- <div class="col-lg-12 col-sm-12 mt-3 bgc">
                <label class="">Travel type</label>
                <div class="input-group mb-3">
                    <label class="input-group-text border-0 border-bottom " for="inputGroupSelect01"><img
                            src="../assets/svg/10.svg">
                    </label>
                    <select class="form-select border-0 border-bottom pb-0 bgc" id="inputGroupSelect01">
                        <option selected>Select Travel type</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div> --}}

                <div class="table-responsive-sm table-striped pt-4 pb-3 ps-0 pe-0 mb-3 bg-white">
                    <table id="example" class="table  roundedTable" style="width:100%">
                        <thead style="backgrounD-color: #F4F6F8;">
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;  ">Sr.No</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Incident Number</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Currency Type</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Card Number</th>
			    <th style="color: #2565ab; font-weight: 800;  ">Passport Number</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Foreign Currency<br>Amount</th>
			    <th style="color: #2565ab; font-weight: 800;  ">FX Rate</th>
                            <th style="color: #2565ab; font-weight: 800;  ">INR Amount</th>
			    <th style="color: #2565ab; font-weight: 800;  ">Date</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Status</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Upload Document</th>
                        </tr>
                        </thead>
                        <tbody>
			
                        @if (isset($AgentWithoutDocIncident) && count($AgentWithoutDocIncident)>0)
			
                            @php $count= 1 @endphp
                            @foreach ($AgentWithoutDocIncident as $inci_without_doc)
                                {{-- currency from currency table --}}
                                @php
                                    $ic_currency_type = '';
                                    $ic_frgn_curr_amount = '';
                                    $ic_inr_amount = '';
                                    $ic_currency_rate = '';
                                @endphp
                                @foreach ($inci_without_doc->incidentCurrency as $inci_currency)
                                    @php
                                        $ic_currency_type .= $inci_currency->inci_currency_type . '<br>';
                                        $ic_frgn_curr_amount .= $inci_currency->inci_frgn_curr_amount . '<br>';
                                        $ic_inr_amount .= $inci_currency->inci_inr_amount . '<br>';
                                        $ic_currency_rate .= $inci_currency->inci_currency_rate . '<br>';
                                    @endphp
                                @endforeach
                                {{-- end --}}

                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $inci_without_doc->inci_number }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- <img src="../assets/img/usd_t.png" style="width: 25px; height: 18px"
                                        class="rounded-1" /> --}}
                                            <div class="ms-2">
                                                <p class=" mb-0">
                                                    <?= $ic_currency_type ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $inci_without_doc->inci_forex_card_no }}</td>
									 <td>{{ $inci_without_doc->inci_passport_number }}</td>
                                    <td><?= $ic_frgn_curr_amount ?></td>
				    <td><?= $ic_currency_rate ?></td>
                                    <td><?= $ic_inr_amount ?></td>
				    <td>{{ $inci_without_doc->inci_create_time }}</td>		
                                    <td>
                                        @php
                                            $assign_status = '';
                                            $color = '';
                                            $badge_color = '';
                                        @endphp
                                        @if ($inci_without_doc->inci_status == '3')
                                            @php
                                                $assign_status = 'Under Process';
                                                $color = '#FF9E2E';
                                                $badge_color = 'badge-warning';
                                            @endphp
                                        @elseif($inci_without_doc->inci_status == '2')
                                            @php
                                                $assign_status = 'Expired';
                                                $color = '#2999bd';
                                                $badge_color = 'badge-info';
                                            @endphp
                                        @elseif($inci_without_doc->inci_status == '1')
                                            @php
                                                $assign_status = 'Accepted';
                                                $color = '#0F9500';
                                                $badge_color = 'badge-success';
                                            @endphp
                                        @elseif($inci_without_doc->inci_status == '0')
                                            @php
                                                $assign_status = 'Rejected';
                                                $color = '#EC0000';
                                                $badge_color = 'badge-danger';
                                            @endphp
                                        @endif
                                        <li class="list-group-item d-flex align-items-center"> <span
                                                    class="badge {{ $badge_color }} badge-pill me-3"><i
                                                        class="fa-solid fa-circle"
                                                        style=" color: {{ $color }}; font-size: 9px; margin: -2px;"></i></span>
                                            <span style="color:{{ $color }}; font-weight:700; ">
                                                    {{ $assign_status }} </span>
                                        </li>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" data-id="{{ $inci_without_doc->inci_number }}"
                                           id="{{ $inci_without_doc->inci_number }}"
                                           class="fw-bold uploadDoc">Upload
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
			
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Check Incident Status Tab 3-->
            <div class="tab-pane fade" id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                {{-- <!-- <div class="col-lg-12 col-sm-4 mt-3 bgc">
                            <label class="">Travel type</label>
                                <div class="input-group mb-3">
                                <label class="input-group-text border-0 border-bottom " for="inputGroupSelect01"><img src="../assets/svg/10.svg">
                                 </label>
                                <select class="form-select border-0 border-bottom pb-0 bgc" id="inputGroupSelect01">
                                 <option selected>Select Travel type</option>
                                <option value="1">One</option>
                                        <option value="2">Two</option>
                                         <option value="3">Three</option>
                                       </select>
                                   </div>
                               </div> --> --}}

                <div class="d-flex justify-content bg-white">
                    <div class="border-1"></div>
                    <div class="ps-1">Upload</div>
                    <div class="ps-1 fw-bold">Documents</div>
                </div>

                <div class="table-responsive-sm table-striped pt-4 pb-3 ps-0 pe-0 mb-3 bg-white">
                    <table id="example1" class="table  roundedTable incident_status_tbl" style="width:100%">
                        <thead style="backgrounD-color: #F4F6F8;">
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;  ">Sr.No</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Incident Number</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Currency Type</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Card Number</th>
							<th style="color: #2565ab; font-weight: 800;  ">Passport Number</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Foreign Currency<br>Amount</th>
			    <th style="color: #2565ab; font-weight: 800;  ">FX Rate</th>
                            <th style="color: #2565ab; font-weight: 800;  ">INR Amount</th>
			    <th style="color: #2565ab; font-weight: 800;  ">Date</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Status</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if ($AgentIncidentDetail)
                            @php $count= 1 @endphp
                            @foreach ($AgentIncidentDetail as $agentInci)
                                {{-- currency from currency table --}}
                                @php
                                    $inci_currency_type = '';
                                    $inci_frgn_curr_amount = '';
                                    $inci_inr_amount = '';
                                    $inci_currency_rate = '';
				    $inci_create_time = '';
                                @endphp
                                @foreach ($agentInci->incidentCurrency as $agent_inci_currency)
                                    @php
                                        $inci_currency_type .= $agent_inci_currency->inci_currency_type . '<br>';
                                        $inci_frgn_curr_amount .= $agent_inci_currency->inci_frgn_curr_amount . '<br>';
                                        $inci_inr_amount .= $agent_inci_currency->inci_inr_amount . '<br>';
                                        $inci_currency_rate .= $agent_inci_currency->inci_currency_rate . '<br>';
                                    @endphp
                                @endforeach
                                {{-- end --}}
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $agentInci->inci_number }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- <img src="../assets/img/usd_t.png" style="width: 25px; height: 18px"
                                            class="rounded-1" /> --}}
                                            <div class="ms-2">
                                                <p class=" mb-0"><?= $inci_currency_type ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $agentInci->inci_forex_card_no }}</td>
					<td>{{ $agentInci->inci_passport_number }}</td>
                                    <td><?= $inci_frgn_curr_amount ?></td>
				    <td><?= $inci_currency_rate ?></td>
                                    <td><?= $inci_inr_amount ?></td>
			   	    <td>{{date('d-m-Y H:i:s', strtotime($agentInci->inci_create_time))}}</td>
                                    <td>
                                        @php
                                            $assign_status = '';
                                            $color = '';
                                            $badge_color = '';
                                        @endphp
                                        @if ($agentInci->inci_status == '3')
                                            @php
                                                $assign_status = 'Under Process';
                                                $color = '#FF9E2E';
                                                $badge_color = 'badge-warning';
                                            @endphp
                                        @elseif($agentInci->inci_status == '2')
                                            @php
                                                $assign_status = 'Expired';
                                                $color = '#2999bd';
                                                $badge_color = 'badge-info';
                                            @endphp
                                        @elseif($agentInci->inci_status == '1')
                                            @php
                                                $assign_status = 'Accepted';
                                                $color = '#0F9500';
                                                $badge_color = 'badge-success';
                                            @endphp
                                        @elseif($agentInci->inci_status == '0')
                                            @php
                                                $assign_status = 'Rejected';
                                                $color = '#EC0000';
                                                $badge_color = 'badge-danger';
                                            @endphp
                                        @endif
                                        <li class="list-group-item d-flex align-items-center"> <span
                                                    class="badge {{ $badge_color }} badge-pill me-3"><i
                                                        class="fa-solid fa-circle"
                                                        style=" color: {{ $color }}; font-size: 9px; margin: -2px;"></i></span>
                                            <span style="color:{{ $color }}; font-weight:700; ">
                                                    {{ $assign_status }} </span>
                                        </li>
                                    </td>
                                    <td>
                                        @if ($agentInci->inci_status == '0')
                                            <a href="javascript:void(0)" data-id="{{ $agentInci->inci_number }}"
                                               id="rejected_{{ $agentInci->inci_number }}"
                                               class="fw-bold uploadRejectedDoc">Upload
                                            </a>
					@else
                                            <a href="javascript:void(0)" data-id="{{ $agentInci->inci_number }}"
                                               id="view_{{ $agentInci->inci_number }}"
                                               class="fw-bold viewDoc">View</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
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

    {{-- upload document modal --}}
    <div class="modal fade" id="uploadDocModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="background: rgba(6,39,75,0.5);">
        <div class="modal-dialog  modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div id="loadingoverlay"></div>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel" style="color: #2565ab;">Upload Document</h5>
                    <div type="button" class="btn-close docBtnClose" data-bs-dismiss="modal" aria-label="Close">
                    </div>
                </div>
                {!! Form::open([
                    'route' => ['agent-upload-document'],
                    'class' => 'upload_doc_form',
                    'id' => 'upload_doc_form',
                    'enctype' => 'multipart/form-data',
                    'files' => true,
                ]) !!}

                @csrf
                <div class="modal-body upload-doc-body">

                </div>
                <div class="modal-footer justify-content-center">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn-lg btn btn-secondary"
                            style="background-color: #008204 !important;">Upload
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{-- upload Rejected document modal --}}
    <div class="modal fade" id="uploadRejectedDocModal" tabindex="-1" aria-labelledby="exampleModalLabel1"
         aria-hidden="true" style="background: rgba(6,39,75,0.5);">
        <div class="modal-dialog  modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div id="loadingoverlay"></div>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel1" style="color: #2565ab;">Upload Document</h5>
                    <div type="button" class="btn-close docBtnClose" data-bs-dismiss="modal" aria-label="Close">
                    </div>
                </div>
                {!! Form::open([
                    'route' => ['agent-upload-rejected-document'],
                    'class' => 'upload_rej_doc_form',
                    'id' => 'upload_rej_doc_form',
                    'enctype' => 'multipart/form-data',
                    'files' => true,
                ]) !!}

                @csrf
                <div class="modal-body upload-rej-doc-body">
                    <h3>Hello</h3>
                </div>
                <div class="modal-footer justify-content-center">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn-lg btn btn-secondary"
                            style="background-color: #008204 !important;">Upload
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{-- --------- --}}


    <div class="modal" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <iframe src="" id="iframe" title="W3Schools Free Online Web Tutorials" class="w-100"
                            style="height: 500px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            onclick="closeModal()">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="viewpopupModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="closeModal()"></button>
                </div>
                <div class="modal-body viewpopup-body" >

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            onclick="closeModal()">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- upload Rejected document modal --}}
    <div class="modal fade" id="viewDocModal" tabindex="-1" aria-labelledby="exampleModalLabel1"
         aria-hidden="true" style="background: rgba(6,39,75,0.5);">
        <div class="modal-dialog  modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div id="loadingoverlay"></div>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel1" style="color: #2565ab;">Upload Document</h5>
                    <div type="button" class="btn-close docBtnClose" data-bs-dismiss="modal" aria-label="Close">
                    </div>
                </div>
                {!! Form::open([
                    'route' => ['agent-upload-rejected-document'],
                    'class' => 'upload_rej_doc_form',
                    'id' => 'upload_rej_doc_form',
                    'enctype' => 'multipart/form-data',
                    'files' => true,
                ]) !!}

                @csrf
                <div class="modal-body upload-rej-doc-body">
                    <h3>Hello</h3>
                </div>
                <div class="modal-footer justify-content-center">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn-lg btn btn-secondary"
                            style="background-color: #008204 !important;">Upload
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{-- --------- --}}	
    <div
      class="modal fade bank-change-notice-modal"
      id="staticBackdrop"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content container">
          <div class="modal-body row row-cols-2">
            <div class="col-12 col-sm-6 modal-content-side modal-side-img">
              <img
                src="../images/popup-screen-bank-notice.png"
                class="img-fluid"
                alt="bank img"
              />
            </div>
            <div class="col-12 col-sm-6 modal-content-side modal-side-img">
              <div class="modal-header">
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <h1 class="im-title">Important Notice</h1>
              <p class="modal-desc">
                We had changed our HDFC Bank Account to
                <b>Kotak Bank.</b>
              </p>
              <p class="modal-desc">New Bank Account is <b>Kotak Mahendra Bank,</b> </p>
              <p class="modal-desc">
                <b> Account Number: 09572010000386 </b>
                <br />
                <b>IFSC code: KKBK0000957.</b>
              </p>
              <p class="modal-desc">
                Please transfer all future payments to the new account.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <style>
    .bank-change-notice-modal {
      font-family: "Roboto", sans-serif;
    }
    .bank-change-notice-modal .modal-dialog {
      max-width: 900px;
    }
    .bank-change-notice-modal .modal-header {
      border-bottom: none;
      padding: 5px 0;
    }
    .bank-change-notice-modal .modal-body {
      min-height: 440px;
    }
    .bank-change-notice-modal .modal-desc {
      font-size: 19px;
      font-family: inherit;
      font-weight: 400;
    }
    .bank-change-notice-modal .modal-header .btn-close:focus {
      outline: none;
      border: none;
      box-shadow: none;
    }
    .im-title {
      font-weight: 700;
      font-style: normal;
      margin-bottom: 18px;
    }

    @media (max-width: 576px) {
      .bank-change-notice-modal .modal-header {
        position: absolute;
        top: 0;
        right: 0;
      }
      .bank-change-notice-modal .modal-desc {
        font-size: 16px;
      }
    }
  </style>
  
	
@endsection
@push('pagescript')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.js">
    </script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js">
    </script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#traveltype').change(function () {
	    $('#pan_txt').html('PAN *');
            var travelType = parseInt($(this).val());
            if (parseInt($('#documentStatus').val()) == 1) {
                $('#sell-document-block').show();
                switch (travelType) {
                    case 1:
                        if($('#BuySell').val()==1) {
                            $('.fx_passport').show();
                            $('.fx_letter').hide();
                            $('.fx_visa').show();
                            $('.fx_ticket').show();
                            $('.fx_pan').show();
                            $('.fx_application').show();
                            $('.fx_annexure').show();
                            $('.fx_bank_transfer').show();
                            $('.fx_sof').show();
                            $('.fx_other').show();
                            $('.fx_university').hide();
                            $('.fx_emp_declaration_form').hide();
                            $('.fx_employment_letter').hide();
                            $('.fx_immigration_d_form').hide();
                            $('.fx_medical_letter').hide();
                            $('.fx_refund_form').hide();
                            $('.fx_surrender_letter').hide();
                        }
                        else{
                            $('.fx_passport').show();
                            $('.fx_letter').hide();
                            $('.fx_visa').hide();
                            $('.fx_ticket').hide();
                            $('.fx_pan').hide();
                            $('.fx_application').hide();
                            $('.fx_annexure').show();
                            $('.fx_bank_transfer').hide();
                            $('.fx_sof').hide();
                            $('.fx_other').hide();
                            $('.fx_university').hide();
                            $('.fx_emp_declaration_form').hide();
                            $('.fx_employment_letter').hide();
                            $('.fx_immigration_d_form').hide();
                            $('.fx_medical_letter').hide();
                            $('.fx_refund_form').show();
                            $('.fx_surrender_letter').hide();
                        }
                        break;

                    case 2:
			$('#pan_txt').html('Company Pan Card *');
                        if($('#BuySell').val()==1) {
                            $('.fx_passport').show();
                            $('.fx_letter').show();
                            $('.fx_visa').hide();
                            $('.fx_ticket').hide();
                            $('.fx_pan').show();
                            $('.fx_application').show();
                            $('.fx_annexure').show();
                            $('.fx_bank_transfer').show();
                            $('.fx_sof').hide();
                            $('.fx_other').show();
                            $('.fx_university').hide();
                            $('.fx_emp_declaration_form').hide();
                            $('.fx_employment_letter').hide();
                            $('.fx_immigration_d_form').hide();
                            $('.fx_medical_letter').hide();
                            $('.fx_refund_form').hide();
                            $('.fx_surrender_letter').hide();
                        }
                        else{
                            $('.fx_passport').show();
                            $('.fx_letter').hide();
                            $('.fx_visa').hide();
                            $('.fx_ticket').hide();
                            $('.fx_pan').hide();
                            $('.fx_application').hide();
                            $('.fx_annexure').show();
                            $('.fx_bank_transfer').hide();
                            $('.fx_sof').hide();
                            $('.fx_other').hide();
                            $('.fx_university').hide();
                            $('.fx_emp_declaration_form').hide();
                            $('.fx_employment_letter').hide();
                            $('.fx_immigration_d_form').hide();
                            $('.fx_medical_letter').hide();
                            $('.fx_refund_form').show();
                            $('.fx_surrender_letter').show();
                        }
                        break;
                    case 3:
                        $('.fx_passport').show();
                        $('.fx_letter').hide();
                        $('.fx_visa').show();
                        $('.fx_ticket').show();
                        $('.fx_pan').show();
                        $('.fx_application').show();
                        $('.fx_annexure').show();
                        $('.fx_bank_transfer').hide();
                        $('.fx_sof').show();
                        $('.fx_other').show();
                        $('.fx_university').hide();
                        $('.fx_emp_declaration_form').show();
                        $('.fx_employment_letter').show();
                        $('.fx_immigration_d_form').hide();
                        $('.fx_medical_letter').hide();
                        $('.fx_refund_form').hide();
                        $('.fx_surrender_letter').hide();
                        break;
                    case 4:
                        $('.fx_passport').show();
                        $('.fx_letter').hide();
                        $('.fx_visa').show();
                        $('.fx_ticket').show();
                        $('.fx_pan').show();
                        $('.fx_application').show();
                        $('.fx_annexure').show();
                        $('.fx_bank_transfer').hide();
                        $('.fx_sof').show();
                        $('.fx_other').show();
                        $('.fx_university').show();
                        $('.fx_emp_declaration_form').hide();
                        $('.fx_employment_letter').hide();
                        $('.fx_immigration_d_form').hide();
                        $('.fx_medical_letter').hide();
                        $('.fx_refund_form').hide();
                        $('.fx_surrender_letter').hide();
                        break;
                    case 5:
                        $('.fx_passport').show();
                        $('.fx_letter').hide();
                        $('.fx_visa').show();
                        $('.fx_ticket').show();
                        $('.fx_pan').show();
                        $('.fx_application').show();
                        $('.fx_annexure').show();
                        $('.fx_bank_transfer').hide();
                        $('.fx_sof').show();
                        $('.fx_other').show();
                        $('.fx_university').hide();
                        $('.fx_emp_declaration_form').hide();
                        $('.fx_employment_letter').hide();
                        $('.fx_immigration_d_form').show();
                        $('.fx_medical_letter').hide();
                        $('.fx_refund_form').hide();
                        $('.fx_surrender_letter').hide();
                        break;
                    case 6:
                        $('.fx_passport').show();
                        $('.fx_letter').show();
                        $('.fx_visa').hide();
                        $('.fx_ticket').hide();
                        $('.fx_pan').show();
                        $('.fx_application').show();
                        $('.fx_annexure').show();
                        $('.fx_bank_transfer').hide();
                        $('.fx_sof').hide();
                        $('.fx_other').hide();
                        $('.fx_university').hide();
                        $('.fx_emp_declaration_form').hide();
                        $('.fx_employment_letter').hide();
                        $('.fx_immigration_d_form').hide();
                        $('.fx_medical_letter').show();
                        $('.fx_refund_form').hide();
                        $('.fx_surrender_letter').hide();
                        break;
                        case 7:
                        $('.fx_passport').show();
                        $('.fx_letter').show();
                        $('.fx_visa').hide();
                        $('.fx_ticket').hide();
                        $('.fx_pan').show();
                        $('.fx_application').show();
                        $('.fx_annexure').show();
                        $('.fx_bank_transfer').hide();
                        $('.fx_sof').hide();
                        $('.fx_other').hide();
                        $('.fx_university').hide();
                        $('.fx_emp_declaration_form').hide();
                        $('.fx_employment_letter').hide();
                        $('.fx_immigration_d_form').hide();
                        $('.fx_medical_letter').hide();
                        $('.fx_refund_form').hide();
                        $('.fx_surrender_letter').hide();
                        break;
                }
            }
        });

        function closeModal() {
            $('#viewModal').modal("hide");
	    $('#viewpopupModal').modal("hide");
        }

        function removeSelectedFile(file) {
            $('#' + file).val("");
            $('.' + file + 'View').removeClass("d-block").addClass("d-none");
        }

        function readFile(fileName) {
            var input = $('#' + fileName)[0];
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#iframe').attr("src", e.target.result);
                    $('#viewModal').modal("show");
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // view Upload Document Modal
        $(document).ready(function () {
         $('#staticBackdrop').modal("show");
     
        $(document).on('click', '.btn-close', function () {
            $('#staticBackdrop').modal("hide");
       });
            $('#passport').change(function (e) {
                if (e.target.value) {
                    $('.passportView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.passportView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#visa').change(function (e) {
                if (e.target.value) {
                    $('.visaView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.visaView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#pan').change(function (e) {
                if (e.target.value) {
                    $('.panView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.panView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#ticket').change(function (e) {
                if (e.target.value) {
                    $('.ticketView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.ticketView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#application').change(function (e) {
                if (e.target.value) {
                    $('.applicationView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.applicationView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#refund_form').change(function (e) {
                if (e.target.value) {
                    $('.refund_formView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.refund_formView').removeClass("d-block").addClass("d-none");
                }
            });
            $('#surrender_letter').change(function (e) {
                if (e.target.value) {
                    $('.surrender_letterView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.surrender_letterView').removeClass("d-block").addClass("d-none");
                }
            });



            $('#annexure').change(function (e) {
                if (e.target.value) {
                    $('.annexureView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.annexureView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#bankTransfer').change(function (e) {
                if (e.target.value) {
                    $('.bankTransferView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.bankTransferView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#sof').change(function (e) {
                if (e.target.value) {
                    $('.sofView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.sofView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#other').change(function (e) {
                if (e.target.value) {
                    $('.otherView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.otherView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#lerms_letter').change(function (e) {
                if (e.target.value) {
                    $('.lerms_letterView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.lerms_letterView').removeClass("d-block").addClass("d-none");
                }
            });
            $('#university_letter').change(function (e) {
                if (e.target.value) {
                    $('.university_letterView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.university_letterView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#emp_declaration_form').change(function (e) {
                if (e.target.value) {
                    $('.emp_declaration_formView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.emp_declaration_formView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#employment_letter').change(function (e) {
                if (e.target.value) {
                    $('.employment_letterView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.employment_letterView').removeClass("d-block").addClass("d-none");
                }
            });

            $('#immigration_d_form').change(function (e) {
                if (e.target.value) {
                    $('.immigration_d_formView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.immigration_d_formView').removeClass("d-block").addClass("d-none");
                }
            });
            $('#medical_letter').change(function (e) {
                if (e.target.value) {
                    $('.medical_letterView').removeClass("d-none").addClass("d-block");
                } else {
                    $('.medical_letterView').removeClass("d-block").addClass("d-none");
                }
            });

            $(document).on('click', '.uploadDoc', function () {
                var inci_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('agent-view-upload-document') }}",
                    data: {
                        inci_id: inci_id,
                    },
                    success: function (result) {
                        $(".upload-doc-body").html(result);
                        $("#uploadDocModal").modal("show");
                        // $("#" + inci_id).text("Uploaded");
                    }
                });
            });
            //Submit form uplaod document
            $(document).on('submit', '.upload_doc_form', function (e) {
                e.preventDefault();
                $('#loadingoverlay').addClass("loading");
                var fd = new FormData();
                if ($('#passport1').length > 0) {
                    var file1 = $('#passport1')[0].files[0];
                    fd.append('passport', file1);
                }
                if ($('#visa1').length > 0) {
                    var file2 = $('#visa1')[0].files[0];
                    fd.append('visa', file2);
                }
                if ($('#ticket1').length > 0) {
                    var file3 = $('#ticket1')[0].files[0];
                    fd.append('ticket', file3);
                }
                if ($('#pan1').length > 0) {
                    var file4 = $('#pan1')[0].files[0];
                    fd.append('pan', file4);
                }
                if ($('#application1').length > 0) {
                    var file5 = $('#application1')[0].files[0];
                    fd.append('application', file5);
                }
                if ($('#annexure1').length > 0) {
                    var file6 = $('#annexure1')[0].files[0];
                    fd.append('annexure', file6);
                }
                if ($('#banktransfer1').length > 0) {
                    var file7 = $('#banktransfer1')[0].files[0];
                    fd.append('banktransfer', file7);
                }
                if ($('#sof1').length > 0) {
                    var file8 = $('#sof1')[0].files[0];
                    fd.append('sof', file8);
                }
                if ($('#other1').length > 0) {
                    var file9 = $('#other1')[0].files[0];
                    fd.append('other', file9);
                }
                if ($('#lerms_letter1').length > 0) {
                    var file10 = $('#lerms_letter1')[0].files[0];
                    fd.append('lerms_letter', file10);
                }
                if ($('#university_letter1').length > 0) {
                    var file11 = $('#university_letter1')[0].files[0];
                    fd.append('university_letter', file11);
                }
                if ($('#employment_letter1').length > 0) {
                    var file12 = $('#employment_letter1')[0].files[0];
                    fd.append('employment_letter', file12);
                }
                if ($('#emp_declaration_form1').length > 0) {
                    var file13 = $('#emp_declaration_form1')[0].files[0];
                    fd.append('emp_declaration_form', file13);
                }
                if ($('#immigration_d_form1').length > 0) {
                    var file14 = $('#immigration_d_form1')[0].files[0];
                    fd.append('immigration_d_form', file14);
                }
                if ($('#medical_letter1').length > 0) {
                    var file15 = $('#medical_letter1')[0].files[0];
                    fd.append('medical_letter', file15);
                }

                var serializeData = $(this).serializeArray();
                $.each(serializeData, function (key, val) {
                    fd.append(val['name'], val['value']);
                });
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (result) {
                        if (result.success == 'True') {
                            $(".upload-doc-body").html('')
                            $("#uploadDocModal").modal("hide");
                            $('#loadingoverlay').removeClass("loading");
                            $('#loadingoverlay').css("display", "none");
                            toastr.success('Document uploaded successfully');
                            window.location.reload();
                        } else {
                            $('#loadingoverlay').removeClass("loading");
                            $('#loadingoverlay').css("display", "none");
                            Swal.fire({
                                icon: 'warning',
                                title: 'Sorry!',
                                text: result.errMessage,
                                footer: ''
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.docBtnClose', function () {
                $(".upload-doc-body").html('')
                $("#uploadDocModal").modal("hide");
            });
        });
        // ------end-----

        //Upload rejected doc modal
        $(document).on('click', '.uploadRejectedDoc', function () {
            var inci_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ route('agent-view-rej-upload-doc') }}",
                data: {
                    inci_id: inci_id,
                },
                success: function (result) {
                    console.log(result);
                    $(".upload-rej-doc-body").html(result);
                    $("#uploadRejectedDocModal").modal("show");
                    // $("#" + inci_id).text("Uploaded");
                }
            });
        });

	//View doc modal
        $(document).on('click', '.viewDoc', function () {
            var inci_id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('agent-view-document') }}",
                data: {
                    inci_id: inci_id,
                },
                success: function (result) {
                    //console.log(result);
                    $(".viewpopup-body").html(result);
                    $("#viewpopupModal").modal("show");
                    // $("#" + inci_id).text("Uploaded");
                }
            });
        });

        //Submit form uplaod rejected document
        $(document).on('submit', '.upload_rej_doc_form', function (e) {
            e.preventDefault();
            $('#loadingoverlay').addClass("loading");
            var fd = new FormData();
            if ($('#passport2').length > 0) {
                var file1 = $('#passport2')[0].files[0];
                fd.append('passport', file1);
            }
            if ($('#visa2').length > 0) {
                var file2 = $('#visa2')[0].files[0];
                fd.append('visa', file2);
            }
            if ($('#ticket2').length > 0) {
                var file3 = $('#ticket2')[0].files[0];
                fd.append('ticket', file3);
            }
            if ($('#pan2').length > 0) {
                var file4 = $('#pan2')[0].files[0];
                fd.append('pan', file4);
            }
            if ($('#application2').length > 0) {
                var file5 = $('#application2')[0].files[0];
                fd.append('application', file5);
            }
            if ($('#annexure2').length > 0) {
                var file6 = $('#annexure2')[0].files[0];
                fd.append('annexure', file6);
            }
            if ($('#banktransfer2').length > 0) {
                var file7 = $('#banktransfer2')[0].files[0];
                fd.append('banktransfer', file7);
            }
            if ($('#sof2').length > 0) {
                var file8 = $('#sof2')[0].files[0];
                fd.append('sof', file8);
            }
            if ($('#other2').length > 0) {
                var file9 = $('#other2')[0].files[0];
                fd.append('other', file9);
            }
            if ($('#lerms_letter2').length > 0) {
                var file10 = $('#lerms_letter2')[0].files[0];
                fd.append('lerms_letter', file10);
            }
            if ($('#university_letter2').length > 0) {
                var file11 = $('#university_letter2')[0].files[0];
                fd.append('university_letter', file11);
            }
            if ($('#employment_letter2').length > 0) {
                var file12 = $('#employment_letter2')[0].files[0];
                fd.append('employment_letter', file12);
            }
            if ($('#emp_declaration_form2').length > 0) {
                var file13 = $('#emp_declaration_form2')[0].files[0];
                fd.append('emp_declaration_form', file13);
            }
            if ($('#immigration_d_form2').length > 0) {
                var file14 = $('#immigration_d_form2')[0].files[0];
                fd.append('immigration_d_form', file14);
            }
            if ($('#medical_letter2').length > 0) {
                var file15 = $('#medical_letter2')[0].files[0];
                fd.append('medical_letter', file15);
            }
            if ($('#refound2').length > 0) {
                var file16 = $('#refound2')[0].files[0];
                fd.append('refound', file16);
            }            
	    if ($('#surrender_letter2').length > 0) {
                var file17 = $('#surrender_letter2')[0].files[0];
                fd.append('surrender_letter', file17);
            }

            var serializeData = $(this).serializeArray();
            $.each(serializeData, function (key, val) {
                fd.append(val['name'], val['value']);
            });
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: fd,
                cache: false,
                contentType: false,
                processData: false,

                success: function (result) {
                    if (result == 'success') {
                        $(".upload-rej-doc-body").html('')
                        $("#uploadRejectedDocModal").modal("hide");
                        $('#loadingoverlay').removeClass("loading");
                        $('#loadingoverlay').css("display", "none");
                        toastr.success('Document uploaded successfully');
                        window.location.reload();
                    } else {
                        $('#loadingoverlay').removeClass("loading");
                        $('#loadingoverlay').css("display", "none");
                    }
                }
            });
        });

        $(document).on('click', '.docBtnClose', function () {
            $(".upload-rej-doc-body").html('')
            $("#uploadRejectedDocModal").modal("hide");
        });
        // ------end reject doc upload model-----

        $("#BuySell").change(function () {
            $("#documentStatus option[value*='0']").prop('disabled', false);
            $("#documentStatus option[value*='1']").prop('disabled', false);
            $('#documentStatus').val('');
            $('#traveltype').val('');
            $('#traveltype').empty().append('<option selected value="">Select Travel type</option>');
            $("#transaction_type").val("");
            var buysheelval = $('#BuySell').val();
            $('#bt-sell-document-block').hide();
            $('#sell-document-block').hide();

            if (buysheelval == 0) {
                //$('#sell-document-block').hide();
                $('#documentStatus').val(1);
                $("#documentStatus option[value*='0']").prop('disabled',true);
                //$('#documentStatus').attr('readonly');
                //$('#transaction_type').prop('disabled', 'disabled');
                $("#transaction_type option[value*='1']").prop('disabled', 'disabled');
                $("#transaction_type option[value*='2']").prop('disabled', 'disabled');
                $("#transaction_type option[value*='3']").prop('disabled', 'disabled');
                $("#transaction_type option[value*='4']").prop('disabled', false);
                $("#transaction_type").val("4");
                //$('#sell-document-block').show();
                //$('#traveltype_section').hide();
                $('#date_of_departure_section').hide();
                $("#traveltype").attr("required", false);
                $("#date_of_departure").attr("required", false);

                $("#passport").attr("required", false);
                $("#visa").attr("required", false);
                $("#ticket").attr("required", false);
                $("#pan").attr("required", false);
                $("#application").attr("required", false);
                $("#annexure").attr("required", false);
                $("#bankTransfer").attr("required", false);
                $("#sof").attr("required", false);

                $('#traveltype').append(new Option('BTQ', 1));
                $('#traveltype').append(new Option('BT', 2));
            } else {

                $('#buy-document-block').hide();
                $('#documentStatus').prop('disabled', false);
                $("#transaction_type option[value*='1']").prop('disabled', false);
                $("#transaction_type option[value*='2']").prop('disabled', false);
                $("#transaction_type option[value*='3']").prop('disabled', false);
                $("#transaction_type option[value*='4']").prop('disabled', 'disabled');
                $('#traveltype_section').show();
                $('#date_of_departure_section').show();
                $("#traveltype").attr("required", true);
                $("#date_of_departure").attr("required", true);

                $('#traveltype').append(new Option('BTQ', 1));
                $('#traveltype').append(new Option('BT', 2));
                $('#traveltype').append(new Option('Employment', 3));
                $('#traveltype').append(new Option('Student', 4));
                $('#traveltype').append(new Option('Immigration', 5));
                $('#traveltype').append(new Option('Medical', 6));
                
            }
        });


        $("#documentStatus").change(function () {
            $('#sell-document-block').hide();

            $('#bt-sell-document-block').hide();
            var documentType = $(this).val();
            var BuySell = $('#BuySell').val();
            $('#traveltype').val('');

            if (BuySell == 1) {
                if (documentType == 1) {
                    // $('#sell-document-block').show();
                    $('#document-comments').show();
                    $('#buy-document-block').hide();
                    $('.sell-with-doc').show();
                    $('#DepartureDate').removeClass('sellDocument');
                    $('#passportNumber').removeClass('sellDocument');
                    $('#insedentInsertForm').validate().settings.ignore = ".buyDocument";

                    $("#passport").attr("required", true);
                    $("#visa").attr("required", true);
                    $("#ticket").attr("required", true);
                    $("#pan").attr("required", true);
                    $("#application").attr("required", true);
                    $("#annexure").attr("required", true);
                    $("#bankTransfer").attr("required", true);
                    $("#sof").attr("required", true);
                } else {
                    $('#sell-document-block').hide();
                    $('#buy-document-block').hide();
                    $('#document-comments').hide();
                    $('.sell-with-doc').hide();
                    $('#DepartureDate').addClass('sellDocument');
                    $('#passportNumber').addClass('sellDocument');
                    $('#insedentInsertForm').validate().settings.ignore = ".buyDocument,.sellDocument,.comments";

                    $("#passport").attr("required", false);
                    $("#visa").attr("required", false);
                    $("#ticket").attr("required", false);
                    $("#pan").attr("required", false);
                    $("#application").attr("required", false);
                    $("#annexure").attr("required", false);
                    $("#bankTransfer").attr("required", false);
                    $("#sof").attr("required", false);
                }
            } else {
                $('#sell-document-block').hide();
                $('#buy-document-block').show();
                $('.sell-with-doc').hide();
                $('#DepartureDate').removeClass('sellDocument');
                $('#passportNumber').removeClass('sellDocument');
                 $("#bankTransfer").attr("required", false);
                $('#insedentInsertForm').validate().settings.ignore = ".sellDocument";
            }
            $('#buy-doc-status').val(documentType);
        });


        function validateFxValueInput(input) {
            const validPattern = /^[0-9]*\.?[0-9]*$/;
            if (validPattern.test(input.value)) {
                calculateInr();
            } else {
                input.value = "";
            }
        }

        function calculateInr() {
            var amount = $('#amount').val();

            //Here fetch Dropsown box for getting buy rate and sell rate
            var BuySell = $('#BuySell').val();
            //alert(BuySell);
            if (BuySell == 'Select') {
                $('#BuySellError').html('Please Select Any One');
            } else {

                $('#BuySellError').html('');

                var agentBuy = $('#agentBuy').val();
                var agentSell = $('#sellMargin').val();
                //This is buy Rate
                if (BuySell == 0) {

                    //alert(agentBuy);
                    var buyRate = agentBuy;
                    var agentMargin = buyRate / 100;
                    var inrRate = $('#blockBuy').val();


                    var currencyFullName = $('#currencyFullName').val();
		    var BuyMargin = $('#buyMargin').val();
                    var BuyFixMargin = $('#buyfixRate').val();

                    //alert(currencyFullName);
                    if (currencyFullName == 'AED') {

                        var currencyRate = (parseFloat(inrRate) - (parseFloat(BuyFixMargin) + parseFloat(BuyMargin)));
                        var inrCalculation = (parseFloat(currencyRate)) * amount;
                    } else {

                        var currencyRate = (parseFloat(inrRate) - (parseFloat(BuyFixMargin) + parseFloat(BuyMargin)));
                        var inrCalculation = (parseFloat(currencyRate)) * amount;

                    }

                    //alert(inrCalculation);
                    $('#inrAmount').val(inrCalculation.toFixed());
                    $('#agentMargin').val(agentBuy);
                    //$('#currencyRate').val(currencyRate.toFixed(2));
		    if (currencyFullName == 'JPY') {

                        $('#currencyRate').val(currencyRate.toFixed(4));
                    }
                    else{
                        $('#currencyRate').val(currencyRate.toFixed(2));
                    }

                    //$('#autoLoader').hide();
                }
                //This is Sell Rate
                else if (BuySell == 1) {

                    var sellRate = agentSell;
                    console.log("hii==>"+sellRate);
                    var agentMargin = sellRate / 100;

                    var inrRate = $('#blockSell').val();
                    var currency_rate_val = parseFloat(inrRate) + parseFloat(sellRate);
                    var currencyFullName = $('#currencyFullName').val();
                    //alert(currencyFullName);
                    if (currencyFullName == 'JPY/INR') {
                        var currencyRate = (parseFloat(inrRate) + parseFloat(sellRate));
                        var inrCalculation = (parseFloat(inrRate) + parseFloat(agentMargin)) * amount;
                    } else {
			console.log("Inrrate==>"+parseFloat(inrRate)+"currency_rate_val==>"+parseFloat(currency_rate_val));
			console.log("Inrrate==>"+parseFloat(inrRate)+"sellRate==>"+parseFloat(sellRate));

                        var currencyRate = parseFloat(currency_rate_val);
                       // var calculation =((parseFloat(inrRate) * parseFloat(sellRate)))/100;
	               // console.log("calculation==>"+parseFloat(currencyRate));
                       // var inrCalculation = ( parseFloat(calculation) + parseFloat(inrRate)) * amount;
   var inrCalculation = ( parseFloat(currencyRate) * amount );

                        // var currencyRate = parseFloat(currency_rate_val);
                        // var inrCalculation = (parseFloat(inrRate) + parseFloat(sellRate)) * amount;
			console.log("currencyRate ==>"+currencyRate);
			console.log("inrCalculation ==>"+inrCalculation);

                    }

                    $('#inrAmount').val(inrCalculation.toFixed());
                    $('#agentMargin').val(agentSell);
                    //$('#currencyRate').val(currencyRate.toFixed(2));
		    if (currencyFullName == 'JPY') {

                        $('#currencyRate').val(currencyRate.toFixed(4));
                    }
                    else{
                        $('#currencyRate').val(currencyRate.toFixed(2));
                    }
                    //alert(agentMargin);
                    //$('#autoLoader').hide();
                }
            }
        }

        var getBuyAndSellMargin = "{{ url('getBuyAndSellMargin') }}";

        //this function is call for getting block value (currency buy rate & sel rate)
        function getBlockRate(currencyId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').val()
                },
                url: getBuyAndSellMargin,
                method: 'post',
                data: {
                    currencyId: currencyId
                },
                success: function (result) {
                    var jsonValue = JSON.parse(result);
                    //Put Bye Value In blockBuy Id
                    $('#blockBuy').val(jsonValue.cur_bye);
                    //Put Sell Value In blockBuy Id
                    $('#blockSell').val(jsonValue.cur_sell);
                    //Curency Name
                    $('#currencyFullName').val(jsonValue.currency_name_key);
                    //$('#customerNumberName').focus();
		    $('#buyfixRate').val(jsonValue.buy_fix_margin);
                    $('#buyMargin').val(jsonValue.buy_margin);

                    //append rate value
                    var current_time = jsonValue.currentTime;
                    var is_holiday = jsonValue.is_holiday;
                    console.log("is_holiday==>"+is_holiday);
                     console.log("current_time==>"+current_time);
                    console.log("jsonValue==>"+jsonValue);
                     console.log(jsonValue);
                    if(is_holiday == false){
                         console.log("if");
                        switch (true) {
                        case (current_time >= jsonValue.time_10 && current_time < jsonValue.time_12):
                            console.log("case1");
                            $('#sellMargin').val(jsonValue.sell_margin_10_12);
                            break;
                        case (current_time >= jsonValue.time_12 && current_time < jsonValue.time_14):
                            console.log("case2");
                            $('#sellMargin').val(jsonValue.sell_margin_12_2);
                            break;
                        case (current_time >= jsonValue.time_14 && current_time < jsonValue.time_15_30):
                            console.log("case3");
                            $('#sellMargin').val(jsonValue.sell_margin_2_3_30);
                            break;
                        case (current_time >= jsonValue.time_15_30):
                            $('#sellMargin').val(jsonValue.sell_margin_3_30_end);
                            console.log("case4");
                            break;
                        default:
                            $('#sellMargin').val(jsonValue.sell_margin);
                            console.log("default");
                            break;
                     }
                    }else{
 console.log("else");
                        $('#sellMargin').val(jsonValue.holiday_margin);
                    }
                    $('#amount').focus();
                    if ($('#amount').val() != 'undefined') {
                        calculateInr();
                    }
                }
            });

        }

        var rowCount = $("#selected-currency tbody tr").length;
        $('#addCurrency').click(function () {

            var BuySell = $("#BuySell").val();
            var selectedCurrencyType = $("#selected-currency-type").val();
            var amount = $("#amount").val();
            var inramount = $("#inrAmount").val();
            var currencyRate = $("#currencyRate").val();
			if(selectedCurrencyType=='10'){
                amount =Math.round(amount);
            }
            
            var selectedCurrencyTypeName = $("#selected-currency-type option:selected").html();
            var validate = false;
            if (BuySell == 'error') {

                $('#BuySellError').html('Please Select Buy Or Sell');
            } else {
                $('#BuySellError').html('');
            }

            if ($.isNumeric(amount) && amount!=0 && selectedCurrencyType!='' ) {
                validate = true;
                $('#currencyError').html('');
            } else {
                $('#currencyError').html('Add min one currency.');
            }
            
            

            //Hide add currency button
            var t_val = $("#transaction_type option:selected").val();
            if (rowCount > 0) {
                if (t_val == 1) {
                    $('#addCurrency').hide();
                }
            }

            if (validate) {
               // $('#option_' + selectedCurrencyType).hide();
                var html = '';
                html += '<tr id="row-' + rowCount + '">';
                html += ' <td>';
                html += '   <span>' + rowCount + '</span>';
                html += ' </td>';
                html += ' <td>';
                html += '   <span>' + selectedCurrencyTypeName + '</span>';
                html += '   <input type="hidden" class="inci_currency_type" name="currency[' + rowCount +
                    '][inci_currency_type]" value="' +
                    selectedCurrencyTypeName + '" />';
                html += '   <input type="hidden" name="currency[' + rowCount + '][inci_frgn_curr_amount]" value="' +
                    amount + '" />';
                html += '   <input type="hidden" name="currency[' + rowCount + '][inci_inr_amount]" value="' +
                    inramount + '" />';
                html += '   <input type="hidden" name="currency[' + rowCount + '][inci_currency_rate]" value="' +
                    currencyRate + '" />';
                html += ' </td>';
                html += ' <td>';
                html += '   <span>' + amount + '</span>';
                html += ' </td>';
                html += ' <td>' + currencyRate + '</td>';
                html += ' <td class="inramount">' + inramount + '</td>';
                html += ' <td>';
                html += '   <a href="javascript:void(0)" class="remove-currency" currencyId="' +
                    selectedCurrencyType + '" data-row="' + rowCount +
                    '">Remove</a>';
                html += ' </td>';
                html += '</tr>';
                // console.log('html', html);
                $(".currencyTable").append(html);
                // $('#selected-currency-type').find('[value=' + selectedCurrencyType + ']').remove();
                $('#selected-currency-type').val('');
                $("#amount").val('');
                $("#inrAmount").val('');
                $("#currencyRate").val('');
                setTimeout(function () {
                    calculateTotal(rowCount)
                }, 100);
                rowCount++;
            }
        });

        $("tbody").delegate(".remove-currency", "click", function () {
            var row = $(this).attr('data-row');
            var currencyId = $(this).attr('currencyId');
            $('#option_' + currencyId).show();
            $('#row-' + row).remove();
            $('#addCurrency').show();
            setTimeout(function () {
                calculateTotal(rowCount)
            }, 100);
        });

        function calculateTotal(i) {
            var sum = 0;
            $('#selected-currency tbody tr').each(function () {
                $(this).find('.inramount').each(function () {
                    var combat = $(this).text();
                    if (!isNaN(combat) && combat.length !== 0) {
                        sum = parseFloat(sum, 2) + parseFloat(combat, 2);
                    }
                });
            });
            $('#total').html(sum.toFixed());
            $('#totalinrAmount').val(sum.toFixed());
        }

        //Show add currency button
        $(document).ready(function () {
            $(document).on('change', '#transaction_type', function () {
                $(".currency_op").removeAttr('style');
                // var rowlength = $("#selected-currency tbody tr").length;
                $(".currencyTable").html('');
                $('#total').html('0.0');
                $('#addCurrency').show();
            });
        });

        $("#insedentInsertForm").validate({
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
                BuySell: "required",
                customerNumberName: "required",
                documentStatus: "required",
		comment: "required",
                transaction_type: "required",
                departure_date: "required",
                passport_number: { required: function(element) {
                        return $("#documentStatus").val() == 1;
                    } },
                totalinrAmount: 'required',
                incident_agree: 'required',
                passport: {
                    required: function (element) {

                        if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 2 || $('#traveltype')
                                .val() == 3 || $('#traveltype')
                                .val() == 4 || $('#traveltype')
                                .val() == 5 || $('#traveltype').val() == 6 ) && $('#documentStatus').val() == 1;
                        }
                        else{
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 2 );
                        }

                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                visa: {
                    required: function (element) {

                        if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 3 || $('#traveltype')
                                .val() == 4 || $('#traveltype')
                                .val() == 5) && $(
                                '#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                ticket: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 3 || $('#traveltype')
                                .val() == 4 || $('#traveltype')
                                .val() == 5) && $(
                                '#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                pan: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 2 || $('#traveltype')
                                .val() == 3 || $('#traveltype')
                                .val() == 4 || $('#traveltype')
                                .val() == 5  || $('#traveltype').val() == 6 ) && $('#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                application: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 2 || $('#traveltype')
                                .val() == 3 || $('#traveltype')
                                .val() == 4 || $('#traveltype')
                                .val() == 5 || $('#traveltype').val() == 6) && 
                                $('#documentStatus').val() == 1;
                        }else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                annexure: {
                    required: function (element) {
                         if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 2 || $('#traveltype')
                                .val() == 3 || $('#traveltype')
                                .val() == 4 || $('#traveltype')
                                .val() == 5 || $('#traveltype').val() == 6 ) && $('#documentStatus').val() == 1;
                        }
                        else{
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 2) && $(
                                '#documentStatus').val() == 1;
                        }
                    },
                    extension: "jpg,jpeg,png,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                bankTransfer: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 2) && $('#documentStatus').val() == 1;
                        }
						  else if ($('#BuySell').val() == 0) {
                           // return ($('#traveltype').val() == 2) && $('#documentStatus').val() == 1;
                            return false;
                        } else 
						{
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                sof: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 3 || $('#traveltype')
                                .val() == 4 || $('#traveltype')
                                .val() == 5) && $(
                                '#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                lerms_letter: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return ($('#traveltype').val() == 2 || $('#traveltype').val() == 6 ) && $('#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                university_letter: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return $('#traveltype').val() == 4 && $('#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                emp_declaration_form: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return $('#traveltype').val() == 3 && $('#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                employment_letter: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return $('#traveltype').val() == 3 && $('#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                immigration_d_form: {
                    required: function (element) {
                        if ($('#BuySell').val() == 1) {
                            return $('#traveltype').val() == 5 && $('#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                medical_letter: {
                    required: function (element) {
                         if ($('#BuySell').val() == 1) {
                            return $('#traveltype').val() == 6 &&               $('#documentStatus').val() == 1;
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                refund_form: {
                    required: function (element) {
                        if ($('#BuySell').val() == 0) {
                            return ($('#traveltype').val() == 1 || $('#traveltype').val() == 2);
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },
                surrender_letter: {
                    required: function (element) {
                        if ($('#BuySell').val() == 0) {
                            return ($('#traveltype').val() == 2);
                        } else {
                            return false;
                        }
                    },
                    extension: "jpg,jpeg,png,xls,xlsx,pdf",
		    filesize: 1113282   //max size 1 MB
                },

            },
            messages: {
                //customerNumberName: "Please enter card number",
                documentStatus: "Please select document type",
                transaction_type: "Please select transaction type",
                totalinrAmount: "Please add Min one Currency"
            },
            submitHandler: function (form) {
                //currency validation
                $('.type_error').remove();
                if ($(".inci_currency_type").length == 0) {
                    $("#selected-currency-type").closest(".input-group").after(
                        '<div class="text-danger type_error">Please add Min one Currency.</div>'
                    );
                    return false;
                }
                $('body #loading_divs').addClass("loading");
                //get current time
                var currentTime = new Date().getHours();
                var doc_type = $('#documentStatus option:selected').val();

                // if (currentTime >= 10 && currentTime <= 16 && doc_type == 0) {
                setTimeout(() => { 
                    $.ajax({
                        url: "{{ url('incidentInsert') }}",
                        type: 'POST',
                        async: false,
                        data: new FormData(document.getElementById('insedentInsertForm')),
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        success: function (response) {
				//console.log(response);
				//alert('Helloo');
				//return false;
                            if(response.success=='True') {
                                //alert("True");
                                $('body #loading_divs').removeClass("loading");
                                $('#incident_number_new').html("#" + response.viewNumber);
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

	$.validator.addMethod('filesize', function (value, element, arg) {
            //console.log("Validation rules==>", Object.keys(element.files), element.files);
            if(Object.keys(element.files).length>0) {
                //console.log("value==>" + element.files[0].size + " Avg==>" + arg);
                if (element.files[0].size <= arg) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        },'File size must be less than 1 MB.');

        $('.creditCardText').keyup(function () {

            var num = $(this).val();
            var numberCheck = $.isNumeric(num);
            if (numberCheck) {
                var foo = $(this).val().split("-").join(""); // remove hyphens
                if (foo.length > 0) {
                    foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
                }
                $(this).val(foo);
            }
            return;
        });
    </script>
    <script type="text/javascript">
		$("#transaction_type").change(function () {
            var transaction_type= $('select[name=transaction_type]').val() // Here we can get the value of selected item
            if(transaction_type=='2'){
                $('#date_of_departure').datepicker('setStartDate', '');
            }
            else {
                $('#date_of_departure').datepicker('setStartDate', '-2d');
            }
        });
		
        $(function () {
            //$('#datepicker').datepicker();
            $('#datepicker').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                startDate: '-2d',
                endDate: '+60d',
                autoclose: true
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
@endpush
