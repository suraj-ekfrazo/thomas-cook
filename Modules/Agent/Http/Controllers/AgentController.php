<?php

namespace Modules\Agent\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AgentExport;
use Helper;
use Illuminate\Validation\Rule;

use App\Imports\ImportAgents;

class AgentController extends Controller
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
        return view('agent::index');
    }

    public function getAgent(Request $request)
    {
        return $request->user();
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $searchValue = $input['search_keywords']; // Search value
        $array = [
            'id', 'user_name', 'agent_code', 'email', 'agent_form', 'agent_to',
            'mobile_number', 'create_date'
        ];
        $column = $input['order'][0]['column'];
        $query = Agent::with('parent', 'createdBy', 'updatedBy')
            ->where('agent_type', '!=', 'sub-agent')->orWhereNull('agent_type')->where(function ($query) use ($searchValue) {
                $query->where('user_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('agent_code', 'like', '%' . $searchValue . '%');
            })->orderBy($array[$column], $input['order'][0]['dir']);
            
        //   echo   $rawSql = vsprintf(str_replace(['?'], ['\'%s\''], $query->toSql()), $query->getBindings());
        //   die;


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
        return view('agent::modal.add')->with($data)->render();
    }

    public function checkAgentName(Request $request)
    {
        // return $request->username;
        if (isset($request->name)) {

            $count =  Agent::where('user_name', '=', $request->name)->count();

            if ($count > 0) {
                $response = "<span style='color: red;'>Already Taken.</span>";
            } else {
                $response = "<span style='color: green;'>Not Taken.</span>";
            }
            echo $response;
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function save(Request $request)
    {
        // $loginUser = User::find(Auth::id());
        $input = $request->all();
        $request->validate([
            'user_name' => 'required|max:30|unique:agents,user_name,NULL,id,deleted_at,NULL',
            'agent_code' => 'required|max:20',
            'agent_status' => 'required',
            'validity_from' => 'required|date|date_format:Y-m-d',
            'validity_till' => 'required|date|date_format:Y-m-d',
          //  'buy_margin' => 'required|numeric|between:0,99.99',
          //  'sell_margin' => 'required|numeric|between:0,99.99',
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'gender' => 'required',
            'mobile_number' => 'required|digits:10|unique:agents,mobile_number,NULL,id,deleted_at,NULL',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:agents,email,NULL,id,deleted_at,NULL',
            'password' => 'required|same:emp_confirm_password',
            'profile' => 'nullable|max:2048|mimes:jpg,jpeg,png',
        ],
        [
            'agent_code.required' => 'The BPC ID field is required.',
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
        //$input['agent_buy'] = $request->buy_margin;
        //$input['agent_sell'] = $request->sell_margin;
        $input['status'] = $request->agent_status;
        $input['agent_key'] = $request->agent_code;
        $input['password'] = Hash::make($request->password);
        $input['created_by'] = Auth::id();
        unset($input['parent_agent']);
        unset($input['validity_from']);
        unset($input['validity_till']);
        unset($input['agent_status']);
        unset($input['buy_margin']);
        unset($input['sell_margin']);
        unset($input['emp_confirm_password']);
        unset($input['_tokens']);
        $result = Agent::create($input);
        $message = 'Agent successfully added.';
        if ($result) {

            $data = [
                'subject' => 'Login Credentials',
                'email' => $request->email,
                'name' => $request->first_name,
                'username' => $request->user_name,
                'password' => $request->password,
                'login_link' => 'https://newbpc.bpcpartners.in/public/agent/login'
            ];
//	Helper::sendMailCreateIncident($data['subject'],'Login Credentials',$data['email'],$data,'email.logintext');

            /*Mail::send('email.logintext', $data, function ($msg) use ($data) {
                $msg->from('vetron.marketing@gmail.com', 'Thomas Cook');
                $msg->to($data['email']);
                $msg->subject($data['subject']);
            });*/
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
        $result = Agent::with('parent')->where('id', $id)->first();
        $data['data'] = $result;
        return view('agent::modal.view')->with($data)->render();
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
        return view('agent::modal.edit')->with($data)->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        // $loginUser = User::find(Auth::id());
        $input = $request->all();
        $id = $request->id;
        $request->validate([
            'user_name' => 'required|max:30|unique:agents,user_name,' . $id . ',id,deleted_at,NULL',
            'agent_code' => 'required|max:20',
            'agent_status' => 'required',
            'validity_from' => 'required|date|date_format:Y-m-d',
            'validity_till' => 'required|date|date_format:Y-m-d',
           // 'buy_margin' => 'required|numeric|between:0,99.99',
           // 'sell_margin' => 'required|numeric|between:0,99.99',
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'gender' => 'required',
            'mobile_number' => 'required|digits:10|unique:agents,mobile_number,' . $id . ',id,deleted_at,NULL',
            'email' => 'required|unique:agents,email,' . $id . ',id,deleted_at,NULL',
           // 'email' => 'required|unique:agents,email,NULL,id,deleted_at,' . $id . '',
            'password' => 'nullable|same:emp_confirm_password',
            'profile' => 'nullable|max:2048|mimes:jpg,jpeg,png',
        ],
        [
            'agent_code.required' => 'The BPC ID field is required.'
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
        $message = 'Agent successfully updated.';
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
            $message = 'Agent deleted Successfully';
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

    //Update Status
    public function updateStatus(Request $request)
    {
        $agent = Agent::find($request->id);
        $agent->status = $request->status;
        $agent->save();

        $message = 'Status updated successfully.';
        if ($agent) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $request->status));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }
	 public function export() 
    {
       
        return Excel::download(new AgentExport, 'agent.csv');
    }
    
    // Import agent functionality

   public function importView(Request $request){
        
        return view('agent::importFile');
    }

    public function import(Request $request){

          $file=$request->hasFile('file');

        
        if ($request->hasFile('file')) {
             //$successarray = new ImportAgents->getRowCount();
            Excel::import(new ImportAgents, $request->file('file')->store('temp'));
            
            //return redirect()->back();

            return response()->json(array('type' => 'SUCCESS', 'message' => 'Excel Data Get successfully', 'data' => []));

        }
    }
}
