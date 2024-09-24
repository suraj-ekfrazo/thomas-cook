<?php

namespace Modules\AdminIncidents\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminIncidents\Entities\Incident;
use Modules\AdminIncidents\Entities\IncidentUpdate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\DB;

class AdminIncidentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
      public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        return view('adminincidents::index');
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $searchValue = $input['search_keywords']; // Search value
        $array = [
            'id', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_comment', 'inci_up_bordx_no', 'inci_up_inc_key', 'inci_up_received_date', 'inci_up_date', 'inci_up_time', 'inci_up_received_date', 'inci_up_received_time', 'created_at'
        ];
        $column = $input['order'][0]['column'];
        $query = IncidentUpdate::with([
            'incident.incidentCurrency',
            'incident.buyDocuments',
            'incident.sellDocuments',
            'incident.incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            }, 'incident.agent' => function ($query) {
                $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
            }
        ])->where('inci_up_inc_key', 'like', '%' . $searchValue . '%')->orderBy($array[$column], $input['order'][0]['dir']);

        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_up_date', '>=', $from_date)->where('inci_up_date', '<=', $to_date);
            });
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_up_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_up_date', '=', $to_date);
            });
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

    //Report Summary
    public function reportSummary()
    {
        $IncidentBuy =  Incident::where('inci_buy_sell_req', 0)->whereDate('inci_create_time',date('Y-m-d'))->get()->count();
        $IncidentSell = Incident::where('inci_buy_sell_req', 1)->whereDate('inci_create_time',date('Y-m-d'))->get()->count();
        $IncidentSellBlockRate = Incident::where(['inci_buy_sell_req' => 1, 'doc_type' => 0])->whereDate('inci_create_time',date('Y-m-d'))->get()->count();
        $IncidentSellWithDoc = Incident::where(['inci_buy_sell_req' => 1, 'doc_type' => 1])->whereDate('inci_create_time',date('Y-m-d'))->get()->count();
        $IncidentPending = Incident::where('inci_status', 3)->whereDate('inci_create_time',date('Y-m-d'))->get()->count();
        $IncidentDeclined = Incident::where('inci_status', 0)->whereDate('inci_create_time',date('Y-m-d'))->get()->count();
        $IncidentAccepted = Incident::where('inci_status', 1)->whereDate('inci_create_time',date('Y-m-d'))->get()->count();
        return view('adminincidents::modal.report-summary', compact('IncidentBuy', 'IncidentSell', 'IncidentPending', 'IncidentDeclined', 'IncidentAccepted', 'IncidentSellBlockRate', 'IncidentSellWithDoc'));
    }
    public function reportSummaryTable(Request $request)
    {
        $query1 =  Incident::where('inci_buy_sell_req', 0);
        $query2 = Incident::where('inci_buy_sell_req', 1);
        $query3 = Incident::where(['inci_buy_sell_req' => 1, 'doc_type' => 0]);
        $query4 = Incident::where(['inci_buy_sell_req' => 1, 'doc_type' => 1]);
        $query5 = Incident::where('inci_status', 3);
        $query6 = Incident::where('inci_status', 0);
        $query7 = Incident::where('inci_status', 1);

        if ($request->from_date != '' && $request->to_date != '') {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));

            $query1->where(function ($query1) use ($from_date, $to_date) {
                $query1->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });

            $query2->where(function ($query2) use ($from_date, $to_date) {
                $query2->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
            $query3->where(function ($query3) use ($from_date, $to_date) {
                $query3->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
            $query4->where(function ($query4) use ($from_date, $to_date) {
                $query4->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
            $query5->where(function ($query5) use ($from_date, $to_date) {
                $query5->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
            $query6->where(function ($query6) use ($from_date, $to_date) {
                $query6->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
            $query7->where(function ($query7) use ($from_date, $to_date) {
                $query7->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
        } else if ($request->from_date != '' || $request->to_date != '') {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));

            $query1->where(function ($query1) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query1->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query1->Where('inci_recived_date', '=', $to_date);
            });
            $query2->where(function ($query2) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query2->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query2->Where('inci_recived_date', '=', $to_date);
            });
            $query3->where(function ($query3) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query3->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query3->Where('inci_recived_date', '=', $to_date);
            });
            $query4->where(function ($query4) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query4->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query4->Where('inci_recived_date', '=', $to_date);
            });
            $query5->where(function ($query5) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query5->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query5->Where('inci_recived_date', '=', $to_date);
            });
            $query6->where(function ($query6) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query6->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query6->Where('inci_recived_date', '=', $to_date);
            });
            $query7->where(function ($query7) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query7->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query7->Where('inci_recived_date', '=', $to_date);
            });
        }
        $IncidentBuy = $query1->get()->count();
        $IncidentSell = $query2->get()->count();
        $IncidentSellBlockRate = $query3->get()->count();
        $IncidentSellWithDoc = $query4->get()->count();
        $IncidentPending = $query5->get()->count();
        $IncidentDeclined = $query6->get()->count();
        $IncidentAccepted = $query7->get()->count();
        return view('adminincidents::modal.report-summary-table', compact('IncidentBuy', 'IncidentSell', 'IncidentPending', 'IncidentDeclined', 'IncidentAccepted', 'IncidentSellBlockRate', 'IncidentSellWithDoc'));
    }

    //Buy Report
    public function viewBuyReport()
    {
        return view('adminincidents::modal.buy-report');
    }

    public function buyReport(Request $request)
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
        ]);
        $query->where('inci_buy_sell_req', 0)->where('inci_number', 'like', '%' . $searchValue . '%')->orderBy($array[$column], $input['order'][0]['dir']);

        //Datatable search
        

        //Date filter
        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
        
            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
            
              


        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
            
        }
        if (!empty($searchValue)) {
            
            $query->orWhereHas('incidentAssign', function ($query) use ($searchValue) {
                $query->where('users.user_code', 'Like', '%' . $searchValue . '%');
            })->where('inci_buy_sell_req', 0);
            $query->orWhereHas('agent', function ($query) use ($searchValue) {
                $query->where('agents.agent_key', 'Like', '%' . $searchValue . '%')->orWhere('agents.first_name', 'Like', '%' . $searchValue . '%');
            })->where('inci_buy_sell_req', 0);

            $query->orWhere(function ($query) use ($searchValue) {
                $query->where('inci_forex_card_no', 'like', '%' . $searchValue . '%');
            });
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

    //Sell Report
    public function viewSellReport()
    {
        return view('adminincidents::modal.sell-report');
    }

    public function sellReport(Request $request)
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
        ])->where('inci_buy_sell_req', 1)->where('inci_number', 'like', '%' . $searchValue . '%')->orderBy($array[$column], $input['order'][0]['dir']);

        //Datatable search
        if (!empty($searchValue)) {
            $query->orWhereHas('incidentAssign', function ($query) use ($searchValue) {
                $query->where('users.user_code', 'Like', '%' . $searchValue . '%');
            })->where('inci_buy_sell_req', 1);
            $query->orWhereHas('agent', function ($query) use ($searchValue) {
                $query->where('agents.agent_key', 'Like', '%' . $searchValue . '%')->orWhere('agents.first_name', 'Like', '%' . $searchValue . '%');
            })->where('inci_buy_sell_req', 1);

            $query->orWhere(function ($query) use ($searchValue) {
                $query->where('inci_forex_card_no', 'like', '%' . $searchValue . '%');
            });
        }

        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
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

    //Tc User Report
    public function viewTcUserReport()
    {
        $data = User::with('roles')->role('TC user')->where('id', '!=', 1)->get()->toArray();
        return view('adminincidents::modal.tc-user-report', compact('data'));
    }

    public function tcUserReport(Request $request)
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
        ])->where('inci_number', 'like', '%' . $searchValue . '%')->orderBy($array[$column], $input['order'][0]['dir']);

        $tcuser = $input['tcuser_id'];
        if ($input['from_date'] != '' && $input['to_date'] != ''  && $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            })->where('inci_assignto', $tcuser)->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' && $input['to_date'] != '' && $input['tcuser_id'] == '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' && $input['to_date'] == '' && $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date, $tcuser) {
                $query->where('inci_recived_date', '=', $from_date);
                $query->Where('inci_assignto', '=', $tcuser);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] == '' && $input['to_date'] != '' && $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($to_date, $tcuser) {
                $query->Where('inci_recived_date', '=', $to_date);
                $query->Where('inci_assignto', '=', $tcuser);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] == '' && $input['to_date'] == '' && $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($tcuser) {
                $query->Where('inci_assignto', '=', $tcuser);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] == '' && $input['to_date'] != '' && $input['tcuser_id'] == '') {
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($to_date) {
                $query->Where('inci_recived_date', '=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' || $input['to_date'] != '' || $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date, $tcuser) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
                else if ($tcuser != '')
                    $query->Where('inci_assignto', '=', $tcuser);
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

    //Agent Report
    public function viewAgentReport()
    {
        $data = Agent::select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name')->get()->toArray();
        return view('adminincidents::modal.agent-report', compact('data'));
    }

    public function agentReport(Request $request)
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
        ])->where('inci_number', 'like', '%' . $searchValue . '%')->orderBy($array[$column], $input['order'][0]['dir']);

        $agent_id = $input['agent_id'];
        if ($input['from_date'] != '' && $input['to_date'] != ''  && $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            })->where('agent_id', $agent_id)->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' && $input['to_date'] != '' && $input['agent_id'] == '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' && $input['to_date'] == '' && $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date, $agent_id) {
                $query->where('inci_recived_date', '=', $from_date);
                $query->Where('agent_id', '=', $agent_id);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] == '' && $input['to_date'] != '' && $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($to_date, $agent_id) {
                $query->Where('inci_recived_date', '=', $to_date);
                $query->Where('agent_id', '=', $agent_id);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] == '' && $input['to_date'] == '' && $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($agent_id) {
                $query->Where('agent_id', '=', $agent_id);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] == '' && $input['to_date'] != '' && $input['agent_id'] == '') {
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($to_date) {
                $query->Where('inci_recived_date', '=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' || $input['to_date'] != '' || $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date, $agent_id) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
                else if ($agent_id != '')
                    $query->Where('agent_id', '=', $agent_id);
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

    //Export all data
    public function tableDataExport(Request $request)
    {
        $input = $request->all();
        $array = [
            'id', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_inc_key', 'inci_up_comment', 'inci_up_bordx_no', 'inci_up_inc_key', 'inci_up_received_date', 'inci_up_date', 'inci_up_time', 'inci_up_received_date', 'inci_up_received_time', 'created_at'
        ];
        $query = IncidentUpdate::with([
            'incident.incidentCurrency',
            'incident.buyDocuments',
            'incident.sellDocuments',
            'incident.incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            }, 'incident.agent' => function ($query) {
                $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
            }
        ]);

        if (isset($input['from_date']) || isset($input['to_date'])) {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            if ($from_date != '' && $to_date != '') {
                $query->where(function ($query) use ($from_date, $to_date) {
                    $query->where('inci_up_date', '>=', $from_date)->where('inci_up_date', '<=', $to_date);
                });
            } else if ($from_date != '' || $to_date != '') {
                $query->where(function ($query) use ($from_date, $to_date) {
                    if ($from_date != '')
                        $query->where('inci_up_date', '=', $from_date);
                    else if ($to_date != '')
                        $query->Where('inci_up_date', '=', $to_date);
                });
            }
        }

        $result['data'] = $query->get()->toArray();
        if ($result) {

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'TC User Name');
            $sheet->setCellValue('B1', 'Incident Number');
            $sheet->setCellValue('C1', 'Agent Code');
            $sheet->setCellValue('D1', 'Agent Name');
            $sheet->setCellValue('E1', 'Card number');
            $sheet->setCellValue('F1', 'Passport No.');
            $sheet->setCellValue('G1', 'Transaction Type');
            $sheet->setCellValue('H1', 'International Currency');
            $sheet->setCellValue('I1', 'Amount');
            $sheet->setCellValue('J1', 'Indian Currency');
            $sheet->setCellValue('K1', 'Amount');
            $sheet->setCellValue('L1', 'Rate');
            $sheet->setCellValue('M1', 'With Documents?');
            $sheet->setCellValue('N1', 'Status');
            $sheet->setCellValue('O1', 'Travel Departure Date');
            $sheet->setCellValue('P1', 'Comment');
            $sheet->setCellValue('Q1', 'Bordx No.');
            $sheet->setCellValue('R1', 'Cashier');
            $sheet->setCellValue('S1', 'Booking Date');
            $sheet->setCellValue('T1', 'Doc Upload Date');
            $sheet->setCellValue('U1', 'Doc Upload Time');
            $sheet->setCellValue('V1', 'Completed Date');
            $sheet->setCellValue('W1', 'Completed Time');
            /*$sheet->setCellValue('X1', 'Create Date');*/
            $rows = 2;

            foreach ($result['data'] as $key => $value) {
                $sheet->setCellValue('A' . $rows,ucwords($value['incident']['incident_assign'] ? $value['incident']['incident_assign']['user_code'] : '' ));
                $sheet->setCellValue('B' . $rows, ucwords($value['inci_up_inc_key']));
                $sheet->setCellValue('C' . $rows, ucwords($value['incident']['agent']['agent_key']));
                $sheet->setCellValue('D' . $rows, ucwords($value['incident']['agent']['first_name'] . ' ' . $value['incident']['agent']['last_name']));
                $sheet->setCellValue('E' . $rows, ucwords($value['incident']['inci_forex_card_no']));
                $sheet->setCellValue('F' . $rows, ucwords($value['incident']['inci_passport_number']));
                $transactionType = $value['incident']['transaction_type'];
                if ($transactionType == '0')
                    $transactionName = 'Reload';
                else if ($transactionType == '1')
                    $transactionName = 'Activation';
                else if ($transactionType == '2')
                    $transactionName = 'Refund';
                else
                    $transactionName = '';
                $sheet->setCellValue('G' . $rows, ucwords($transactionName));
                $sheet->setCellValue('H' . $rows, ucwords($value['incident']['inci_currency_type']));
                $sheet->setCellValue('I' . $rows, ucwords($value['incident']['inci_frgn_curr_amount']));
                $sheet->setCellValue('J' . $rows, "INR");
                $sheet->setCellValue('K' . $rows, ucwords($value['incident']['inci_inr_amount']));
                $sheet->setCellValue('L' . $rows, ucwords($value['incident']['inci_currency_rate']));
                if (($value['incident']['buy_documents'] && count($value['incident']['buy_documents']) > 0) || ($value['incident']['sell_documents'] && count($value['incident']['sell_documents']) > 0)) {
                    $buyYesNo = 'Yes';
                } else {
                    $buyYesNo = 'No';
                }
                $sheet->setCellValue('M' . $rows, $buyYesNo);
                $acceptStatus = $value['inci_up_accept_status'];
                if ($acceptStatus == '0')
                    $acceptStatusStr = 'Under Process';
                else if ($acceptStatus == '1')
                    $acceptStatusStr = 'Accepted';
                else if ($acceptStatus == '2')
                    $acceptStatusStr = 'Rejected';
                else
                    $acceptStatusStr = '';
                $sheet->setCellValue('N' . $rows, $acceptStatusStr);
                $sheet->setCellValue('O' . $rows, ucwords($value['incident']['inci_departure_date']));
                $sheet->setCellValue('P' . $rows, ucwords($value['inci_up_comment']));
                $sheet->setCellValue('Q' . $rows, ucwords($value['inci_up_bordx_no']));
                $sheet->setCellValue('R' . $rows, ucwords("Admin"));
                $sheet->setCellValue('S' . $rows, date('d-m-Y', strtotime($value['inci_up_date'])));
                $sheet->setCellValue('T' . $rows, date('d-m-Y', strtotime($value['inci_up_time'])));
                $sheet->setCellValue('U' . $rows, date('d-m-Y', strtotime($value['inci_up_received_date'])));
                $sheet->setCellValue('V' . $rows, date('d-m-Y', strtotime($value['inci_up_received_time'])));
                $sheet->setCellValue('W' . $rows, date('d-m-Y', strtotime($value['created_at'])));
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

    //Export Buy data
    public function tableBuyDataExport(Request $request)
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
        ])->where('inci_buy_sell_req', 0)->orderBy('inci_number', 'DESC');

        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
            });
        }

        $result['data'] = $query->get()->toArray();
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
    public function tableSellDataExport(Request $request)
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
        ])->where('inci_buy_sell_req', 1)->orderBy('inci_number', 'DESC');

        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
            });
        }
        $result['data'] = $query->get()->toArray();
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

    //Export Tc User data
    public function tableTcUserDataExport(Request $request)
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
        ])->orderBy('inci_number', 'DESC');

        $tcuser = $input['tcuser_id'];
        if ($input['from_date'] != '' && $input['to_date'] != ''  && $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            })->where('inci_assignto', $tcuser);
        } else if ($input['from_date'] != '' && $input['to_date'] != '' && $input['tcuser_id'] == '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
            });
        } else if ($input['from_date'] != '' && $input['to_date'] == '' && $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date, $tcuser) {
                $query->where('inci_recived_date', '=', $from_date);
                $query->Where('inci_assignto', '=', $tcuser);
            });
        } else if ($input['from_date'] == '' && $input['to_date'] != '' && $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($to_date, $tcuser) {
                $query->Where('inci_recived_date', '=', $to_date);
                $query->Where('inci_assignto', '=', $tcuser);
            });
        } else if ($input['from_date'] == '' && $input['to_date'] == '' && $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where(function ($query) use ($tcuser) {
                $query->Where('inci_assignto', '=', $tcuser);
            });
        } else if ($input['from_date'] == '' && $input['to_date'] != '' && $input['tcuser_id'] == '') {
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where(function ($query) use ($to_date) {
                $query->Where('inci_recived_date', '=', $to_date);
            });
        } else if ($input['from_date'] != '' || $input['to_date'] != '' || $input['tcuser_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where(function ($query) use ($from_date, $to_date, $tcuser) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
                else if ($tcuser != '')
                    $query->Where('inci_assignto', '=', $tcuser);
            });
        }


        $result['data'] = $query->get()->toArray();
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

    //Export Agent data
    public function tableAgentDataExport(Request $request)
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
        ])->orderBy('inci_number', 'DESC');

        $agent_id = $input['agent_id'];
        if ($input['from_date'] != '' && $input['to_date'] != ''  && $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_recived_date', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            })->where('agent_id', $agent_id);
        } else if ($input['from_date'] != '' && $input['to_date'] != '' && $input['agent_id'] == '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
            });
        } else if ($input['from_date'] != '' && $input['to_date'] == '' && $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date, $agent_id) {
                $query->where('inci_recived_date', '=', $from_date);
                $query->Where('agent_id', '=', $agent_id);
            });
        } else if ($input['from_date'] == '' && $input['to_date'] != '' && $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($to_date, $agent_id) {
                $query->Where('inci_recived_date', '=', $to_date);
                $query->Where('agent_id', '=', $agent_id);
            });
        } else if ($input['from_date'] == '' && $input['to_date'] == '' && $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where(function ($query) use ($agent_id) {
                $query->Where('agent_id', '=', $agent_id);
            });
        } else if ($input['from_date'] == '' && $input['to_date'] != '' && $input['agent_id'] == '') {
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where(function ($query) use ($to_date) {
                $query->Where('inci_recived_date', '=', $to_date);
            });
        } else if ($input['from_date'] != '' || $input['to_date'] != '' || $input['agent_id'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));
            $query->where(function ($query) use ($from_date, $to_date, $agent_id) {
                if ($from_date != '')
                    $query->where('inci_recived_date', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_recived_date', '=', $to_date);
                else if ($agent_id != '')
                    $query->Where('agent_id', '=', $agent_id);
            });
        }
        $result['data'] = $query->get()->toArray();

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
	

    public function unassigned()
    {
        return view('adminincidents::unassigned');
    }

    public function tableDataUnassigned(Request $request)
    {
        $input = $request->all();
        $array = [
            'id', 'inci_number', 'inci_number', 'created_at'
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
        ])->where('inci_assign_status', 0)->orderBy($array[$column], $input['order'][0]['dir']);

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

    public function getIncidentDetails(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->incident) && $request->incident != '') {
                $incident = $request->get('incident');
                $incidentDetails = Incident::with('incidentUpdate', 'incidentCurrency', 'incidentAssign', 'agent')->where('inci_number', $incident)->first();
                if ($incidentDetails) {
                    return response()->json([
                        'data' => $incidentDetails
                    ], 200);
                } else {
                    return response()->json([
                        'error' => "Incident details not found!"
                    ], 400);
                }
            } else {
                return response()->json([
                    'error' => "Invalid request"
                ], 400);
            }
        } else {
            return response()->json([
                'error' => "Invalid request"
            ], 400);
        }
    }

     //Tc User Report
    public function viewTcUserSummaryReport()
    {
	$data = User::with('roles')->role('TC user')->where('id', '!=', 1)->get()->toArray();
        return view('adminincidents::modal.tc-user-summary-report', compact('data'));
    }

    public function tcUserSummaryReport(Request $request)
    {
        $input = $request->all();
        
        $searchValue = $input['search_keywords'];
        
        
        $query = Incident::select([
            'inci_assignto',
            DB::raw('COUNT(CASE WHEN inci_assign_status = "1" THEN 1 ELSE 0 END) as assigned_count'),
            DB::raw('COUNT(CASE WHEN inci_status = "1" THEN 1 END) as approved_count'),
            DB::raw('COUNT(CASE WHEN inci_status = "0" THEN 1 END) as rejected_count'),
            DB::raw('COUNT(CASE WHEN inci_status = "3" THEN 1 END) as pending_count'),
            DB::raw('COUNT(CASE WHEN TIME(inci_create_time) > "19:00:00" THEN 1 END) as after7_count'),
            DB::raw('COUNT(CASE WHEN TIME(inci_create_time) < "19:00:00" THEN 1 END) as before7_count'),

        ])->with([
            'incidentAssign' => function ($query) {
                $query->select('id', 'name', 'email')->withTrashed();
            }
        ]);
        if ($input['from_date'] != 'null' && $input['to_date'] != 'null') {
            $query->whereDate('inci_create_time', '>=', date('Y-m-d',strtotime($input['from_date'])));
            $query->whereDate('inci_create_time', '<=', date('Y-m-d',strtotime($input['to_date'])));
        }
        else{
            $query->whereDate('inci_create_time', date('Y-m-d'));
        }
        
        
        $query->groupBy('inci_assignto');
        //print_r(json_encode(count($query->get())));exit;
        /*print_r(json_encode($query->get()->toArray()));
        echo $query->count();
        exit;*/

        $result['draw'] = $input['draw'];
        $result['recordsTotal'] = $query->get()->count();
        $result['recordsFiltered'] = $query->get()->count();
        $result['data'] = $query->skip($input['start'])->take($input['length'])->get()->toArray();

        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Success', 'data' => $result['data'], 'recordsTotal' => $result['recordsTotal'], 'recordsFiltered' => $result['recordsFiltered']));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }
}
