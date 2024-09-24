<?php

namespace App\Console\Commands;

use App\Mail\IncidentExpiry;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Incidents;
use App\Models\TcUser;


class AutoAssign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoAssign:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto assign pending incidents';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         //Log::info("-----Cron Auto Assign start-----");
		$loginTcUser=TcUser::getLoginTcUserList();
		
        	$data = [];
		
        	$get_incident=$this->getPendingIncident(0);
		//Log::info(count($get_incident)."==>".count($loginTcUser));
        	if((count($get_incident)>0) && (count($loginTcUser)>0)) {
			//Log::info("hello");
			
            		foreach ($loginTcUser as $key=>$value){
                		$cnt_assign= Incidents::select('id')->where('inci_assignto','=',$value)->where('inci_status','3')->count();
                		//$cnt_assign=3;


				//Log::info("-------------------------");
                		if($cnt_assign<5){
					$arr_incident_id=array();
                    			$remain_cnt=5-$cnt_assign;
					
                    			//$totalUpdate = $get_incident->slice(count($get_incident), $remain_cnt)->pluck('id')->all();
					$totalUpdate = array_slice($get_incident, 0, $remain_cnt);
					//Log::info($totalUpdate);
					foreach($totalUpdate as $key=>$valueid){
						$arr_incident_id[]=$valueid['id'];
					}
					//Log::info($arr_incident_id);
                    			$data = array_merge($data,$totalUpdate);

                    			if(count($totalUpdate) > 0) {
                        			//Log::info($arr_incident_id);
                        			Incidents::whereIn('id', $arr_incident_id)->update(['inci_assign_status'=>'1','inci_assignto'=>$value]);
                    			}
                		}
            		}
            		//print($arr_data);
        	}
        	else{
            		//Log::info("No any pending incident Or No any login tc-user");
        	}	 			
			
         //Log::info("-----Cron Auto Assign End-----");
    }

	
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
	//Log::info($result);
        return $result;
    }
 
}
