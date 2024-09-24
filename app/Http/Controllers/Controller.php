<?php

namespace App\Http\Controllers;

use App\Models\Incidents;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPendingIncident($limit = 0)
    {
        $get_reload_incident = [];
        $get_before2days_incident = [];
        $arr_final_pending_list = [];
        $arr_incident = [];
        $get_buysell_incident = [];
        $result = [];

        $before_2days_date = Carbon::now()->subDays(2);
        //Get reload type incident
        $get_reload_incident = Incidents::where('inci_status', '=', '3')->where('inci_assign_status', '=', '0')->where('transaction_type', '=', '2')->pluck('id')->toArray();

        if ($limit != 0) {
            if (count($get_reload_incident) >= $limit) {
                $arr_final_pending_list = array_slice($get_reload_incident, 0, $limit);
            } else {

                //Get incident where departure date is past 24 hours, status is under process,not assign to any one, not in above query
                $get_before2days_incident = Incidents::where('inci_status', '=', '3')->where('inci_assign_status', '=', '0')->whereDate('inci_departure_date', '>', $before_2days_date)->whereNotIn('id', $get_reload_incident)->pluck('id')->toArray();
                $arr_incident = array_merge($get_reload_incident, $get_before2days_incident);

                if (count($arr_incident) >= $limit) {
                    $arr_final_pending_list = array_slice($arr_incident, 0, $limit);
                } else {
                    $get_buysell_incident = Incidents::where('inci_status', '=', '3')->where('inci_assign_status', '=', '0')->whereNotIn('id', $arr_incident)->pluck('id')->toArray();
                    $arr_final_pending_list = array_merge($arr_incident, $get_buysell_incident);
                }
                //Get incident buy/sell,status is under process,not assign to any one, not in above query
            }
        } else {
            $get_before2days_incident = Incidents::where('inci_status', '=', '3')->where('inci_assign_status', '=', '0')->whereDate('inci_departure_date', '>', $before_2days_date)->whereNotIn('id', $get_reload_incident)->pluck('id')->toArray();
            $arr_incident = array_merge($get_reload_incident, $get_before2days_incident);
            //Get incident buy/sell,status is under process,not assign to any one, not in above query
            $get_buysell_incident = Incidents::where('inci_status', '=', '3')->where('inci_assign_status', '=', '0')->whereNotIn('id', $arr_incident)->pluck('id')->toArray();
            $arr_final_pending_list = array_merge($arr_incident, $get_buysell_incident);
        }

        //$arr_final_pending_list = array_merge($arr_incident, $get_buysell_incident);
        if ($arr_final_pending_list) {
            $result = Incidents::whereIn('id', $arr_final_pending_list)->orderByRaw('FIELD(id, ' . implode(", ", $arr_final_pending_list) . ')')->get()->toArray();
        }
        return $result;
    }
}
