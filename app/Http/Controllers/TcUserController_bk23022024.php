<?php

namespace App\Http\Controllers;

use App\Mail\IncidentUpdateStatus;
use App\Models\IncidentComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Helper;
use Modules\AdminIncidents\Entities\Incident;
use App\Models\CurrencyRate;
use App\Models\Incidents;
use Illuminate\Support\Facades\Mail;
use Log;

class TcUserController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth:tcuser');
    }

    public function tcUserDashboard()
    {
	
        $userid =  Auth::user()->id;
	    $username = Auth::user()->first_name;
        $login_status = Auth::user()->login_status;
	//$login_status = 1;
	//print_r($login_status);exit;
        // 1st Tab
        $query1 = Incident::with([
            'incidentCurrency',
            'incidentAssign' => function ($query1) {
                $query1->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query1) {
                $query1->select('id', 'agent_key','agent_code', 'user_name', 'email', 'first_name', 'last_name');
            }
        ]);

        if ($userid == env('TC_USER_ID')) {
            $IncidentRequest = $query1->where(['mudra_posting' => 0])->where('inci_buy_sell_req','1')->orderBy('id', 'DESC')->get();
        } else {
            $IncidentRequest = $query1->where('inci_assignto', $userid)->whereNotIn('inci_status', [0, 1])->orderBy('id', 'DESC')->get();
        }

        //2nd Tab
        $query2 = Incident::with([
            'incidentUpdate',
            'incidentCurrency',
            'incidentAssign' => function ($query2) {
                $query2->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query2) {
                $query2->select('id', 'agent_key','agent_code', 'user_name', 'email', 'first_name', 'last_name');
            }
        ]);
        if ($userid == env('TC_USER_ID')) {
            $IncidentSellRequest = $query2->where('mudra_posting', 1)->orderBy('id', 'DESC')->limit(300)->get();
        } else {
            $IncidentSellRequest = $query2->where('inci_assignto', $userid)->whereIn('inci_status', [0, 1])->orderBy('id', 'DESC')->get();
        }


        $currencydata = CurrencyRate::get();
        $data['currencydata'] = $currencydata;
        foreach ($currencydata as $key => $value) {
            $currency_name = str_replace("/INR", "", $value->currency_name_key);
            $currencydata[$key]['rate_margin'] = DB::table('rate_margin')->where("currency_name", $currency_name)->first();
        }
	//print_r(json_encode($IncidentSellRequest)); exit;

        return view('tcuser-dashboard', compact('IncidentRequest', 'IncidentRequest', 'currencydata', 'currencydata', 'IncidentSellRequest', 'userid','login_status','username'));
        //return view('tcuser-dashboard', compact('IncidentRequest'));
    }

    public function bookingRequest(Request $request)
    {
        $userid =  Auth::user()->id;
        $input = $request->all();
        $searchValue = $input['search_keywords']; // Search value
        $array = [
            'id', 'inci_number', 'inci_forex_card_no', 'inci_passport_number'
        ];
        $column = $input['order'][0]['column'];
        $query = Incident::with([
            'incidentCurrency',
            'incidentAssign' => function ($query1) {
                $query1->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query1) {
                $query1->select('id', 'agent_key','agent_code', 'user_name', 'email', 'first_name', 'last_name');
            }
        ]);
        if($input['search_keywords']!=""){
            $query->where(
                function($query) use ($searchValue) {
                    return $query
                        ->where('inci_number', 'LIKE', '%'.$searchValue.'%')
                        ->orWhere('inci_forex_card_no', 'like', '%' . $searchValue . '%')
                        ->orWhere('inci_passport_number', 'like', '%' . $searchValue . '%');
                });
        }        
	if ($userid == env('TC_USER_ID')) {
            $query->where(['mudra_posting' => 0]);
        } else {
            $query->where('inci_assignto', $userid)->whereNotIn('inci_status', [0, 1]);
        }

	$query->orderBy($array[$column], $input['order'][0]['dir'])->orderBy('id', 'DESC')->get();

        $result['draw'] = $input['draw'];
        $result['recordsTotal'] = $query->count();
        $result['recordsFiltered'] = $query->count();
        $result['data'] = $query->skip($input['start'])->take($input['length'])->get()->toArray();
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Success', 'data' => $result['data'], 'recordsTotal' => $result['recordsTotal'], 'recordsFiltered' => $result['recordsFiltered']));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    public function viewBookingRquest($inci_number)
    {
	  $email = Auth::user()->email;
          $userid =  Auth::user()->id;
          $login_status = Auth::user()->login_status;
          $username = Auth::user()->first_name;
		
	$bookingDetail=Incidents::with('buy_incident','sell_incident','agentDetail')->where('inci_number', $inci_number)->first();
        $bookingDetail['incedent_doc'] = (object)[];
        if(isset($bookingDetail['buy_incident']) && !empty($bookingDetail['buy_incident'])) {
            $bookingDetail['incedent_doc'] = $bookingDetail['buy_incident'];
        } else if(isset($bookingDetail['sell_incident']) && !empty($bookingDetail['sell_incident'])) {
            $bookingDetail['incedent_doc'] = $bookingDetail['sell_incident'];
        }
	
        unset($bookingDetail['buy_incident']);
        unset($bookingDetail['sell_incident']);
//	echo json_encode($bookingDetail);
        /*$InciBookingRequest = DB::table('incidents')->where('inci_number', $inci_number)
            ->leftJoin('incident_sell_documents', 'incidents.inci_number', '=', 'incident_sell_documents.incident_number')->select("incident_sell_documents.*", "incidents.doc_type", "incidents.inci_forex_card_no as card_no", "incidents.transaction_type", "incidents.inci_buy_sell_req", "incidents.inci_number", "incidents.bordox_no", "incidents.inci_status as inci_status", "incidents.inci_status_message as inci_comment", "incidents.inci_departure_date", "incidents.travel_type")->first();*/

        $InciCurrency = DB::table('incidents')->where('inci_number', $inci_number)
            ->leftJoin('incident_currency as ic', 'incidents.inci_number', '=', 'ic.incident_id')
            ->select("incidents.*", "ic.inci_currency_type as icy", "ic.inci_frgn_curr_amount as ifca", "ic.inci_inr_amount as iia", "ic.inci_currency_rate as icr")->get();

        $currencydata = CurrencyRate::get();
        $data['currencydata'] = $currencydata;
	foreach ($currencydata as $key => $value) {
            $currency_name = str_replace("/INR", "", $value->currency_name_key);
            $currencydata[$key]['rate_margin'] = DB::table('rate_margin')->where("currency_name", $currency_name)->first();
        }

        //return view('tcuser.update-booking-request', compact('bookingDetail', 'InciCurrency', 'currencydata'));
	//print_r($bookingDetail);exit;
	return view('tcuser.update-booking-request')->with(compact('InciCurrency', 'currencydata','bookingDetail','username', 'userid', 'login_status'));
    }

    //View Document using Incident Number
    public function viewDocument(Request $request)
    {
        $inciDoc=Incidents::with('buy_incident','sell_incident')->where('inci_number', $request->id)->first();
        $inciDoc['incedent_doc'] = (object)[];
        if(isset($inciDoc['buy_incident']) && !empty($inciDoc['buy_incident'])) {
            $inciDoc['incedent_doc'] = $inciDoc['buy_incident'];
        } else if(isset($inciDoc['sell_incident']) && !empty($inciDoc['sell_incident'])) {
            $inciDoc['incedent_doc'] = $inciDoc['sell_incident'];
        }
        unset($inciDoc['buy_incident']);
        unset($inciDoc['sell_incident']);
        //echo json_encode($inciDoc);exit;
        //$inciDetail = DB::table('incidents')->where('inci_number', $request->id)->first();
        //$inciDoc = DB::table('incident_sell_documents')->where('incident_number', $request->id)->first();
        //return view("tcuser.view-doc", compact('inciDoc', 'inciDetail'))->render();
        return view("tcuser.view-doc", compact('inciDoc'))->render();
    }

    //update single document status and comment
    public function updateSingleDcocumentStatus(Request $request)
    {

        $id = $request->id;
        $status = $request->status ?  $request->status : '';
        $comment = $request->comment ? $request->comment : '';
        $inci_type = $request->inci_type ? $request->inci_type : '0';

        $valid_array = array();

        if ($request->doc_type == 'passport') {

            if ($request->status == 4) {
                $pass_comment = '';
            } else {
                $pass_comment = $comment;
            }

            if ($request->status == 2 && $pass_comment == '') {

                $valid_array['passport_comment'] = 'required';
            } else {

                if($inci_type==1) {
                    DB::table('incident_sell_documents')->where('id', $id)->update(array(
                        'passport_status' => $status, 'passport_comment' => $pass_comment,
                    ));
                }else{
                    DB::table('incident_buy_documents')->where('id', $id)->update(array(
                        'passport_status' => $status, 'passport_comment' => $pass_comment,
                    ));
                }
                exit;
            }
        } elseif ($request->doc_type == 'visa') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['visa_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'visa_status' => $status, 'visa_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'ticket') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['ticket_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'ticket_status' => $status, 'ticket_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'pan_card') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['pan_card_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'pan_card_status' => $status, 'pan_card_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'annex') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['annex_comment'] = 'required';
            } else {
                if($inci_type==1) {
                    DB::table('incident_sell_documents')->where('id', $id)->update(array(
                        'annex_status' => $status, 'annex_comment' => $comment,
                    ));
                }else{
                    DB::table('incident_buy_documents')->where('id', $id)->update(array(
                        'annex_status' => $status, 'annex_comment' => $comment,
                    ));
                }
            }
        } elseif ($request->doc_type == 'application') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['application_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'apply_status' => $status, 'apply_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'bank_transfer') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['bank_transfer_comment'] = 'required';
            } else {
                if($inci_type==1) {
                    DB::table('incident_sell_documents')->where('id', $id)->update(array(
                        'bank_transfer_status' => $status, 'bank_transfer_comment' => $comment,
                    ));
                }else{
                    DB::table('incident_buy_documents')->where('id', $id)->update(array(
                        'bank_transfer_status' => $status, 'bank_transfer_comment' => $comment,
                    ));
                }
            }
        } elseif ($request->doc_type == 'sof') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['sof_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'sof_status' => $status, 'sof_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'lerms_letter') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['lerms_letter_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'lerms_letter_status' => $status, 'lerms_letter_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'university_letter') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['university_letter_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'university_letter_status' => $status, 'university_letter_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'employment_letter') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['emp_letter_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'emp_letter_status' => $status, 'emp_letter_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'employment_form') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['emp_form_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'emp_declaration_form_status' => $status, 'emp_declaration_form_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'immigration_d_form') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['immigration_d_form_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'immigration_d_form_status' => $status, 'immigration_d_form_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'medical_letter') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['medical_letter_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'medical_letter_status' => $status, 'medical_letter_comment' => $comment,
                ));
            }
        } elseif ($request->doc_type == 'other') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['other_comment'] = 'required';
            } else {
                DB::table('incident_sell_documents')->where('id', $id)->update(array(
                    'other_status' => $status, 'other_comment' => $comment,
                ));
            }
        }elseif ($request->doc_type == 'refund_letter') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['refound_comment'] = 'required';
            } else {
                    DB::table('incident_buy_documents')->where('id', $id)->update(array(
                        'refound_status' => $status, 'refound_comment' => $comment,
                    ));
            }
        } elseif ($request->doc_type == 'surrender_letter') {
            if ($request->status == 2 && $comment == '') {
                $valid_array['surrender_letter_comment'] = 'required';
            } else {
                DB::table('incident_buy_documents')->where('id', $id)->update(array(
                    'surrender_letter_status' => $status, 'surrender_letter_comment' => $comment,
                ));
            }
        }

        //Validation for comment
        $request->validate($valid_array);
        return json_encode(array("status" => 200, "message" => "Document updated successfully!"));
    }

    //update all document detail 
    public function updateDcocument(Request $request)
    {
        $id = $request->id;
        $inci_number = $request->inci_number;
        $update_data = array();
        $validate_array = array();
        $message = array();
	    $update_incidata =array();
	

        $count = 0;
        if(isset($request->annexure_file) && $request->annexure_file==1){
            if($request->chk_annexure){
                $count++;
                $update_data['annex_status']=4;
                $update_data['annex_comment'] = '';
            }
            else{
                $validate_array['annex_comment'] = 'required';
                $update_data['annex_status']=2;
                if (empty($request->annex_comment)) {
                    $validate_array['annex_comment'] = 'required';
                }
                else{
                    $update_data['annex_comment'] = $request->annex_comment;
                }
            }
        }

        //Application
        if(isset($request->application_file) && $request->application_file==1){
            if($request->chk_application){
                $count++;
                $update_data['apply_status']=4;
                $update_data['apply_comment'] = '';
            }
            else{
                $validate_array['apply_comment'] = 'required';
                $update_data['apply_status']=2;
                if (empty($request->application_comment)) {
                    $validate_array['apply_comment'] = 'required';
                }
                else{
                    $update_data['apply_comment'] = $request->application_comment;
                }
            }
        }

        //Pancard
        if(isset($request->pan_card_file) && $request->pan_card_file==1){
            if($request->chk_pan_card){
                $count++;
                $update_data['pan_card_status']=4;
                $update_data['pan_card_comment'] = '';
            }
            else{
                $validate_array['pan_card_comment'] = 'required';
                $update_data['pan_card_status']=2;
                if (empty($request->pan_card_comment)) {
                    $validate_array['pan_card_comment'] = 'required';
                }
                else{
                    $update_data['pan_card_comment'] = $request->pan_card_comment;
                }
            }
        }

        //Lerms letter
        if(isset($request->lerms_letter_file) && $request->lerms_letter_file==1){
            if($request->chk_lerms_letter){
                $count++;
                $update_data['lerms_letter_status']=4;
                $update_data['lerms_letter_comment'] = '';
            }
            else{
                $update_data['lerms_letter_status']=2;
                if (empty($request->lerms_letter_comment)) {
                    $validate_array['lerms_letter_comment'] = 'required';
                }
                else{
                    $update_data['lerms_letter_comment'] = $request->lerms_letter_comment;
                }
            }
        }

        //Passport
        if(isset($request->passport_file) && $request->passport_file==1){
            if($request->chk_passport){
                $count++;
                $update_data['passport_status']=4;
                $update_data['passport_comment'] = '';
            }
            else{
                $validate_array['passport_comment'] = 'required';
                $update_data['passport_status']=2;
                if (empty($request->passport_comment)) {
                    $validate_array['passport_comment'] = 'required';
                }
                else{
                    $update_data['passport_comment'] = $request->passport_comment;
                }
            }
        }

        //Ticket
        if(isset($request->ticket_file) && $request->ticket_file==1){
            if($request->chk_ticket){
                $count++;
                $update_data['ticket_status']=4;
                $update_data['ticket_comment'] = '';
            }
            else{
                $update_data['ticket_status']=2;
                if (empty($request->ticket_comment)) {
                    $validate_array['ticket_comment'] = 'required';
                }
                else{
                    $update_data['ticket_comment'] = $request->ticket_comment;
                }
            }
        }

        //Visa
        if(isset($request->visa_file) && $request->visa_file==1){
            if($request->chk_visa){
                $count++;
                $update_data['visa_status']=4;
                $update_data['visa_comment'] = '';
            }
            else{
                $validate_array['visa_comment'] = 'required';
                $update_data['visa_status']=2;
                if (empty($request->visa_comment)) {
                    $validate_array['visa_comment'] = 'required';
                }
                else{
                    $update_data['visa_comment'] = $request->visa_comment;
                }
            }
        }

        //SOF
        if(isset($request->sof_file) && $request->sof_file==1){
            if($request->chk_sof){
                $count++;
                $update_data['sof_status']=4;
                $update_data['sof_comment'] = '';
            }
            else{
                $update_data['sof_status']=2;
                if (empty($request->sof_comment)) {
                    $validate_array['sof_comment'] = 'required';
                }
                else{
                    $update_data['sof_comment'] = $request->sof_comment;
                }
            }
        }

        //Bank Transfer
        if(isset($request->bank_transfer_file) && $request->bank_transfer_file==1){
            if($request->chk_bank_transfer){
                $count++;
                $update_data['bank_transfer_status']=4;
                $update_data['bank_transfer_comment'] = '';
            }
            else{
                $update_data['bank_transfer_status']=2;
                if (empty($request->bank_transfer_comment)) {
                    $validate_array['bank_transfer_comment'] = 'required';
                }
                else{
                    $update_data['bank_transfer_comment'] = $request->bank_transfer_comment;
                }
            }
        }

        //University letter file
        if(isset($request->university_letter_file) && $request->university_letter_file==1){
            if($request->chk_university_letter){
                $count++;
                $update_data['university_letter_status']=4;
                $update_data['university_letter_comment'] = '';
            }
            else{
                $update_data['university_letter_status']=2;
                if (empty($request->university_letter_comment)) {
                    $validate_array['university_letter_comment'] = 'required';
                }
                else{
                    $update_data['university_letter_comment'] = $request->university_letter_comment;
                }
            }
        }

        //Employment letter file
        if(isset($request->employment_letter_file) && $request->employment_letter_file==1){
            if($request->chk_employment_letter){
                $count++;
                $update_data['emp_letter_status']=4;
                $update_data['emp_letter_comment'] = '';
            }
            else{
                $update_data['emp_letter_status']=2;
                if (empty($request->emp_letter_comment)) {
                    $validate_array['emp_letter_comment'] = 'required';
                }
                else{
                    $update_data['emp_letter_comment'] = $request->emp_letter_comment;
                }
            }
        }

        //Employment Declaration
        if(isset($request->employment_declaration_file) && $request->employment_declaration_file==1){
            if($request->chk_employment_declaration){
                $count++;
                $update_data['emp_declaration_form_status']=4;
                $update_data['emp_declaration_form_comment'] = '';
            }
            else{
                $update_data['emp_declaration_form_status']=2;
                if (empty($request->emp_form_comment)) {
                    $validate_array['emp_declaration_form_comment'] = 'required';
                }
                else{
                    $update_data['emp_declaration_form_comment'] = $request->emp_form_comment;
                }
            }
        }

        //Immigration Declaration form
        if(isset($request->immigration_declaration_file) && $request->immigration_declaration_file==1){
            if($request->chk_immigration_declaration){
                $count++;
                $update_data['immigration_d_form_status']=4;
                $update_data['immigration_d_form_comment'] = '';
            }
            else{
                $update_data['immigration_d_form_status']=2;
                if (empty($request->immigration_d_form_comment)) {
                    $validate_array['immigration_d_form_comment'] = 'required';
                }
                else{
                    $update_data['immigration_d_form_comment'] = $request->immigration_d_form_comment;
                }
            }
        }

        //Medical Letter
        if(isset($request->medical_letter_file) && $request->medical_letter_file==1){
            if($request->chk_medical_letter){
                $count++;
                $update_data['medical_letter_status']=4;
                $update_data['medical_letter_comment'] = '';
            }
            else{
                $update_data['medical_letter_status']=2;
                if (empty($request->medical_letter_comment)) {
                    $validate_array['medical_letter_comment'] = 'required';
                }
                else{
                    $update_data['medical_letter_comment'] = $request->medical_letter_comment;
                }
            }
        }

        //Refund Form
        if(isset($request->refund_form_file) && $request->refund_form_file==1){
            if($request->chk_refund_form){
                $count++;
                $update_data['refound_status']=4;
                $update_data['refound_comment'] = '';
            }
            else{
                $update_data['refound_status']=2;
                if (empty($request->refund_letter_comment)) {
                    $validate_array['refund_letter_comment'] = 'required';
                }
                else{
                    $update_data['refound_comment'] = $request->refund_letter_comment;
                }
            }
        }

        //Surrender Letter
        if(isset($request->surrender_letter_file) && $request->surrender_letter_file==1){
            if($request->chk_surrender_letter){
                $count++;
                $update_data['surrender_letter_status']=4;
                $update_data['surrender_letter_comment'] = '';
            }
            else{
                $update_data['surrender_letter_status']=2;
                if (empty($request->surrender_letter_comment)) {
                    $validate_array['surrender_letter_comment'] = 'required';
                }
                else{
                    $update_data['surrender_letter_comment'] = $request->surrender_letter_comment;
                }
            }
        }

        //Other Letter
        if(isset($request->other_file) && $request->other_file==1){
            if($request->chk_other){
                $count++;
                $update_data['other_status']=4;
                $update_data['other_comment'] = '';
            }
            else{
                $update_data['other_status']=2;
                if (empty($request->other_comment)) {
                    $validate_array['other_comment'] = 'required';
                }
                else{
                    $update_data['other_comment'] = $request->other_comment;
                }
            }
        }


        //required bordox no and comment on status approve
        if ($request->inci_status == 1) {
            $validate_array['bordox_no'] = 'required';
            $validate_array['inci_status_message'] = 'required';
            $message = [
                'inci_status_message.required' => 'Please add comment here',
            ];
        }


      
        $this->validate($request, $validate_array, $message);

        $update_incidata['bordox_no'] = '';
        if (!empty($request->bordox_no)) {
            $update_incidata['bordox_no'] = $request->bordox_no;
        }
        $update_incidata['inci_status_message'] = '';


        foreach ($update_data as $key => $value) {
            if ($value == 2) {
                $value = str_replace('_status', '', $key);
                DB::table('incident_document_comments')->insert([
                    'incident_id'    =>  $inci_number,
                    'key'            =>  $key,
                    'comment'        =>  $update_data[$value.'_comment'],
                    'user_id'        =>  Auth::user()->id,
                    'created_at'     =>  date('Y-m-d H:i:s'),
                    'updated_at'     =>  date('Y-m-d H:i:s')
                ]);
            }
        }

        
        if (!empty($request->inci_status_message)) {
            //$update_incidata['inci_status_message'] = $request->inci_status_message;
	    $arr_comments=array();
            $arr_comments['incident_no']=$inci_number;
            $arr_comments['tc_user_id']=Auth::user()->id;
            $arr_comments['comment']=$request->inci_status_message;
            IncidentComment::create($arr_comments);
        }
        $update_incidata['inci_status'] = $count == $request->document_no ? 1 : 0;
        //update in incident_sell_documents table
        if ((count($update_data) > 0) && ($request->inci_type=='1')) {
            DB::table('incident_sell_documents')->where('id', $id)->update($update_data);
        }
        else{
            DB::table('incident_buy_documents')->where('id', $id)->update($update_data);
        }

        //send email notification on approved or reject
        if ($request->inci_status == 1) {
            $email = Auth::user()->email;
            $tcuser_email = DB::table('users')->where('email', $email)->first();
            // $myEmail = TcUser::getTcUserEmailByCode($request->email);
            $myEmail = $tcuser_email;

            // $myEmail = 'rashmika@yopmail.com';
            $subject = 'Incident Approved';
            $message = 'Your Incident  number ' . $inci_number . ' is Approved';
            $data=[];
            //Mail::to($myEmail)->send(new IncidentUpdateStatus($subject, $message));
	    Helper::sendMailCreateIncident($subject,$message,$email,$data,'mail.incidentUpdateStatusMail');

            }
            else if($request->inci_status == 0){

                $email = Auth::user()->email;
                $tcuser_email = DB::table('users')->where('email', $email)->first();
                $myEmail = $tcuser_email;
                $subject = 'Incident Rejected';
                $message = 'We regret to inform you that incident number '.$inci_number.' has been rejected. Kindly login to the NewBPCPartners portal to check the reason for rejection and upload the new documents.';
		$data=[];
            	Helper::sendMailCreateIncident($subject,$message,$email,$data,'mail.incidentUpdateStatusMail');

                //Mail::to($myEmail)->send(new IncidentUpdateStatus($subject, $message));
            }
    
        else{
            //DB::table('incident_buy_documents')->where('id', $id)->update($update_data);
        }
        //update in incident table
	date_default_timezone_set('Asia/Kolkata');
	$update_incidata['completed_at']=date('Y-m-d H:i:s');
        DB::table('incidents')->where('inci_number', $inci_number)->update($update_incidata);
	
        return response()->json(['message' => 'Document updated successfully!']);
        //return redirect()->back()->with('message', 'Document updated successfully!');
    }

    //update mudra posting status
    public function updateMudraPostingStatus(Request $request)
    {
        $inci_number = $request->inci_id;
        $mudraposting = $request->mudraposting;

        $updatestatus = DB::table('incidents')->where('inci_number', $inci_number)->update(['mudra_posting' => $mudraposting]);
        if ($updatestatus) {
            return json_encode('success');
        }
    }

    public function updateOnlineStatus(Request $request)
    {
        
        $userid = $request->userid;
        $login_status = $request->login_status;

        //print_r($login_status);

        //print_r($userid);
       

        $login = DB::table('users')->where("id", $userid)->update(['login_status' => $login_status]);
        $message = 'Updated Successfully';
        if ($login) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $login));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    public function logout()
    {
        // User::where('id','=',Auth::id())->update(['login_status'=>'0']);
        Auth::guard('tcuser')->logout();
        return redirect("/tcuser/login");
    }
}
