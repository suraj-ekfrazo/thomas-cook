<?php

namespace App\Console\Commands;

use App\Mail\IncidentExpiry;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\AdminIncidents\Entities\Incident;

class ExpiryIncident extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiryIncident:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
          $start_time =  Carbon::now();

         //Log::info("-----cron Expired cron start-----");

         $results = Incident::select('incidents.*','agents.email')->join('agents', 'agents.id','incidents.agent_id')->where('expiry_date' ,'=', date('Y-m-d') )->where('inci_status','!=','1')->get();

        //print_r($results);
         foreach($results as $result) {
 
           
                 $inci_number = $result->inci_number;
                 $myEmail = $result->email;
                 $subject = 'Incident Expired';
                 $message = 'Your Incident Number is '. $inci_number .' Expired';
                 //Mail::to($myEmail)->send(new IncidentExpiry($subject, $message));
		 Incident::where('inci_number',$inci_number)->update(['inci_status'=>'2']);
          		      
                 }    

         //Log::info("-----cron Expired cron End-----");
        $this->info('Email Cron Send Successfully');
    }

 
}
