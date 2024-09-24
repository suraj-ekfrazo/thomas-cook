<?php

namespace Modules\BookingAllocation\Http\Controllers;

use App\Models\Agents;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminIncidents\Entities\Incident;
use Illuminate\Support\Facades\DB;

use App\User;

class BookingAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
	$data_agent = Agents::get()->toArray();
        return view('bookingallocation::index',compact('data_agent'));
    }

    public function tableData(Request $request)
    {
        $input = $request->all();

        $searchValue = $input['search_keywords']; // Search value

        $array = ['id', 'inci_number','inci_buy_sell_req','inci_departure_date'];
        $column = $input['order'][0]['column'];
        $query = Incident::with([
	    'agent',
            'incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            },
        ]);
	$query->Where('incidents.inci_status','!=','1');

	//->where('incidents.inci_status', 3)->orderBy($array[$column], $input['order'][0]['dir'])->where('inci_status','!=','1')->orderBy('inci_inr_amount', 'desc')->orderBy('inci_recived_date', 'desc')->orderBy('inci_recived_time', 'desc');        
// 	if($searchValue) {
//             $query->Where(function($queryData) use ($searchValue){
//                 $queryData->where('inci_number', '=',$searchValue);
//                 //$queryData->Where('inci_departure_date', 'like', '%' . $searchValue . '%');
//             });
            
//         }

$query->where('inci_number', 'like', '%' . $searchValue . '%');


	/*if($searchValue!="") {
                $query->where('inci_number', 'like', '%' . $searchValue . '%');
            }*/

            if ((isset($input['from_date']) && $input['from_date'] != 'null') && (isset($input['to_date']) && $input['to_date'] != 'null')) {
                $query->whereDate('created_at', '>=', date('Y-m-d',strtotime($input['from_date'])));
                $query->whereDate('created_at', '<=', date('Y-m-d',strtotime($input['to_date'])));
            }
            if (isset($input['type']) && $input['type'] != 'null') {
                $query->where('inci_buy_sell_req',  $input['type']);
            }
	    if (isset($input['agent_id']) && $input['agent_id'] != 'null') {
            	$query->where('agent_id',  $input['agent_id']);
            }
            // $query->orderBy('inci_inr_amount', 'desc')->orderBy('inci_recived_date', 'desc')->orderBy('inci_recived_time', 'desc');
            
            $query->orderBy($array[$column], $input['order'][0]['dir']);
	

	    /*$query->WhereHas('incidentAssign', function ($query) use ($searchValue) {
		if($searchValue!="")
		{
            
	    		$query->where('users.name', 'Like', '%' . $searchValue . '%');
		}
        });*/

	/*if($searchValue) {
            $query->orWhere(function($queryData) use ($searchValue){
                $queryData->where('inci_number', 'like', '%' . $searchValue . '%');
                $queryData->orWhere('inci_departure_date', 'like', '%' . $searchValue . '%');
            });
            
        }*/
        $result['data'] = array();
        $result['draw'] = $input['draw'];
        $result['recordsTotal'] = $query->count();
        $result['recordsFiltered'] = $query->count();
        // $result['data'] = $query->skip($input['start'])->take($input['length'])->get()->toArray();

        $allUsers = User::where('login_status','=','1')->where('status','1')->with('roles')->role('TC User')->get()->toArray();
        $demo = $query->skip($input['start'])->take($input['length'])->get()->toArray();
        foreach ($demo as $key => $value) {
            $result['data'][$key]['inci_number'] = $value['inci_number'];
	    $result['data'][$key]['inci_departure_date'] = $value['inci_departure_date'];
            $result['data'][$key]['inci_buy_sell_req'] = $value['inci_buy_sell_req'];
            $result['data'][$key]['inci_assign_name'] = isset($value['incident_assign']['name']) ? $value['incident_assign']['name'] : '';
            $result['data'][$key]['userid'] = isset($value['incident_assign']['id']) ? $value['incident_assign']['id'] : '';
            $result['data'][$key]['allUsers'] = $allUsers;
	    $result['data'][$key]['agent'] = $value['agent'];
        }
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Success', 'data' => $result['data'], 'recordsTotal' => $result['recordsTotal'], 'recordsFiltered' => $result['recordsFiltered']));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    public function updateAssignedUser(Request $request)
    {
        $tcuser_id = $request->tcuser_id;
        $inci_number = $request->inci_number;

        $incident = Incident::where("inci_number", $inci_number)->update(['inci_assignto' => $tcuser_id, 'inci_assign_status' => 1]);
        $message = 'Updated Successfully';
        if ($incident) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $incident));
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
        return view('bookingallocation::create');
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
        return view('bookingallocation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('bookingallocation::edit');
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
