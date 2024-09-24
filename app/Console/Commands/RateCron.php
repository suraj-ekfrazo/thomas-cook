<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;
use DB;
use Modules\Holidays\Entities\Holiday;

class RateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get current market rate of all currency';

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
	date_default_timezone_set("Asia/Calcutta");
	//Log::info("Cron start:".date('H:i:s')."==>".strtotime(date('H:i:s'))."<".strtotime('16:00:00'));
	
	$holidays =Holiday::select('holiday_date')->pluck('holiday_date');
        $today = Carbon::now();
        $datesToCheck = $holidays; // Use the format 'Y-m-d'
        $datesToCheckCollection = collect($datesToCheck);
        if (!$today->isWeekend() && !$datesToCheckCollection->contains($today->toDateString())) {
        if ((strtotime(date('H:i:s')) > strtotime('10:00:00') && strtotime(date('H:i:s')) < strtotime('16:00:00'))) {
	
	//exit;
	$username='thomascookindialtd114899244';
        $password='gmj30d1nqd0c43goiu6hrus9fq';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://xecdapi.xe.com/v1/convert_from/?from=INR&to=USD,EUR,GBP&amount=1',
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
            //$rate_margn=DB::table('rate_margin')->select('buy_margin','sell_margin')->where('currency_name',$val['quotecurrency'])->first();
            //print_r($rate_margn->buy_margin);
            $buyMargin = $newval;
            $sellMargin = $newval;
            DB::table('currency')
                ->where('currency_name_key', $val['quotecurrency'])
                ->update(['cur_sell' => round($sellMargin,2)]);
		//Log::info('New==>'.$val['quotecurrency'].'==>'.$newval);	
        }
        //Log::info("Cron End");
	}
    }
    }
}
