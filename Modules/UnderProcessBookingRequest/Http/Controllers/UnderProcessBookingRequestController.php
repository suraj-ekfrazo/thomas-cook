<?php

namespace Modules\UnderProcessBookingRequest\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminIncidents\Entities\Incident;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UnderProcessBookingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('underprocessbookingrequest::index');
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $searchValue = $input['search_keywords']; // Search value
        $array = [
            'id', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number',
            'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number',
            'inci_number',
            'created_at'
        ];
        $column = $input['order'][0]['column'];
        $query = Incident::with([
            'incidentUpdate',
            'incidentCurrency',
            'buyDocuments',
            'sellDocuments',
            'incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query) {
                $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
            }
        ])->where(['inci_status' => 3, 'inci_buy_sell_req' => 0, 'doc_type' => 1])->where(function ($query) use ($searchValue) {
            if($searchValue!=''){
            $query->where('inci_number', 'like', '%' . $searchValue . '%')
                ->orWhere('inci_forex_card_no', 'like',  '%' . $searchValue . '%')
                ->orWhereHas('incidentAssign', function ($query) use ($searchValue) {
                    $query->where('users.user_code', 'like', '%' . $searchValue . '%');
                })
                ->orWhereHas('agent', function ($query) use ($searchValue) {
                    $query->where('agents.agent_key', 'like', '%' . $searchValue . '%');
                });
            }
        });//->orderBy($array[$column], $input['order'][0]['dir']);


        //datatable search
        // $query->orWhereHas('incidentAssign', function ($query) use ($searchValue) {
        //     $query->where('users.user_code', 'Like', '%' . $searchValue . '%');
        // });
        // $query->orWhereHas('agent', function ($query) use ($searchValue) {
        //     $query->where('agents.agent_key', 'Like', '%' . $searchValue . '%')->orWhere('agents.first_name', 'Like', '%' . $searchValue . '%');
        // });

        //date filter
        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_create_time', '>=', $from_date)->where('inci_create_time', '<=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else{ 
            if ($input['from_date'] != '' || $input['to_date'] != '') {
               
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != ''){
                    $query->where('inci_create_time', '=', $from_date);
               } else if ($to_date != '')
                    $query->Where('inci_create_time', '=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
            }
            
        }
        
//  $sql_with_bindings = str_replace_array('?', $query->getBindings(), $query->toSql());

// dd($sql_with_bindings);
// die;
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


    public function dataSell()
    {
        return view('underprocessbookingrequest::sell-data');
    }

    public function tableDataSell(Request $request)
    {

        $input = $request->all();
        $searchValue = $input['search_keywords']; // Search value
        $array = [
            'id', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number',
            'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number',
            'inci_number',
            'created_at'
        ];
        $column = $input['order'][0]['column'];
        $query = Incident::with([

            'incidentCurrency',
            'buyDocuments',
            'sellDocuments',
            'incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query) {
                $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
            }
        ])->where(['inci_status' => 3, 'inci_buy_sell_req' => 1, 'doc_type' => 1])->where(function ($query) use ($searchValue) {
            $query->where('inci_number', 'like', '%' . $searchValue . '%')
                ->orWhere('inci_forex_card_no', 'like',  '%' . $searchValue . '%')
                ->orWhereHas('incidentAssign', function ($query) use ($searchValue) {
                    $query->where('users.user_code', 'like', '%' . $searchValue . '%');
                })
                ->orWhereHas('agent', function ($query) use ($searchValue) {
                    $query->where('agents.agent_key', 'like', '%' . $searchValue . '%');
                });
        })->orderBy($array[$column], $input['order'][0]['dir']);

        //date filter
        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_create_time', '>=', $from_date)->where('inci_create_time', '<=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_create_time', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_create_time', '=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        }
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

     //Export Buy data
    public function tableDataExport(Request $request)
    {
        $input = $request->all();
        $query = Incident::with([
            'incidentUpdate',
            'incidentCurrency',
            'buyDocuments',
            'sellDocuments',
            'incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query) {
                $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
            }
        ])->where(['inci_status' => 3, 'inci_buy_sell_req' => 0, 'doc_type' => 1]);

        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_create_time', '>=', $from_date)->where('inci_create_time', '<=', $to_date);
            });
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_create_time', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_create_time', '=', $to_date);
            });
        }

        $result['data'] = $query->orderBy('id','DESC')->get()->toArray();
        //print_r($result); exit;
        if ($result) {

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Incident Number');
            $sheet->setCellValue('B1', 'TC User Name ');
            $sheet->setCellValue('C1', 'Agent Code');
            $sheet->setCellValue('D1', 'Agent Name');
            $sheet->setCellValue('E1', 'Card number');
            $sheet->setCellValue('F1', 'Passport No.');
            $sheet->setCellValue('G1', 'Transaction Type');
            $sheet->setCellValue('H1', 'FX Currency');
            $sheet->setCellValue('I1', 'FX Amount');
            $sheet->setCellValue('J1', 'FX Rate');
            $sheet->setCellValue('K1', 'INR Amount');
            $sheet->setCellValue('L1', 'With Documents?');
            $sheet->setCellValue('M1', 'Status');
            $sheet->setCellValue('N1', 'Travel Departure Date');
            $sheet->setCellValue('O1', 'Comment');
            $sheet->setCellValue('P1', 'Bordx No.');
            $sheet->setCellValue('Q1', 'Cashier');
            $sheet->setCellValue('R1', 'Booking Date');
            $sheet->setCellValue('S1', 'Booking Time');
            $sheet->setCellValue('T1', 'Doc Upload Date');
            $sheet->setCellValue('U1', 'Doc Upload Time');
            $sheet->setCellValue('V1', 'Completed Date');
            $sheet->setCellValue('W1', 'Completed Time');
            /*$sheet->setCellValue('X1', 'Create Date');*/
            $rows = 2;

            foreach ($result['data'] as $key => $value) {
                $sheet->setCellValue('A' . $rows, ucwords($value['inci_number']));
                $sheet->setCellValue('B' . $rows, ucwords($value['incident_assign'] ? $value['incident_assign']['user_code'] : '' ));
                $sheet->setCellValue('C' . $rows, ucwords($value['agent']['agent_key']));
                $sheet->setCellValue('D' . $rows, ucwords($value['agent']['first_name'] . ' ' . $value['agent']['last_name']));
                $sheet->setCellValue('E' . $rows, ucwords($value['inci_forex_card_no']));
                $sheet->setCellValue('F' . $rows, ucwords($value['inci_passport_number']));
                $transactionType = $value['transaction_type'];
                if($transactionType==1){
                    $transactionName = "Activation";
                } else if ($transactionType == '2') {
                    $transactionName = "Reload";
                } else if ($transactionType == '3') {
                    $transactionName = "Activation + Reload";
                } else{
                    $transactionName = "Encashment";
                }

                $sheet->setCellValue('G' . $rows, ucwords($transactionName));

                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $internationalCurrency = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $currencyType = $data['inci_currency_type'];
                        $internationalCurrency = $currencyType;
                    }

                }

                $sheet->setCellValue('H' . $rows, ucwords($internationalCurrency));
                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $amount = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $amount = $data['inci_frgn_curr_amount'];
                    }
                }
                $sheet->setCellValue('I' . $rows, ucwords($amount));

                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $rate = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $rate = $data['inci_currency_rate'];
                    }

                }
                $sheet->setCellValue('J' . $rows, ucwords($rate));
                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $inr_amount = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $inr_amount = $data['inci_inr_amount'];
                    }
                }
                $sheet->setCellValue('K' . $rows, ucwords($inr_amount));
                if (($value['buy_documents'] && count($value['buy_documents']) > 0) || ($value['sell_documents'] && count($value['sell_documents']) > 0)) {
                    $buyYesNo = 'Yes';
                } else {
                    $buyYesNo = 'No';
                }
                $sheet->setCellValue('L' . $rows, $buyYesNo);
                $acceptStatus = '';
                if (isset($value['inci_status']))
                    $acceptStatus = $value['inci_status'];
                if ($acceptStatus == '0')
                    $acceptStatusStr = 'Rejected';
                else if ($acceptStatus == '1')
                    $acceptStatusStr = 'Approved';
                else if ($acceptStatus == '2')
                    $acceptStatusStr = 'Expired';
                else
                    $acceptStatusStr = 'Under Process';
                $sheet->setCellValue('M' . $rows, $acceptStatusStr);
                $sheet->setCellValue('N' . $rows, ucwords($value['inci_departure_date']));
                $sheet->setCellValue('O' . $rows, isset($value['inci_status_message']) ? ucwords($value['inci_status_message']) : '');
                $sheet->setCellValue('P' . $rows, isset($value['bordox_no']) ? ucwords($value['bordox_no']) : '');
                $sheet->setCellValue('Q' . $rows, ucwords("Admin"));
                $sheet->setCellValue('R' . $rows, isset($value['inci_create_time']) ? date('d-m-Y', strtotime($value['inci_create_time'])) : '');
                $sheet->setCellValue('S' . $rows, isset($value['inci_create_time']) ? date('H:i:s', strtotime($value['inci_create_time'])) : '');
                $sheet->setCellValue('T' . $rows, isset($value['inci_recived_date']) ? date('d-m-Y', strtotime($value['inci_recived_date'])) : '');
                $sheet->setCellValue('U' . $rows, isset($value['inci_recived_time']) ? $value['inci_recived_time'] : '');
                $sheet->setCellValue('V' . $rows, isset($value['completed_at']) ? date('d-m-Y',strtotime($value['completed_at'])) : '');
                $sheet->setCellValue('W' . $rows, isset($value['completed_at']) ? date('h:i:s',strtotime($value['completed_at'])) : '');
                //$sheet->setCellValue('W' . $rows, date('d-m-Y', strtotime($value['created_at'])));
                $rows++;
            }

            $fileName = "reports.xlsx";
            $writer = new Xlsx($spreadsheet);
            $writer->save(public_path("filereport/" . $fileName));
            $path = url("filereport/" . $fileName);
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Success', 'data' => array('path' => $path)));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }  

    //Export Sell data
    public function tablesellDataExport(Request $request)
    {
        $input = $request->all();

        $query = Incident::with([
            'incidentUpdate',
            'incidentCurrency',
            'buyDocuments',
            'sellDocuments',
            'incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query) {
                $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
            }
        ])->where(['inci_status' => 3, 'inci_buy_sell_req' => 1, 'doc_type' => 1]);

        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_create_time', '>=', $from_date)->where('inci_create_time', '<=', $to_date);
            });
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_create_time', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_create_time', '=', $to_date);
            });
        }

        $result['data'] = $query->orderBy('id','DESC')->get()->toArray();
        //print_r($result); exit;
        if ($result) {

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Incident Number');
            $sheet->setCellValue('B1', 'TC User Name ');
            $sheet->setCellValue('C1', 'Agent Code');
            $sheet->setCellValue('D1', 'Agent Name');
            $sheet->setCellValue('E1', 'Card number');
            $sheet->setCellValue('F1', 'Passport No.');
            $sheet->setCellValue('G1', 'Transaction Type');
            $sheet->setCellValue('H1', 'FX Currency');
            $sheet->setCellValue('I1', 'FX Amount');
            $sheet->setCellValue('J1', 'FX Rate');
            $sheet->setCellValue('K1', 'INR Amount');
            $sheet->setCellValue('L1', 'With Documents?');
            $sheet->setCellValue('M1', 'Status');
            $sheet->setCellValue('N1', 'Travel Departure Date');
            $sheet->setCellValue('O1', 'Comment');
            $sheet->setCellValue('P1', 'Bordx No.');
            $sheet->setCellValue('Q1', 'Cashier');
            $sheet->setCellValue('R1', 'Booking Date');
            $sheet->setCellValue('S1', 'Booking Time');
            $sheet->setCellValue('T1', 'Doc Upload Date');
            $sheet->setCellValue('U1', 'Doc Upload Time');
            $sheet->setCellValue('V1', 'Completed Date');
            $sheet->setCellValue('W1', 'Completed Time');
            /*$sheet->setCellValue('X1', 'Create Date');*/
            $rows = 2;

            foreach ($result['data'] as $key => $value) {
                $sheet->setCellValue('A' . $rows, ucwords($value['inci_number']));
                $sheet->setCellValue('B' . $rows, ucwords($value['incident_assign'] ? $value['incident_assign']['user_code'] : '' ));
                $sheet->setCellValue('C' . $rows, ucwords($value['agent']['agent_key']));
                $sheet->setCellValue('D' . $rows, ucwords($value['agent']['first_name'] . ' ' . $value['agent']['last_name']));
                $sheet->setCellValue('E' . $rows, ucwords($value['inci_forex_card_no']));
                $sheet->setCellValue('F' . $rows, ucwords($value['inci_passport_number']));
                $transactionType = $value['transaction_type'];
                if($transactionType==1){
                    $transactionName = "Activation";
                } else if ($transactionType == '2') {
                    $transactionName = "Reload";
                } else if ($transactionType == '3') {
                    $transactionName = "Activation + Reload";
                } else{
                    $transactionName = "Encashment";
                }

                $sheet->setCellValue('G' . $rows, ucwords($transactionName));

                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $internationalCurrency = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $currencyType = $data['inci_currency_type'];
                        $internationalCurrency = $currencyType;
                    }

                }

                $sheet->setCellValue('H' . $rows, ucwords($internationalCurrency));
                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $amount = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $amount = $data['inci_frgn_curr_amount'];
                    }
                }
                $sheet->setCellValue('I' . $rows, ucwords($amount));

                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $rate = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $rate = $data['inci_currency_rate'];
                    }

                }
                $sheet->setCellValue('J' . $rows, ucwords($rate));
                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $inr_amount = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $inr_amount = $data['inci_inr_amount'];
                    }
                }
                $sheet->setCellValue('K' . $rows, ucwords($inr_amount));
                if (($value['buy_documents'] && count($value['buy_documents']) > 0) || ($value['sell_documents'] && count($value['sell_documents']) > 0)) {
                    $buyYesNo = 'Yes';
                } else {
                    $buyYesNo = 'No';
                }
                $sheet->setCellValue('L' . $rows, $buyYesNo);
                $acceptStatus = '';
                if (isset($value['inci_status']))
                    $acceptStatus = $value['inci_status'];
                if ($acceptStatus == '0')
                    $acceptStatusStr = 'Rejected';
                else if ($acceptStatus == '1')
                    $acceptStatusStr = 'Approved';
                else if ($acceptStatus == '2')
                    $acceptStatusStr = 'Expired';
                else
                    $acceptStatusStr = 'Under Process';
                $sheet->setCellValue('M' . $rows, $acceptStatusStr);
                $sheet->setCellValue('N' . $rows, ucwords($value['inci_departure_date']));
                $sheet->setCellValue('O' . $rows, isset($value['inci_status_message']) ? ucwords($value['inci_status_message']) : '');
                $sheet->setCellValue('P' . $rows, isset($value['bordox_no']) ? ucwords($value['bordox_no']) : '');
                $sheet->setCellValue('Q' . $rows, ucwords("Admin"));
                $sheet->setCellValue('R' . $rows, isset($value['inci_create_time']) ? date('d-m-Y', strtotime($value['inci_create_time'])) : '');
                $sheet->setCellValue('S' . $rows, isset($value['inci_create_time']) ? date('H:i:s', strtotime($value['inci_create_time'])) : '');
                $sheet->setCellValue('T' . $rows, isset($value['inci_recived_date']) ? date('d-m-Y', strtotime($value['inci_recived_date'])) : '');
                $sheet->setCellValue('U' . $rows, isset($value['inci_recived_time']) ? $value['inci_recived_time'] : '');
                $sheet->setCellValue('V' . $rows, isset($value['completed_at']) ? date('d-m-Y',strtotime($value['completed_at'])) : '');
                $sheet->setCellValue('W' . $rows, isset($value['completed_at']) ? date('h:i:s',strtotime($value['completed_at'])) : '');
                //$sheet->setCellValue('W' . $rows, date('d-m-Y', strtotime($value['created_at'])));
                $rows++;
            }

            $fileName = "reports.xlsx";
            $writer = new Xlsx($spreadsheet);
            $writer->save(public_path("filereport/" . $fileName));
            $path = url("filereport/" . $fileName);
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Success', 'data' => array('path' => $path)));
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
        return view('underprocessbookingrequest::create');
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
        return view('underprocessbookingrequest::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('underprocessbookingrequest::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
