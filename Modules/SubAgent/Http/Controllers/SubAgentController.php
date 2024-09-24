<?php

namespace Modules\SubAgent\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubAgentExport;
use Helper;

class SubAgentController extends Controller
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
        return view('subagent::index');
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $searchValue = $input['search_keywords']; // Search value
        $array = [
            'id', 'user_name', 'agent_code', 'email', 'agent_form', 'agent_to', 'mobile_number', 'parent_id', 'create_date','status'
        ];
        $column = $input['order'][0]['column'];
        $query = Agent::with('parent', 'createdBy', 'updatedBy')
            ->where('agent_type', '=', 'sub-agent')->where(function ($query) use ($searchValue) {
                $query->where('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('agent_code', 'like', '%' . $searchValue . '%');
            })->orderBy($array[$column], $input['order'][0]['dir']);

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
        $result = Agent::select('id', 'agent_key', 'user_name')->whereNull('parent_id')->where('status', 1)->get();
        $data['parents'] = $result;
        return view('subagent::modal.add')->with($data)->render();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'user_name' => 'required|max:30|unique:agents,user_name,NULL,id,deleted_at,NULL',
            'sub_agent_status' => 'required',
            'validity_from' => 'required|date|date_format:Y-m-d',
            'validity_till' => 'required|date|date_format:Y-m-d',
           // 'buy_margin' => 'required|numeric|between:0,99.99',
          //  'sell_margin' => 'required|numeric|between:0,99.99',
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'gender' => 'required',
            'mobile_number' => 'required|digits:10|unique:agents,mobile_number,NULL,id,deleted_at,NULL',
            'email' => 'required|max:50|unique:agents,email',
            'password' => 'required|same:emp_confirm_password',
            'profile' => 'nullable|max:2048|mimes:jpg,jpeg,png',
            'parent_agent' => 'required'
        ],
        [
            'password.same' => 'The password and confirm password must match.'
        ]);
        // profile upload
        if ($request->hasfile('profile')) {
            $profile = $request->agent_code . '_' . time() . '.' . $request->profile->extension();
            $request->profile->move(public_path('users/agent/profile/'), $profile);
            $input['profile'] = $profile;
        } else {
            $input['profile'] = NULL;
        }
        if (isset($request->parent_agent) && $request->parent_agent != '') {
            $input['parent_id'] = $request->parent_agent;
        }
        $input['agent_form'] = date('Y-m-d', strtotime($request->validity_from));
        $input['agent_to'] = date('Y-m-d', strtotime($request->validity_till));
		if($request->buy_margin!=""){
			$input['agent_buy'] = $request->buy_margin;
		}
		else{
			$input['agent_buy'] = '0';
		}
		
		if($request->sell_margin!=""){
			$input['agent_sell'] = $request->sell_margin;
		}
		else{
			$input['agent_sell'] = '0';
		}
        
        //$input['agent_sell'] = $request->sell_margin;
        $input['status'] = $request->sub_agent_status;
        $input['agent_key'] = $request->agent_code;
        $input['password'] = Hash::make($request->password);
        $input['created_by'] = Auth::id();
        unset($input['parent_agent']);
        unset($input['validity_from']);
        unset($input['validity_till']);
        unset($input['sub_agent_status']);
        unset($input['buy_margin']);
        unset($input['sell_margin']);
        unset($input['emp_confirm_password']);
        unset($input['_tokens']);
        $result = Agent::create($input);
        $message = 'Sub Agent successfully added.';
        if ($result) {
             $data = [
                 'subject' => 'Login Credentials',
                 'email' => $request->email,
                 'name' => $request->first_name,
                 'username' => $request->email,
                 'password' => $request->password,
                 'login_link' => 'https://uat-newbpc.bpcpartners.in/public/agent/login'
             ];
	    // Helper::sendMailCreateIncident($data['subject'],'Login Credentials',$data['email'],$data,'email.logintext');

            // Mail::send('email.logintext', $data, function ($msg) use ($data) {
            //     $msg->from('vetron.marketing@gmail.com', 'Thomas Cook');
            //     $msg->to($data['email']);
            //     $msg->subject($data['subject']);
            // });
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong!', 'data' => []));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('subagent::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $Agent = Agent::with('parent')->where('id', $id)->first();
        $parents = Agent::select('id', 'agent_key', 'user_name')->whereNull('parent_id')->where('status', 1)->get();
        $data['data'] = $Agent;
        $data['parents'] = $parents;
        return view('subagent::modal.edit')->with($data)->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $id = $request->id;
        $request->validate([
            'user_name' => 'required|max:30|unique:agents,user_name,' . $id . ',id,deleted_at,NULL',

            'agent_status' => 'required',
            'validity_from' => 'required|date|date_format:Y-m-d',
            'validity_till' => 'required|date|date_format:Y-m-d',
           // 'buy_margin' => 'required|numeric|between:0,99.99',
          //  'sell_margin' => 'required|numeric|between:0,99.99',
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'gender' => 'required',
            'mobile_number' => 'required|digits:10|unique:agents,mobile_number,' . $id . ',id,deleted_at,NULL',
            'email' => 'required|max:50|unique:agents,email,' . $id . ',id,deleted_at,NULL',
          //  'email' => 'required|max:50|unique:agents,email,NULL,id,deleted_at,' . $id . '',
            'password' => 'nullable|same:emp_confirm_password',
            'profile' => 'nullable|max:2048|mimes:jpg,jpeg,png',
        ]);
        // profile upload
        if ($request->hasfile('profile')) {
            $profile = $request->agent_code . '_' . time() . '.' . $request->profile->extension();
            $request->profile->move(public_path('users/agent/profile/'), $profile);
            $input['profile'] = $profile;
        } else {
            unset($input['profile']);
        }
        if (isset($request->parent_agent) && $request->parent_agent != '') {
            $input['parent_id'] = $request->parent_agent;
        }
        $input['agent_form'] = date('Y-m-d', strtotime($request->validity_from));
        $input['agent_to'] = date('Y-m-d', strtotime($request->validity_till));
		if($request->buy_margin!=""){
			$input['agent_buy'] = $request->buy_margin;
		}
		else{
			$input['agent_buy'] = '0';
		}
		
		if($request->sell_margin!=""){
			$input['agent_sell'] = $request->sell_margin;
		}
		else{
			$input['agent_sell'] = '0';
		}
        //$input['agent_buy'] = $request->buy_margin;
        //$input['agent_sell'] = $request->sell_margin;
        $input['status'] = $request->agent_status;
        $input['agent_key'] = $request->agent_code;
        if ($request->password != '') {
            $input['password'] = Hash::make($request->password);
        } else {
            unset($input['password']);
        }
        $input['updated_by'] = Auth::id();
        unset($input['parent_agent']);
        unset($input['validity_from']);
        unset($input['validity_till']);
        unset($input['agent_status']);
        unset($input['buy_margin']);
        unset($input['sell_margin']);
        unset($input['emp_confirm_password']);
        unset($input['_token']);
        $result = Agent::where('id', $id)->update($input);
        $message = 'Sub Agent successfully updated.';
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $result));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            Agent::where('id', $id)->delete();
            DB::commit();
            $message = 'Sub Agent deleted Successfully';
            if ($id) {
                return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
            } else {
                DB::rollback();
                return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('type' => 'ERROR', 'message' => $e->getMessage(), 'data' => []));
        }
    }

    public function getAgentData(Request $request)
    {
        $id = $request->parent_id;
        $result = Agent::select('id', 'agent_key', 'user_name', 'agent_buy', 'agent_sell')->where(['id' => $id, 'status' => 1])->first();
        return  json_encode($result);
    }

    //Update Status
    public function updateStatus(Request $request)
    {
        $subagent = Agent::find($request->id);
        $subagent->status = $request->status;
        $subagent->save();

        $message = 'Status updated successfully.';
        if ($subagent) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $request->status));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }
	   public function export() 
    {   
        return Excel::download(new SubAgentExport, 'subagent.csv');
    }
}
