<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Agents;
use App\Models\Subagents;
use App\Models\Incidents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;
use Session;
use File;
use App\User;
use App\Mail\createIncidentSuccess;
use Helper;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\TcUser;
use Carbon\Carbon;
use Log;


class FrontController extends Controller
{
    public static function sendMail()
    {
	Helper::sendMail("Test me here.....","<body class='marginheight=0 marginwidth=0 topmargin=0' leftmargin=0 style='height: 100% !important; margin: 0; padding: 0; width: 100% !important;min-width: 100%;'>
  <table name='bmeMainBody' style='background-color: rgb(214, 71, 69);' width='100%' cellspacing='0' cellpadding='0' border='0' bgcolor='#d64745'>
    <tbody>
      <tr>
        Hello
      </tr>
    </tbody>
  </table>
</body>");
	//sendMail();
    }

    public function getRatePlan()
    {
        Log::info("Cron Start =================> Cron Stop: ");
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://xecdapi.xe.com/v1/convert_from/?from=INR&to=USD,EUR,GBP,AUD,CAD,JPY,SGD,CHF,AED,THB&amount=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array(),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ZGF0YXNlZWR0ZWNoc29sdXRpb25zNDg1NjEwMzA3OmRncWk1MTlmdDM2OG9jOTVpYTE3aWJuMTQz'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $jsn_data = json_decode($response, TRUE);
        Log::info(['Data=>' => json_encode($jsn_data)]);
    }
    public function Autcheck()
    {
        $user_id = Session::get('agentType');
        if ($user_id) {
            return;
        } else {
            return redirect('/')->send();
        }
    }

    //Agent Login PAge
    public function index()
    {
	
        return view('thomasCook.login');
    }

    public function booking()
    {
        $startDate = now();
        $skipdates = array();
        $holidays = DB::table('holidays')->get();
        if ($holidays->count() > 0) {
            $skipdates = $holidays->pluck('holi_date')->toArray();
        }
        $skipdays = array("Saturday", "Sunday");
        $expiryData = $this->addDays(strtotime($startDate), 2, $skipdays, $skipdates);

        $agentCode = Session::get('agentCode');
        $agentType = Session::get('agentType');
        $subAgentCode = Session::get('subAgentCode');

        $getAgentCode = $agentCode;
        $agents = DB::table('agents')->where('agent_code', $agentCode)->first();
        $subAgents = null;
        if ($agentType == 'subAgent') :
            $subAgents = DB::table('sub_agents')->where('agent_code', $agentCode)->where('sub_agent_code', $subAgentCode)->first();
        endif;
        $incidents = DB::table('incidents')->where('inci_agent_code', $agentCode)
            ->where('inci_status', '=', '1')->where('inci_show_hide_status', '!=', '2')->get();
        $AllCurrency = DB::table('currency')->get();

        return view('thomasCook.index', compact('agents', 'incidents', 'agentType', 'agentCode', 'AllCurrency', 'getAgentCode', 'subAgents'));
    }

    //Agent Login PAge
    public function testing()
    {
        $loginTcUsers =  TcUser::getSellLoginUserIds();
        $lastTcUser =  TcUser::getLastUserIds();
        $oneOrMoreLogin = false;
        $nextRequestUser = '';
        $currentTcUser = '';
        $assignTcUser = '';

        // check tc user login or not
        if ($loginTcUsers) {
            $currentTcUser = $loginTcUsers[0];
            // check login user 1 or more
            if (count($loginTcUsers) > 1) {
                $oneOrMoreLogin = true;
                // check if last tc user is exits or not
                if ($lastTcUser) {

                    // check last user login or not
                    if (isset($loginTcUsers[$lastTcUser->last_key])) {
                        if (isset($loginTcUsers[$lastTcUser->last_key + 1])) {

                            // last user index and login user index match
                            if ($loginTcUsers[$lastTcUser->last_key] ==  $lastTcUser->tc_user) {
                                $currentTcUser = $loginTcUsers[$lastTcUser->last_key + 1];
                            } else {
                                if (isset($loginTcUsers[$lastTcUser->last_key])) {
                                    $currentTcUser = $loginTcUsers[$lastTcUser->last_key];
                                } else {
                                    $currentTcUser =  $loginTcUsers[0];
                                }
                            }
                        } else {
                            $currentTcUser =  $loginTcUsers[0];
                        }
                    } else {
                        // last tc user is not login, request assign to next user
                        $currentTcUser = $loginTcUsers[0];
                    }
                } else {
                    // no tc user exits
                    $currentTcUser = $loginTcUsers[0];
                }
            } else {
                $oneOrMoreLogin = false;
                // only one user login
            }
        } else {
        }
        echo "<pre>";
        print_r('Login:');
        echo "<pre>";
        print_r($loginTcUsers);
        echo "<pre>";
        print_r('currentTcUser:');
        echo "<pre>";
        print_r($currentTcUser);

        die;
    }

    function zipData($source, $destination)
    {
        if (extension_loaded('zip') === true) {
            if (file_exists($source) === true) {
                $zip = new \ZipArchive();
                if ($zip->open($destination, \ZIPARCHIVE::CREATE) === true) {
                    $source = realpath($source);
                    if (is_dir($source) === true) {
                        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = realpath($file);
                            if (is_dir($file) === true) {
                                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                            } else if (is_file($file) === true) {
                                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                            }
                        }
                    } else if (is_file($source) === true) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }
                return $zip->close();
            }
        }
        return false;
    }

    //Agent Login Here And Going To Index Page
    public function agentLogin(Request $request)
    {
	$AgentData = DB::table('agents')->where(['agent_user_name' => $request->agentUserName])->first();

        if ($AgentData) {

            $agentPassword = decrypt($AgentData->agent_password);
            $agentCode = $AgentData->agent_code;
            $getAgentCode = $agentCode;

            $agentChangePass = $AgentData->agent_change_pass;

            if ($agentChangePass == 1) {

                if ($agentPassword ==  $request->agentPassword) {

                    $agentType = 'agent';


                    /*$agentCurrency = DB::table('currency')
                            ->where('cur_agent_code','=',$agentCode)
                            ->get();*/
                    $agents = DB::table('agents')->where('agent_code', $agentCode)->first();

                    $incidents = DB::table('incidents')->where('inci_agent_code', $agentCode)->where('inci_status', '=', '1')->where('inci_show_hide_status', '!=', '2')->get();
                    $AllCurrency = DB::table('currency')->get();


                    Session::put('agentCode', $agentCode);
                    Session::put('agentPassword', $request->agentPassword);
                    Session::put('agentUserName', $request->agentUserName);
                    Session::put('agentLogin', 'agent');
                    Session::put('agentType', $agentType);

                    //return view('thomasCook.index',compact('agents','incidents','agentType','agentCode','AllCurrency','getAgentCode'));
                    return redirect('/booking');
                } else {
                    session::flash('loginError');
                    return back();
                }
            } else {
                return view('mail.forgotPassword');
            }
        } else {

            $subAgentData = DB::table('sub_agents')->where(['sub_agent_name' => $request->agentUserName])->first();
            if ($subAgentData) {

                $agentPassword = decrypt($subAgentData->sub_agent_password);
                $subAgentCode = $subAgentData->sub_agent_code;
                $agentCode = $subAgentData->agent_code;
                $getAgentCode = $subAgentCode;

                $subAgentChangePass = $subAgentData->sub_agent_chanhe_password;

                if ($subAgentChangePass == 1) {
                    if ($agentPassword ==  $request->agentPassword) {
                        $agentType = 'subAgent';
                        $subAgents = DB::table('sub_agents')->where('sub_agent_code', $subAgentCode)->first();

                        $incidents = DB::table('incidents')->where('inci_agent_code', $agentCode)->where('inci_status', '1')->where('inci_show_hide_status', '!=', '2')->get();
                        $AllCurrency = DB::table('currency')->get();
                        Session::put('agentType', $agentType);
                        Session::put('agentCode', $subAgentData->agent_code);
                        Session::put('subAgentCode', $subAgentData->sub_agent_code);
                        return view('thomasCook.index', compact('subAgents', 'incidents', 'agentType', 'agentCode', 'AllCurrency', 'getAgentCode'));
                    } else {
                        session::flash('loginError');
                        return back();
                    }
                } else {
                    return view('mail.forgotPassword');
                }
            } else {
                session::flash('loginError');
                return back();
            }
        }
    }
    //////// Index Page Call
    public function agentHome()
    {
        return back();
    }
    //Agent Logout

    public function agentLogout()
    {
        //session::flush();

        session()->forget('agentCode');
        session()->forget('agentPassword');
        session()->forget('agentUserName');
        session()->forget('agentLogin');
        session()->forget('agentType');
        session()->forget('subAgentCode');


        return redirect('/agent');
    }



    //incident Buy And Sell Margin get// using Ajax
    public function getBuyAndSellMargin(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $agentCurrency = DB::table('currency')->where('cur_id', '=', $request->currencyId)
            ->get();
            $current_date = date('Y-m-d');
            $currentHoliday = DB::table('holidays')->where('holiday_date',$current_date)->first();
        foreach ($agentCurrency as $key => $value) {
            $array = $value;

            //Get rate margin according to time
            $currency_name = str_replace("/INR", "", $value->currency_name_key);
            $rate_margin = DB::table('rate_margin')->where("currency_name", $currency_name)->first();
	        $array->buy_margin = $rate_margin->buy_margin;
            $array->buy_fix_margin = $rate_margin->buy_fix_margin;
            $array->sell_margin = $rate_margin->sell_margin;
            $array->sell_margin_10_12 = $rate_margin->sell_margin_10_12;
            $array->sell_margin_12_2 = $rate_margin->sell_margin_12_2;
            $array->sell_margin_2_3_30 = $rate_margin->sell_margin_2_3_30;
            $array->sell_margin_3_30_end = $rate_margin->sell_margin_3_30_end;
            $array->holiday_margin = $rate_margin->holiday_margin;
            $array->currentTime = strtotime(date("H:i"));
            $array->time_10 = strtotime("10:00");
            $array->time_12 = strtotime("12:00");
            $array->time_14 = strtotime("14:00");
            $array->time_15_30 = strtotime("15:30");
            $array->is_holiday  = $currentHoliday ? true : false;
        }
        echo json_encode($array);
    }
    //ajax use for check incident date in not holiday
    public function getDateForHoliday(Request $request)
    {
        $holidays = DB::table('holidays')->where('holi_date', $request->getDate)->first();

        if ($holidays != '') {
            echo "2";
        } else {
            echo "1";
        }

        //echo json_encode($array);
    }

    // Add Incident
    public function incidentInsert(Request $request)
    {
		
	ini_set('max_execution_time', 0);
	ini_set('memory_limit', -1);

	$login_user = Session::get('login_agent_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $arr_input = $request->all();

        $request['agentType'] = 'agent';
        //Log::info(["Request===>"=>json_encode($arr_input)]);
        //        print_r($arr_input);
        //        exit;
        $incideantCreated  = false;
        $tcUser = [];
        $userAssign = '';
        $customerArray = array();
        $incidentInsert = "0";
        $viewNumber = '';
        $bookingArray = array();
	$bookingArray['created_at']=date('Y-m-d h:i:s');
        $currentTimeinSeconds = time();
        $inci_key = substr(sha1($currentTimeinSeconds), 0, 8);
        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');

        /********************************
            1 = With document (10AM to 5PM)
            0 = Without document (10AM to 4PM)
         *******************************/
        $tmp_buy_sell=0;
        $tmp_buy_sell_msg="";


//        exit;
	//10:00 AM to 17:00
	$currentTime = date('H:i:s');

	if ($request->documentStatus == 1 && ($currentTime < '01:00:00' || $currentTime > '23:45:00')) {

            $tmp_buy_sell=1;
            $tmp_buy_sell_msg='You can create incident with document between 05:00AM to 11:45PM Only!';
        }
        else if ($request->documentStatus == 0 && ($currentTime < '01:00:00' || $currentTime > '23:45:00')) {

            //echo "10:00 AM to 16:00";
            $tmp_buy_sell=1;
            $tmp_buy_sell_msg='You can create incident without document between 05:00AM to 11:45PM Only!';
        }



	//echo $tmp_buy_sell; exit;

        if($tmp_buy_sell==0) {
	    entrypoint:
            $incidentNumberDetails = DB::table('incidents')->orderBy('id', 'DESC')->first();

            if ($incidentNumberDetails != '') {
                $number = $incidentNumberDetails->inci_number;
                $indexChar = substr($number, 0, -6);
                $getNumber = substr($number, -6);
                if ($getNumber + 1 > 999999) {
                    $number = (++$indexChar . "000001");
                    $viewNumber = (++$indexChar . "000001");
                    $bookingArray['inci_number'] = $number;
                    $getNumber = 000001;
                } else {
                    $number = ($indexChar . sprintf("%06s", ++$getNumber));
                    $viewNumber = ($indexChar . sprintf("%06s", $getNumber));
                    $bookingArray['inci_number'] = $number;
                }
            } else {
                $bookingArray['inci_number'] = 'A000001';
                $viewNumber = 'A000001';
            }

            $document_agent_code = $viewNumber;

            $incidentNumber = $request->agentCodeDetails . "_" . $currentDate . "_" . $request->customerNumberName;
            $bookingArray['inci_key'] = $bookingArray['inci_number'] . "-" . $inci_key;
            $bookingArray['agent_id'] = $login_user;
            $bookingArray['inci_agent_key'] = $request->agentCode;
            $bookingArray['inci_agent_code'] = $request->agentCodeDetails;
            if (isset($request->passport_number) && $request->passport_number != '')
                $bookingArray['inci_passport_number'] = $request->passport_number;
            if (isset($request->date_of_departure) && $request->date_of_departure != '')
                $bookingArray['inci_departure_date'] = date('Y-m-d', strtotime($request->date_of_departure));
            $incidentType = $request->incidentType;
            if (!empty($request->traveltype)) {
                $bookingArray['travel_type'] = $request->traveltype;
            }

            if (!empty($request->incident_agree)) {
                $bookingArray['incident_agree'] = 1;
            }

            if ($incidentType == 1) {

                date_default_timezone_set('Asia/Kolkata');
                $currentDate = date('Y-m-d');
                date_default_timezone_set('Asia/Kolkata');
                $currentTime = date('H:i');

                $bookingArray['inci_type'] = $incidentType;
                $bookingArray['inci_forex_card_no'] = $request->customerNumberName;
                $bookingArray['inci_name'] = $request->customerNumberName;
                if($request->documentStatus==1)
                {
                    $bookingArray['inci_recived_date'] = $currentDate;
                    $bookingArray['inci_recived_time'] = $currentTime;
                }                
		$bookingArray['inci_currency_type'] = $request->currencyFullName;
                $bookingArray['inci_frgn_curr_amount'] = "N/A";
                $bookingArray['inci_buy_sell_req'] = $request->BuySell;
                $bookingArray['inci_agent_margin'] = $request->agentMargin;
                $bookingArray['inci_inr_amount'] = "N/A";
                $bookingArray['inci_agent_type'] = $request->agentType;
                $bookingArray['inci_currency_rate'] = $request->currencyRate;
                $bookingArray['transaction_type'] = $request->transaction_type;
                $bookingArray['inci_create_time'] = now();

                // check tc user login or not
                $getLoginTcUser = $this->getLoginTcUserId($request->BuySell);
                if ($getLoginTcUser) {
                    $tcUserId = $getLoginTcUser['id'];
                    $tcUserKey = $getLoginTcUser['last_key'];
                    $tcUser = TcUser::getTcUser($tcUserId);
                }
                

                //$tcUser = User::with('roles')->role('Tc user')->where('id', '!=', env('TC_USER_ID'))->where('login_status','=','1')->where('status','1')->whereRaw("find_in_set($request->BuySell,tc_type)")->inRandomOrder()->first();
		
		
		if($request->BuySell==0){
                    //Buy
                    $tcUser = User::where('id', '=','74')->first();
                }
                else{
                    //Sell
                    $tcUser = User::with('roles')->role('Tc user')->where('id', '!=', env('TC_USER_ID'))->where('login_status','=','1')->whereRaw("find_in_set($request->BuySell,tc_type)")->inRandomOrder()->first();
                }
		
		// if tc user login
		if ($tcUser) {

                    $tcuser_id =  $tcUser->id;
		
		   if($request->BuySell==0){
		    //buy
                    $cnt_assign = 0;
		   }
		   else{
			//sell
			$cnt_assign = Incidents::select('id')->where('inci_assignto', '=', $tcuser_id)->count();

		   }

                    // if tc user login
                    if ($cnt_assign < 5) {
                        $userAssign = $tcUser->id;
                        //$bookingArray['.'] = $userAssign;
                        if ($request->documentStatus == 1) {
                            $bookingArray['inci_assignto'] = $userAssign;
                            $bookingArray['inci_assign_status'] = 1;
                        } else {
                            $bookingArray['inci_assignto'] = '';
                        }

                        $customerArray['inci_up_assign_to'] = $userAssign;
                        // return response()->json( $viewNumber);
                    } else {
                        $admin = DB::table('users')->first();
                        $userAssign = $admin->id;
                        //$bookingArray['inci_assignto'] = $userAssign;
                        $bookingArray['inci_assignto'] = '';
                        $customerArray['inci_up_assign_to'] = $userAssign;
                    }
                } else {
                    $admin = DB::table('users')->first();
                    $userAssign = $admin->id;
                    //$bookingArray['inci_assignto'] = $userAssign;
                    $bookingArray['inci_assignto'] = '';
                    $customerArray['inci_up_assign_to'] = $userAssign;
                }
                // if tc user login
               /** if ($tcUser) {
                    $userAssign = $tcUser->id;
                    //$bookingArray['inci_assignto'] = $userAssign;
                    if($request->documentStatus==1){
                        $bookingArray['inci_assignto'] = $userAssign;
                        $bookingArray['inci_assign_status'] = 1;
                    }
                    else{
                        $bookingArray['inci_assignto'] = '';
                    }

                    $customerArray['inci_up_assign_to'] = $userAssign;
                    // return response()->json( $viewNumber);
                } else {
                    $admin = DB::table('users')->first();
                    $userAssign = $admin->id;
                    //$bookingArray['inci_assignto'] = $userAssign;
                    $bookingArray['inci_assignto'] = '';
                    $customerArray['inci_up_assign_to'] = $userAssign;
                } **/
                //  return response()->json( $bookingArray['inci_assignto']);

                // if incident type sell and document type != withdocument

                $updateInsident = false;
                // 0 => Buy && 1 => Sell
                // documentStatus = 0 => Without Document
                // documentStatus = 1 => With Document
                $bookingArray['doc_temp_type'] = $request->documentStatus;
                if (($request->BuySell == 1 && $request->documentStatus == 1) || $request->BuySell == 0) {
                    $bookingArray['inci_show_hide_status'] = 2;
                    $updateInsident = true;
                } else {
                    /*
                    * Set expiry date if incident type sell and document type "Without document"
                    */
                    // $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday")
                    // $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01");
                    $startDate = now();
                    $skipdates = array();
                    $skipdays = array("Saturday", "Sunday");
                    $holidays = DB::table('holidays')->get();
                    if ($holidays->count() > 0) {
                        $skipdates = $holidays->pluck('holi_date')->toArray();
                    }
                    $expiryData = $this->addDays(strtotime($startDate), 4, $skipdays, $skipdates);
                    $bookingArray['expiry_date'] = $expiryData;
                    $bookingArray['inci_assignto'] = env('TC_USER_ID');
                    $bookingArray['inci_assign_status'] = 1;
                    $customerArray['inci_up_assign_to'] = env('TC_USER_ID');
                }
                //print_r($request->date_of_departure);exit;

                $bookingArray['inci_departure_date'] = date('Y-m-d', strtotime($request->date_of_departure));
                $bookingArray['travel_type'] = $request->traveltype;
                //echo $request->date_of_departure.'===>'.$bookingArray['inci_departure_date'];exit;
                $bookingArray['inci_status'] = 3;
                $bookingArray['doc_type'] = $request->documentStatus;
		$bookingArray['comment'] = $request->comment;
                //echo $bookingArray['inci_departure_date']; exit;
                //print_r($bookingArray);exit;
		Log::info($bookingArray);
		$incidentNumberCheck = Incidents::where('inci_number',$bookingArray['inci_number'])->count();
                if($incidentNumberCheck==1){
                    goto entrypoint;
                }
		$incidentInsert = DB::table('incidents')->insertGetId($bookingArray);

                $currentTimeinSeconds = time();
                $inci_up_key = substr(sha1($currentTimeinSeconds), 0, 8);
                $customerArray['inci_up_key'] = $viewNumber . "-" . $inci_up_key;
                $customerArray['inci_up_name'] = $request->custName;
                //$customerArray['inci_up_agent_code']=$request->agentCode;
                $customerArray['inci_up_agent_code'] = $request->agentCodeDetails;
                $customerArray['inci_up_agent_code_details'] = $request->agentCodeDetails;
                $customerArray['inci_up_inc_key'] = $bookingArray['inci_key'];
                $customerArray['inci_up_agent_type'] = $request->agentType;
                $customerArray['inci_up_fax_number'] = $request->customerNumberName;
                date_default_timezone_set('Asia/Kolkata');
                $currentDate = date('Y-m-d');
                $currentTime = date('H:i');
                $customerArray['inci_up_date'] = $currentDate;
                $customerArray['inci_up_time'] = $currentTime;

                if ($updateInsident) {
                    $incidentInsert = DB::table('incident_update')->insert($customerArray);
                }
                // echo "<pre>";print_r( $customerArray);die;
                $incideantCreated = true;
                // assign new request for tc user
                if ($tcUser) {
                    $assign_requests = array(
                        'tc_user' => $tcUserId,
                        'last_key' => $tcUserKey
                    );
                    $assignTcUser = DB::table('assign_requests')->insert($assign_requests);
                }


                // send email if incident  create successfully
                if ($incideantCreated) {
                    // add currency
                    $currencyData = $request->currency;
                    foreach ($currencyData as $currency) {
                        $currencyParma = array(
                            'incident_id' => $viewNumber,
                            'inci_currency_type' => $currency['inci_currency_type'],
                            'inci_frgn_curr_amount' => $currency['inci_frgn_curr_amount'],
                            'inci_inr_amount' => round($currency['inci_inr_amount']),
                            'inci_currency_rate' => $currency['inci_currency_rate'],
                        );
                        $currencyAdd = DB::table('incident_currency')->insertGetId($currencyParma);
                    }

                    // Upload Document
                    if ($request->BuySell == 1) {
                        if ($request->documentStatus == 1) {
                            if ($request->traveltype == 1) {

                                //Travel type = BTQ
                                $this->sellDocumentUpload($request, $viewNumber, $request->agentCodeDetails);
                            } else if ($request->traveltype == 2) {
                                //Travel type = BT

                                $this->sellbtDocumentUpload($request, $viewNumber, $request->agentCodeDetails);
                            } else if ($request->traveltype == 3) {
                                //Travel type Employment
                                $this->sellEmploymentDocumentUpload($request, $viewNumber, $request->agentCodeDetails);
                            } else if ($request->traveltype == 4) {
                                //Travel type =  student
                                $this->sellStudentDocumentUpload($request, $viewNumber, $request->agentCodeDetails);
                            } else if ($request->traveltype == 5) {
                                //Travel type Immigartion
                                $this->sellImmigrationDocumentUpload($request, $viewNumber, $request->agentCodeDetails);
                            } else if ($request->traveltype == 6) {
                                //Travel type Medical
                                $this->sellMedicalDocumentUpload($request, $viewNumber, $request->agentCodeDetails);
                            }

                            $docdata = DB::table('incident_sell_documents')->where('incident_number', $viewNumber)->first();
                            //print_r($docdata->passport);
                            //exit;
                            if ($docdata) {
                                $annexure = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->annex);
                                $passport = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->passport);
                                $pan = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->pan_card);
                                $ticket = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->ticket);
                                $visa = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->visa);
                                $application = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->apply);
                                $sof = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->sof);
                                $bank_transfer = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->bank_transfer);
				$lerms_letter = url("allDocuments/" . $currentDate . "/" . $viewNumber . "/" . $docdata->lerms_letter);
                                //echo $annexure."<br/>".$passport."<br/>".$pan."<br/>".$ticket."<br/>".$visa."<br/>".$application."<br/>".$sof."<br/>".$bank_transfer;

                                //$data1 = array('issue_id' => $viewNumber, 'annexure' => $annexure, 'passport' => $passport, 'pan' => $pan, 'ticket' => $ticket, 'visa' => $visa, 'aadhar' => '');
				if ($request->traveltype == 1) {
                                    //Travel type = BTQ
                                    $data1 = array('issue_id' => $viewNumber, 'annexure' => $annexure, 'passport' => $passport, 'pan' => $pan, 'ticket' => $ticket, 'visa' => $visa);
                                } else if ($request->traveltype == 2) {
                                    //Travel type = BT
                                    $data1 = array('issue_id' => $viewNumber, 'annexure' => $annexure, 'passport' => $passport, 'pan' => $pan, 'bt' => $lerms_letter);
                                }
                                else{
                                    $data1 = array('issue_id' => $viewNumber, 'annexure' => $annexure, 'passport' => $passport, 'pan' => $pan, 'ticket' => $ticket, 'visa' => $visa);
                                }
                                //Log::info(json_encode($data1));
                                /*$curl = curl_init();

                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'http://44.200.48.161:8000/uploadfiles',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                    CURLOPT_POSTFIELDS => json_encode($data1),
                                    CURLOPT_HTTPHEADER => array(
                                        'Content-Type: application/json'
                                    )
                                ));

                                $response = curl_exec($curl);
                                Log::info($response);
                                curl_close($curl);*/
                            }
                        }
                    } else {
                        $this->buyDocumentUpload($request, $viewNumber);
                    }


                    //if ($tcUser) {
                        $subject = 'Incident Created Successfully';
                        $message = 'Our rate booking for incident number '.$viewNumber.' is succesfully done';

                        $agentEmail = Agents::getAgentEmailByCode($request->agentCode);
                        $mailId = '';

                        //$agentEmail='nishant@yopmail.com';
                        if ($agentEmail != '') {
                            $mailId = $agentEmail;
                        } else {
                            $subAgentEmail = Subagents::getAgentEmailByCode($request->agentCode);;
                            $mailId = $subAgentEmail;
                        }
                        //return response()->json( $agentEmail);
			$data = [];
			Helper::sendMailCreateIncident($subject,$message,$mailId,$data,'mail.incidentCreateMail');

			//Helper::sendMailCreateIncident($subject,$message,$mailId);
			//echo $mailId;
			//Helper::sendMail($subject,$message,'nishant@yopmail.com');
			//exit;

                        //Mail::to($mailId)->send(new createIncidentSuccess($subject, $message));
                    //}
                    //return view('agents-thankyou', ['incidentnumber' => $viewNumber]);
                    //return response()->json($viewNumber);
                    return response()->json(['success'=>'True','errMessage'=>'','viewNumber'=>$viewNumber]);
                }
            }
        }
        else{
            return response()->json(['success'=>'False','errMessage'=>$tmp_buy_sell_msg]);
        }
    }
    /***********************************************************
        SellWithoutDocument
        - Document upload by agent sell and document type without
     ************************************************************/
    public function documentUploadSellWithout(Request $request)
    {

        $incideantCreated  = false;
        $tcUser = [];
        $userAssign = '';
        $customerArray = array();
        $incidentInsert = "0";
        $viewNumber = '';
        $bookingArray = array();
        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date('H:i');
        $incidentType = DB::table('incidents')->where(['inci_key' => $request->incident_key])->first();
        // check tc user login or not
        $getLoginTcUser = $this->getLoginTcUserId($incidentType->inci_buy_sell_req);
        if ($getLoginTcUser) {
            $tcUserId = $getLoginTcUser['id'];
            $tcUserKey = $getLoginTcUser['last_key'];
            $tcUser = TcUser::getTcUser($tcUserId);
        }
        /* // if tc user login
        if ( $tcUser ) {
            $userAssign=$tcUser->tc_key;
            $bookingArray['inci_assignto']= $userAssign;
            $customerArray['inci_up_assign_to'] = $userAssign;
           // return response()->json( $viewNumber);
        }else{
            $admin = DB::table('admins')->first();
            $userAssign=$admin->admin_key;
            $bookingArray['inci_assignto']= $admin->admin_key;
            $customerArray['inci_up_assign_to'] =  $admin->admin_key;

        } */
        $customerArray['inci_up_assign_to'] = $incidentType->inci_assignto;
        $bookingArray['inci_show_hide_status'] = 2;
        $currentTimeinSeconds = time();
        $inci_up_key = substr(sha1($currentTimeinSeconds), 0, 8);
        $customerArray['inci_up_key'] = $incidentType->inci_number . "-" . $inci_up_key;
        $customerArray['inci_up_name'] = '';
        $customerArray['inci_up_agent_code'] = $incidentType->inci_agent_code;
        $customerArray['inci_up_agent_code_details'] = $incidentType->inci_agent_key;
        $customerArray['inci_up_inc_key'] = $incidentType->inci_key;
        $customerArray['inci_up_agent_type'] = $incidentType->inci_agent_type;
        $customerArray['inci_up_fax_number'] = $incidentType->inci_forex_card_no;
        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');
        $customerArray['inci_up_date'] = $currentDate;
        $customerArray['inci_up_time'] = $currentTime;

        $incidentsArray = [];
        $incidentsArray['inci_show_hide_status'] = 2;
        if (isset($request->passport_number) && $request->passport_number != '')
            $incidentsArray['inci_passport_number'] = $request->passport_number;
        if (isset($request->date_of_departure) && $request->date_of_departure != '')
            $incidentsArray['inci_departure_date'] = date('Y-m-d', strtotime($request->date_of_departure));

        $this->sellDocumentUpload($request, $incidentType->inci_number, $incidentType->inci_agent_code);
        $incidentUpdate = DB::table('incidents')->where(['inci_key' => $request->incident_key])->update($incidentsArray);
        $incidentInsert = DB::table('incident_update')->insert($customerArray);
        $incideantCreated = true;

        /* if ( $tcUser ) {
            $assign_requests = array(
                'tc_user' =>  $tcUserId,
                'last_key'=>  $tcUserKey
            );
            $assignTcUser = DB::table('assign_requests')->insert($assign_requests);

          } */
        // send email if incident  create successfully
        if ($incideantCreated) {

            //if($tcUser){
            $subject = 'Incident Created Successfully';
            $message = 'Your booking request number is  ' . $viewNumber . ' has been submitted';
            $agentEmail = Agents::getAgentEmailByCode($request->agentCode);
            $mailId = '';
            if ($agentEmail != '') {
                $mailId = $agentEmail;
            } else {
                $subAgentEmail = Subagents::getAgentEmailByCode($request->sub_agent_code);;
                $mailId = $subAgentEmail;
            }
            //return response()->json( $agentEmail);
            //Mail::to($mailId)->send(new createIncidentSuccess($subject, $message));
            //}
            return response()->json(1);
        }
    }
    /***********************************************************
        BuyWithoutDocument
        - Document upload by agent buy and document type without
     ************************************************************/
    public function documentUploadBuyWithout(Request $request)
    {
        $incideantCreated  = false;
        $tcUser = [];
        $userAssign = '';
        $customerArray = array();
        $incidentInsert = "0";
        $viewNumber = '';
        $bookingArray = array();
        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date('H:i');
        $incidentType = DB::table('incidents')->where(['inci_key' => $request->incident_key])->first();
        // check tc user login or not
        $getLoginTcUser = $this->getLoginTcUserId($request->BuySell);
        if ($getLoginTcUser) {
            $tcUserId = $getLoginTcUser['id'];
            $tcUserKey = $getLoginTcUser['last_key'];
            $tcUser = TcUser::getTcUser($tcUserId);
        }
        // if tc user login
        if ($tcUser) {
            $userAssign = $tcUser->tc_key;
            if($request->BuySell == 0){
                $bookingArray['inci_assignto'] = $userAssign;
                $bookingArray['inci_assignto_status'] = 1;
        }
            $customerArray['inci_up_assign_to'] = $userAssign;
            // return response()->json( $viewNumber);
        } else {
            $admin = DB::table('admins')->first();
            $userAssign = $admin->admin_key;
            $bookingArray['inci_assignto'] = $admin->admin_key;
            $customerArray['inci_up_assign_to'] =  $admin->admin_key;
        }
        $bookingArray['inci_show_hide_status'] = 2;
        $currentTimeinSeconds = time();
        $inci_up_key = substr(sha1($currentTimeinSeconds), 0, 8);
        $customerArray['inci_up_key'] = $incidentType->inci_number . "-" . $inci_up_key;
        $customerArray['inci_up_name'] = '';
        $customerArray['inci_up_agent_code'] = $incidentType->inci_agent_code;
        $customerArray['inci_up_agent_code_details'] = $incidentType->inci_agent_key;
        $customerArray['inci_up_inc_key'] = $incidentType->inci_key;
        $customerArray['inci_up_agent_type'] = $incidentType->inci_agent_type;
        $customerArray['inci_up_fax_number'] = $incidentType->inci_forex_card_no;
        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');
        $customerArray['inci_up_date'] = $currentDate;
        $customerArray['inci_up_time'] = $currentTime;

        $this->buyDocumentUpload($request, $incidentType->inci_number);
        $incidentUpdate = DB::table('incidents')->where(['inci_key' => $request->incident_key])->update(['inci_show_hide_status' => '2']);
        $incidentInsert = DB::table('incident_update')->insert($customerArray);
        $incideantCreated = true;

        if ($tcUser) {
            $assign_requests = array(
                'tc_user' =>  $tcUserId,
                'last_key' =>  $tcUserKey
            );
            $assignTcUser = DB::table('assign_requests')->insert($assign_requests);
        }
        // send email if incident  create successfully
        if ($incideantCreated) {

            if ($tcUser) {
                $subject = 'Incident Created Successfully';
                $message = 'Your booking request number is  ' . $viewNumber . ' has been submitted';
                $agentEmail = Agents::getAgentEmailByCode($request->agentCode);
                $mailId = '';
                if ($agentEmail != '') {
                    $mailId = $agentEmail;
                } else {
                    $subAgentEmail = Subagents::getAgentEmailByCode($request->agentCode);;
                    $mailId = $subAgentEmail;
                }
                //return response()->json( $agentEmail);
                //Mail::to($mailId)->send(new createIncidentSuccess($subject, $message));
            }
            return response()->json(1);
        }
    }

    /***********************************************************
        SellWithDocument
        - Document upload by agent sell and document type with BTQ
     ************************************************************/
    function sellDocumentUpload($request, $inci_number, $default_agent_code = '')
    {

        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $customerArray['incident_number'] = $inci_number;
        $todayDate = date('Y-m-d');
        $documentPath = public_path() . '/allDocuments/' . $todayDate . '/' . $inci_number . '/';

        if (isset($default_agent_code) && $default_agent_code != '') :
            $agent_code = $default_agent_code;
        else :
            $agent_code = $request->agentCode;
        endif;

        if (!empty($request->file('passport'))) {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();

            //$actualPassportName= str_replace(" ","_",$namePassport);

            //Need a static name for uploaded file
            $actualPassportName = "PASSPORT";
            //this is for upload folder
            //$uploadFileNamePassport=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $uploadFileNamePassport = $agent_code . '_' . $inci_number . '_' . $actualPassportName . '.' . $extPassport;
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['passport'] = $uploadFileNamePassport;
            $customerArray['passport_status'] = 3;
            /*End Customer Passport Upload*/
        }

        /*Customer Visa Upload*/
        if (!empty($request->file('visa'))) {
            $visa = $request->file('visa');
            $milliseconds = round(microtime(true) * 1000);
            $nameVisa = $visa->getClientOriginalName();
            $extVisa = $visa->getClientOriginalExtension();
            $actualNameVisa = str_replace(" ", "_", $nameVisa);
            $actualNameVisa = "VISA";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extVisa;
            $uploadFileNameVisa = $agent_code . '_' . $inci_number . '_' . $actualNameVisa . '.' . $extVisa;
            //this is for database
            $visa->move($documentPath, $uploadFileNameVisa);
            $customerArray['visa'] = $uploadFileNameVisa;
            $customerArray['visa_status'] = 3;
            /*End Customer Visa Upload*/
        }

        /*Customer ticket Upload*/
        if (!empty($request->file('ticket'))) {
            $ticket = $request->file('ticket');
            $milliseconds = round(microtime(true) * 1000);
            $nameTicket = $ticket->getClientOriginalName();
            $extTicket = $ticket->getClientOriginalExtension();
            $actualNameTicket = str_replace(" ", "_", $nameTicket);
            $actualNameTicket = "TICKET";
            //this is for upload folder
            //$uploadFileNameTicket=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameTicket.'.'.$extTicket;
            $uploadFileNameTicket = $agent_code . '_' . $inci_number . '_' . $actualNameTicket . '.' . $extTicket;
            //this is for database
            $ticket->move($documentPath, $uploadFileNameTicket);
            $customerArray['ticket'] = $uploadFileNameTicket;
            $customerArray['ticket_status'] = 3;
            /*End Customer ticket Upload*/
        }

        /*Customer pan Upload*/
        if (!empty($request->file('pan'))) {
            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $extPan = $pan->getClientOriginalExtension();
            $actualNamePan = str_replace(" ", "_", $namePan);
            $actualNamePan = "PAN";
            //this is for upload folder
            //$uploadFileNamePan=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamePan.'.'.$extPan;
            $uploadFileNamePan = $agent_code . '_' . $inci_number . '_' . $actualNamePan . '.' . $extPan;
            //this is for database
            $pan->move($documentPath, $uploadFileNamePan);
            $customerArray['pan_card'] = $uploadFileNamePan;
            $customerArray['pan_card_status'] = 3;
            /*End Customer pan Upload*/
        }

        /*Customer application Upload*/
        if (!empty($request->file('application'))) {
            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $extApplication = $application->getClientOriginalExtension();
            $actualNameApplication = str_replace(" ", "_", $nameApplication);
            $actualNameApplication = 'RELOAD_FORMS';

            //this is for upload folder
            //$uploadFileNameApplication=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameApplication.'.'.$extApplication;
            $uploadFileNameApplication = $agent_code . '_' . $inci_number . '_' . $actualNameApplication . '.' . $extApplication;
            //this is for database
            $application->move($documentPath, $uploadFileNameApplication);
            $customerArray['apply'] = $uploadFileNameApplication;
            $customerArray['apply_status'] = 3;
            /*End Customer application Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $extAnnexure = $annexure->getClientOriginalExtension();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';
            //this is for upload folder
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            //this is for database
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['annex'] = $uploadFileNamenameAnnexure;
            $customerArray['annex_status'] = 3;
            /*End Customer Annexure Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('bankTransfer'))) {
            $bankTransfer = $request->file('bankTransfer');
            $milliseconds = round(microtime(true) * 1000);
            $namebankTransfer = $bankTransfer->getClientOriginalName();
            $extbankTransfer = $bankTransfer->getClientOriginalExtension();
            $actualNameBankTransfer = str_replace(" ", "_", $namebankTransfer);
            $actualNameBankTransfer = 'bank_transfer';
            //this is for upload folder
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameBankTransfer.'.'.$extbankTransfer;
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameBankTransfer . '.' . $extbankTransfer;
            //this is for database
            $bankTransfer->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['bank_transfer'] = $uploadFileNameBankTransfer;
            $customerArray['bank_transfer_status'] = 3;
            /*End Customer Annexure Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('sof'))) {
            $sof = $request->file('sof');
            $milliseconds = round(microtime(true) * 1000);
            $nameSof = $sof->getClientOriginalName();
            $extSof = $sof->getClientOriginalExtension();
            $actualNameSof = str_replace(" ", "_", $nameSof);
            $actualNameSof = 'SOF';
            //this is for upload folder
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameSof.'.'.$extSof;
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameSof . '.' . $extSof;
            //this is for database
            $sof->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['sof'] = $uploadFileNameBankTransfer;
            $customerArray['sof_status'] = 3;

            /*End Customer Annexure Upload*/
        }

        if (!empty($request->file('businessLetter'))) {

            /*Customer businessLetter Upload*/
            $businessLetter = $request->file('businessLetter');
            $milliseconds = round(microtime(true) * 1000);
            $nameBusinessLetter = $businessLetter->getClientOriginalName();
            $extBusinessLetter = $businessLetter->getClientOriginalExtension();
            //$actualNameBusinessLetter= str_replace(" ","_",$nameBusinessLetter);
            $actualNameBusinessLetter = 'BusinessLetter';
            //this is for upload folder
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameBusinessLetter.'.'.$extBusinessLetter;
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameBusinessLetter . '.' . $extBusinessLetter;
            //this is for database
            $businessLetter->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['business'] = $uploadFileNameBankTransfer;
            $customerArray['business_status'] = 3;
            /*End Customer businessLetter Upload*/
        }

        if (!empty($request->file('other'))) {

            /*Customer Annexure Upload*/
            $other = $request->file('other');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $extOther = $other->getClientOriginalExtension();
            //$actualNameOther= str_replace(" ","_",$nameOther);
            $actualNameOther = 'Other';
            //this is for upload folder
            //$uploadFileNameOther=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameOther.'.'.$extOther;
            $uploadFileNameOther = $agent_code . '_' . $inci_number . '_' . $actualNameOther . '.' . $extOther;
            //this is for database
            $other->move($documentPath, $uploadFileNameOther);
            $customerArray['other'] = $uploadFileNameOther;
            $customerArray['other_status'] = 3;

            /*End Customer Annexure Upload*/
        }
	$customerArray['created_at'] = date('Y-m-d h:i:s');
        $incidentInsert = DB::table('incident_sell_documents')->insert($customerArray);
        $addCooment = $this->addCooment($request, $inci_number);

        return  $customerArray;
    }

    /***********************************************************
    Sell-WithDocument-BT
    - Document upload by agent sell and BT and document type with
     ************************************************************/
    function sellbtDocumentUpload($request, $inci_number, $default_agent_code = '')
    {
        //echo $inci_number."==>".$default_agent_code;
        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $customerArray['incident_number'] = $inci_number;
        $todayDate = date('Y-m-d');
        $documentPath =  'allDocuments/' . $todayDate . '/' . $inci_number . '/';

        if (isset($default_agent_code) && $default_agent_code != '') :
            $agent_code = $default_agent_code;
        else :
            $agent_code = $request->agentCode;
        endif;

        if (!empty($request->file('passport'))) {

            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();

            //$actualPassportName= str_replace(" ","_",$namePassport);

            //Need a static name for uploaded file
            $actualPassportName = "PASSPORT";
            //this is for upload folder
            //$uploadFileNamePassport=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $uploadFileNamePassport = $agent_code . '_' . $inci_number . '_' . $actualPassportName . '.' . $extPassport;
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['passport'] = $uploadFileNamePassport;
            $customerArray['passport_status'] = 3;

            /*End Customer Passport Upload*/
        }

        /*Customer Lerms Letter Upload*/
        if (!empty($request->file('lerms_letter'))) {
            $lerms_letter = $request->file('lerms_letter');

            $namelermsletter = $lerms_letter->getClientOriginalName();
            $extlermsletter = $lerms_letter->getClientOriginalExtension();
            $actualNamelermsletter = str_replace(" ", "_", $namelermsletter);
            $actualNamelermsletter = "Lerms_Letter";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extlermsletter;
            $uploadFileNamelermsletter = $agent_code . '_' . $inci_number . '_' . $actualNamelermsletter . '.' . $extlermsletter;
            //this is for database
            $lerms_letter->move($documentPath, $uploadFileNamelermsletter);
            $customerArray['lerms_letter'] = $uploadFileNamelermsletter;
            $customerArray['lerms_letter_status'] = 3;

            /*End Customer Lerms Letter Upload*/
        }


        /*Customer pan Upload*/
        if (!empty($request->file('pan'))) {
            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $extPan = $pan->getClientOriginalExtension();
            $actualNamePan = str_replace(" ", "_", $namePan);
            $actualNamePan = "PAN";
            //this is for upload folder
            //$uploadFileNamePan=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamePan.'.'.$extPan;
            $uploadFileNamePan = $agent_code . '_' . $inci_number . '_' . $actualNamePan . '.' . $extPan;
            //this is for database
            $pan->move($documentPath, $uploadFileNamePan);
            $customerArray['pan_card'] = $uploadFileNamePan;
            $customerArray['pan_card_status'] = 3;

            /*End Customer pan Upload*/
        }

        /*Customer application Upload*/
        if (!empty($request->file('application'))) {
            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $extApplication = $application->getClientOriginalExtension();
            $actualNameApplication = str_replace(" ", "_", $nameApplication);
            $actualNameApplication = 'RELOAD_FORMS';

            //this is for upload folder
            //$uploadFileNameApplication=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameApplication.'.'.$extApplication;
            $uploadFileNameApplication = $agent_code . '_' . $inci_number . '_' . $actualNameApplication . '.' . $extApplication;
            //this is for database
            $application->move($documentPath, $uploadFileNameApplication);
            $customerArray['apply'] = $uploadFileNameApplication;
            $customerArray['apply_status'] = 3;

            /*End Customer application Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $extAnnexure = $annexure->getClientOriginalExtension();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';
            //this is for upload folder
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            //this is for database
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['annex'] = $uploadFileNamenameAnnexure;
            $customerArray['annex_status'] = 3;

            /*End Customer Annexure Upload*/
        }
             /*Customer bankTransfer  Upload*/
            if (!empty($request->file('bankTransfer'))) {
            $bankTransfer = $request->file('bankTransfer');
            $milliseconds = round(microtime(true) * 1000);
            $namebankTransfer = $bankTransfer->getClientOriginalName();
            $extbankTransfer = $bankTransfer->getClientOriginalExtension();
            $actualNameBankTransfer = str_replace(" ", "_", $namebankTransfer);
            $actualNameBankTransfer = 'bank_transfer';
            //this is for upload folder
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameBankTransfer.'.'.$extbankTransfer;
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameBankTransfer . '.' . $extbankTransfer;
            //this is for database
            $bankTransfer->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['bank_transfer'] = $uploadFileNameBankTransfer;
            $customerArray['bank_transfer_status'] = 3;
            /*End Customer bankTransfer Upload*/
            }
		

        /*Customer other document Upload*/
        if (!empty($request->file('other'))) {

            /*Customer other document Upload*/
            $other = $request->file('other');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $extOther = $other->getClientOriginalExtension();
            //$actualNameOther= str_replace(" ","_",$nameOther);
            $actualNameOther = 'Other';
            //this is for upload folder
            //$uploadFileNameOther=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameOther.'.'.$extOther;
            $uploadFileNameOther = $agent_code . '_' . $inci_number . '_' . $actualNameOther . '.' . $extOther;
            //this is for database
            $other->move($documentPath, $uploadFileNameOther);
            $customerArray['other'] = $uploadFileNameOther;
            $customerArray['other_status'] = 3;
            /*End Customer other document Upload*/
        }
	$customerArray['created_at'] = date('Y-m-d h:i:s');
        $incidentInsert = DB::table('incident_sell_documents')->insert($customerArray);
        $addCooment = $this->addCooment($request, $inci_number);

        return  $customerArray;
    }

    /***********************************************************
    Sell-WithDocument-Student
    - Document upload by agent sell and Student and document type with
     ************************************************************/
    function sellStudentDocumentUpload($request, $inci_number, $default_agent_code = '')
    {
        //echo $inci_number."==>".$default_agent_code;
        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $customerArray['incident_number'] = $inci_number;
        $todayDate = date('Y-m-d');
        $documentPath =  'allDocuments/' . $todayDate . '/' . $inci_number . '/';

        if (isset($default_agent_code) && $default_agent_code != '') :
            $agent_code = $default_agent_code;
        else :
            $agent_code = $request->agentCode;
        endif;

        if (!empty($request->file('passport'))) {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();
            //$actualPassportName= str_replace(" ","_",$namePassport);
            //Need a static name for uploaded file
            $actualPassportName = "PASSPORT";
            //this is for upload folder
            //$uploadFileNamePassport=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $uploadFileNamePassport = $agent_code . '_' . $inci_number . '_' . $actualPassportName . '.' . $extPassport;
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['passport'] = $uploadFileNamePassport;
            $customerArray['passport_status'] = 3;

            /*End Customer Passport Upload*/
        }

        /*Customer Visa Upload*/
        if (!empty($request->file('visa'))) {
            $visa = $request->file('visa');
            $milliseconds = round(microtime(true) * 1000);
            $nameVisa = $visa->getClientOriginalName();
            $extVisa = $visa->getClientOriginalExtension();
            $actualNameVisa = str_replace(" ", "_", $nameVisa);
            $actualNameVisa = "VISA";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extVisa;
            $uploadFileNameVisa = $agent_code . '_' . $inci_number . '_' . $actualNameVisa . '.' . $extVisa;
            //this is for database
            $visa->move($documentPath, $uploadFileNameVisa);
            $customerArray['visa'] = $uploadFileNameVisa;
            $customerArray['visa_status'] = 3;

            /*End Customer Visa Upload*/
        }

        /*Customer ticket Upload*/
        if (!empty($request->file('ticket'))) {
            $ticket = $request->file('ticket');
            $milliseconds = round(microtime(true) * 1000);
            $nameTicket = $ticket->getClientOriginalName();
            $extTicket = $ticket->getClientOriginalExtension();
            $actualNameTicket = str_replace(" ", "_", $nameTicket);
            $actualNameTicket = "TICKET";
            //this is for upload folder
            //$uploadFileNameTicket=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameTicket.'.'.$extTicket;
            $uploadFileNameTicket = $agent_code . '_' . $inci_number . '_' . $actualNameTicket . '.' . $extTicket;
            //this is for database
            $ticket->move($documentPath, $uploadFileNameTicket);
            $customerArray['ticket'] = $uploadFileNameTicket;
            $customerArray['ticket_status'] = 3;

            /*End Customer ticket Upload*/
        }

        /*Customer pan Upload*/
        if (!empty($request->file('pan'))) {
            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $extPan = $pan->getClientOriginalExtension();
            $actualNamePan = str_replace(" ", "_", $namePan);
            $actualNamePan = "PAN";
            //this is for upload folder
            //$uploadFileNamePan=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamePan.'.'.$extPan;
            $uploadFileNamePan = $agent_code . '_' . $inci_number . '_' . $actualNamePan . '.' . $extPan;
            //this is for database
            $pan->move($documentPath, $uploadFileNamePan);
            $customerArray['pan_card'] = $uploadFileNamePan;
            $customerArray['pan_card_status'] = 3;

            /*End Customer pan Upload*/
        }

        /*Customer application Upload*/
        if (!empty($request->file('application'))) {
            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $extApplication = $application->getClientOriginalExtension();
            $actualNameApplication = str_replace(" ", "_", $nameApplication);
            $actualNameApplication = 'RELOAD_FORMS';

            //this is for upload folder
            //$uploadFileNameApplication=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameApplication.'.'.$extApplication;
            $uploadFileNameApplication = $agent_code . '_' . $inci_number . '_' . $actualNameApplication . '.' . $extApplication;
            //this is for database
            $application->move($documentPath, $uploadFileNameApplication);
            $customerArray['apply'] = $uploadFileNameApplication;
            $customerArray['apply_status'] = 3;
            /*End Customer application Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $extAnnexure = $annexure->getClientOriginalExtension();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';
            //this is for upload folder
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            //this is for database
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['annex'] = $uploadFileNamenameAnnexure;
            $customerArray['annex_status'] = 3;

            /*End Customer Annexure Upload*/
        }

        /*Customer sof Upload*/
        if (!empty($request->file('sof'))) {
            $sof = $request->file('sof');
            $milliseconds = round(microtime(true) * 1000);
            $nameSof = $sof->getClientOriginalName();
            $extSof = $sof->getClientOriginalExtension();
            $actualNameSof = str_replace(" ", "_", $nameSof);
            $actualNameSof = 'SOF';
            //this is for upload folder
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameSof.'.'.$extSof;
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameSof . '.' . $extSof;
            //this is for database
            $sof->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['sof'] = $uploadFileNameBankTransfer;
            $customerArray['sof_status'] = 3;
            /*End Customer sof Upload*/
        }

        /*Customer university Letter Upload*/
        if (!empty($request->file('university_letter'))) {
            $university_letter = $request->file('university_letter');

            $nameuniversityletter = $university_letter->getClientOriginalName();
            $extuniversityletter = $university_letter->getClientOriginalExtension();
            $actualNameuniversityletter = str_replace(" ", "_", $nameuniversityletter);
            $actualNameuniversityletter = "university_letter";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extuniversityletter;
            $uploadFileNameuniversityletter = $agent_code . '_' . $inci_number . '_' . $actualNameuniversityletter . '.' . $extuniversityletter;
            //this is for database
            $university_letter->move($documentPath, $uploadFileNameuniversityletter);
            $customerArray['university_letter'] = $uploadFileNameuniversityletter;
            $customerArray['university_letter_status'] = 3;
            /*End Customer university Letter Upload*/
        }

        /*Customer other document Upload*/
        if (!empty($request->file('other'))) {

            /*Customer other document Upload*/
            $other = $request->file('other');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $extOther = $other->getClientOriginalExtension();
            //$actualNameOther= str_replace(" ","_",$nameOther);
            $actualNameOther = 'Other';
            //this is for upload folder
            //$uploadFileNameOther=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameOther.'.'.$extOther;
            $uploadFileNameOther = $agent_code . '_' . $inci_number . '_' . $actualNameOther . '.' . $extOther;
            //this is for database
            $other->move($documentPath, $uploadFileNameOther);
            $customerArray['other'] = $uploadFileNameOther;
            $customerArray['other_status'] = 3;
            /*End Customer other document Upload*/
        }
	
	$customerArray['created_at'] = date('Y-m-d h:i:s');
        $incidentInsert = DB::table('incident_sell_documents')->insert($customerArray);
        $addCooment = $this->addCooment($request, $inci_number);

        return  $customerArray;
    }

    /***********************************************************
    Sell-WithDocument-Employment
    - Document upload by agent sell and Employment and document type with
     ************************************************************/
    function sellEmploymentDocumentUpload($request, $inci_number, $default_agent_code = '')
    {
        //echo $inci_number."==>".$default_agent_code;
        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $customerArray['incident_number'] = $inci_number;
        $todayDate = date('Y-m-d');
        $documentPath =  'allDocuments/' . $todayDate . '/' . $inci_number . '/';

        if (isset($default_agent_code) && $default_agent_code != '') :
            $agent_code = $default_agent_code;
        else :
            $agent_code = $request->agentCode;
        endif;

        if (!empty($request->file('passport'))) {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();
            //$actualPassportName= str_replace(" ","_",$namePassport);
            //Need a static name for uploaded file
            $actualPassportName = "PASSPORT";
            //this is for upload folder
            //$uploadFileNamePassport=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $uploadFileNamePassport = $agent_code . '_' . $inci_number . '_' . $actualPassportName . '.' . $extPassport;
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['passport'] = $uploadFileNamePassport;
            $customerArray['passport_status'] = 3;
            /*End Customer Passport Upload*/
        }

        /*Customer Visa Upload*/
        if (!empty($request->file('visa'))) {
            $visa = $request->file('visa');
            $milliseconds = round(microtime(true) * 1000);
            $nameVisa = $visa->getClientOriginalName();
            $extVisa = $visa->getClientOriginalExtension();
            $actualNameVisa = str_replace(" ", "_", $nameVisa);
            $actualNameVisa = "VISA";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extVisa;
            $uploadFileNameVisa = $agent_code . '_' . $inci_number . '_' . $actualNameVisa . '.' . $extVisa;
            //this is for database
            $visa->move($documentPath, $uploadFileNameVisa);
            $customerArray['visa'] = $uploadFileNameVisa;
            $customerArray['visa_status'] = 3;

            /*End Customer Visa Upload*/
        }

        /*Customer ticket Upload*/
        if (!empty($request->file('ticket'))) {
            $ticket = $request->file('ticket');
            $milliseconds = round(microtime(true) * 1000);
            $nameTicket = $ticket->getClientOriginalName();
            $extTicket = $ticket->getClientOriginalExtension();
            $actualNameTicket = str_replace(" ", "_", $nameTicket);
            $actualNameTicket = "TICKET";
            //this is for upload folder
            //$uploadFileNameTicket=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameTicket.'.'.$extTicket;
            $uploadFileNameTicket = $agent_code . '_' . $inci_number . '_' . $actualNameTicket . '.' . $extTicket;
            //this is for database
            $ticket->move($documentPath, $uploadFileNameTicket);
            $customerArray['ticket'] = $uploadFileNameTicket;
            $customerArray['ticket_status'] = 3;

            /*End Customer ticket Upload*/
        }

        /*Customer pan Upload*/
        if (!empty($request->file('pan'))) {
            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $extPan = $pan->getClientOriginalExtension();
            $actualNamePan = str_replace(" ", "_", $namePan);
            $actualNamePan = "PAN";
            //this is for upload folder
            //$uploadFileNamePan=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamePan.'.'.$extPan;
            $uploadFileNamePan = $agent_code . '_' . $inci_number . '_' . $actualNamePan . '.' . $extPan;
            //this is for database
            $pan->move($documentPath, $uploadFileNamePan);
            $customerArray['pan_card'] = $uploadFileNamePan;
            $customerArray['pan_card_status'] = 3;

            /*End Customer pan Upload*/
        }

        /*Customer application Upload*/
        if (!empty($request->file('application'))) {
            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $extApplication = $application->getClientOriginalExtension();
            $actualNameApplication = str_replace(" ", "_", $nameApplication);
            $actualNameApplication = 'RELOAD_FORMS';

            //this is for upload folder
            //$uploadFileNameApplication=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameApplication.'.'.$extApplication;
            $uploadFileNameApplication = $agent_code . '_' . $inci_number . '_' . $actualNameApplication . '.' . $extApplication;
            //this is for database
            $application->move($documentPath, $uploadFileNameApplication);
            $customerArray['apply'] = $uploadFileNameApplication;
            $customerArray['apply_status'] = 3;

            /*End Customer application Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $extAnnexure = $annexure->getClientOriginalExtension();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';
            //this is for upload folder
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            //this is for database
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['annex'] = $uploadFileNamenameAnnexure;
            $customerArray['annex_status'] = 3;

            /*End Customer Annexure Upload*/
        }

        /*Customer sof Upload*/
        if (!empty($request->file('sof'))) {
            $sof = $request->file('sof');
            $milliseconds = round(microtime(true) * 1000);
            $nameSof = $sof->getClientOriginalName();
            $extSof = $sof->getClientOriginalExtension();
            $actualNameSof = str_replace(" ", "_", $nameSof);
            $actualNameSof = 'SOF';
            //this is for upload folder
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameSof.'.'.$extSof;
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameSof . '.' . $extSof;
            //this is for database
            $sof->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['sof'] = $uploadFileNameBankTransfer;
            $customerArray['sof_status'] = 3;

            /*End Customer sof Upload*/
        }

        /*Customer employment Letter Upload*/
        if (!empty($request->file('employment_letter'))) {
            $employment_letter = $request->file('employment_letter');

            $nameemploymentletter = $employment_letter->getClientOriginalName();
            $extemploymentletter = $employment_letter->getClientOriginalExtension();
            $actualNameemploymentletter = str_replace(" ", "_", $nameemploymentletter);
            $actualNameemploymentletter = "employment_letter";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extemploymentletter;
            $uploadFileNameemploymentletter = $agent_code . '_' . $inci_number . '_' . $actualNameemploymentletter . '.' . $extemploymentletter;
            //this is for database
            $employment_letter->move($documentPath, $uploadFileNameemploymentletter);
            $customerArray['employment_letter'] = $uploadFileNameemploymentletter;
            $customerArray['emp_letter_status'] = 3;

            /*End Customer employment Letter Upload*/
        }

        /*Customer Employment Declaration Form Upload*/
        if (!empty($request->file('emp_declaration_form'))) {
            $emp_declaration_form = $request->file('emp_declaration_form');

            $nameemploymentletter = $emp_declaration_form->getClientOriginalName();
            $extemploymentletter = $emp_declaration_form->getClientOriginalExtension();
            $actualNameemploymentletter = str_replace(" ", "_", $nameemploymentletter);
            $actualNameemploymentletter = "emp_declaration_form";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extemploymentletter;
            $uploadFileNameemploymentletter = $agent_code . '_' . $inci_number . '_' . $actualNameemploymentletter . '.' . $extemploymentletter;
            //this is for database
            $emp_declaration_form->move($documentPath, $uploadFileNameemploymentletter);
            $customerArray['emp_declaration_form'] = $uploadFileNameemploymentletter;
            $customerArray['emp_declaration_form_status'] = 3;

            /*End Customer Employment Declaration Form Upload*/
        }

        /*Customer other document Upload*/
        if (!empty($request->file('other'))) {

            /*Customer other document Upload*/
            $other = $request->file('other');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $extOther = $other->getClientOriginalExtension();
            //$actualNameOther= str_replace(" ","_",$nameOther);
            $actualNameOther = 'Other';
            //this is for upload folder
            //$uploadFileNameOther=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameOther.'.'.$extOther;
            $uploadFileNameOther = $agent_code . '_' . $inci_number . '_' . $actualNameOther . '.' . $extOther;
            //this is for database
            $other->move($documentPath, $uploadFileNameOther);
            $customerArray['other'] = $uploadFileNameOther;
            $customerArray['other_status'] = 3;

            /*End Customer other document Upload*/
        }

        $customerArray['created_at'] = date('Y-m-d h:i:s');
	$incidentInsert = DB::table('incident_sell_documents')->insert($customerArray);
        $addCooment = $this->addCooment($request, $inci_number);

        return  $customerArray;
    }

    /***********************************************************
    Sell-WithDocument-Immigration
    - Document upload by agent sell and Immigration and document type with
     ************************************************************/
    function sellImmigrationDocumentUpload($request, $inci_number, $default_agent_code = '')
    {
        //echo $inci_number."==>".$default_agent_code;
        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $customerArray['incident_number'] = $inci_number;
        $todayDate = date('Y-m-d');
        $documentPath =  'allDocuments/' . $todayDate . '/' . $inci_number . '/';

        if (isset($default_agent_code) && $default_agent_code != '') :
            $agent_code = $default_agent_code;
        else :
            $agent_code = $request->agentCode;
        endif;

        if (!empty($request->file('passport'))) {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();
            //$actualPassportName= str_replace(" ","_",$namePassport);
            //Need a static name for uploaded file
            $actualPassportName = "PASSPORT";
            //this is for upload folder
            //$uploadFileNamePassport=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $uploadFileNamePassport = $agent_code . '_' . $inci_number . '_' . $actualPassportName . '.' . $extPassport;
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['passport'] = $uploadFileNamePassport;
            $customerArray['passport_status'] = 3;

            /*End Customer Passport Upload*/
        }

        /*Customer Visa Upload*/
        if (!empty($request->file('visa'))) {
            $visa = $request->file('visa');
            $milliseconds = round(microtime(true) * 1000);
            $nameVisa = $visa->getClientOriginalName();
            $extVisa = $visa->getClientOriginalExtension();
            $actualNameVisa = str_replace(" ", "_", $nameVisa);
            $actualNameVisa = "VISA";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extVisa;
            $uploadFileNameVisa = $agent_code . '_' . $inci_number . '_' . $actualNameVisa . '.' . $extVisa;
            //this is for database
            $visa->move($documentPath, $uploadFileNameVisa);
            $customerArray['visa'] = $uploadFileNameVisa;
            $customerArray['visa_status'] = 3;

            /*End Customer Visa Upload*/
        }

        /*Customer ticket Upload*/
        if (!empty($request->file('ticket'))) {
            $ticket = $request->file('ticket');
            $milliseconds = round(microtime(true) * 1000);
            $nameTicket = $ticket->getClientOriginalName();
            $extTicket = $ticket->getClientOriginalExtension();
            $actualNameTicket = str_replace(" ", "_", $nameTicket);
            $actualNameTicket = "TICKET";
            //this is for upload folder
            //$uploadFileNameTicket=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameTicket.'.'.$extTicket;
            $uploadFileNameTicket = $agent_code . '_' . $inci_number . '_' . $actualNameTicket . '.' . $extTicket;
            //this is for database
            $ticket->move($documentPath, $uploadFileNameTicket);
            $customerArray['ticket'] = $uploadFileNameTicket;
            $customerArray['ticket_status'] = 3;

            /*End Customer ticket Upload*/
        }

        /*Customer pan Upload*/
        if (!empty($request->file('pan'))) {
            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $extPan = $pan->getClientOriginalExtension();
            $actualNamePan = str_replace(" ", "_", $namePan);
            $actualNamePan = "PAN";
            //this is for upload folder
            //$uploadFileNamePan=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamePan.'.'.$extPan;
            $uploadFileNamePan = $agent_code . '_' . $inci_number . '_' . $actualNamePan . '.' . $extPan;
            //this is for database
            $pan->move($documentPath, $uploadFileNamePan);
            $customerArray['pan_card'] = $uploadFileNamePan;
            $customerArray['pan_card_status'] = 3;

            /*End Customer pan Upload*/
        }

        /*Customer application Upload*/
        if (!empty($request->file('application'))) {
            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $extApplication = $application->getClientOriginalExtension();
            $actualNameApplication = str_replace(" ", "_", $nameApplication);
            $actualNameApplication = 'RELOAD_FORMS';

            //this is for upload folder
            //$uploadFileNameApplication=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameApplication.'.'.$extApplication;
            $uploadFileNameApplication = $agent_code . '_' . $inci_number . '_' . $actualNameApplication . '.' . $extApplication;
            //this is for database
            $application->move($documentPath, $uploadFileNameApplication);
            $customerArray['apply'] = $uploadFileNameApplication;
            $customerArray['apply_status'] = 3;

            /*End Customer application Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $extAnnexure = $annexure->getClientOriginalExtension();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';
            //this is for upload folder
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            //this is for database
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['annex'] = $uploadFileNamenameAnnexure;
            $customerArray['annex_status'] = 3;

            /*End Customer Annexure Upload*/
        }

        /*Customer sof Upload*/
        if (!empty($request->file('sof'))) {
            $sof = $request->file('sof');
            $milliseconds = round(microtime(true) * 1000);
            $nameSof = $sof->getClientOriginalName();
            $extSof = $sof->getClientOriginalExtension();
            $actualNameSof = str_replace(" ", "_", $nameSof);
            $actualNameSof = 'SOF';
            //this is for upload folder
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameSof.'.'.$extSof;
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameSof . '.' . $extSof;
            //this is for database
            $sof->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['sof'] = $uploadFileNameBankTransfer;
            $customerArray['sof_status'] = 3;

            /*End Customer sof Upload*/
        }

        /*Customer Immigration Declaration Form Upload*/
        if (!empty($request->file('immigration_d_form'))) {
            $immigration_d_form = $request->file('immigration_d_form');

            $nameimmigrationdform = $immigration_d_form->getClientOriginalName();
            $extimmigrationdform = $immigration_d_form->getClientOriginalExtension();
            $actualNameimmigrationdform = str_replace(" ", "_", $nameimmigrationdform);
            $actualNameimmigrationdform = "Immigration_d_Form";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extimmigrationdform;
            $uploadFileNameimmigrationdform = $agent_code . '_' . $inci_number . '_' . $actualNameimmigrationdform . '.' . $extimmigrationdform;
            //this is for database
            $immigration_d_form->move($documentPath, $uploadFileNameimmigrationdform);
            $customerArray['immigration_d_form'] = $uploadFileNameimmigrationdform;
            $customerArray['immigration_d_form_status'] = 3;

            /*End Customer Immigration Declaration Form Upload*/
        }

        /*Customer other document Upload*/
        if (!empty($request->file('other'))) {

            /*Customer other document Upload*/
            $other = $request->file('other');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $extOther = $other->getClientOriginalExtension();
            //$actualNameOther= str_replace(" ","_",$nameOther);
            $actualNameOther = 'Other';
            //this is for upload folder
            //$uploadFileNameOther=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameOther.'.'.$extOther;
            $uploadFileNameOther = $agent_code . '_' . $inci_number . '_' . $actualNameOther . '.' . $extOther;
            //this is for database
            $other->move($documentPath, $uploadFileNameOther);
            $customerArray['other'] = $uploadFileNameOther;
            $customerArray['other_status'] = 3;

            /*End Customer other document Upload*/
        }
	$customerArray['created_at'] = date('Y-m-d h:i:s');
        $incidentInsert = DB::table('incident_sell_documents')->insert($customerArray);
        $addCooment = $this->addCooment($request, $inci_number);

        return  $customerArray;
    }

    /***********************************************************
    Sell-WithDocument-Medical
    - Document upload by agent sell and medical and document type with
     ************************************************************/
    function sellMedicalDocumentUpload($request, $inci_number, $default_agent_code = '')
    {
        //echo $inci_number."==>".$default_agent_code;
        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $customerArray['incident_number'] = $inci_number;
        $todayDate = date('Y-m-d');
        $documentPath =  'allDocuments/' . $todayDate . '/' . $inci_number . '/';

        if (isset($default_agent_code) && $default_agent_code != '') :
            $agent_code = $default_agent_code;
        else :
            $agent_code = $request->agentCode;
        endif;

        if (!empty($request->file('passport'))) {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();
            //$actualPassportName= str_replace(" ","_",$namePassport);
            //Need a static name for uploaded file
            $actualPassportName = "PASSPORT";
            //this is for upload folder
            //$uploadFileNamePassport=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $uploadFileNamePassport = $agent_code . '_' . $inci_number . '_' . $actualPassportName . '.' . $extPassport;
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['passport'] = $uploadFileNamePassport;
            $customerArray['passport_status'] = 3;

            /*End Customer Passport Upload*/
        }

        /*Customer Lerms Letter Upload*/
        if (!empty($request->file('lerms_letter'))) {
            $lerms_letter = $request->file('lerms_letter');

            $namelermsletter = $lerms_letter->getClientOriginalName();
            $extlermsletter = $lerms_letter->getClientOriginalExtension();
            $actualNamelermsletter = str_replace(" ", "_", $namelermsletter);
            $actualNamelermsletter = "Lerms_Letter";
            //this is for upload folder
            //$uploadFileNameVisa=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameVisa.'.'.$extlermsletter;
            $uploadFileNamelermsletter = $agent_code . '_' . $inci_number . '_' . $actualNamelermsletter . '.' . $extlermsletter;
            //this is for database
            $lerms_letter->move($documentPath, $uploadFileNamelermsletter);
            $customerArray['lerms_letter'] = $uploadFileNamelermsletter;
            $customerArray['lerms_letter_status'] = 3;

            /*End Customer Lerms Letter Upload*/
        }

        /*Customer pan Upload*/
        if (!empty($request->file('pan'))) {
            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $extPan = $pan->getClientOriginalExtension();
            $actualNamePan = str_replace(" ", "_", $namePan);
            $actualNamePan = "PAN";
            //this is for upload folder
            //$uploadFileNamePan=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamePan.'.'.$extPan;
            $uploadFileNamePan = $agent_code . '_' . $inci_number . '_' . $actualNamePan . '.' . $extPan;
            //this is for database
            $pan->move($documentPath, $uploadFileNamePan);
            $customerArray['pan_card'] = $uploadFileNamePan;
            $customerArray['pan_card_status'] = 3;

            /*End Customer pan Upload*/
        }

        /*Customer application Upload*/
        if (!empty($request->file('application'))) {
            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $extApplication = $application->getClientOriginalExtension();
            $actualNameApplication = str_replace(" ", "_", $nameApplication);
            $actualNameApplication = 'RELOAD_FORMS';

            //this is for upload folder
            //$uploadFileNameApplication=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameApplication.'.'.$extApplication;
            $uploadFileNameApplication = $agent_code . '_' . $inci_number . '_' . $actualNameApplication . '.' . $extApplication;
            //this is for database
            $application->move($documentPath, $uploadFileNameApplication);
            $customerArray['apply'] = $uploadFileNameApplication;
            $customerArray['apply_status'] = 3;

            /*End Customer application Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $extAnnexure = $annexure->getClientOriginalExtension();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';
            //this is for upload folder
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            //this is for database
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['annex'] = $uploadFileNamenameAnnexure;
            $customerArray['annex_status'] = 3;

            /*End Customer Annexure Upload*/
        }

        /*Customer Medical Letter document Upload*/
        if (!empty($request->file('medical_letter'))) {

            /*Customer medical_letter document Upload*/
            $medical_letter = $request->file('medical_letter');
            $milliseconds = round(microtime(true) * 1000);
            $namemedical_letter = $medical_letter->getClientOriginalName();
            $extmedical_letter = $medical_letter->getClientOriginalExtension();
            //$actualNamemedical_letter= str_replace(" ","_",$namemedical_letter);
            $actualNamemedical_letter = 'medical_letter';
            //this is for upload folder
            //$uploadFileNamemedical_letter=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamemedical_letter.'.'.$extmedical_letter;
            $uploadFileNamemedical_letter = $agent_code . '_' . $inci_number . '_' . $actualNamemedical_letter . '.' . $extmedical_letter;
            //this is for database
            $medical_letter->move($documentPath, $uploadFileNamemedical_letter);
            $customerArray['medical_letter'] = $uploadFileNamemedical_letter;
            $customerArray['medical_letter_status'] = 3;

            /*End Customer Medical Letter document Upload*/
        }

        $customerArray['created_at'] = date('Y-m-d h:i:s');
	$incidentInsert = DB::table('incident_sell_documents')->insert($customerArray);
        $addCooment = $this->addCooment($request, $inci_number);

        return  $customerArray;
    }

    /***********************************************************
        BuyDocument
        - Document upload by agent buy with and without
     ************************************************************/
    function buyDocumentUpload($request, $inci_number)
    {

        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $customerArray['incident_number'] = $inci_number;
        $todayDate = date('Y-m-d');
        $documentPath = public_path() . '/allDocuments/' . $todayDate . '/' . $inci_number . '/';
        $agent_code = $request->agentCodeDetails;

        if (!empty($request->file('passport'))) {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            //$actualPassportName= str_replace(" ","_",$namePassport);
            $actualPassportName = "PASSPORT";
            $extPassport = $passport->getClientOriginalExtension();

            //this is for upload folder
            //$uploadFileNamePassport=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $uploadFileNamePassport = $agent_code . '_' . $inci_number . '_' . $actualPassportName . '.' . $extPassport;
            //this is for database
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['passport'] = $uploadFileNamePassport;
            $customerArray['passport_status'] = 3;

            /*End Customer Passport Upload*/
        }

        /*Customer refundSell Upload*/
        if (!empty($request->file('refund_form'))) {
            $refundSell = $request->file('refund_form');
            $milliseconds = round(microtime(true) * 1000);
            $nameRefound = $refundSell->getClientOriginalName();
            //$actualNameRefound= str_replace(" ","_",$nameRefound);
            $actualNameRefound = "RefundForm";
            $extRefuncForm = $refundSell->getClientOriginalExtension();
            //this is for upload folder
            //$uploadFileNameRefound=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameRefound.'.'.$extRefuncForm;
            $uploadFileNameRefound = $agent_code . '_' . $inci_number . '_' . $actualNameRefound . '.' . $extRefuncForm;
            //this is for database
            $refundSell->move($documentPath, $uploadFileNameRefound);
            $customerArray['refound'] = $uploadFileNameRefound;
            $customerArray['refound_status'] = 3;

            /*End Customer refundSell Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';
            $extAnnexure = $annexure->getClientOriginalExtension();
            //this is for upload folder
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            //this is for database
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['annex'] = $uploadFileNamenameAnnexure;
            $customerArray['annex_status'] = 3;

            /*End Customer Annexure Upload*/
        }

        /*Customer surrender letter Upload*/
        if (!empty($request->file('surrender_letter'))) {
            $surrenderletter = $request->file('surrender_letter');
            $milliseconds = round(microtime(true) * 1000);
            $namesurrenderletter = $surrenderletter->getClientOriginalName();
            //$actualNamenameAnnexure= str_replace(" ","_",$namesurrenderletter);
            $actualNamenamesurrenderletter = 'Surrender-Letter';
            $extsurrenderletter = $surrenderletter->getClientOriginalExtension();
            //this is for upload folder
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenamesurrenderletter = $agent_code . '_' . $inci_number . '_' . $actualNamenamesurrenderletter . '.' . $extsurrenderletter;
            //this is for database
            $surrenderletter->move($documentPath, $uploadFileNamenamesurrenderletter);
            $customerArray['surrender_letter'] = $uploadFileNamenamesurrenderletter;
            $customerArray['surrender_letter_status'] = 3;

            /*End Customer surrender letter Upload*/
        }
		   /*Customer bankTransfer  Upload*/
          if (!empty($request->file('bankTransfer'))) {
            $bankTransfer = $request->file('bankTransfer');
            $milliseconds = round(microtime(true) * 1000);
            $namebankTransfer = $bankTransfer->getClientOriginalName();
            $extbankTransfer = $bankTransfer->getClientOriginalExtension();
            $actualNameBankTransfer = str_replace(" ", "_", $namebankTransfer);
            $actualNameBankTransfer = 'bank_transfer';
            //this is for upload folder
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameBankTransfer.'.'.$extbankTransfer;
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameBankTransfer . '.' . $extbankTransfer;
            //this is for database
            $bankTransfer->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['bank_transfer'] = $uploadFileNameBankTransfer;
            $customerArray['bank_transfer_status'] = 3;
            /*End Customer bankTransfer Upload*/
            }

        if (!empty($request->file('otherSell'))) {
            /*Customer Annexure Upload*/
            $other = $request->file('otherSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $extOther = $other->getClientOriginalExtension();
            //$actualNameOther= str_replace(" ","_",$nameOther);
            $actualNameOther = 'Other';
            //this is for upload folder
            //$uploadFileNameOther=$milliseconds.'_'.$agent_code.'_'.$inci_number.'_'.$actualNameOther.'.'.$extOther;
            $uploadFileNameOther = $agent_code . '_' . $inci_number . '_' . $actualNameOther . '.' . $extOther;
            //this is for database
            //$filenameOther='http:loudeffect.ga/thomasCook/public/allFiles/other/'.$milliseconds.'_'.$request->agentKeySell.'_'.$inci_number.'_'.$actualNameOther;
            $filenameOther = $milliseconds . '_' . $agent_code . '_' . $inci_number . '_' . $actualNameOther;
            //$other->move(public_path().'/allFiles/other/', $uploadFileNameOther);
            $other->move($documentPath, $uploadFileNameOther);
            $customerArray['inci_up_other'] = $uploadFileNameOther;
            $customerArray['other_status'] = 3;

            /*End Customer Annexure Upload*/
        }


        $customerArray['created_at'] = date('Y-m-d h:i:s');
	$incidentInsert = DB::table('incident_buy_documents')->insert($customerArray);
        $addCooment = $this->addCooment($request, $inci_number);

        return  $customerArray;
    }
    /******************************
        Add Document Comment
     *******************************/
    function addCooment($request, $inci_number)
    {
        $commentArray['incident_number'] = $inci_number;
        $commentArray['comment'] = $request->comment;
        $commentArray['created_at'] = Carbon::now()->toDateTimeString();
        DB::table('document_comments')->insert($commentArray);
    }
    /******************************
        Insert Incident Old Code
     *******************************/
    public function incidentInsertOLD(Request $request)
    {


        $viewNumber = '';
        $bookingArray = array();
        $currentTimeinSeconds = time();
        $inci_key = substr(sha1($currentTimeinSeconds), 0, 8);
        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        $incidentNumberDetails = DB::table('incidents')->orderBy('inci_id', 'DESC')->first();
        if ($incidentNumberDetails != '') {

            $number = $incidentNumberDetails->inci_number;
            $indexChar = substr($number, 0, -6);
            $getNumber = substr($number, -6);

            if ($getNumber + 1 > 999999) {
                //echo (++$indexChar."000001");
                $number = (++$indexChar . "000001");
                $viewNumber = (++$indexChar . "000001");
                $bookingArray['inci_number'] = $number;
                $getNumber = 000001;
            } else {
                //echo ($indexChar.sprintf("%06s", ++$getNumber));
                $number = ($indexChar . sprintf("%06s", ++$getNumber));
                $viewNumber = ($indexChar . sprintf("%06s", $getNumber));
                $bookingArray['inci_number'] = $number;
            }
        } else {
            $bookingArray['inci_number'] = 'A000001';
            $viewNumber = 'A000001';
        }
        $incidentNumber = $request->agentCodeDetails . "_" . $currentDate . "_" . $request->customerNumberName;

        $bookingArray['inci_key'] = $bookingArray['inci_number'] . "-" . $inci_key;
        $bookingArray['inci_agent_key'] = $request->agentCode;
        $bookingArray['inci_agent_code'] = $request->agentCodeDetails;
        $bookingArray['departure_date'] = date('yyyy-mm-dd', strtotime($request->date_of_departure));
        $incidentType = $request->incidentType;
        //incidentType 1 mean number insert
        //incidentType 0 means text insert
        if ($incidentType == 1) {

            date_default_timezone_set('Asia/Kolkata');
            $currentDate = date('Y-m-d');

            date_default_timezone_set('Asia/Kolkata');
            $currentTime = date('H:i');
            $bookingArray['inci_type'] = $incidentType;
            $bookingArray['inci_forex_card_no'] = $request->customerNumberName;
            $bookingArray['inci_name'] = $request->customerNumberName;
            $bookingArray['inci_recived_date'] = $currentDate;
            $bookingArray['inci_recived_time'] = $currentTime;
            $bookingArray['inci_currency_type'] = $request->currencyFullName;
            $bookingArray['inci_frgn_curr_amount'] = $request->amount;
            $bookingArray['inci_buy_sell_req'] = $request->BuySell;
            $bookingArray['inci_agent_margin'] = $request->agentMargin;
            $bookingArray['inci_inr_amount'] = $request->inrAmount;
            $bookingArray['inci_agent_type'] = $request->agentType;
            $bookingArray['inci_currency_rate'] = $request->currencyRate;
            $bookingArray['transaction_type'] = $request->transaction_type;
            $bookingArray['inci_create_time'] = now();
            // print_r($bookingArray);die;

            if ($request->documentStatus == 1) {
                $bookingArray['inci_assign_status'] = $request->documentStatus;
                $bookingArray['inci_status'] = $request->documentStatus;
                $incidentInsert = DB::table('incidents')->insert($bookingArray);
                $subject = 'Incident Created Successfully';
                $password = 'Your booking request number is  ' . $viewNumber . ' has been submitted';
                $agent = DB::table('agents')->where('agent_code', $request->agentCode)->first();
                $mailId = '';
                if ($agent != '') {
                    $mailId = $agent->agent_mail;
                } else {
                    $subAgent = DB::table('sub_agents')->where('sub_agent_code', $request->agentCode)->first();
                    $mailId = $subAgent->sub_agent_mail;
                }
                Mail::to($mailId)->send(new createIncidentSuccess($subject, $password));
                return response()->json($viewNumber);
            } else {
                $tcUserLogin = DB::table('tc_user')->where('tc_login_date', '!=', 'Logout')->where('tc_type', '=', $request->BuySell)->orderBy('checklogintime', 'ASC')->get();

                $tcUser = [];
                $getLoginTcUser = $this->getLoginTcUserId($request->BuySell);
                if ($getLoginTcUser) {
                    $tcUserId = $getLoginTcUser['id'];
                    $tcUserKey = $getLoginTcUser['last_key'];

                    $tcUser = TcUser::getTcUser($tcUserId);
                }
                if ($tcUser) {

                    $userAssign = $tcUser->tc_key;
                    if($request->BuySell == 0){
                        $bookingArray['inci_assignto'] = $userAssign;
                        $bookingArray['inci_assignto_status'] = 1;
                    }
                   
                    $incidentInsert = DB::table('incidents')->insert($bookingArray);

                    $assign_requests = array(
                        'tc_user' =>  $tcUserId,
                        'last_key' =>  $tcUserKey
                    );
                    $assignTcUser = DB::table('assign_requests')->insert($assign_requests);
                    $subject = 'Incident Created Successfully';
                    $password = 'Your booking request number is  ' . $viewNumber . ' has been submitted';
                    $agent = DB::table('agents')->where('agent_code', $request->agentCode)->first();
                    $mailId = '';
                    if ($agent != '') {
                        $mailId = $agent->agent_mail;
                    } else {
                        $subAgent = DB::table('sub_agents')->where('sub_agent_code', $request->agentCode)->first();
                        $mailId = $subAgent->sub_agent_mail;
                    }
                    Mail::to($mailId)->send(new createIncidentSuccess($subject, $password));

                    return response()->json($viewNumber);
                } else {
                    $admin = DB::table('admins')->first();
                    $bookingArray['inci_assignto'] = $admin->admin_key;
                    $incidentInsert = DB::table('incidents')->insert($bookingArray);
                    $subject = 'Incident Created Successfully';
                    $password = 'Your booking request number is  ' . $viewNumber . ' has been submitted';
                    $agent = DB::table('agents')->where('agent_code', $request->agentCode)->first();
                    $mailId = '';
                    if ($agent != '') {
                        $mailId = $agent->agent_mail;
                    } else {
                        $subAgent = DB::table('sub_agents')->where('sub_agent_code', $request->agentCode)->first();
                        $mailId = $subAgent->sub_agent_mail;
                    }
                    Mail::to($mailId)->send(new createIncidentSuccess($subject, $password));
                    return response()->json($viewNumber);
                }
            }
        }
    }

    /**********************************************************
        Get Incidents Details by Ajax request
     ***********************************************************/
    public function getIncidentDetails(Request $request)
    {

        $incidentsDetails = DB::table('incident_update')->where('inci_up_inc_key', $request->incidentKey)
            ->where('inci_up_accept_status', 1)->first();

        if ($incidentsDetails) {

            $incidentDetails = DB::table('incidents')
                ->join('incident_update', 'incident_update.inci_up_inc_key', '=', 'incidents.inci_key')
                ->select('incident_update.*', 'incidents.*')
                ->where('inci_up_inc_key', '=', $request->incidentKey)
                ->first();

            echo json_encode($incidentDetails);
        } else {
            $response = [];
            $incidentsDetails = DB::table('incidents')->where('inci_key', $request->incidentKey)->first();
            $comments = DB::table('document_comments')->where('incident_number', $incidentsDetails->inci_number)->get();
            $currencyRecords = DB::table('incident_currency')->where('incident_id', $incidentsDetails->inci_number)->get();
            $response['incident'] = $incidentsDetails;
            $response['comments'] = ($comments->count() == 0) ? 'hide' : '';
            $response['currencyRecords'] = ($currencyRecords->count() >= 1) ? $currencyRecords : 0;
            $response['currencyTotal'] = ($currencyRecords->count() >= 1) ? $currencyRecords->sum('inci_inr_amount') : 0;

            echo json_encode($response);
        }
    }

    /**********************************************************
         Upload file for sell( OLD )
        = Upload File For Buy
     ***********************************************************/
    public function uploadFiles(Request $request)
    {

        /*return response()->json([
       'message'   => 'Image Upload Successfully',
       'uploaded_image' => '<img src="public/images/'.$request->getAgentType.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success'
      ]);die;*/

        $incidentType = DB::table('incidents')->where(['inci_key' => $request->incidentKeyValue])->first();
        $todayDate = date('Y-m-d');
        $documentPath = public_path() . '/allDocuments/' . $todayDate . '/' . $incidentType->inci_number . '/';


        /*Customer Passport Upload*/
        $customerArray = array();
        $currentTimeinSeconds = time();
        $inci_up_key = substr(sha1($currentTimeinSeconds), 0, 8);
        $customerArray['inci_up_key'] = $incidentType->inci_number . "-" . $inci_up_key;
        $customerArray['inci_up_name'] = $request->custName;
        $customerArray['inci_up_agent_code'] = $request->agentKey;
        $customerArray['inci_up_agent_code_details'] = $request->getAgentCodeDetails;
        $customerArray['inci_up_inc_key'] = $request->incidentKeyValue;

        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');
        $customerArray['inci_up_date'] = $currentDate;
        $customerArray['inci_up_time'] = $currentTime;

        if ($request->customerFaxNumber == null) {
            $customerArray['inci_up_fax_number'] = $request->forexNumber;
            //print_r( $customerArray);

        } else {
            $customerArray['inci_up_fax_number'] = $request->customerFaxNumber;
            // print_r( $customerArray);
        } //die;

        if (!empty($request->file('passport'))) {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $actualPassportName = str_replace(" ", "_", $namePassport);
            //this is for upload folder
            $uploadFileNamePassport = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualPassportName;
            //this is for database
            $filenamePassport = 'http:loudeffect.ga/thomasCook/public/allFiles/passport/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualPassportName;
            //$passport->move(public_path().'/allFiles/passport/', $uploadFileNamePassport);

            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['inci_up_pass'] = $uploadFileNamePassport;
            /*End Customer Passport Upload*/
        }

        if (!empty($request->file('visa'))) {
            /*Customer Visa Upload*/
            $visa = $request->file('visa');
            $milliseconds = round(microtime(true) * 1000);
            $nameVisa = $visa->getClientOriginalName();
            $actualNameVisa = str_replace(" ", "_", $nameVisa);
            //this is for upload folder
            $uploadFileNameVisa = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameVisa;
            //this is for database
            $filenameVisa = 'http:loudeffect.ga/thomasCook/public/allFiles/visa/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameVisa;
            //$visa->move(public_path().'/allFiles/visa/', $uploadFileNameVisa);
            $visa->move($documentPath, $uploadFileNameVisa);
            $customerArray['inci_up_visa'] = $uploadFileNameVisa;
            /*End Customer Visa Upload*/
        }


        /*Customer ticket Upload*/
        if (!empty($request->file('ticket'))) {
            $ticket = $request->file('ticket');
            $milliseconds = round(microtime(true) * 1000);
            $nameTicket = $ticket->getClientOriginalName();
            $actualNameTicket = str_replace(" ", "_", $nameTicket);
            //this is for upload folder
            $uploadFileNameTicket = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameTicket;
            //this is for database
            $filenameTicket = 'http:loudeffect.ga/thomasCook/public/allFiles/ticket/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameTicket;
            //$ticket->move(public_path().'/allFiles/ticket/', $uploadFileNameTicket);
            $ticket->move($documentPath, $uploadFileNameTicket);
            $customerArray['inci_up_tiket'] = $uploadFileNameTicket;
            /*End Customer ticket Upload*/
        }

        if (!empty($request->file('pan'))) {
            /*Customer pan Upload*/
            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $actualNamePan = str_replace(" ", "_", $namePan);
            //this is for upload folder
            $uploadFileNamePan = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNamePan;
            //this is for database
            $filenamePan = 'http:loudeffect.ga/thomasCook/public/allFiles/pan/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNamePan;
            //$pan->move(public_path().'/allFiles/pan/', $uploadFileNamePan);
            $pan->move($documentPath, $uploadFileNamePan);
            $customerArray['inci_up_pan'] = $uploadFileNamePan;
            /*End Customer pan Upload*/
        }


        /*Customer application Upload*/
        if (!empty($request->file('application'))) {
            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $actualNameApplication = str_replace(" ", "_", $nameApplication);
            //this is for upload folder
            $uploadFileNameApplication = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameApplication;
            //this is for database
            $filenameApplication = 'http:loudeffect.ga/thomasCook/public/allFiles/application/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameApplication;
            //$application->move(public_path().'/allFiles/application/', $uploadFileNameApplication);
            $application->move($documentPath, $uploadFileNameApplication);
            $customerArray['inci_up_appli'] = $uploadFileNameApplication;
            /*End Customer application Upload*/
        }


        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $actualNamenameAnnexure = str_replace(" ", "_", $nameAnnexure);
            //this is for upload folder
            $uploadFileNamenameAnnexure = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNamenameAnnexure;
            //this is for database
            $filenamenameAnnexure = 'http:loudeffect.ga/thomasCook/public/allFiles/annexure/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNamenameAnnexure;
            //$annexure->move(public_path().'/allFiles/annexure/', $uploadFileNamenameAnnexure);
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['inci_up_annex'] = $uploadFileNamenameAnnexure;
            /*End Customer Annexure Upload*/
        }



        /*Customer bankTransfer Upload*/
        if (!empty($request->file('bankTransfer'))) {
            $bankTransfer = $request->file('bankTransfer');
            $milliseconds = round(microtime(true) * 1000);
            $namebankTransfer = $bankTransfer->getClientOriginalName();
            $actualNameBankTransfer = str_replace(" ", "_", $namebankTransfer);
            //this is for upload folder
            $uploadFileNameBankTransfer = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameBankTransfer;
            //this is for database
            $filenameBankTransfer = 'http:loudeffect.ga/thomasCook/public/allFiles/bankTransfer/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameBankTransfer;
            // $bankTransfer->move(public_path().'/allFiles/bankTransfer/', $uploadFileNameBankTransfer);
            $bankTransfer->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['inci_up_bank_transfer'] = $uploadFileNameBankTransfer;
            /*End Customer bankTransfer Upload*/
        }

        /*Customer sof Upload*/
        if (!empty($request->file('sof'))) {
            $sof = $request->file('sof');
            $milliseconds = round(microtime(true) * 1000);
            $nameSof = $sof->getClientOriginalName();
            $actualNameSof = str_replace(" ", "_", $nameSof);
            //this is for upload folder
            $uploadFileNameBankTransfer = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameSof;
            //this is for database
            $filenameSof = 'http:loudeffect.ga/thomasCook/public/allFiles/sof/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameSof;
            //$sof->move(public_path().'/allFiles/sof/', $uploadFileNameBankTransfer);
            $sof->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['inci_up_sof'] = $uploadFileNameBankTransfer;
            /*End Customer sof Upload*/
        }
        if (!empty($request->file('businessLetter'))) {

            /*Customer businessLetter Upload*/
            $businessLetter = $request->file('businessLetter');
            $milliseconds = round(microtime(true) * 1000);
            $nameBusinessLetter = $businessLetter->getClientOriginalName();
            $actualNameBusinessLetter = str_replace(" ", "_", $nameBusinessLetter);
            //this is for upload folder
            $uploadFileNameBankTransfer = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameBusinessLetter;
            //this is for database
            $filenameBusinessLetter = 'http:loudeffect.ga/thomasCook/public/allFiles/businessLetter/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameBusinessLetter;
            //$businessLetter->move(public_path().'/allFiles/businessLetter/', $uploadFileNameBankTransfer);
            $businessLetter->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['inci_up_business'] = $uploadFileNameBankTransfer;
            /*End Customer businessLetter Upload*/
        }


        if (!empty($request->file('other'))) {

            /*Customer Annexure Upload*/
            $other = $request->file('other');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $actualNameOther = str_replace(" ", "_", $nameOther);
            //this is for upload folder
            $uploadFileNameOther = $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameOther;
            //this is for database
            $filenameOther = 'http:loudeffect.ga/thomasCook/public/allFiles/other/' . $milliseconds . '_' . $request->agentKey . '_' . $incidentType->inci_number . '_' . $actualNameOther;
            //$other->move(public_path().'/allFiles/other/', $uploadFileNameOther);
            $other->move($documentPath, $uploadFileNameOther);
            $customerArray['inci_up_other'] = $uploadFileNameOther;
            /*End Customer Annexure Upload*/
        }

        //$customerArray['inci_up_travle_date']=$request->custDate;
        $customerArray['inci_up_agent_type'] = $request->getAgentType;
        // echo json_encode($customerArray);die;

        //$incidentInsert = DB::table('incident_update')->insert($customerArray);


        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');



        $inciBuySell = $incidentType->inci_buy_sell_req;

        $tcUserLogin = DB::table('tc_user')->where('tc_login_date', '!=', 'Logout')->where('tc_type', '=', $inciBuySell)->orderBy('checklogintime', 'ASC')->get();

        if (count($tcUserLogin) > 0) {
            foreach ($tcUserLogin as $key => $allTcUser) {

                $incidentDetails = DB::table('incidents')
                    ->join('incident_update', 'incident_update.inci_up_inc_key', '=', 'incidents.inci_key')
                    ->where(['inci_up_assign_to' => $allTcUser->tc_key])
                    ->where(['inci_up_accept_status' => 0])
                    ->orderBy('inci_up_id', 'DESC')
                    ->get();

                $userDetails[] = array('userKey' => $allTcUser->tc_key, 'count' => count($incidentDetails));
            }

            array_multisort(array_column($userDetails, 'count'), SORT_ASC, $userDetails);  //SORT_DESC
            $getLoginTcUser = $this->getLoginTcUserId($inciBuySell);
            if ($getLoginTcUser) {
                $tcUserId = $getLoginTcUser['id'];
                $tcUserKey = $getLoginTcUser['last_key'];

                $tcUser = TcUser::getTcUser($tcUserId);
            }
            $userAssign = $tcUser->tc_key;
            //$userAssign=$userDetails[0]['userKey'];
            if ($incidentType->inci_assignto != '') {
                $customerArray['inci_up_assign_to'] = $incidentType->inci_assignto;
            } else {
                $admin = DB::table('admins')->first();
                if (count($tcUserLogin) > 0) {
                    $customerArray['inci_up_assign_to'] = $userAssign;
                } else {
                    $customerArray['inci_up_assign_to'] = $admin->admin_key;
                }
            }
            $incidentUpdate = DB::table('incidents')->where(['inci_key' => $request->incidentKeyValue])->update(['inci_show_hide_status' => '2']);
            $incidentInsert = DB::table('incident_update')->insert($customerArray);
            $assign_requests = array(
                'tc_user' =>  $tcUserId,
                'last_key' =>  $tcUserKey
            );
            $assignTcUser = DB::table('assign_requests')->insert($assign_requests);
            $subject = 'Incident Updated Successfully';
            $message = $incidentType->inci_number . ' documents have been uploaded';
            $agent = DB::table('agents')->where('agent_code', $request->agentKey)->first();
            $mailId = '';
            if ($agent != '') {
                $mailId = $agent->agent_mail;
            } else {
                $subAgent = DB::table('sub_agents')->where('sub_agent_code', $request->agentKey)->first();
                $mailId = $subAgent->sub_agent_mail;
            }
            //Mail::to($mailId)->send(new createIncidentSuccess($subject, $message));
            return response()->json('1');
        } else {
            $incidentUpdate = DB::table('incidents')->where(['inci_key' => $request->incidentKeyValue])->update(['inci_show_hide_status' => '2']);
            $admin = DB::table('admins')->first();
            $customerArray['inci_up_assign_to'] = $admin->admin_key;
            $incidentInsert = DB::table('incident_update')->insert($customerArray);
            $subject = 'Incident Updated Successfully';
            $message = $incidentType->inci_number . ' documents have been uploaded';
            $agent = DB::table('agents')->where('agent_code', $request->agentKey)->first();
            $mailId = '';
            if ($agent != '') {
                $mailId = $agent->agent_mail;
            } else {
                $subAgent = DB::table('sub_agents')->where('sub_agent_code', $request->agentKey)->first();
                $mailId = $subAgent->sub_agent_mail;
            }
            //Mail::to($mailId)->send(new createIncidentSuccess($subject, $message));
            return response()->json('1');
        }
    }

    //Upload File For Sell
    public function uploadFilesForSell(Request $request)
    {

        /*return response()->json([
       'message'   => 'Image Upload Successfully',
       'uploaded_image' => '<img src="public/images/'.$request->getAgentType.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success'
      ]);die;*/


        /*Customer Passport Upload*/


        /*        date_default_timezone_set('Asia/Kolkata');
        $currentDate= date('Y-m-d');
        $currentTime= date('H:i');
        $tcUserLogin = DB::table('tc_user')->where(['tc_login_date'=>$currentDate])->where('tc_login_time','<',$currentTime)->get();
        if (count($tcUserLogin) == 0) {
           return response()->json( '0');die;
        }*/



        $incidentType = DB::table('incidents')->where(['inci_key' => $request->incidentSellKeyValue])->first();
        $todayDate = date('Y-m-d');
        $documentPath = public_path() . '/allDocuments/' . $todayDate . '/' . $incidentType->inci_number . '/';

        $customerArray = array();

        $currentTimeinSeconds = time();
        $inci_up_key = substr(sha1($currentTimeinSeconds), 0, 8);
        $customerArray['inci_up_key'] = $incidentType->inci_number . "-" . $inci_up_key;
        $customerArray['inci_up_name'] = $request->customerNameSell;
        $customerArray['inci_up_agent_code'] = $request->agentKeySell;
        $customerArray['inci_up_agent_code_details'] = $request->getAgentCodeDetailsSell;
        $customerArray['inci_up_inc_key'] = $request->incidentSellKeyValue;

        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');

        $customerArray['inci_up_date'] = $currentDate;
        $customerArray['inci_up_time'] = $currentTime;

        if ($request->customerFaxNumber == null) {
            $customerArray['inci_up_fax_number'] = $request->forexNumberSell;
            //print_r( $customerArray);

        } else {
            $customerArray['inci_up_fax_number'] = $request->customerFaxNumberSell;
            // print_r( $customerArray);
        } //die;

        if (!empty($request->file('passportSell'))) {
            $passport = $request->file('passportSell');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $actualPassportName = str_replace(" ", "_", $namePassport);
            //this is for upload folder
            $uploadFileNamePassport = $milliseconds . '_' . $request->agentKeySell . '_' . $incidentType->inci_number . '_' . $actualPassportName;
            //this is for database
            $filenamePassport = 'http:loudeffect.ga/thomasCook/public/allFiles/passport/' . $milliseconds . '_' . $request->agentKeySell . '_' . $incidentType->inci_number . '_' . $actualPassportName;
            //$passport->move(public_path().'/allFiles/', $uploadFileNamePassport);
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['inci_up_pass'] = $uploadFileNamePassport;
            /*End Customer Passport Upload*/
        }


        /*Customer Visa Upload*/
        /* $document=$request->file('documentSell');
        $milliseconds = round(microtime(true) * 1000);
        $nameDocument=$document->getClientOriginalName();
        $actualNameDocument= str_replace(" ","_",$nameDocument);
        //this is for upload folder
        $uploadFileNameDocument=$milliseconds.'_'.$actualNameDocument;
        //this is for database
        $filenameDocument='http:loudeffect.ga/thomasCook/public/allFiles/document/'.$milliseconds.'_'.$actualNameDocument;
        $document->move(public_path().'/allFiles/document/', $uploadFileNameDocument);
        $customerArray['inci_up_document']=$filenameDocument;*/
        /*End Customer Visa Upload*/



        /*Customer ticket Upload*/
        if (!empty($request->file('refundSell'))) {
            $refundSell = $request->file('refundSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameRefound = $refundSell->getClientOriginalName();
            $actualNameRefound = str_replace(" ", "_", $nameRefound);
            //this is for upload folder
            $uploadFileNameRefound = $milliseconds . '_' . $request->agentKeySell . '_' . $incidentType->inci_number . '_' . $actualNameRefound;
            //this is for database
            $filenameRefound = 'http:loudeffect.ga/thomasCook/public/allFiles/refound/' . $milliseconds . '_' . $request->agentKeySell . '_' . $incidentType->inci_number . '_' . $actualNameRefound;
            // $refundSell->move(public_path().'/allFiles/refound/', $uploadFileNameRefound);
            $refundSell->move($documentPath, $uploadFileNameRefound);
            $customerArray['inci_up_refound'] = $uploadFileNameRefound;
            /*End Customer ticket Upload*/
        }




        /*Customer Annexure Upload*/
        if (!empty($request->file('annexureSell'))) {
            $annexure = $request->file('annexureSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $actualNamenameAnnexure = str_replace(" ", "_", $nameAnnexure);
            //this is for upload folder
            $uploadFileNamenameAnnexure = $milliseconds . '_' . $request->agentKeySell . '_' . $incidentType->inci_number . '_' . $actualNamenameAnnexure;
            //this is for database
            $filenamenameAnnexure = 'http:loudeffect.ga/thomasCook/public/allFiles/annexure/' . $milliseconds . '_' . $request->agentKeySell . '_' . $incidentType->inci_number . '_' . $actualNamenameAnnexure;
            //$annexure->move(public_path().'/allFiles/annexure/', $uploadFileNamenameAnnexure);
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['inci_up_annex'] = $uploadFileNamenameAnnexure;
            /*End Customer Annexure Upload*/
        }



        if (!empty($request->file('otherSell'))) {

            /*Customer Annexure Upload*/
            $other = $request->file('otherSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $actualNameOther = str_replace(" ", "_", $nameOther);
            //this is for upload folder
            $uploadFileNameOther = $milliseconds . '_' . $request->agentKeySell . '_' . $incidentType->inci_number . '_' . $actualNameOther;
            //this is for database
            $filenameOther = 'http:loudeffect.ga/thomasCook/public/allFiles/other/' . $milliseconds . '_' . $request->agentKeySell . '_' . $incidentType->inci_number . '_' . $actualNameOther;
            //$other->move(public_path().'/allFiles/other/', $uploadFileNameOther);
            $other->move($documentPath, $uploadFileNameOther);
            $customerArray['inci_up_other'] = $uploadFileNameOther;
            /*End Customer Annexure Upload*/
        }

        // $customerArray['inci_up_travle_date']=$request->custDateSell;
        $customerArray['inci_up_agent_type'] = $request->getAgentTypeSell;
        // echo json_encode($customerArray);die;

        //$incidentInsert = DB::table('incident_update')->insert($customerArray)->lastInsertId();

        date_default_timezone_set('Asia/Kolkata');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');
        /*$tcUserLogin = DB::table('tc_user')->where(['tc_login_date'=>$currentDate])->where('tc_login_time','<',$currentTime)->get();*/



        $inciBuySell = $incidentType->inci_buy_sell_req;

        $tcUserLogin = DB::table('tc_user')->where('tc_login_date', '!=', 'Logout')->where('tc_type', '=', $inciBuySell)->orderBy('checklogintime', 'ASC')->get();

        //$tcUserLogin= DB::table('tc_user')->where('tc_login_date','!=','Logout')->orderBy('checklogintime','ASC')->get();

        if (count($tcUserLogin) > 0) {
            foreach ($tcUserLogin as $key => $allTcUser) {

                $incidentDetails = DB::table('incidents')
                    ->join('incident_update', 'incident_update.inci_up_inc_key', '=', 'incidents.inci_key')
                    ->where(['inci_up_assign_to' => $allTcUser->tc_key])
                    ->where(['inci_up_accept_status' => 0])
                    ->orderBy('inci_up_id', 'DESC')
                    ->get();

                $userDetails[] = array('userKey' => $allTcUser->tc_key, 'count' => count($incidentDetails));
            }

            array_multisort(array_column($userDetails, 'count'), SORT_ASC, $userDetails);  //SORT_DESC

            // $incidentUpdateHere = DB::table('incident_update')->where('')->update('inci_up_assign_to',$test[$i]['userKey']);
            $tcUserLogin = DB::table('tc_user')->where('tc_login_date', '!=', 'Logout')->where('tc_type', '=', $request->BuySell)->orderBy('checklogintime', 'ASC')->get();

            $tcUser = [];
            $getLoginTcUser = $this->getLoginTcUserId($request->BuySell);
            if ($getLoginTcUser) {
                $tcUserId = $getLoginTcUser['id'];
                $tcUserKey = $getLoginTcUser['last_key'];

                $tcUser = TcUser::getTcUser($tcUserId);
            }
            $userAssign = $tcUser->tc_key;
            //$userAssign=$userDetails[0]['userKey'];
            if ($incidentType->inci_assignto != '') {
                $customerArray['inci_up_assign_to'] = $incidentType->inci_assignto;
            } else {
                $admin = DB::table('admins')->first();
                //$customerArray['inci_up_assign_to']= $admin->admin_key;
                if (count($tcUserLogin) > 0) {
                    $customerArray['inci_up_assign_to'] = $userAssign;
                } else {
                    $customerArray['inci_up_assign_to'] = $admin->admin_key;
                }
            }

            $incidentUpdate = DB::table('incidents')->where('inci_key', $request->incidentSellKeyValue)->update(['inci_show_hide_status' => '2']);
            $incidentInsert = DB::table('incident_update')->insert($customerArray);
            $assign_requests = array(
                'tc_user' =>  $tcUserId,
                'last_key' =>  $tcUserKey
            );
            $assignTcUser = DB::table('assign_requests')->insert($assign_requests);
            $subject = 'Incident Updated Successfully';
            $message = $incidentType->inci_number . ' documents have been uploaded';
            $agent = DB::table('agents')->where('agent_code', $request->agentKeySell)->first();
            $mailId = '';
            if ($agent != '') {
                $mailId = $agent->agent_mail;
            } else {
                $subAgent = DB::table('sub_agents')->where('sub_agent_code', $request->agentKeySell)->first();
                $mailId = $subAgent->sub_agent_mail;
            }
            //Mail::to($mailId)->send(new createIncidentSuccess($subject, $message));
            return response()->json('1');

            return response()->json('1');
        } else {
            $incidentUpdate = DB::table('incidents')->where('inci_key', $request->incidentSellKeyValue)->update(['inci_show_hide_status' => '2']);
            $admin = DB::table('admins')->first();
            $customerArray['inci_up_assign_to'] = $admin->admin_key;
            $incidentInsert = DB::table('incident_update')->insert($customerArray);
            $subject = 'Incident Updated Successfully';
            $message = $incidentType->inci_number . ' documents have been uploaded';
            $agent = DB::table('agents')->where('agent_code', $request->agentKeySell)->first();
            $mailId = '';
            if ($agent != '') {
                $mailId = $agent->agent_mail;
            } else {
                $subAgent = DB::table('sub_agents')->where('sub_agent_code', $request->agentKeySell)->first();
                $mailId = $subAgent->sub_agent_mail;
            }
            //Mail::to($mailId)->send(new createIncidentSuccess($subject, $message));
            return response()->json('1');
        }
        /* return response()->json([
       'message'   => 'Image Upload Successfully',
       'uploaded_image' => '<img src="public/images/'.$request->custDate.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success'
      ]);*/
    }

    //Create Sub Agent Apge Calling
    public function createSubAgent()
    {


        $SubagentDetails = DB::table('sub_agents')->where('agent_code', Session::get('agentCode'))->get();
        /*   print_r($SubagentDetails);die;*/
        return view('thomasCook.createSubAgent', compact('SubagentDetails'));
    }

    //Add Sub Agent
    //Sub Agent Insert
    public function addSubAgent(Request $request)
    {

        $SubagentDetails = DB::table('sub_agents')->where('sub_agent_name', $request->agentUserName)->first();
        $depValidator = Validator::make($request->all(), [
            'agentCode' => 'required|max:255',
            'agentUserName' => 'required|max:255',
            'agentPassword' => 'required|max:255',
            'subAgentCode' => 'required|max:255',
            'agentStatus' => 'required',
            'agentForm' => 'required',
            'agentTo' => 'required',
            'agentName' => 'required',
            'agentLastName' => 'required',
            'contact' => 'required',
            'agentEmail' => 'required',
        ]);


        if ($depValidator->fails()) {
            Session::flash('agentError', '');
            return redirect('createSubAgent')->withErrors($depValidator)->withInput();
        }



        $AgentHave = DB::table('agents')->where('agent_user_name', $request->agentUserName)->first();
        if ($AgentHave) {

            Session::flash('subAgentAlreadyExist', '');
            return back();
        } else {
            $adminHave = DB::table('admins')->where('admin_mail_id', $request->agentUserName)->first();

            if ($adminHave) {

                Session::flash('subAgentAlreadyExist', '');
                return back();
            } else {
                $TcUserHave = DB::table('tc_user')->where('tc_user_name', $request->agentUserName)->first();
                if ($TcUserHave) {

                    Session::flash('subAgentAlreadyExist', '');
                    return back();
                } else {

                    $agentCodeDetails = DB::table('sub_agents')->where('sub_agent_name', $request->agentUserName)->first();


                    if ($agentCodeDetails) {

                        Session::flash('subAgentAlreadyExist', '');
                        return back();
                    } else {

                        $AgentCode = DB::table('agents')->where('agent_code', $request->subAgentCode)->first();

                        if ($AgentCode) {

                            Session::flash('agentCodeAlreadyExist', '');
                            return back();
                        } else {

                            $subAgentCode = DB::table('sub_agents')->where('sub_agent_code', $request->subAgentCode)->first();

                            if ($subAgentCode) {

                                Session::flash('agentCodeAlreadyExist', '');
                                return back();
                            } else {
                                $AgentCode = DB::table('agents')->where('agent_code', $request->agentCode)->first();
                                $buyMargin = $AgentCode->agent_buy;
                                $sellMargin = $AgentCode->agent_sell;
                                $agentArray = array();
                                $currentTimeinSeconds = time();
                                $subagent_key = substr(sha1($currentTimeinSeconds), 0, 8);
                                date_default_timezone_set('Asia/Kolkata');
                                $currentDate = date('Y-m-d');
                                $agentArray['sub_agent_key'] = $request->agentCode . "-" . $subagent_key;
                                $agentArray['agent_code'] = $request->agentCode;
                                $agentArray['sub_agent_name'] = $request->agentUserName;
                                $agentArray['sub_agent_password'] = encrypt($request->agentPassword);
                                $agentArray['sub_agent_code'] = $request->subAgentCode;
                                $agentArray['sub_agent_status'] = $request->agentStatus;
                                $agentArray['sub_agent_form'] = $request->agentForm;
                                $agentArray['sub_agent_to'] = $request->agentTo;
                                $agentArray['sub_agent_buy'] = $buyMargin;
                                $agentArray['sub_agent_sell'] = $sellMargin;
                                $agentArray['sub_agent_first_name'] = $request->agentName;
                                $agentArray['sub_agent_last_name'] = $request->agentLastName;
                                $agentArray['sub_agent_contact'] = $request->contact;
                                $agentArray['sub_agent_mail'] = $request->agentEmail;
                                $agentArray['create_date'] = $currentDate;

                                $employeeLeave = DB::table('sub_agents')->insert($agentArray);
                                Session::flash('agentSuccess', '');
                                return back();
                            }
                        }
                    }
                }
            }
        }
    }



    /*///////////////////////////  Edit Sub Agent ///////////////////////////*/

    //Edit Sub Agent
    public function editSubAgent(Request $request)
    {

        $subAgentDetails = DB::table('sub_agents')->where('sub_agent_key', $request->subAgentKey)->first();
        if ($subAgentDetails != '') {
            $password = decrypt($subAgentDetails->sub_agent_password);
        }



        $subAgentAllDetails = array(
            'sub_agent_key' => $subAgentDetails->sub_agent_key,
            'sub_agent_code' => $subAgentDetails->sub_agent_code,
            'sub_agent_name' => $subAgentDetails->sub_agent_name,
            'sub_agent_password' => $password,
            'sub_agent_status' => $subAgentDetails->sub_agent_status,
            'sub_agent_form' => $subAgentDetails->sub_agent_form,
            'sub_agent_to' => $subAgentDetails->sub_agent_to,
            'sub_agent_buy' => $subAgentDetails->sub_agent_buy,
            'sub_agent_sell' => $subAgentDetails->sub_agent_sell,
            'sub_agent_first_name' => $subAgentDetails->sub_agent_first_name,
            'sub_agent_last_name' => $subAgentDetails->sub_agent_last_name,
            'sub_agent_contact' => $subAgentDetails->sub_agent_contact,
            'sub_agent_mail' => $subAgentDetails->sub_agent_mail,
            'create_date' => $subAgentDetails->create_date,
        );

        echo json_encode($subAgentAllDetails);
    }


    /*///////////////////////Update Sub Agent //////////////////////////*/
    //Sub Agent Update
    public function updateSubAgent(Request $request)
    {

        $depValidator = Validator::make($request->all(), [
            'getSubUserName' => 'required|max:255',
            'subAgentPassword' => 'required|max:255',
            'getSubAgentCode' => 'required|max:255',
            'getSubStatus' => 'required',
            'getSubAgentForm' => 'required',
            'getSubAgentTo' => 'required',
            'subAgentFirstName' => 'required',
            'getSubAgentLastName' => 'required',
            'SubContact' => 'required',
            'subAgentEmail' => 'required',
        ]);


        if ($depValidator->fails()) {
            Session::flash('agentError', '');
            return redirect('createSubAgent')->withErrors($depValidator)->withInput();
        }



        $AgentHave = DB::table('agents')->where('agent_user_name', $request->getSubUserName)->first();
        if ($AgentHave) {

            Session::flash('subAgentAlreadyExist', '');
            return back();
        } else {
            $adminHave = DB::table('admins')->where('admin_mail_id', $request->getSubUserName)->first();

            if ($adminHave) {

                Session::flash('subAgentAlreadyExist', '');
                return back();
            } else {
                $TcUserHave = DB::table('tc_user')->where('tc_user_name', $request->getSubUserName)->first();
                if ($TcUserHave) {

                    Session::flash('subAgentAlreadyExist', '');
                    return back();
                } else {



                    $agentArray = array();
                    $agentArray['sub_agent_password'] = encrypt($request->subAgentPassword);
                    $agentArray['sub_agent_code'] = $request->getSubAgentCode;
                    $agentArray['sub_agent_status'] = $request->getSubStatus;
                    $agentArray['sub_agent_form'] = $request->getSubAgentForm;
                    $agentArray['sub_agent_to'] = $request->getSubAgentTo;
                    $agentArray['sub_agent_first_name'] = $request->subAgentFirstName;
                    $agentArray['sub_agent_last_name'] = $request->getSubAgentLastName;
                    $agentArray['sub_agent_contact'] = $request->SubContact;
                    $agentArray['sub_agent_mail'] = $request->subAgentEmail;


                    $employeeLeave = DB::table('sub_agents')->where('sub_agent_key', $request->getSubAgentKey)->update($agentArray);
                    Session::flash('subUpdateSuccess', '');
                    return back();
                }
            }
        }
    }


    /*/////////////////////////////  Sub Agent Delete   ////////////////////////*/
    //Delete Agent
    public function frontSubAgentDelete($subAgentKey)
    {

        $agents = DB::table('sub_agents')->where('sub_agent_key', $subAgentKey)->delete();
        return back();
    }


    //Forex Card number Check
    /*    public function cardNumberCheck(Request $request){

        $incidentCardNumber = DB::table('incidents')->where('inci_forex_card_no',$request->inputval)->first();
        print_r($incidentCardNumber);die;
        if ($incidentCardNumber !='') {
           echo "1";
        }else{
            echo "0";
        }

    }*/


    //Check Incident Status
    public function checkIncidentStatus($agentCode, $agentCodeDetails)
    {
        $this->Autcheck();
        //DB::enableQueryLog();

        $incidentDetails = DB::table('incidents')
            ->join('incident_update', 'incident_update.inci_up_inc_key', '=', 'incidents.inci_key')
            ->select('incident_update.*', 'incidents.*')
            //->where('inci_up_agent_code_details','=',$agentCode)
            ->where('incidents.inci_agent_code', '=', $agentCode)
            ->orderBy('inci_number', 'DESC')
            ->get();
        //dd(DB::getQueryLog());
        //print_r($incidentDetails);die;
        $incidentAllDetails = array();
        $incidentKeys = array();
        foreach ($incidentDetails as $key => $agentsValue) {
            $getInciKay = $agentsValue->inci_up_key;
            $agentReport = array(
                'cardNumber' => substr($agentsValue->inci_up_fax_number, -6),
                'inci_key' => $agentsValue->inci_key,
                'inci_number' => $agentsValue->inci_number,
                'inci_currency_type' => $agentsValue->inci_currency_type,
                'inci_up_date' => $agentsValue->inci_up_date,
                'inci_up_time' => $agentsValue->inci_up_time,
                'inci_currency_type' => $agentsValue->inci_currency_type,
                'inci_frgn_curr_amount' => $agentsValue->inci_frgn_curr_amount,
                'inci_buy_sell_req' => $agentsValue->inci_buy_sell_req,

                'inci_agent_margin' => $agentsValue->inci_agent_margin,
                'inci_inr_amount' => $agentsValue->inci_inr_amount,
                'inci_up_accept_status' => $agentsValue->inci_up_accept_status,
                'inci_up_recived_date' => $agentsValue->inci_up_recived_date,
                'inci_up_recived_time' => $agentsValue->inci_up_recived_time,
                'inci_up_comment' => $agentsValue->inci_up_comment,
                'inci_status_message' => $agentsValue->inci_status_message,
                'inci_up_name' => 'Document Updated  ',
                'inci_up_edit_ststus' => '1',
                'inci_up_edit_key' => $getInciKay,
                'inci_up_key' => $getInciKay
            );
            $incidentKeys[] = $agentsValue->inci_up_inc_key;
            array_push($incidentAllDetails, $agentReport);
        }



        $incidentValueDetails = DB::table('incidents')->where('inci_agent_code', $agentCode)->get();

        foreach ($incidentValueDetails as $key => $value) {
            //echo $value->inci_key;
            //echo $incidentKeys[$key];die;
            ///$inciKey=$incidentKeys[$key];
            $getInciKay = $value->inci_key;
            if (!in_array($getInciKay, $incidentKeys)) {

                $agentDetail = array(
                    'cardNumber' => substr($value->inci_forex_card_no, -6),
                    'inci_key' => $value->inci_key,
                    'inci_number' => $value->inci_number,
                    'inci_currency_type' => $value->inci_currency_type,
                    'inci_up_date' => $value->inci_recived_date,
                    'inci_up_time' => $value->inci_recived_time,
                    'inci_currency_type' => $value->inci_currency_type,
                    'inci_frgn_curr_amount' => $value->inci_frgn_curr_amount,
                    'inci_buy_sell_req' => $value->inci_buy_sell_req,

                    'inci_agent_margin' => $value->inci_agent_margin,
                    'inci_inr_amount' => $value->inci_inr_amount,
                    'inci_up_accept_status' => $value->inci_status,
                    'inci_up_recived_date' => '',
                    'inci_up_recived_time' => '',
                    'inci_up_comment' => $value->inci_status_message,
                    'inci_status_message' => $value->inci_status_message,
                    'inci_up_name' => 'Document Not Updated',
                    'inci_up_edit_ststus' => '0',
                    'inci_up_edit_key' => $getInciKay,

                );
                array_push($incidentAllDetails, $agentDetail);
            };
        }

        //  echo "<pre>";print_r($incidentAllDetails);die;

        return view('thomasCook.incidentStatus', compact('incidentAllDetails'));
    }

    /***********************************************************
        Incident Edit Form
        - Rejected document Upload
     ************************************************************/
    public function incidentEdit($incidentUpdateKey)
    {
        $incidentUpdateDetails = DB::table('incident_update')->where('inci_up_key', $incidentUpdateKey)->first();
        //Passport'/'
        $passport = $incidentUpdateDetails->inci_up_pass;
        $pos = strrpos($passport, '_');
        $passportFileName = $pos === false ? $passport : substr($passport, $pos + 1);

        //Visa'/'
        $visa = $incidentUpdateDetails->inci_up_visa;
        $pos = strrpos($visa, '_');
        $visaFileName = $pos === false ? $visa : substr($visa, $pos + 1);

        //Tiket'/'
        $tiket = $incidentUpdateDetails->inci_up_tiket;
        $pos = strrpos($tiket, '_');
        $tiketFileName = $pos === false ? $tiket : substr($tiket, $pos + 1);

        //pan'/'
        $pan = $incidentUpdateDetails->inci_up_pan;
        $pos = strrpos($pan, '_');
        $panFileName = $pos === false ? $pan : substr($pan, $pos + 1);

        //Application'/'
        $application = $incidentUpdateDetails->inci_up_appli;
        $pos = strrpos($application, '_');
        $applicationFileName = $pos === false ? $application : substr($application, $pos + 1);

        //Annexure'/'
        $annexure = $incidentUpdateDetails->inci_up_annex;
        $pos = strrpos($annexure, '_');
        $annexureFileName = $pos === false ? $annexure : substr($annexure, $pos + 1);


        //Buseness'/'
        $business = $incidentUpdateDetails->inci_up_business;
        $pos = strrpos($business, '_');
        $businessFileName = $pos === false ? $business : substr($business, $pos + 1);


        //Application'/'
        $bankTransfer = $incidentUpdateDetails->inci_up_bank_transfer;
        $pos = strrpos($bankTransfer, '_');
        $bankTransferFileName = $pos === false ? $bankTransfer : substr($bankTransfer, $pos + 1);

        //Sof'/'
        $sof = $incidentUpdateDetails->inci_up_sof;
        $pos = strrpos($sof, '_');
        $sofFileName = $pos === false ? $sof : substr($sof, $pos + 1);

        //Document'/'
        $document = $incidentUpdateDetails->inci_up_document;
        $pos = strrpos($document, '_');
        $documentFileName = $pos === false ? $document : substr($document, $pos + 1);

        //Refound'/'
        $refound = $incidentUpdateDetails->inci_up_refound;
        $pos = strrpos($refound, '_');
        $refoundFileName = $pos === false ? $refound : substr($refound, $pos + 1);


        //Other'/'
        $other = $incidentUpdateDetails->inci_up_other;
        $pos = strrpos($other, '_');
        $otherFileName = $pos === false ? $other : substr($other, $pos + 1);
        $count = 1;


        $filesName = array();
        $filesName = array(
            'inci_up_pass' => $passportFileName,
            'inci_up_visa' => $visaFileName,
            'inci_up_tiket' => $tiketFileName,
            'inci_up_pan' => $panFileName,
            'inci_up_appli' => $applicationFileName,
            'inci_up_annex' => $annexureFileName,

            'inci_up_business' => $businessFileName,
            'inci_up_bank_transfer' => $bankTransferFileName,
            'inci_up_sof' => $sofFileName,
            'inci_up_document' => $documentFileName,
            'inci_up_refound' => $refoundFileName,
            'inci_up_other' => $otherFileName,
        );

        $incidentKey = $incidentUpdateDetails->inci_up_inc_key;
        $incident = DB::table('incidents')->where('inci_key', $incidentKey)->first();
        $buySell = $incident->inci_buy_sell_req;
        $currencyRecords = '';
        $incidentDocuments = '';
        if ($incidentUpdateDetails != '') {
            $agentType = $incidentUpdateDetails->inci_up_agent_type;
            $agentCode = $incidentUpdateDetails->inci_up_agent_code;
            if ($agentType == 'agent') {
                $agents = DB::table('agents')->where('agent_code', $agentCode)->first();
            } else {
                $agents = DB::table('sub_agents')->where('sub_agent_code', $agentCode)->first();
            }
            $getIncidentDocuments = '';
            if ($incident->inci_buy_sell_req == 1) {
                $getIncidentDocuments = DB::table('incident_sell_documents')->where('incident_number', $incident->inci_number)->get();
            } else {
                $getIncidentDocuments = DB::table('incident_buy_documents')->where('incident_number', $incident->inci_number)->get();
            }
            if ($getIncidentDocuments->count() ==  1) {
                $incidentDocuments = $getIncidentDocuments->first();
            }

            $documentComments = DB::table('document_comments')->where('incident_number', $incident->inci_number)->get();
            $currencyRecords = DB::table('incident_currency')->where('incident_id', $incident->inci_id)->get();
        }
        // dd($incidentDocuments);die;
        $AllCurrency = DB::table('currency')->get();

        $viewName = "thomasCook.incidentEdit";
        if (!empty($currencyRecords)) {
            if ($incident->inci_buy_sell_req == 1) {
                $viewName = 'thomasCook.incidentEditSell';
            } else {
                $viewName = 'thomasCook.incidentEditBuy';
            }
        }
        return view($viewName, compact('incidentUpdateDetails', 'AllCurrency', 'agentType', 'agents', 'incidentKey', 'agentCode', 'buySell', 'filesName', 'incidentUpdateKey', 'currencyRecords', 'documentComments', 'incidentDocuments'));
    }

    //Incident Buy Update

    public function incidentBuyUpadte(Request $request)
    {
        $todayDate = date('Y-m-d');
        $incidentType = DB::table('incident_update')
            ->join('incidents', 'incidents.inci_key', '=', 'incident_update.inci_up_inc_key')
            ->select('incident_update.*', 'incidents.*')
            ->where('inci_up_key', '=', $request->incidentUpdateKey)
            ->first();
        // $incidentType = DB::table('incident_update')->where('inci_up_key',$request->incidentUpdateKey)->first();

        $IncidentUpdate = array();
        if ($request->documentSell != '') {
            $document = $request->file('documentSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameDocument = $document->getClientOriginalName();
            $actualNameDocument = str_replace(" ", "_", $nameDocument);
            //this is for upload folder
            /*  $uploadFileNameDocument=$milliseconds.'_'.$actualNameDocument;
            //this is for database
            $filenameDocument='http:loudeffect.ga/thomasCook/public/allFiles/document/'.$milliseconds.'_'.$actualNameDocument;
            $document->move(public_path().'/allDocuments/'.$todayDate.'/'.$incidentType->inci_number.'/');
            $IncidentUpdate['inci_up_document']=$filenameDocument;*/
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenameDocument=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameDocument;
            $filenameDocument = $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameDocument;
            $document->move($documentPath, $filenameDocument);
            $IncidentUpdate['inci_up_document'] = $filenameDocument;
            if (file_exists($documentPath . $request->documentSellValue)) {
                unlink($documentPath . $request->documentSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_document'] = $request->documentSellValue;
        }

        if ($request->passportSell != '') {
            $passport = $request->file('passportSell');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $actualPassportName = str_replace(" ", "_", $namePassport);
            //this is for upload folder
            /*    $uploadFileNamePassport=$milliseconds.'_'.$actualPassportName;
            //this is for database
            $filenamePassport='http:loudeffect.ga/thomasCook/public/allFiles/passport/'.$milliseconds.'_'.$actualPassportName;
            $passport->move(public_path().'/allDocuments/'.$todayDate.'/'.$incidentType->inci_number.'/');
            $IncidentUpdate['inci_up_pass']=$filenamePassport;*/
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenamePassport=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualPassportName;
            $filenamePassport = $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualPassportName;
            $passport->move($documentPath, $filenamePassport);
            $IncidentUpdate['inci_up_pass'] = $filenamePassport;
            if (file_exists($documentPath . $request->passportSellValue)) {
                unlink($documentPath . $request->passportSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_pass'] = $request->passportSellValue;
        }

        if ($request->refundSell != '') {
            $refundSell = $request->file('refundSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameRefound = $refundSell->getClientOriginalName();
            $actualNameRefound = str_replace(" ", "_", $nameRefound);
            //this is for upload folder
            /* $uploadFileNameRefound=$milliseconds.'_'.$actualNameRefound;
            //this is for database
            $filenameRefound='http:loudeffect.ga/thomasCook/public/allFiles/refound/'.$milliseconds.'_'.$actualNameRefound;
            $refundSell->move(public_path().'/allDocuments/'.$todayDate.'/'.$incidentType->inci_number.'/');
            $IncidentUpdate['inci_up_refound']=$filenameRefound;*/
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenameRefound=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameRefound;
            $filenameRefound = $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameRefound;
            $refundSell->move($documentPath, $filenameRefound);
            $IncidentUpdate['inci_up_refound'] = $filenameRefound;
            if (file_exists($documentPath . $request->refundSellValue)) {
                unlink($documentPath . $request->refundSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_refound'] = $request->refundSellValue;
        }

        if ($request->annexureSell != '') {
            $annexure = $request->file('annexureSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $actualNamenameAnnexure = str_replace(" ", "_", $nameAnnexure);
            //this is for upload folder
            /*$uploadFileNamenameAnnexure=$milliseconds.'_'.$actualNamenameAnnexure;
            //this is for database
            $filenamenameAnnexure='http:loudeffect.ga/thomasCook/public/allFiles/annexure/'.$milliseconds.'_'.$actualNamenameAnnexure;
            $annexure->move(public_path().'/allDocuments/'.$todayDate.'/'.$incidentType->inci_number.'/');
            $IncidentUpdate['inci_up_annex']=$filenamenameAnnexure;*/

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenamenameAnnexure=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNamenameAnnexure;
            $filenamenameAnnexure = $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNamenameAnnexure;
            $annexure->move($documentPath, $filenamenameAnnexure);
            $IncidentUpdate['inci_up_annex'] = $filenamenameAnnexure;
            if (file_exists($documentPath . $request->annexureSellValue)) {
                unlink($documentPath . $request->annexureSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_annex'] = $request->annexureSellValue;
        }

        if ($request->otherSell != '') {
            $other = $request->file('otherSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $actualNameOther = str_replace(" ", "_", $nameOther);
            //this is for upload folder
            /*  $uploadFileNameOther=$milliseconds.'_'.$actualNameOther;
            //this is for database
            $filenameOther='http:loudeffect.ga/thomasCook/public/allFiles/other/'.$milliseconds.'_'.$actualNameOther;
            $other->move(public_path().'/allDocuments/'.$todayDate.'/'.$incidentType->inci_number.'/');
            $IncidentUpdate['inci_up_other']=$filenameOther;*/

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $filenameOther = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameOther;
            $other->move($documentPath, $filenameOther);
            $IncidentUpdate['inci_up_other'] = $filenameOther;
            if ($request->otherSellValue) {
                if (file_exists($documentPath . $request->otherSellValue)) {
                    unlink($documentPath . $request->otherSellValue);
                }
            }
        } else {
            $IncidentUpdate['inci_up_other'] = $request->otherSellValue;
        }
        $IncidentUpdate['inci_up_accept_status'] = '0';
        //print_r($IncidentUpdate);die;
        $incidentUpdateDetails = DB::table('incident_update')->where('inci_up_key', $request->incidentUpdateKey)->update($IncidentUpdate);

        if ($incidentUpdateDetails > 0) {
            Session::flash('incidentUpdate', '');
            //echo "<script>window.close();</script>";
            return back();
        } else {
            Session::flash('incidentUpdate', '');
            //echo "<script>window.close();</script>";
            return back();
        }
    }

    public function incidentBuyUpadteWithComment(Request $request)
    {
        $todayDate = date('Y-m-d');
        $incidentType = DB::table('incident_update')
            ->join('incidents', 'incidents.inci_key', '=', 'incident_update.inci_up_inc_key')
            ->select('incident_update.*', 'incidents.*')
            ->where('inci_up_key', '=', $request->incidentUpdateKey)
            ->first();
        $getIncidentDocument = DB::table('incident_buy_documents')->where('incident_number', $incidentType->inci_number)->get()->first();
        //dd($getIncidentDocument);
        //dd($incidentType);
        $agent_code = $incidentType->inci_up_agent_code;
        $IncidentUpdate = array();

        if ($getIncidentDocument->pass_status == 2) {
            $passport = $request->file('passportSell');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();
            //$actualPassportName= str_replace(" ","_",$namePassport);
            $actualPassportName = 'PASSPORT';
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenamePassport=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $filenamePassport = $agent_code . '_' . $incidentType->inci_number . '_' . $actualPassportName . '.' . $extPassport;
            $passport->move($documentPath, $filenamePassport);
            $IncidentUpdate['inci_up_pass'] = $filenamePassport;
            $IncidentUpdate['pass_status'] = 3;
            /*if(file_exists($documentPath.$request->passportSellValue)){
                 unlink($documentPath.$request->passportSellValue);
                }*/
        }
        if ($getIncidentDocument->refound_status == 2) {
            $refundSell = $request->file('refundSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameRefound = $refundSell->getClientOriginalName();
            $extRefound = $refundSell->getClientOriginalExtension();
            //$actualNameRefound= str_replace(" ","_",$nameRefound);
            $actualNameRefound = 'RefundForm';

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenameRefound=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameRefound.'.'.$extRefound;
            //$filenameRefound=$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameRefound.'.'.$extRefound;
            $filenameRefound = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNameRefound . '.' . $extRefound;
            $refundSell->move($documentPath, $filenameRefound);
            $IncidentUpdate['inci_up_refound'] = $filenameRefound;
            $IncidentUpdate['refound_status'] = 3;
            /*if(file_exists($documentPath.$request->refundSellValue)){
                 unlink($documentPath.$request->refundSellValue);
                }*/
        }
        if ($getIncidentDocument->annex_status == 2) {
            $annexure = $request->file('annexureSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $extAnnexure = $annexure->getClientOriginalExtension();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenamenameAnnexure=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $filenamenameAnnexure = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            $annexure->move($documentPath, $filenamenameAnnexure);
            $IncidentUpdate['inci_up_annex'] = $filenamenameAnnexure;
            $IncidentUpdate['annex_status'] = 3;
            /*if(file_exists($documentPath.$request->annexureSellValue)){
                 unlink($documentPath.$request->annexureSellValue);
                }*/
        }
        if ($getIncidentDocument->other_status == 2) {
            $other = $request->file('otherSell');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $extOther = $other->getClientOriginalExtension();
            //$actualNameOther= str_replace(" ","_",$nameOther);
            $actualNameOther = 'Other';

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenameOther=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameOther.'.'.$extOther;
            $filenameOther = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNameOther . '.' . $extOther;
            $other->move($documentPath, $filenameOther);
            $IncidentUpdate['inci_up_other'] = $filenameOther;
            $IncidentUpdate['other_status'] = 3;
            /*if($request->otherSellValue){
                 if(file_exists($documentPath.$request->otherSellValue)){
                 unlink($documentPath.$request->otherSellValue);
                }
            }*/
        }

        $IncidentParma['inci_up_accept_status'] = '0';
        $incidentUpdateDetails = DB::table('incident_update')->where('inci_up_key', $request->incidentUpdateKey)->update($IncidentParma);
        // dd($IncidentUpdate);
        $incidentUpdateDoc = DB::table('incident_buy_documents')->where('incident_number', $incidentType->inci_number)->update($IncidentUpdate);

        $comment = DB::table('document_comments')->insert(
            array(
                'incident_number' => $incidentType->inci_number,
                'comment' => $request->comment
            )
        );

        if ($incidentUpdateDetails > 0) {
            Session::flash('incidentUpdate', '');
            //echo "<script>window.close();</script>";
            return back();
        } else {
            Session::flash('incidentUpdate', '');
            //echo "<script>window.close();</script>";
            return back();
        }
    }


    //Incident Sell Update

    public function incidentSellUpadte(Request $request)
    {
        $todayDate = date('Y-m-d');
        $incidentType = DB::table('incident_update')
            ->join('incidents', 'incidents.inci_key', '=', 'incident_update.inci_up_inc_key')
            ->select('incident_update.*', 'incidents.*')
            ->where('inci_up_key', '=', $request->incidentUpdateKey)
            ->first();


        $IncidentUpdate = array();
        if ($request->passport != '') {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $actualPassportName = str_replace(" ", "_", $namePassport);
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $uploadFileNamePassport = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualPassportName;
            $passport->move($documentPath, $uploadFileNamePassport);
            $IncidentUpdate['inci_up_pass'] = $uploadFileNamePassport;
            if (file_exists($documentPath . $request->passportSellValue)) {
                unlink($documentPath . $request->passportSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_pass'] = $request->passportSellValue;
        }

        if ($request->visa != '') {
            $visa = $request->file('visa');
            $milliseconds = round(microtime(true) * 1000);
            $nameVisa = $visa->getClientOriginalName();
            $actualNameVisa = str_replace(" ", "_", $nameVisa);
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $uploadFileNameVisa = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameVisa;
            $visa->move($documentPath, $uploadFileNameVisa);
            $IncidentUpdate['inci_up_visa'] = $uploadFileNameVisa;
            if (file_exists($documentPath . $request->visaSellValue)) {
                unlink($documentPath . $request->visaSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_visa'] = $request->visaSellValue;
        }

        if ($request->ticket != '') {
            $ticket = $request->file('ticket');
            $milliseconds = round(microtime(true) * 1000);
            $nameTicket = $ticket->getClientOriginalName();
            $actualNameTicket = str_replace(" ", "_", $nameTicket);
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $uploadFileNameTicket = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameTicket;
            $ticket->move($documentPath, $uploadFileNameTicket);
            $IncidentUpdate['inci_up_tiket'] = $uploadFileNameTicket;
            if (file_exists($documentPath . $request->ticketSellValue)) {
                unlink($documentPath . $request->ticketSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_tiket'] = $request->ticketSellValue;
        }


        if ($request->pan != '') {
            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $actualNamePan = str_replace(" ", "_", $namePan);

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $uploadFileNamePan = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNamePan;
            $pan->move($documentPath, $uploadFileNamePan);
            $IncidentUpdate['inci_up_pan'] = $uploadFileNamePan;
            if (file_exists($documentPath . $request->panSellValue)) {
                unlink($documentPath . $request->panSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_pan'] = $request->panSellValue;
        }

        if ($request->application != '') {
            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $actualNameApplication = str_replace(" ", "_", $nameApplication);
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $uploadFileNameApplication = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameApplication;
            $application->move($documentPath, $uploadFileNameApplication);
            $IncidentUpdate['inci_up_appli'] = $uploadFileNameApplication;
            if (file_exists($documentPath . $request->applicationSellValue)) {
                unlink($documentPath . $request->applicationSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_appli'] = $request->applicationSellValue;
        }

        if ($request->annexure != '') {
            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $actualNamenameAnnexure = str_replace(" ", "_", $nameAnnexure);

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $uploadFileNamenameAnnexure = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNamenameAnnexure;
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $IncidentUpdate['inci_up_annex'] = $uploadFileNamenameAnnexure;
            if (file_exists($documentPath . $request->annexureSellValue)) {
                unlink($documentPath . $request->annexureSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_annex'] = $request->annexureSellValue;
        }

        if ($request->bankTransfer != '') {
            $bankTransfer = $request->file('bankTransfer');
            $milliseconds = round(microtime(true) * 1000);
            $namebankTransfer = $bankTransfer->getClientOriginalName();
            $actualNameBankTransfer = str_replace(" ", "_", $namebankTransfer);

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $filenameBankTransfer = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameBankTransfer;
            $bankTransfer->move($documentPath, $filenameBankTransfer);
            $IncidentUpdate['inci_up_bank_transfer'] = $filenameBankTransfer;
            if (file_exists($documentPath . $request->bankTransferSellValue)) {
                unlink($documentPath . $request->bankTransferSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_bank_transfer'] = $request->bankTransferSellValue;
        }

        if ($request->businessLetter != '') {
            $businessLetter = $request->file('businessLetter');
            $milliseconds = round(microtime(true) * 1000);
            $nameBusinessLetter = $businessLetter->getClientOriginalName();
            $actualNameBusinessLetter = str_replace(" ", "_", $nameBusinessLetter);

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $filenameBusinessLetter = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameBusinessLetter;
            $businessLetter->move($documentPath, $filenameBusinessLetter);
            $IncidentUpdate['inci_up_business'] = $filenameBusinessLetter;
            if ($request->businessSellValue) {
                if (file_exists($documentPath . $request->businessSellValue)) {
                    unlink($documentPath . $request->businessSellValue);
                }
            }
        } else {
            $IncidentUpdate['inci_up_business'] = $request->businessSellValue;
        }

        if ($request->sof != '') {
            $sof = $request->file('sof');
            $milliseconds = round(microtime(true) * 1000);
            $nameSof = $sof->getClientOriginalName();
            $actualNameSof = str_replace(" ", "_", $nameSof);
            //this is for upload folder

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $uploadFileNameBankTransfer = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $actualNameSof;
            $sof->move($documentPath, $uploadFileNameBankTransfer);
            $IncidentUpdate['inci_up_sof'] = $uploadFileNameBankTransfer;
            if (file_exists($documentPath . $request->sofSellValue)) {
                unlink($documentPath . $request->sofSellValue);
            }
        } else {
            $IncidentUpdate['inci_up_sof'] = $request->sofSellValue;
        }



        if ($request->other != '') {
            $other = $request->file('other');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $actualNameOther = str_replace(" ", "_", $nameOther);
            //this is for upload folder
            $uploadFileNameOther = $milliseconds . '_' . $actualNameOther;

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            $filenameOther = $milliseconds . '_' . $incidentType->inci_agent_key . '_' . $incidentType->inci_number . '_' . $uploadFileNameOther;
            $other->move($documentPath, $filenameOther);
            $IncidentUpdate['inci_up_other'] = $filenameOther;

            if ($request->otherSellValue) {
                if (file_exists($documentPath . $request->otherSellValue)) {
                    unlink($documentPath . $request->otherSellValue);
                }
            }
        } else {
            $IncidentUpdate['inci_up_other'] = $request->otherSellValue;
        }
        //print_r($IncidentUpdate);die;
        $IncidentUpdate['inci_up_accept_status'] = '0';
        $incidentUpdateDetails = DB::table('incident_update')->where('inci_up_key', $request->incidentUpdateKey)->update($IncidentUpdate);

        if ($incidentUpdateDetails > 0) {
            Session::flash('incidentUpdate', '');
            //echo "<script>window.close();</script>";
            return back();
        } else {
            Session::flash('incidentUpdate', '');
            //echo "<script>window.close();</script>";
            return back();
        }
    }
    public function incidentSellUpadteWithComment(Request $request)
    {
        $todayDate = date('Y-m-d');
        $incidentType = DB::table('incident_update')
            ->join('incidents', 'incidents.inci_key', '=', 'incident_update.inci_up_inc_key')
            ->select('incident_update.*', 'incidents.*')
            ->where('inci_up_key', '=', $request->incidentUpdateKey)
            ->first();

        $getIncidentDocument = DB::table('incident_sell_documents')->where('incident_number', $incidentType->inci_number)->get()->first();

        $agent_code = $incidentType->inci_up_agent_code;


        $IncidentUpdate = array();
        if ($getIncidentDocument->pass_status == 2) {

            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();
            //$actualPassportName= str_replace(" ","_",$namePassport);
            $actualPassportName = 'PASSPORT';
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$uploadFileNamePassport=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualPassportName.'.'.$extPassport;
            $uploadFileNamePassport = $agent_code . '_' . $incidentType->inci_number . '_' . $actualPassportName . '.' . $extPassport;
            $passport->move($documentPath, $uploadFileNamePassport);
            $IncidentUpdate['inci_up_pass'] = $uploadFileNamePassport;
            $IncidentUpdate['pass_status'] = 3;
            /*if(file_exists($documentPath.$request->passportSellValue)){
                 unlink($documentPath.$request->passportSellValue);
                }*/
        }
        if ($getIncidentDocument->visa_status == 2) {

            $visa = $request->file('visa');
            $milliseconds = round(microtime(true) * 1000);
            $nameVisa = $visa->getClientOriginalName();
            $extVisa = $visa->getClientOriginalExtension();
            //$actualNameVisa= str_replace(" ","_",$nameVisa);
            $actualNameVisa = 'VISA';
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$uploadFileNameVisa=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameVisa.'.'.$extVisa;
            $uploadFileNameVisa = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNameVisa . '.' . $extVisa;
            $visa->move($documentPath, $uploadFileNameVisa);
            $IncidentUpdate['inci_up_visa'] = $uploadFileNameVisa;
            $IncidentUpdate['visa_status'] = 3;
            /*if(file_exists($documentPath.$request->visaSellValue)){
                 unlink($documentPath.$request->visaSellValue);
                }*/
        }
        if ($getIncidentDocument->tiket_status == 2) {


            $ticket = $request->file('ticket');
            $milliseconds = round(microtime(true) * 1000);
            $nameTicket = $ticket->getClientOriginalName();
            $extTicket = $ticket->getClientOriginalExtension();
            //$actualNameTicket= str_replace(" ","_",$nameTicket);
            $actualNameTicket = 'TICKET';
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$uploadFileNameTicket=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameTicket.'.'.$extTicket;
            $uploadFileNameTicket = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNameTicket . '.' . $extTicket;
            $ticket->move($documentPath, $uploadFileNameTicket);
            $IncidentUpdate['inci_up_tiket'] = $uploadFileNameTicket;
            $IncidentUpdate['tiket_status'] = 3;
            /*if(file_exists($documentPath.$request->ticketSellValue)){
                 unlink($documentPath.$request->ticketSellValue);
                }*/
        }
        if ($getIncidentDocument->pan_status == 2) {

            $pan = $request->file('pan');
            $milliseconds = round(microtime(true) * 1000);
            $namePan = $pan->getClientOriginalName();
            $extPan = $pan->getClientOriginalExtension();
            //$actualNamePan= str_replace(" ","_",$namePan);
            $actualNamePan = 'PAN';

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$uploadFileNamePan=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNamePan.'.'.$extPan;
            $uploadFileNamePan = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNamePan . '.' . $extPan;
            $pan->move($documentPath, $uploadFileNamePan);
            $IncidentUpdate['inci_up_pan'] = $uploadFileNamePan;
            $IncidentUpdate['pan_status'] = 3;
            /*if(file_exists($documentPath.$request->panSellValue)){
                 unlink($documentPath.$request->panSellValue);
                }*/
        }
        if ($getIncidentDocument->appli_status == 2) {

            $application = $request->file('application');
            $milliseconds = round(microtime(true) * 1000);
            $nameApplication = $application->getClientOriginalName();
            $extApplication = $application->getClientOriginalExtension();
            //$actualNameApplication= str_replace(" ","_",$nameApplication);
            $actualNameApplication = 'RELOAD_FORMS';
            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$uploadFileNameApplication=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameApplication.'.'.$extApplication;
            $uploadFileNameApplication = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNameApplication . '.' . $extApplication;
            $application->move($documentPath, $uploadFileNameApplication);
            $IncidentUpdate['inci_up_appli'] = $uploadFileNameApplication;
            $IncidentUpdate['appli_status'] = 3;
            /*if(file_exists($documentPath.$request->applicationSellValue)){
                 unlink($documentPath.$request->applicationSellValue);
                }*/
        }
        if ($getIncidentDocument->annex_status == 2) {

            $annexure = $request->file('annexure');
            $milliseconds = round(microtime(true) * 1000);
            $nameAnnexure = $annexure->getClientOriginalName();
            $extAnnexure = $annexure->getClientOriginalExtension();
            //$actualNamenameAnnexure= str_replace(" ","_",$nameAnnexure);
            $actualNamenameAnnexure = 'Annexure';

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$uploadFileNamenameAnnexure=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNamenameAnnexure.'.'.$extAnnexure;
            $uploadFileNamenameAnnexure = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $IncidentUpdate['inci_up_annex'] = $uploadFileNamenameAnnexure;
            $IncidentUpdate['annex_status'] = 3;
            /*if(file_exists($documentPath.$request->annexureSellValue)){
                 unlink($documentPath.$request->annexureSellValue);
                }*/
        }
        if ($getIncidentDocument->bank_status == 2) {

            $bankTransfer = $request->file('bankTransfer');
            $milliseconds = round(microtime(true) * 1000);
            $namebankTransfer = $bankTransfer->getClientOriginalName();
            $extbankTransfer = $bankTransfer->getClientOriginalExtension();
            //$actualNameBankTransfer= str_replace(" ","_",$namebankTransfer);
            $actualNameBankTransfer = 'bank_transfer';

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenameBankTransfer=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameBankTransfer.'.'.$extbankTransfer;
            $filenameBankTransfer = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNameBankTransfer . '.' . $extbankTransfer;
            $bankTransfer->move($documentPath, $filenameBankTransfer);
            $IncidentUpdate['inci_up_bank_transfer'] = $filenameBankTransfer;
            $IncidentUpdate['bank_status'] = 3;
            /*if(file_exists($documentPath.$request->bankTransferSellValue)){
                 unlink($documentPath.$request->bankTransferSellValue);
                }*/
        }
        if ($getIncidentDocument->business_status == 2) {
            $businessLetter = $request->file('businessLetter');
            $milliseconds = round(microtime(true) * 1000);
            $nameBusinessLetter = $businessLetter->getClientOriginalName();
            $extBusinessLetter = $businessLetter->getClientOriginalExtension();
            $actualNameBusinessLetter = str_replace(" ", "_", $nameBusinessLetter);

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenameBusinessLetter=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameBusinessLetter.'.'.$extBusinessLetter;
            $filenameBusinessLetter = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNameBusinessLetter . '.' . $extBusinessLetter;
            $businessLetter->move($documentPath, $filenameBusinessLetter);
            $IncidentUpdate['inci_up_business'] = $filenameBusinessLetter;
            $IncidentUpdate['business_status'] = 3;
            /*if($request->businessSellValue){
                    if(file_exists($documentPath.$request->businessSellValue)){
                     unlink($documentPath.$request->businessSellValue);
                    }
                }*/
        }
        if ($getIncidentDocument->sof_status == 2) {


            $sof = $request->file('sof');
            $milliseconds = round(microtime(true) * 1000);
            $nameSof = $sof->getClientOriginalName();
            $extSof = $sof->getClientOriginalExtension();
            //$actualNameSof= str_replace(" ","_",$nameSof);
            $actualNameSof = 'SOF';
            //this is for upload folder

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$uploadFileNameBankTransfer=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$actualNameSof.'.'.$extSof;
            $uploadFileNameBankTransfer = $agent_code . '_' . $incidentType->inci_number . '_' . $actualNameSof . '.' . $extSof;
            $sof->move($documentPath, $uploadFileNameBankTransfer);
            $IncidentUpdate['inci_up_sof'] = $uploadFileNameBankTransfer;
            $IncidentUpdate['sof_status'] = 3;
            /*if(file_exists($documentPath.$request->sofSellValue)){
                     unlink($documentPath.$request->sofSellValue);
                    } */
        }

        if ($getIncidentDocument->other_status == 2) {

            $other = $request->file('other');
            $milliseconds = round(microtime(true) * 1000);
            $nameOther = $other->getClientOriginalName();
            $actualNameOther = str_replace(" ", "_", $nameOther);
            //this is for upload folder
            $uploadFileNameOther = $milliseconds . '_' . $actualNameOther;

            $documentPath = public_path() . '/allDocuments/' . $incidentType->inci_up_date . '/' . $incidentType->inci_number . '/';
            //$filenameOther=$milliseconds.'_'.$incidentType->inci_agent_key.'_'.$incidentType->inci_number.'_'.$uploadFileNameOther;
            $filenameOther = $agent_code . '_' . $incidentType->inci_number . '_' . $uploadFileNameOther;
            $other->move($documentPath, $filenameOther);
            $IncidentUpdate['inci_up_other'] = $filenameOther;
            $IncidentUpdate['other_status'] = 3;

            /*if($request->otherSellValue){
                        if(file_exists($documentPath.$request->otherSellValue)){
                     unlink($documentPath.$request->otherSellValue);
                    }

                    }*/
        }

        // print_r($IncidentUpdate);die;
        $IncidentParma['inci_up_accept_status'] = '0';
        $incidentUpdateDetails = DB::table('incident_update')->where('inci_up_key', $request->incidentUpdateKey)->update($IncidentParma);
        $incidentUpdateDoc = DB::table('incident_sell_documents')->where('incident_number', $incidentType->inci_number)->update($IncidentUpdate);

        $comment = DB::table('document_comments')->insert(
            array(
                'incident_number' => $incidentType->inci_number,
                'comment' => $request->comment
            )
        );

        if ($incidentUpdateDetails > 0) {
            Session::flash('incidentUpdate', '');
            //echo "<script>window.close();</script>";
            return back();
        } else {
            Session::flash('incidentUpdate', '');
            //echo "<script>window.close();</script>";
            return back();
        }
    }


    public function incidentDocuments($incidentUpdateKey)
    {

        $incidentAllDetails = DB::table('incidents')
            ->join('incident_update', 'incident_update.inci_up_inc_key', '=', 'incidents.inci_key')
            ->select('incident_update.*', 'incidents.*')
            ->where('inci_up_key', '=', $incidentUpdateKey)
            ->get()->first();

        /* dd($incidentDetails);
         $incidentAllDetails=DB::table('incident_update')->where('inci_up_key',$incidentUpdateKey)->first();*/
        return view('thomasCook.incidentDocuments', compact('incidentAllDetails'));
    }


    // get login tc user
    function getLoginTcUserId($tcType)
    {

        $loginTcUsers =  TcUser::getSellLoginUserIds($tcType);
        $lastTcUser =  TcUser::getLastUserIds();
        $oneOrMoreLogin = false;
        $nextRequestUser = '';
        $currentTcUser = [];
        $assignTcUser = '';

        // check tc user login or not
        if ($loginTcUsers) {
            $currentTcUser = array(
                'id' => $loginTcUsers[0],
                'last_key' => '0',
            );
            // check login user 1 or more
            if (count($loginTcUsers) > 1) {
                $oneOrMoreLogin = true;
                // check if last tc user is exits or not
                if ($lastTcUser) {

                    // check last user login or not
                    if (isset($loginTcUsers[$lastTcUser->last_key])) {
                        if (isset($loginTcUsers[$lastTcUser->last_key + 1])) {

                            // last user index and login user index match
                            if ($loginTcUsers[$lastTcUser->last_key] ==  $lastTcUser->tc_user) {

                                $currentTcUser = array(
                                    'id' =>  $loginTcUsers[$lastTcUser->last_key + 1],
                                    'last_key' =>  $lastTcUser->last_key + 1
                                );
                            } else {
                                if (isset($loginTcUsers[$lastTcUser->last_key])) {
                                    //$currentTcUser = $loginTcUsers[$lastTcUser->last_key];

                                    $currentTcUser = array(
                                        'id' =>  $loginTcUsers[$lastTcUser->last_key],
                                        'last_key' =>  $lastTcUser->last_key
                                    );
                                } else {
                                    $currentTcUser = array(
                                        'id' => $loginTcUsers[0],
                                        'last_key' => '0',
                                    );
                                }
                            }
                        } else {
                            $currentTcUser = array(
                                'id' => $loginTcUsers[0],
                                'last_key' => '0',
                            );
                        }
                    } else {
                        // last tc user is not login, request assign to next user
                        $currentTcUser = array(
                            'id' => $loginTcUsers[0],
                            'last_key' => '0',
                        );
                    }
                } else {
                    // no tc user exits
                    $currentTcUser = array(
                        'id' => $loginTcUsers[0],
                        'last_key' => '0',
                    );
                }
            }
        }
        return $currentTcUser;
    }
    /*********************************************
        Upload Document
        - If Agent create incident with without
          documents
     *********************************************/
    public function updateIncident($agentCode)
    {
        $agents = '';
        $incidents = array();
        $agentType = '1';
        //$agentCode = '';
        $AllCurrency = array();
        $agentType = '1';
        $getAgentCode = $agentCode;
        $agentCode = $agentCode;
        $currentDate = date('Y-m-d');

        //dd($currentDate);
        $agents = DB::table('agents')->where('agent_code', $agentCode)->first();
        $agent_type = 'agent';
        if (is_null($agents)) :
            $agents = DB::table('sub_agents')->where('agent_code', $agentCode)->first();
            $agent_type = 'sub_agent';
        endif;
        //dd($agents);
        //DB::enableQueryLog();
        $incidents = DB::table('incidents')
            ->where('inci_agent_code', $agentCode)
            ->where('inci_status', '=', '1')
            ->where('inci_show_hide_status', '!=', '2')
            ->where(function ($q) use ($currentDate) {
                $q->where('expiry_date', '>', $currentDate)
                    ->orWhere('expiry_date', NULL);
            })->get();
        //dd(DB::getQueryLog());
        //dd($incidents);
        $AllCurrency = DB::table('currency')->get();

        return view('thomasCook.updateincident', compact('agents', 'incidents', 'agentType', 'agentCode', 'AllCurrency', 'getAgentCode', 'agent_type'));
    }

    function addDays($timestamp, $days, $skipdays = array("Saturday", "Sunday"), $skipdates = array())
    {
        // $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday")
        // $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01");
        //timestamp is strtotime of ur $startDate
        $i = 1;
        // dd($skipdates);
        while ($days >= $i) {
            $timestamp = strtotime("+1 day", $timestamp);
            if ((in_array(date("l", $timestamp), $skipdays)) || (in_array(date("Y-m-d", $timestamp), $skipdates))) {
                $days++;
            }
            $i++;
        }

        //return $timestamp;
        return date("Y-m-d", $timestamp);
    }


    public function support()
    {
        return view('thomasCook.support');
    }

    public function upload_test(Request $request)
    {
        if ($request->isMethod('post')) {
            $passport = $request->file('passport');
            $milliseconds = round(microtime(true) * 1000);
            $namePassport = $passport->getClientOriginalName();
            $extPassport = $passport->getClientOriginalExtension();
            $actualPassportName = str_replace(" ", "_", $namePassport);
            $inci_number = rand(0, 9);

            //Need a static name for uploaded file
            $actualPassportName = "PASSPORT";
            //this is for upload folder
            echo $uploadFileNamePassport = $milliseconds . '_' . $request->agentKey . '_' . $inci_number . '_' . $actualPassportName . '.' . $extPassport;
            die;
        } else {
            return view('sample_upload');
        }
    }

    public function agentthankyou()
    {

        return view('agents-thankyou', ['incidentnumber' => 'James']);
    }
}
