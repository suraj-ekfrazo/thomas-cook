<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;
use App\Models\TcUser;
use App\Models\Incidents;


class ApiController extends Controller
{

    public function buyCurrentRate(){
        Log::info("Buy current rate cron start");
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://services.thomascook.in/tcCommonRS/extnrt/getNewRequestToken',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'uniqueId: 2402:3a80:65f:fff:558a:142:b1ad:ac27',
                'user: mobicule'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $arr_res=json_decode($response);
        Log::info(['First API'=>$arr_res]);
        Log::info(['First API error code'=>$arr_res->errorCode]);
        if($arr_res->errorCode==0){
            $curl_rate = curl_init();
            curl_setopt_array($curl_rate, array(
                CURLOPT_URL => 'https://services.thomascook.in/tcForexRS/generic/roe/1/3/0/2',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'requestId:'.$arr_res->requestId,
                    'sessionId:'.$arr_res->tokenId,
                    'netcore: netcore',
                    'Content-Type: application/json'
                ),
            ));

            $response_rate = curl_exec($curl_rate);
            Log::info(['Data'=>$response_rate]);
            curl_close($curl_rate);
            $arr_res_rate=json_decode($response_rate);
            foreach($arr_res_rate as $val){
                DB::table('currency')->where('currency_name_key',$val->currencyCode)->update(['cur_bye'=>$val->roe]);
		Log::info([$val->currencyCode=>$val->roe]);
            }
            //Log::info("Buy current rate cron in");
        }
        Log::info("Buy current rate cron end");
        return response()->json(['status' => 'true']);

    }

    public function expiredIncidents()
    {
        $today = date("Y-m-d");
        $inci_data = DB::table('incidents')->where('expiry_date', '<', $today)->where(['doc_type' => 0, 'inci_status' => 3])->get();
        if ($inci_data->count() > 0) {

            foreach ($inci_data as $data) {
                DB::table('incidents')->where(['inci_number' => $data->inci_number])->update(['inci_status' => 2]);
            }
            return response()->json(['status' => 'true', 'expired_incidents' => $inci_data]);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Expired incidents not found!']);
        }
    }

    //Auto Assign logic
    public function assignIncident(){
        Log::info("Cron Assign incident start");
        $loginTcUser=TcUser::getLoginTcUserList();
        $data = [];
        $get_incident=collect($this->getPendingIncident(0));
        if(count($get_incident)>0 && count($loginTcUser)>0) {

            foreach ($loginTcUser as $key=>$value){
                $cnt_assign= Incidents::select('id')->where('inci_assignto','=',$value)->count();
                //$cnt_assign=3;
                if($cnt_assign<5){
                    $remain_cnt=5-$cnt_assign;

                    $totalUpdate = $get_incident->slice(count($data), $remain_cnt)->pluck('id')->all();
                    $data = array_merge($data,$totalUpdate);

                    if(count($totalUpdate) > 0) {
                        Log::info("Assign incident to ===> ".$value);
                        Incidents::whereIn('id', $totalUpdate)->update(['inci_assign_status'=>'1','inci_assignto'=>$value]);
                    }
                }
            }
            //print($arr_data);
        }
        else{
            Log::info("No any pending incident Or No any login tc-user");
        }
        Log::info("Cron Assign incident end");
        exit;
//        return $loginTcUser;
//        exit;
        return response()->json(['status' => 'true']);
    }
}
