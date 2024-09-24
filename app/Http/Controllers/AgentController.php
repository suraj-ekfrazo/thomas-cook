<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminIncidents\Entities\IncidentBuyDocuments;
use Modules\AdminIncidents\Entities\IncidentSellDocuments;
use Modules\AdminIncidents\Entities\IncidentUpdate;
use Modules\Agent\Entities\Agent;
use Modules\AdminIncidents\Entities\Incident;
use Illuminate\Support\Facades\DB;
use App\Models\CurrencyRate;
use App\User;
Use Log;
use App\Models\Incidents;
use Helper;


class AgentController extends Controller
{

    public function _construct()
    {
        $this->middleware('auth:agent');
    }

    public function index()
    {
        if (session()->get('agent_code')) {
            return redirect()->route('employee.dashboard');
        } else {
            return view('agent.auth.login');
        }
    }

    public function userCheck(Request $req)
    {
        $this->validate($req, [
            'agent_code' => 'required',
            'password' => 'required',
        ], [
            'agent_code.required' => 'The phone number must be required.',
            'password.required' => 'The password must be required.',
        ]);
        $getInfo = Agent::select('id', 'agent_code', 'password')->where('agent_code', '=', $req->agent_code)->first();
        if ($getInfo) {
            if (!Hash::check($req->password, $getInfo["password"])) {
                return json_encode(array("msg" => "invalid"));
            } else {
                if ($getInfo['agent_code'] == $req->agent_code) {
                    session()->put('agent_id', $getInfo['id']);
                    session()->put('agent_code', $getInfo['agent_code']);
                    return json_encode(array("msg" => "redirect"));
                }
            }
        } else {
            return json_encode(array("msg" => "invalid"));
        }
    }

    public function userDashboard()
    {
        $agent_id =  Auth::user()->id;
        $AgentData = Agent::find(Auth::id());

        //tab 3
        $AgentIncidentDetail = Incident::with('incidentCurrency')->where('agent_id', $agent_id)
            ->where('doc_type', 1)->orderBy('id', 'DESC')->get();
        //tab 2
        $AgentWithoutDocIncident = Incident::with('incidentCurrency')->where([
            'agent_id' => $agent_id,
            'doc_type' => 0,
            'inci_buy_sell_req' => 1
        ])->orderBy('id', 'DESC')->get();
        //Log::info($AgentWithoutDocIncident);

        // $AgentIncidentDetail = DB::table('incidents')->where('agent_id', $agent_id)
        //     ->join('incident_currency', 'incidents.inci_number', '=', 'incident_currency.incident_id')
        //     ->orderBy('incidents.id', 'DESC')->get();

        // $AgentDeclinedIncident = DB::table('incidents')->where([
        //     'agent_id' => $agent_id,
        //     'inci_assign_status' => 2
        // ])
        //     ->join('incident_currency', 'incidents.inci_number', '=', 'incident_currency.incident_id')
        //     ->orderBy('incidents.id', 'DESC')->get();

        $currencydata = CurrencyRate::get();
        $data['currencydata'] = $currencydata;

        foreach ($currencydata as $key => $value) {
            $currency_name = str_replace("/INR", "", $value->currency_name_key);
            $currencydata[$key]['rate_margin'] = DB::table('rate_margin')->where("currency_name", $currency_name)->first();
        }

        return view('agents-dashboard', compact('AgentIncidentDetail', 'AgentWithoutDocIncident', 'currencydata', 'currencydata', 'AgentData'));
        //return view('agents-dashboard')->with('AgentIncidentDetail',$AgentDeclinedIncident);
        // return view('welcome-agent');
    }

    /*public function userProfile()
    {
        $AgentData = Agent::find(Auth::id());
        return view('agents.profile', compact('AgentData'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'same:confirm_password',
            'user_profile' => 'file|mimes:jpg,png,jpeg|max:2048'
        ]);
        $input = $request->all();
        $employee = Agent::find(Auth::id());
        if ($request->user_profile != '') {
            $input['user_profile'] = $employee->code . '_' . $employee->name . '_' . time() . '.' . $request->user_profile->extension();
            $request->user_profile->move(public_path('users/agent/profile/'), $input['user_profile']);
            $filePath = public_path('users/agent/profile/' . $employee->profile);
            try {
                File::delete($filePath);
            } catch (\Throwable $th) {
                //throw $th;
            }
        } else {
            $input['user_profile'] = $employee->profile;
        }
        if (!empty($request->new_password)) {
            $input['new_password'] = Hash::make($request->new_password);
        } else {
            $input['new_password'] = $employee->password;
        }
        $input['profile'] = $input['user_profile'];
        $input['password'] = $input['new_password'];
        $employee->update($input);
        if ($employee) {
            Auth::login($employee);
            return response()->json(['success' => 'User detail updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something went Wrong!'], 400);
        }
    }*/

    public function userProfile()
    {

        $AgentData = Agent::find(Auth::id());
        $currencydata = CurrencyRate::get();
        $data['currencydata'] = $currencydata;

        foreach ($currencydata as $key => $value) {
            $currency_name = str_replace("/INR", "", $value->currency_name_key);
            $currencydata[$key]['rate_margin'] = DB::table('rate_margin')->where("currency_name", $currency_name)->first();
        }
        //print_r($AgentData); exit;
        return view('agent.profile', compact('AgentData','currencydata'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'mobileNumber' => 'required'

        ]);
        $input = $request->all();
        $employee = Agent::find(Auth::id());
        /*if ($request->user_profile != '') {
            $input['user_profile'] = $employee->code . '_' . $employee->name . '_' . time() . '.' . $request->user_profile->extension();
            $request->user_profile->move(public_path('users/agent/profile/'), $input['user_profile']);
            $filePath = public_path('users/agent/profile/' . $employee->profile);
            try {
                File::delete($filePath);
            } catch (\Throwable $th) {
                //throw $th;
            }
        } else {
            $input['user_profile'] = $employee->profile;
        }*/
        if (!empty($request->password)) {
            $input['new_password'] = Hash::make($request->password);
        } else {
            $input['new_password'] = $employee->password;
        }
        //$input['profile'] = $input['user_profile'];
        $input['password'] = $input['new_password'];
        $input['first_name'] = $input['firstName'];
        $input['last_name'] = $input['lastName'];
        $input['user_mobile'] = $input['mobileNumber'];
        $employee->update($input);
        if ($employee) {
            Auth::login($employee);
            return response()->json(['success' =>'True', 'msg'=>'User detail updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something went Wrong!'], 400);
        }
    }

    public function viewUploadDocumentModal(Request $request)
    {
        $inci_id = $request->inci_id;
        $agentdata = Incident::with('agent')->where('inci_number', $inci_id)->first();
        $agentcode = $agentdata->agent->agent_code;
        $travel_type = $agentdata->travel_type;
        $passport_no = $agentdata->inci_passport_number;
        $created_at = $agentdata->created_at;
        return view("agent.upload-doc", compact('inci_id', 'agentcode', 'agentdata', 'travel_type', 'passport_no'))->render();
    }

    public function uploadDocument(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $inci_number = $request->inci_id;

        
        $passport_number = $request->passport_number;
        $agent_code = $request->agent_code;
        $customerArray['incident_number'] = $inci_number;
        $customerArray['inci_up_agent_code'] = $agent_code;
        $todayDate = $request->upload_date;
        $documentPath = public_path() . '/allDocuments/' . $todayDate . '/' . $inci_number . '/';
        if ((strtotime(date('H:i:s')) > strtotime('10:00:00') && strtotime(date('H:i:s')) < strtotime('23:50:00')))
        {
            //passport
            if (!empty($request->file('passport'))) {
                $passport = $request->file('passport');
                $extPassport = $passport->getClientOriginalExtension();
                $actualPassportName = "PASSPORT";

                $uploadFileNamePassport = $agent_code . '_' .  $inci_number . '_' . $actualPassportName . '.' . $extPassport;
                $passport->move($documentPath, $uploadFileNamePassport);
                $customerArray['passport'] = $uploadFileNamePassport;
                $customerArray['passport_status'] = 3;
            }

            /*Customer Visa Upload*/
            if (!empty($request->file('visa'))) {
                $visa = $request->file('visa');
                $extVisa = $visa->getClientOriginalExtension();
                $actualNameVisa = "VISA";
                $uploadFileNameVisa = $agent_code . '_' . $inci_number . '_' . $actualNameVisa . '.' . $extVisa;
                //this is for database
                $visa->move($documentPath, $uploadFileNameVisa);
                $customerArray['visa'] = $uploadFileNameVisa;
                $customerArray['visa_status'] = 3;
                /*End Customer Visa Upload*/
            }
            //Ticket
            if (!empty($request->file('ticket'))) {
                $ticket = $request->file('ticket');
                $extTicket = $ticket->getClientOriginalExtension();
                $actualNameTicket = "TICKET";
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
                $extPan = $pan->getClientOriginalExtension();
                $actualNamePan = "PAN";
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

                $extApplication = $application->getClientOriginalExtension();
                $actualNameApplication = 'RELOAD_FORMS';

                //this is for upload folder
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
                $extAnnexure = $annexure->getClientOriginalExtension();
                $actualNamenameAnnexure = 'Annexure';
                //this is for upload folder
                $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
                //this is for database
                $annexure->move($documentPath, $uploadFileNamenameAnnexure);
                $customerArray['annex'] = $uploadFileNamenameAnnexure;
                $customerArray['annex_status'] = 3;
                /*End Customer Annexure Upload*/
            }

            /*Customer Annexure Upload*/
            if (!empty($request->file('banktransfer'))) {
                $bankTransfer = $request->file('banktransfer');
                $extbankTransfer = $bankTransfer->getClientOriginalExtension();
                $actualNameBankTransfer = 'bank_transfer';
                //this is for upload folder
                $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameBankTransfer . '.' . $extbankTransfer;
                //this is for database
                $bankTransfer->move($documentPath, $uploadFileNameBankTransfer);
                $customerArray['bank_transfer'] = $uploadFileNameBankTransfer;
                $customerArray['bank_transfer_status'] = 3;
                /*End Customer Annexure Upload*/
            }

            /*Customer businessLetter Upload*/
            if (!empty($request->file('sof'))) {
                $businessLetter = $request->file('sof');
                $extBusinessLetter = $businessLetter->getClientOriginalExtension();
                $actualNameBusinessLetter = 'SOF';
                //this is for upload folder
                $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameBusinessLetter . '.' . $extBusinessLetter;
                //this is for database
                $businessLetter->move($documentPath, $uploadFileNameBankTransfer);
                $customerArray['sof'] = $uploadFileNameBankTransfer;
                $customerArray['sof_status'] = 3;
                /*End Customer businessLetter Upload*/
            }

            /*Customer other Upload*/
            if (!empty($request->file('other'))) {

                $other = $request->file('other');
                $extOther = $other->getClientOriginalExtension();
                $actualNameOther = 'Other';
                //this is for upload folder
                $uploadFileNameOther = $agent_code . '_' . $inci_number . '_' . $actualNameOther . '.' . $extOther;
                //this is for database
                $other->move($documentPath, $uploadFileNameOther);
                $customerArray['other'] = $uploadFileNameOther;
                $customerArray['other_status'] = 3;
                /*End Customer other Upload*/
            }
            /*Customer Lerms Letter Upload*/
            if (!empty($request->file('lerms_letter'))) {
                $lerms_letter = $request->file('lerms_letter');
                $extlermsletter = $lerms_letter->getClientOriginalExtension();
                $actualNamelermsletter = "Lerms_Letter";
                //this is for upload folder
                $uploadFileNamelermsletter = $agent_code . '_' . $inci_number . '_' . $actualNamelermsletter . '.' . $extlermsletter;
                //this is for database
                $lerms_letter->move($documentPath, $uploadFileNamelermsletter);
                $customerArray['lerms_letter'] = $uploadFileNamelermsletter;
                $customerArray['lerms_letter_status'] = 3;
                /*End Customer Lerms Letter Upload*/
            }

            /*Customer university Letter Upload*/
            if (!empty($request->file('university_letter'))) {
                $university_letter = $request->file('university_letter');
                $extuniversityletter = $university_letter->getClientOriginalExtension();
                $actualNameuniversityletter = "university_letter";
                //this is for upload folder
                $uploadFileNameuniversityletter = $agent_code . '_' . $inci_number . '_' . $actualNameuniversityletter . '.' . $extuniversityletter;
                //this is for database
                $university_letter->move($documentPath, $uploadFileNameuniversityletter);
                $customerArray['university_letter'] = $uploadFileNameuniversityletter;
                $customerArray['university_letter_status'] = 3;
                /*End Customer university Letter Upload*/
            }

            if (!empty($request->file('employment_letter'))) {
                $employment_letter = $request->file('employment_letter');
                $extemploymentletter = $employment_letter->getClientOriginalExtension();
                $actualNameemploymentletter = "employment_letter";
                //this is for upload folder
                $uploadFileNameemploymentletter = $agent_code . '_' . $inci_number . '_' . $actualNameemploymentletter . '.' . $extemploymentletter;
                //this is for database
                $employment_letter->move($documentPath, $uploadFileNameemploymentletter);
                $customerArray['employment_letter'] = $uploadFileNameemploymentletter;
                $customerArray['emp_letter_status'] = 3;
                /*End Customer employment Letter Upload*/
            }

            /*Customer employment Declaration form Upload*/
            if (!empty($request->file('emp_declaration_form'))) {
                $emp_declaration_form = $request->file('emp_declaration_form');
                $extempdeclarationform = $emp_declaration_form->getClientOriginalExtension();
                $actualNameempdeclarationform = "emp_declaration_form";
                //this is for upload folder
                $uploadFileNameempdeclarationform = $agent_code . '_' . $inci_number . '_' . $actualNameempdeclarationform . '.' . $extempdeclarationform;
                //this is for database
                $emp_declaration_form->move($documentPath, $uploadFileNameempdeclarationform);
                $customerArray['emp_declaration_form'] = $uploadFileNameempdeclarationform;
                $customerArray['emp_declaration_form_status'] = 3;
                /*End Customer employment Declaration form Upload*/
            }

            /*Customer immigration Declaration form Upload*/
            if (!empty($request->file('immigration_d_form'))) {
                $immigration_d_form = $request->file('immigration_d_form');
                $extimmigrationdform = $immigration_d_form->getClientOriginalExtension();
                $actualNameimmigrationdform = "Immigration_d_Form";
                //this is for upload folder
                $uploadFileNameimmigrationdform = $agent_code . '_' . $inci_number . '_' . $actualNameimmigrationdform . '.' . $extimmigrationdform;
                //this is for database
                $immigration_d_form->move($documentPath, $uploadFileNameimmigrationdform);
                $customerArray['immigration_d_form'] = $uploadFileNameimmigrationdform;
                $customerArray['immigration_d_form_status'] = 3;
                /*End Customer immigration Declaration form Upload*/
            }

            /*Customer Medical Letter form Upload*/
            if (!empty($request->file('medical_letter'))) {
                $medical_letter = $request->file('medical_letter');
                $extmedicalletter = $medical_letter->getClientOriginalExtension();
                $actualNamemedicalletter = "medical_letter";
                //this is for upload folder
                $uploadFileNamemedicalletter = $agent_code . '_' . $inci_number . '_' . $actualNamemedicalletter . '.' . $extmedicalletter;
                //this is for database
                $medical_letter->move($documentPath, $uploadFileNamemedicalletter);
                $customerArray['medical_letter'] = $uploadFileNamemedicalletter;
                $customerArray['medical_letter_status'] = 3;
                /*End Customer Medical Letter form Upload*/
            }
            $incidentInsert = DB::table('incident_sell_documents')->insert($customerArray);
            $docdata = DB::table('incidents')->select('travel_type')->where('inci_number', $inci_number)->first();
            //print_r($docdata->travel_type);exit;
            $annexure = isset($customerArray['annex']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['annex']) : "";
            $passport = isset($customerArray['passport']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['passport']) : "";
            $pan = isset($customerArray['pan_card']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['pan_card']) : "";
            $ticket = isset($customerArray['ticket']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['ticket']) : "";
            $visa = isset($customerArray['visa']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['visa']) : "";
            $application = isset($customerArray['apply']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['apply']) : "";
            $sof = isset($customerArray['sof']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['sof']) : "";
            $bank_transfer = isset($customerArray['bank_transfer']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['bank_transfer']) : "";

            $lerms_letter = isset($customerArray['lerms_letter']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['lerms_letter']) : "";
            $university_letter = isset($customerArray['university_letter']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['university_letter']) : "";
            $employment_letter = isset($customerArray['employment_letter']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['employment_letter']) : "";
            $emp_declaration_form = isset($customerArray['emp_declaration_form']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['emp_declaration_form']) : "";
            $immigration_d_form = isset($customerArray['immigration_d_form']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['immigration_d_form']) : "";
            $medical_letter = isset($customerArray['medical_letter']) ? url("allDocuments/" . $todayDate . "/" . $inci_number . "/" . $customerArray['medical_letter']) : "";
            //echo $annexure."<br/>".$passport."<br/>".$pan."<br/>".$ticket."<br/>".$visa."<br/>".$application."<br/>".$sof."<br/>".$bank_transfer;

            //$data1 = array('issue_id' => $inci_number, 'annexure' => $annexure, 'passport' => $passport, 'pan' => $pan, 'ticket' => $ticket, 'visa' => $visa, 'application' => $application, 'sof' => $sof, 'bank_transfer' => $bank_transfer,  'lerms_letter' => $lerms_letter, 'university_letter' => $university_letter, 'employment_letter' => $employment_letter, 'emp_declaration_form' => $emp_declaration_form, 'immigration_d_form' => $immigration_d_form, 'medical_letter' => $medical_letter);
            if($docdata->travel_type==1) {
                $data1 = array('issue_id' => $inci_number, 'annexure' => $annexure, 'passport' => $passport, 'pan' => $pan, 'ticket' => $ticket, 'visa' => $visa, 'application' => $application, 'sof' => $sof, 'bank_transfer' => $bank_transfer, 'lerms_letter' => $lerms_letter, 'university_letter' => $university_letter, 'employment_letter' => $employment_letter, 'emp_declaration_form' => $emp_declaration_form, 'immigration_d_form' => $immigration_d_form, 'medical_letter' => $medical_letter);
            }
            elseif ($docdata->travel_type==2){
                $data1 = array('issue_id' => $inci_number, 'annexure' => $annexure, 'passport' => $passport, 'pan' => $pan, 'bt' => $lerms_letter);
            }
            else{
                $data1 = array('issue_id' => $inci_number, 'annexure' => $annexure, 'passport' => $passport, 'pan' => $pan, 'ticket' => $ticket, 'visa' => $visa, 'application' => $application, 'sof' => $sof, 'bank_transfer' => $bank_transfer, 'lerms_letter' => $lerms_letter, 'university_letter' => $university_letter, 'employment_letter' => $employment_letter, 'emp_declaration_form' => $emp_declaration_form, 'immigration_d_form' => $immigration_d_form, 'medical_letter' => $medical_letter);
            }
            Log::info(json_encode($data1));
            /* $curl = curl_init();

                 curl_setopt_array($curl, array(
                     CURLOPT_URL => 'http://44.200.48.161:8000/uploadfiles',
                     CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_ENCODING => '',
                     CURLOPT_MAXREDIRS => 10,
                     CURLOPT_TIMEOUT => 0,
                     CURLOPT_FOLLOWLOCATION => true,
                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                     CURLOPT_CUSTOMREQUEST => 'POST',
                     CURLOPT_POSTFIELDS =>  json_encode($data1),
                     CURLOPT_HTTPHEADER => array(
                         'Content-Type: application/json'
                     )
                 ));
                 $response = curl_exec($curl);
             Log::info($response);
                 curl_close($curl);*/
            DB::table('incidents')
                ->where('inci_number', $inci_number)
                ->update(array('inci_passport_number'=>$passport_number,'upload_doc_comment'=>$request->upload_doc_comment,'inci_recived_date'=>date('Y-m-d'),'doc_temp_type'=>1,'inci_recived_time'=>date('H:i:s'),'updated_at' => null));
            //get random tcuser
            // $randomUser = DB::table('users')->inRandomOrder()->first();
            $randomUser = User::with('roles')->role('Tc user')->where('id', '!=', env('TC_USER_ID'))->where('status','1')->where('login_status','1')->whereRaw("find_in_set('1',tc_type)")->inRandomOrder()->first();
            if ($incidentInsert) {
                /*if ($incidentInsert) {
                    Incident::where('inci_number', $inci_number)->update(['doc_type' => 1, 'inci_assignto' => $randomUser->id,'inci_recived_date'=>date('Y-m-d'),'inci_recived_time'=>date('H:i:s'),'updated_at' => null]);
                    return response()->json(['success'=>'True','errMessage'=>'']);
                }*/
                if($randomUser)
                {
                    Incident::where('inci_number', $inci_number)->update(['doc_type' => 1, 'inci_assignto' => $randomUser->id,'inci_recived_date'=>date('Y-m-d'),'inci_recived_time'=>date('H:i:s'),'updated_at' => null]);
                    return response()->json(['success'=>'True','errMessage'=>'']);
                }
                else{
                    Incident::where('inci_number', $inci_number)->update(['doc_type' => 1, 'inci_assignto' => "", "inci_assign_status" => 0, 'inci_recived_date'=>date('Y-m-d'),'inci_recived_time'=>date('H:i:s'),'updated_at' => null]);
                    return response()->json(['success'=>'True','errMessage'=>'']);
                }
            }
        }
        else{
            return response()->json(['success'=>'False','errMessage'=>'You can upload document between 10:00 AM to 11:50 PM Only!']);
        }
    }

    //View Rejected Doc Model
    public function viewRejectedUploadDocumentModal(Request $request)
    {
        $inci_id = $request->inci_id;
        $agentdata = Incident::with('agent')->where('inci_number', $inci_id)->first();
        if($agentdata['inci_buy_sell_req']==0){
            //Buy
            $selldata = DB::table('incident_buy_documents')->where('incident_number', $inci_id)->orderBy('id','DESC')->first();
        }
        else{
            //sell
            $selldata = DB::table('incident_sell_documents')->where('incident_number', $inci_id)->orderBy('id','DESC')->first();
        }
        //print_r($selldata); exit;
        $agentcode = $agentdata->agent->agent_code;
        $travel_type = $agentdata->travel_type;
        $created_at = $agentdata->created_at;

        return view("agent.upload-rejected-doc", compact('inci_id', 'agentcode', 'agentdata', 'travel_type', 'selldata'))->render();
    }

    //Upload Rejected Doc
    public function uploadRejectedDocument(Request $request)
    {

        date_default_timezone_set('Asia/Kolkata');
        $customerArray = array();
        $inci_number = $request->inci_id;
        $agent_code = $request->agent_code;
        $upload_date = $request->upload_date;
        $incident_buy_sell = Incidents::select('inci_buy_sell_req')->where('inci_number',$inci_number)->first();
        //$customerArray['incident_number'] = $inci_number;
        // $customerArray['inci_up_agent_code'] = $agent_code;
        //$todayDate = date('Y-m-d');
        $documentPath = public_path() . '/allDocuments/' . $upload_date . '/' . $inci_number . '/';
        //passport
        if (!empty($request->file('passport'))) {
            $passport = $request->file('passport');
            $extPassport = $passport->getClientOriginalExtension();
            $actualPassportName = "PASSPORT1";

            $uploadFileNamePassport = $agent_code . '_' .  $inci_number . '_' . $actualPassportName . '.' . $extPassport;

            if(file_exists($documentPath.$uploadFileNamePassport)){
                $uploadFileNamePassport = $agent_code . '_' .  $inci_number . '_' . $actualPassportName . '_' . date('dmYHis'). '.' . $extPassport;
                //unlink(public_path($documentPath.$uploadFileNamePassport));
            }
            $passport->move($documentPath, $uploadFileNamePassport);
            $customerArray['passport'] = $uploadFileNamePassport;
            $customerArray['passport_status'] = 3;
        }

        /*Customer Visa Upload*/
        if (!empty($request->file('visa'))) {
            $visa = $request->file('visa');
            $extVisa = $visa->getClientOriginalExtension();
            $actualNameVisa = "VISA1";
            $uploadFileNameVisa = $agent_code . '_' . $inci_number . '_' . $actualNameVisa . '.' . $extVisa;
            //this is for database

            if(file_exists($documentPath.$uploadFileNameVisa)){
                $uploadFileNameVisa = $agent_code . '_' .  $inci_number . '_' . $actualNameVisa . '_' . date('dmYHis'). '.' . $extVisa;
                //unlink(public_path($documentPath.$uploadFileNamePassport));
            }

            $visa->move($documentPath, $uploadFileNameVisa);
            $customerArray['visa'] = $uploadFileNameVisa;
            $customerArray['visa_status'] = 3;
            /*End Customer Visa Upload*/
        }
        //Ticket
        if (!empty($request->file('ticket'))) {
            $ticket = $request->file('ticket');
            $extTicket = $ticket->getClientOriginalExtension();
            $actualNameTicket = "TICKET1";
            $uploadFileNameTicket = $agent_code . '_' . $inci_number . '_' . $actualNameTicket . '.' . $extTicket;
            //this is for database
            if(file_exists($documentPath.$uploadFileNameTicket)){
                $uploadFileNameTicket = $agent_code . '_' .  $inci_number . '_' . $actualNameTicket . '_' . date('dmYHis'). '.' . $extTicket;
                //unlink(public_path($documentPath.$uploadFileNamePassport));
            }
            $ticket->move($documentPath, $uploadFileNameTicket);
            $customerArray['ticket'] = $uploadFileNameTicket;
            $customerArray['ticket_status'] = 3;
            /*End Customer ticket Upload*/
        }

        /*Customer pan Upload*/
        if (!empty($request->file('pan'))) {
            $pan = $request->file('pan');
            $extPan = $pan->getClientOriginalExtension();
            $actualNamePan = "PAN1";
            $uploadFileNamePan = $agent_code . '_' . $inci_number . '_' . $actualNamePan . '.' . $extPan;
            //this is for database
            if(file_exists($documentPath.$uploadFileNamePan)){
                $uploadFileNamePan = $agent_code . '_' . $inci_number . '_' . $actualNamePan . '_' . date('dmYHis'). '.' . $extPan;
            }
            $pan->move($documentPath, $uploadFileNamePan);
            $customerArray['pan_card'] = $uploadFileNamePan;
            $customerArray['pan_card_status'] = 3;

            /*End Customer pan Upload*/
        }

        /*Customer application Upload*/
        if (!empty($request->file('application'))) {
            $application = $request->file('application');
            $extApplication = $application->getClientOriginalExtension();
            $actualNameApplication = 'RELOAD_FORMS1';

            //this is for upload folder
            $uploadFileNameApplication = $agent_code . '_' . $inci_number . '_' . $actualNameApplication . '.' . $extApplication;
            //this is for database
            if(file_exists($documentPath.$uploadFileNameApplication)){
                $uploadFileNameApplication = $agent_code . '_' . $inci_number . '_' . $actualNameApplication . '_' . date('dmYHis') . '.' . $extApplication;
            }
            $application->move($documentPath, $uploadFileNameApplication);
            $customerArray['apply'] = $uploadFileNameApplication;
            $customerArray['apply_status'] = 3;

            /*End Customer application Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('annexure'))) {
            $annexure = $request->file('annexure');
            $extAnnexure = $annexure->getClientOriginalExtension();
            $actualNamenameAnnexure = 'Annexure1';
            //this is for upload folder
            $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '.' . $extAnnexure;
            //this is for database
            if(file_exists($documentPath.$uploadFileNamenameAnnexure)){
                $uploadFileNamenameAnnexure = $agent_code . '_' . $inci_number . '_' . $actualNamenameAnnexure . '_' . date('dmYHis') . '.' . $extAnnexure;
            }
            $annexure->move($documentPath, $uploadFileNamenameAnnexure);
            $customerArray['annex'] = $uploadFileNamenameAnnexure;
            $customerArray['annex_status'] = 3;
            /*End Customer Annexure Upload*/
        }

        /*Customer Annexure Upload*/
        if (!empty($request->file('banktransfer'))) {
            $bankTransfer = $request->file('banktransfer');
            $extbankTransfer = $bankTransfer->getClientOriginalExtension();
            $actualNameBankTransfer = 'bank_transfer1';
            //this is for upload folder
            $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameBankTransfer . '.' . $extbankTransfer;
            //this is for database
            if(file_exists($documentPath.$uploadFileNameBankTransfer)){
                $uploadFileNameBankTransfer = $agent_code . '_' . $inci_number . '_' . $actualNameBankTransfer . '_' . date('dmYHis') . '.' . $extbankTransfer;
            }
            $bankTransfer->move($documentPath, $uploadFileNameBankTransfer);
            $customerArray['bank_transfer'] = $uploadFileNameBankTransfer;
            $customerArray['bank_transfer_status'] = 3;
            /*End Customer Annexure Upload*/
        }

        /*Customer businessLetter Upload*/
        if (!empty($request->file('sof'))) {
            $businessLetter = $request->file('sof');
            $extBusinessLetter = $businessLetter->getClientOriginalExtension();
            $actualNameBusinessLetter = 'SOF1';
            //this is for upload folder
            $uploadFileNamesof = $agent_code . '_' . $inci_number . '_' . $actualNameBusinessLetter . '.' . $extBusinessLetter;
            //this is for database
            if(file_exists($documentPath.$uploadFileNamesof)){
                $uploadFileNamesof = $agent_code . '_' . $inci_number . '_' . $actualNameBusinessLetter . '_' . date('dmYHis') . '.' . $extBusinessLetter;
            }
            $businessLetter->move($documentPath, $uploadFileNamesof);
            $customerArray['sof'] = $uploadFileNamesof;
            $customerArray['sof_status'] = 3;

            /*End Customer businessLetter Upload*/
        }

        /*Customer Lerms Letter Upload*/
        if (!empty($request->file('lerms_letter'))) {
            $lerms_letter = $request->file('lerms_letter');
            $extlermsletter = $lerms_letter->getClientOriginalExtension();
            $actualNamelermsletter = "Lerms_Letter1";
            //this is for upload folder
            $uploadFileNamelermsletter = $agent_code . '_' . $inci_number . '_' . $actualNamelermsletter . '.' . $extlermsletter;
            //this is for database
            if(file_exists($documentPath.$uploadFileNamelermsletter)){
                $uploadFileNamelermsletter = $agent_code . '_' . $inci_number . '_' . $actualNamelermsletter . '_' . date('dmYHis') . '.' . $extlermsletter;
            }
            $lerms_letter->move($documentPath, $uploadFileNamelermsletter);
            $customerArray['lerms_letter'] = $uploadFileNamelermsletter;
            $customerArray['lerms_letter_status'] = 3;
            /*End Customer Lerms Letter Upload*/
        }

        /*Customer university Letter Upload*/
        if (!empty($request->file('university_letter'))) {
            $university_letter = $request->file('university_letter');
            $extuniversityletter = $university_letter->getClientOriginalExtension();
            $actualNameuniversityletter = "university_letter1";
            //this is for upload folder
            $uploadFileNameuniversityletter = $agent_code . '_' . $inci_number . '_' . $actualNameuniversityletter . '.' . $extuniversityletter;
            //this is for database
            if(file_exists($documentPath.$uploadFileNameuniversityletter)){
                $uploadFileNameuniversityletter = $agent_code . '_' . $inci_number . '_' . $actualNameuniversityletter . '_' . date('dmYHis') . '.' . $extuniversityletter;
            }
            $university_letter->move($documentPath, $uploadFileNameuniversityletter);
            $customerArray['university_letter'] = $uploadFileNameuniversityletter;
            $customerArray['university_letter_status'] = 3;

            /*End Customer university Letter Upload*/
        }

        /*Customer employment Letter Upload*/
        if (!empty($request->file('employment_letter'))) {
            $employment_letter = $request->file('employment_letter');
            $extemploymentletter = $employment_letter->getClientOriginalExtension();
            $actualNameemploymentletter = "employment_letter1";
            //this is for upload folder
            $uploadFileNameemploymentletter = $agent_code . '_' . $inci_number . '_' . $actualNameemploymentletter . '.' . $extemploymentletter;
            //this is for database
            if(file_exists($documentPath.$uploadFileNameemploymentletter)){
                $uploadFileNameemploymentletter = $agent_code . '_' . $inci_number . '_' . $actualNameemploymentletter . '_' . date('dmYHis') . '.' . $extemploymentletter;
            }
            $employment_letter->move($documentPath, $uploadFileNameemploymentletter);
            $customerArray['employment_letter'] = $uploadFileNameemploymentletter;
            $customerArray['emp_letter_status'] = 3;

            /*End Customer employment Letter Upload*/
        }

        /*Customer employment Declaration form Upload*/
        if (!empty($request->file('emp_declaration_form'))) {
            $emp_declaration_form = $request->file('emp_declaration_form');
            $extempdeclarationform = $emp_declaration_form->getClientOriginalExtension();
            $actualNameempdeclarationform = "emp_declaration_form1";
            //this is for upload folder
            $uploadFileNameempdeclarationform = $agent_code . '_' . $inci_number . '_' . $actualNameempdeclarationform . '.' . $extempdeclarationform;
            //this is for database
            if(file_exists($documentPath.$uploadFileNameempdeclarationform)){
                $uploadFileNameempdeclarationform = $agent_code . '_' . $inci_number . '_' . $actualNameempdeclarationform . '_' . date('dmYHis') . '.' . $extempdeclarationform;
            }
            $emp_declaration_form->move($documentPath, $uploadFileNameempdeclarationform);
            $customerArray['emp_declaration_form'] = $uploadFileNameempdeclarationform;
            $customerArray['emp_declaration_form_status'] = 3;
            /*End Customer employment Declaration form Upload*/
        }

        /*Customer immigration Declaration form Upload*/
        if (!empty($request->file('immigration_d_form'))) {
            $immigration_d_form = $request->file('immigration_d_form');
            $extimmigrationdform = $immigration_d_form->getClientOriginalExtension();
            $actualNameimmigrationdform = "Immigration_d_Form1";
            //this is for upload folder
            $uploadFileNameimmigrationdform = $agent_code . '_' . $inci_number . '_' . $actualNameimmigrationdform . '.' . $extimmigrationdform;
            //this is for database
            if(file_exists($documentPath.$uploadFileNameempdeclarationform)){
                $uploadFileNameimmigrationdform = $agent_code . '_' . $inci_number . '_' . $actualNameimmigrationdform . '_' . date('dmYHis') . '.' . $extimmigrationdform;
            }
            $immigration_d_form->move($documentPath, $uploadFileNameimmigrationdform);
            $customerArray['immigration_d_form'] = $uploadFileNameimmigrationdform;
            $customerArray['immigration_d_form_status'] = 3;

            /*End Customer immigration Declaration form Upload*/
        }

        /*Customer Medical Letter form Upload*/
        if (!empty($request->file('medical_letter'))) {
            $medical_letter = $request->file('medical_letter');
            $extmedicalletter = $medical_letter->getClientOriginalExtension();
            $actualNamemedicalletter = "medical_letter1";
            //this is for upload folder
            $uploadFileNamemedicalletter = $agent_code . '_' . $inci_number . '_' . $actualNamemedicalletter . '.' . $extmedicalletter;
            //this is for database
            if(file_exists($documentPath.$uploadFileNamemedicalletter)){
                $uploadFileNamemedicalletter = $agent_code . '_' . $inci_number . '_' . $actualNamemedicalletter . '_' . date('dmYHis') . '.' . $extmedicalletter;
            }
            $medical_letter->move($documentPath, $uploadFileNamemedicalletter);
            $customerArray['medical_letter'] = $uploadFileNamemedicalletter;
            $customerArray['medical_letter_status'] = 3;
            /*End Customer Medical Letter form Upload*/
        }

        /*other form Upload*/
        if (!empty($request->file('other'))) {

            $other = $request->file('other');
            $extother = $other->getClientOriginalExtension();
            $actualother = "other1";
            //this is for upload folder
            $uploadFileNameother = $agent_code . '_' . $inci_number . '_' . $actualother. '.' . $extother ;
            //this is for database
            if(file_exists($documentPath.$uploadFileNameother)){
                $uploadFileNameother = $agent_code . '_' . $inci_number . '_' . $actualother. '_' . date('dmYHis') . '.' . $extother ;
            }
            $other->move($documentPath, $uploadFileNameother);
            $customerArray['other'] = $uploadFileNameother;
            $customerArray['other_status'] = 3;

            /*End Customer Medical Letter form Upload*/
        }

        /*surrender_letter2 Upload*/
        if (!empty($request->file('surrender_letter'))) {
            $surrender_letter = $request->file('surrender_letter');
            $extsurrenderletter = $surrender_letter->getClientOriginalExtension();
            $actualNamesurrender = "surrender_letter1";
            //this is for upload folder
            $uploadFileNamesurrenderletter = $agent_code . '_' . $inci_number . '_' . $actualNamesurrender . '.' . $extsurrenderletter;
            //this is for database
            if(file_exists($documentPath.$uploadFileNamesurrenderletter)){
                $uploadFileNamesurrenderletter = $agent_code . '_' . $inci_number . '_' . $actualNamesurrender . '_' . date('dmYHis') . '.' . $extsurrenderletter;
            }
            $surrender_letter->move($documentPath, $uploadFileNamesurrenderletter);
            $customerArray['surrender_letter'] = $uploadFileNamesurrenderletter;
            $customerArray['surrender_letter_status'] = 3;
            /*End Customer surrender_letter2 Upload*/
        }

        /*refound2 Upload*/
        if (!empty($request->file('refound'))) {
            $refound = $request->file('refound');
            $extrefound = $refound->getClientOriginalExtension();
            $actualNamerefound = "refound1";
            //this is for upload folder
            $uploadFileNamerefound = $agent_code . '_' . $inci_number . '_' . $actualNamerefound . '.' . $extrefound;
            //this is for database
            if(file_exists($documentPath.$uploadFileNamerefound)){
                $uploadFileNamerefound = $agent_code . '_' . $inci_number . '_' . $actualNamerefound . '_' . date('dmYHis') . '.' . $extrefound;
            }
            $refound->move($documentPath, $uploadFileNamerefound);
            $customerArray['refound'] = $uploadFileNamerefound;
            $customerArray['refound_status'] = 3;
            /*End Customer refound2 Upload*/
        }


        if($incident_buy_sell['inci_buy_sell_req']==0){
            //Buy
            $updateSellIncident = DB::table('incident_buy_documents')->where(['incident_number' => $inci_number])->update($customerArray);
            //$randomUser = User::where('id', '74')->first();
            Incident::where('inci_number', $inci_number)->update(['inci_status' => 3, 'inci_assignto' => '74', 'reinitialize_status' => 1,'inci_recived_date'=>date('Y-m-d'),'inci_recived_time'=>date('H:i:s'),'updated_at' => null]);
            return response()->json('success');
        }
        else{

            //Sell

            Log::info($customerArray);
            if(count($customerArray)>0){
                //$customerArray['apply']=$customerArray['apply'] . "123456s";
                $updateSellIncident = DB::table('incident_sell_documents')->where(['incident_number' => $inci_number])->update($customerArray);
                //print_r($updateSellIncident); exit;

            }

            $incidentdata=Incident::with('agent')->where('inci_number',$inci_number)->get()->toArray();
	//print_r($incidentdata[0]['agent']['email']); exit;

            $randomUser = User::with('roles')->role('Tc user')->where('id', '!=', env('TC_USER_ID'))->where('status','1')->where('login_status','1')->inRandomOrder()->first();
            if($randomUser)
            {
                Incident::where('inci_number', $inci_number)->update(['inci_status' => 3, 'inci_assignto' => $incidentdata[0]['inci_assignto'], 'reinitialize_status' => 1,'inci_recived_date'=>date('Y-m-d'),'inci_recived_time'=>date('H:i:s'),'updated_at' => null]);
            }
            else{
                Incident::where('inci_number', $inci_number)->update(['inci_status' => 3, 'inci_assignto' => '', 'inci_recived_date'=>date('Y-m-d'),'inci_recived_time'=>date('H:i:s'),'updated_at' => null]);

            }

            $data = [
                'subject' => 'Re-Assign Incident',
                'email' => $incidentdata[0]['agent']['email'],
                'name' => $incidentdata[0]['agent']['first_name'],
                'username' => $incidentdata[0]['agent']['first_name'],
                'password' => '',
                'login_link' => ''
            ];

            Helper::sendMailCreateIncident($data['subject'],'Re-Assign Incident',$data['email'],$data,'email.logintext');
            return response()->json('success');
        }


        //$updateSellIncident = DB::table('incident_sell_documents')->where(['incident_number' => $inci_number])->update($customerArray);

        //$randomUser = User::with('roles')->role('Tc user')->where('id', '!=', env('TC_USER_ID'))->where('status','1')->where('login_status','1')->inRandomOrder()->first();

        /*if ($updateSellIncident) {
		$incidentdata=Incident::select('inci_assignto')->where('inci_number',$inci_number)->get()->toArray();

		Incident::where('inci_number', $inci_number)->update(['inci_status' => 3, 'inci_assignto' => $incidentdata[0]['inci_assignto'], 'reinitialize_status' => 1,'inci_recived_date'=>date('Y-m-d'),'inci_recived_time'=>date('H:i:s'),'updated_at' => null]);
		$data = [
                'subject' => 'Re-Assign Incident',
                'email' => $incidentdata[0]['email'],
                'name' => $incidentdata[0]['first_name'],
                'username' => $incidentdata[0]['first_name'],
                'password' => '',
                'login_link' => ''
            ];

		Helper::sendMailCreateIncident($data['subject'],'Re-Assign Incident',$data['email'],$data,'email.logintext');
            return response()->json('success');

        }*/
    }

	
    //View Document
    public function viewDocument(Request $request)
    {
        $inci_id = $request->inci_id;
        $incidentImageDetails = array();
        $incidentImageDetails_single=Incidents::with('buy_incident','sell_incident')->where('inci_number', $inci_id)->first();
        $incidentImageDetails=Incidents::with('buy_incident','sell_incident')->where('inci_number', $inci_id)->first();
        $incidentImageDetails['incedent_doc'] = (object)[];
        if(isset($incidentImageDetails['buy_incident']) && !empty($incidentImageDetails['buy_incident'])) {
            $incidentImageDetails['incedent_doc'] = $incidentImageDetails['buy_incident'];
        } else if(isset($incidentImageDetails['sell_incident']) && !empty($incidentImageDetails['sell_incident'])) {
            $incidentImageDetails['incedent_doc'] = $incidentImageDetails['sell_incident'];
        }
        unset($incidentImageDetails['buy_incident']);
        unset($incidentImageDetails['sell_incident']);

        /*$incidentUpdateDetails = IncidentUpdate::where('inci_up_inc_key', '=', $incidentImageDetails->inci_key)->first();

        if ($incidentUpdateDetails) {
            if ($incidentImageDetails->inci_buy_sell_req == 1) {

                $incidentImageDetails = IncidentSellDocuments::where('incident_number', $incidentImageDetails->inci_number)->first();
            } else {
                $incidentImageDetails = IncidentBuyDocuments::where('incident_number', $incidentImageDetails->inci_number)->first();
            }
        }*/
	//print_r(json_encode($incidentImageDetails_single)); exit;

        return view("agent.view-doc", compact('inci_id', 'incidentImageDetails','incidentImageDetails_single'))->render();
    }


    public function logout()
    {
        Auth::guard('agent')->logout();
        return redirect("/agent/login");
    }
}
