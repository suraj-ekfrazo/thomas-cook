<?php

namespace Modules\RateMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;


class RateMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ratemaster::index');
    }

    public function tableData(Request $request)
    { 
	date_default_timezone_set('Asia/Kolkata');
        $current_time = strtotime('now');

        switch ($current_time) {
            case $current_time >= strtotime('10:00 am') && $current_time < strtotime('12:00 pm'):
                $columnName = 'sell_margin_10_12';
                break;
            case $current_time >= strtotime('12:00 pm') && $current_time < strtotime('02:00 pm'):
                $columnName = 'sell_margin_12_2';
                break;
            case $current_time >= strtotime('02:00 pm') && $current_time < strtotime('03:30 pm'):
                $columnName = 'sell_margin_2_3_30';
                break;
            case $current_time >= strtotime('03:30 pm'):
                $columnName = 'sell_margin_3_30_end';
                break;
            default:
                $columnName = 'sell_margin_3_30_end';
                break;
        }
            $input = $request->all();
            $searchValue = $input['search_keywords']; // Search value
            $array = ['id', 'currency_name', 'buy_margin', 'sell_margin', 'datetime'];
            $column = $input['order'][0]['column'];
            //$query = DB::table('rate_margin')->where('currency_name', 'like', '%' . $searchValue . '%')->orderBy('id', 'Asc');
	    $query = DB::table('rate_margin')
            ->leftJoin('currency', 'currency.currency_name_key', '=', 'rate_margin.currency_name')
            ->select('rate_margin.*', DB::raw('FORMAT((rate_margin.' . $columnName . ' * currency.cur_sell)/100, 2) as current_rate_per'), DB::raw( 'FORMAT(currency.cur_sell + ((rate_margin.' . $columnName . ' * currency.cur_sell)/100),2) as current_rate') )
            ->where('currency_name', 'like', '%' . $searchValue . '%')
            ->orderBy('id', 'Asc');
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

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ratemaster::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ratemaster::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data['data'] = DB::table('rate_margin')->where('id', $id)->first();
        return view('ratemaster::modal.edit')->with($data)->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $request->validate([
            'sell_margin_10_12' => 'required',
            'sell_margin_12_2' => 'required',
            'sell_margin_2_3_30' => 'required',
            'sell_margin_3_30_end' => 'required'
        ]);
	
	$update['buy_margin'] = $request->buy_margin;
        $update['sell_margin_10_12'] = $request->sell_margin_10_12;
        $update['sell_margin_12_2'] = $request->sell_margin_12_2;
        $update['sell_margin_2_3_30'] = $request->sell_margin_2_3_30;
	$update['holiday_margin'] = $request->holiday_margin;

        $update['sell_margin_3_30_end'] = $request->sell_margin_3_30_end;
        $rate = DB::table('rate_margin')->where('id', $request->id)->update($update);
        $message = 'Rate successfully updated.';
        return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $rate));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
