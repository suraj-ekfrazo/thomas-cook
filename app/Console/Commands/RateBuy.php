<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DB;

class RateBuy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'rate:buy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get current market buy rate of all currency';
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
	//Log::info("Buy current rate cron start");
        $curl = curl_init();

            $username='thomascookindialtd114899244';
            $password='gmj30d1nqd0c43goiu6hrus9fq';
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://xecdapi.xe.com/v1/convert_from/?from=INR&to=USD,EUR,GBP,AUD,CAD,JPY,SGD,CHF,AED,THB,SAR,ZAR,NZD&amount=1',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS => array(),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic '.base64_encode($username . ":" . $password)
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $jsn_data=json_decode($response,TRUE);

            foreach($jsn_data['to'] as $val){
                $newval=1/$val['mid'];
                $buyMargin = $newval;
                if($val['quotecurrency']=='JPY'){
                    $newRate=round($buyMargin,4);
                }
                else{
                    $newRate=round($buyMargin,2);
                }
                DB::table('currency')->where('currency_name_key',$val['quotecurrency'])->update(['cur_bye'=>$newRate]);
            }
        //Log::info("Buy current rate cron end");        
    }
}
