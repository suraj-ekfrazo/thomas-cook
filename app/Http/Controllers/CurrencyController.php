<?php

namespace App\Http\Controllers;

use App\incidantModel;
use Illuminate\Http\Request;
use DB;
use Log;


class CurrencyController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tc-user.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->inr_val();
    }

    public function inr_val(){
	
	$username='thomascookindialtd114899244';
        $password='gmj30d1nqd0c43goiu6hrus9fq';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://xecdapi.xe.com/v1/convert_from/?from=INR&to=USD,EUR,GBP,AUD,CAD,JPY,SGD,CHF,AED,THB&amount=1',
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
        //print_r($response);exit;
	curl_close($curl);

        $jsn_data=json_decode($response,TRUE);

        foreach($jsn_data['to'] as $val){
            $newval=1/$val['mid'];
            $rate_margn=DB::table('rate_margin')->select('buy_margin','sell_margin')->where('currency_name',$val['quotecurrency'])->first();
            //print_r($rate_margn->buy_margin);
	    Log::info('Currency==>'.$val['quotecurrency'].",new_val=>".$newval.",buy_margin==>".$rate_margn->buy_margin);
            $buyMargin = $newval;
            $sellMargin = $newval;
	    Log::info('Currency==>'.$val['quotecurrency'].",cur_bye==>".round($buyMargin,2).",cur_sell==>".round($sellMargin,2));
            DB::table('currency')
                ->where('currency_name_key', $val['quotecurrency'])
                ->update(['cur_sell' => round($sellMargin,2)]);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
