<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\IncidentExpiry;
use App\Models\Agents;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\AdminIncidents\Entities\Incident;
use Modules\Agent\Entities\Agent;
use Helper;

class NotificationController extends Controller
{
    public function expirydate(Request $request)
    {
        // $input = $request->all();
        $start_time =  Carbon::now();
        $end_time =   Carbon::parse($start_time)->addDay()->toDateString();
        // print_r($end_time);
        
        $results = Incident::select('incidents.*','agents.email')->join('agents', 'agents.id','incidents.agent_id')->where('expiry_date' ,'=', $end_time )->get();

        foreach($results as $result) {

          
                $inci_number = $result->inci_number;
                $myEmail = $result->email;
                $subject = 'Incident Expiry Alert';
                $message = 'Your Incident Number is '. $inci_number .' Expire Tomorrow';
		
		Helper::sendMailCreateIncident($subject,$message,$myEmail);

                //Mail::to($myEmail)->send(new IncidentExpiry($subject, $message));
                }
            // print_r($result);
        
            return response()->json($result, 200);
          

    }
}
