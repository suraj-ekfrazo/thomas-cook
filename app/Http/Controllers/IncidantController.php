<?php

namespace App\Http\Controllers;

use App\incidantModel;
use Illuminate\Http\Request;
use DB;


class IncidantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Buylist(Request $request)
    {
        $data=$request->all();
        //$incidantList = incidantModel::with('doc')->get()->toArray();
        $incidantList = DB::table('incident_buy_documents')
            ->select('incident_number',
                DB::raw("(case WHEN passport != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',passport) ELSE '' END) AS passport"),
                DB::raw("(case WHEN refound != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',refound) ELSE '' END) AS refound"),
                DB::raw("(case WHEN annex != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',annex) ELSE '' END) AS annex"),
                DB::raw("(case WHEN other != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',other) ELSE '' END) AS other")
                )
            ->get()->toArray();
        return response()->json($incidantList, 200);
    }

    public function Selllist(Request $request)
    {
        $data=$request->all();
        //$incidantList = incidantModel::with('doc')->get()->toArray();
        $incidantList = DB::table('incident_sell_documents')
            ->select('incident_number',
                DB::raw("(case WHEN passport != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',passport) ELSE '' END) AS passport"),
                DB::raw("(case WHEN visa != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',visa) ELSE '' END) AS visa"),
                DB::raw("(case WHEN ticket != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',ticket) ELSE '' END) AS ticket"),
                DB::raw("(case WHEN pan_card != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',pan_card) ELSE '' END) AS pan_card"),
                DB::raw("(case WHEN apply != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',apply) ELSE '' END) AS apply"),
                DB::raw("(case WHEN annex != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',annex) ELSE '' END) AS annex"),
                DB::raw("(case WHEN bank_transfer != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',bank_transfer) ELSE '' END) AS bank_transfer"),
                DB::raw("(case WHEN business != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',business) ELSE '' END) AS business"),
                DB::raw("(case WHEN sof != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',sof) ELSE '' END) AS sof"),
                DB::raw("(case WHEN other != '' THEN CONCAT('".asset('documents/')."/"."',incident_number,'/',other) ELSE '' END) AS other")
            )
            ->get()->toArray();
        return response()->json($incidantList, 200);
    }

   public function receivestatus(Request $request)
    {
        $data = $request->all();
        $incidentType = DB::table('incidents')->select('inci_buy_sell_req')->where('inci_number', $data)->get()->pluck('inci_buy_sell_req');
        if ($incidentType[0] == "1") {
            $cnt_record = DB::table('incident_sell_documents')->where('incident_number', $data[0]['incident_number'])->count();
             
            if ($cnt_record > 0) {
                DB::table('incident_sell_documents')->where('incident_number', $data[0]['incident_number'])->update([
                    'passport_status' => isset($data[0]['passport_status']) ? $data[0]['passport_status'] : '1',
                    'passport_comment' => isset($data[0]['passport_comment']) ? $data[0]['passport_comment'] : '',
                    'pan_card_status' => isset($data[0]['pan_card_status']) ? $data[0]['pan_card_status'] : '1',
                    'pan_card_comment' => isset($data[0]['pan_card_comment']) ? $data[0]['pan_card_comment'] : '',
                    'ticket_status' => isset($data[0]['ticket_status']) ? $data[0]['ticket_status'] : '1',
                    'ticket_comment' => isset($data[0]['ticket_comment']) ? $data[0]['ticket_comment'] : '',
                    'visa_status' => isset($data[0]['visa_status']) ? $data[0]['visa_status'] : '1',
                    'visa_comment' => isset($data[0]['visa_comment']) ? $data[0]['visa_comment'] : '',
                    'annex_status' => isset($data[0]['annexure_status']) ? $data[0]['annexure_status'] : '1',
                    'annex_comment' => isset($data[0]['annexure_comment']) ? $data[0]['annexure_comment'] : '',
                    'lerms_letter_status' => isset($data[0]['lerms_letter_status']) ? $data[0]['lerms_letter_status'] : '1',
                    'lerms_letter_comment' => isset($data[0]['lerms_letter_comment']) ? $data[0]['lerms_letter_comment'] : '',
                    'apply_status' => isset($data[0]['apply_status']) ? $data[0]['apply_status'] : '1',
                    'apply_comment' => isset($data[0]['apply_comment']) ? $data[0]['apply_comment'] : '',
                    'bank_transfer_status' => isset($data[0]['bank_transfer_status']) ? $data[0]['bank_transfer_status'] : '1',
                    'bank_transfer_comment' => isset($data[0]['bank_transfer_comment']) ? $data[0]['bank_transfer_comment'] : '',
                    'sof_status' => isset($data[0]['sof_status']) ? $data[0]['sof_status'] : '1',
                    'sof_comment' => isset($data[0]['sof_comment']) ? $data[0]['sof_comment'] : ''

                ]);
                //Update incident status
                if ($data[0]['passport_status'] == 2 || $data[0]['pan_card_status'] == 2 || $data[0]['visa_status'] == 2) {
                    DB::table('incidents')->where('inci_number', $data[0]['incident_number'])->update(['inci_status' => 0]);
                }
                return response()->json(['message' => 'success', 'code' => 200], 200);
            } else {
                return response()->json(['message' => 'Not found!', 'code' => 204], 204);
            }
        }else{
            $cnt_record = DB::table('incident_buy_documents')->where('incident_number', $data[0]['incident_number'])->count();

            if ($cnt_record > 0) {
              
                DB::table('incident_buy_documents')->where('incident_number', $data[0]['incident_number'])->update([
                    'passport_status' => isset($data[0]['passport_status']) ? $data[0]['passport_status'] : '1',
                    'passport_comment' => isset($data[0]['passport_reasons']) ? $data[0]['passport_reasons'] : '',
                    'annex_status' => isset($data[0]['annexure_status']) ? $data[0]['annexure_status'] : '1',
                    'annex_comment' => isset($data[0]['annexure_reasons']) ? $data[0]['annexure_reasons'] : '',
                    'refound_status' => isset($data[0]['refound_status']) ? $data[0]['refound_status'] : '1',
                    'refound_comment' => isset($data[0]['refound_reasons']) ? $data[0]['refound_reasons'] : '',
                    'surrender_letter_status' => isset($data[0]['surrender_letter_status']) ? $data[0]['surrender_letter_status'] : '1',
                    'surrender_letter_comment' => isset($data[0]['surrender_letter_reasons']) ? $data[0]['surrender_letter_reasons'] : '',
                ]);

                //Update incident status
                if ($data[0]['passport_status'] == 2 ) {
                    DB::table('incidents')->where('inci_number', $data[0]['incident_number'])->update(['inci_status' => 0]);
                }
                return response()->json(['message' => 'success', 'code' => 200], 200);
            } else {
                return response()->json(['message' => 'Not found!', 'code' => 204], 204);
            }

        }
    }

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
        //
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
