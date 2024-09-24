<?php

namespace App\Console\Commands;

use App\Mail\IncidentExpiry;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\AdminIncidents\Entities\Incident;

class ExpiryCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiry:cron';

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
          $end_time =   Carbon::parse($start_time)->addDay()->toDateString();
         //Log::info("cron start");

         $results = Incident::select('incidents.*','agents.email')->join('agents', 'agents.id','incidents.agent_id')->where('expiry_date' ,'=', $end_time )->get();

        //  print_r($results);
         foreach($results as $result) {
 
           
                 $inci_number = $result->inci_number;
                 $myEmail = $result->email;
                 $subject = 'Incident Expiry Alert';
                 $message = 'Your Incident Number is '. $inci_number .' Expire Tomorrow';
                 Mail::to($myEmail)->send(new IncidentExpiry($subject, $message));

                
                 }    

        //Log::info("Cron End");
        $this->info('Email Cron Send Successfully');
    }

 
}
