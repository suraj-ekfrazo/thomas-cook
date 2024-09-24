<?php

namespace Modules\TcUser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TcUserExport;
use Helper;

class TcUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('tcuser::index');
    }

    public function getAgent(Request $request)
    {
        return $request->user();
    }

    public function tableData(Request $request)
    {
        $input = $request->all();

        $searchValue = $input['search_keywords']; // Search value

        $array = ['id','id', 'name', 'email','email', 'created_at','status'];
        $column = $input['order'][0]['column'];
        $query = User::with('roles', 'createdBy', 'updatedBy')->role('Tc user')
            ->where('id', '!=', 1)->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like',  '%' . $searchValue . '%');
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
        $roles = Role::pluck('name', 'name')->all();
        $data['data']['roles'] = $roles;
        $data['data']['id'] = Auth::id();
        return view('tcuser::modal.add')->with($data)->render();
    }

    public function checkName(Request $request)
    {
        // return $request->username;
        if (isset($request->name)) {
            $username = ['name'];
            $count =  User::where('name', '=', $request->name)->count();
            if ($count > 0) {
                $response = "<span style='color: red;'>Already Taken.</span>";
            } else {
                $response = "<span style='color: green;'>Not Taken.</span>";
            }
            echo $response;
            exit;
        }
           
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
            'name' => 'required|max:50|unique:users,name,NULL,id,deleted_at,NULL',
            'user_code' => 'required|max:20|unique:users,user_code,NULL,id,deleted_at,NULL',
            'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:6',
            'user_mobile' => 'required|digits:10|numeric|unique:users,user_mobile,NULL,id,deleted_at,NULL',
            'gender' => 'required',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'user_status' => 'required',
            'tc_type' => 'required',
            'user_profile' => 'nullable|max:2048|mimes:jpg,jpeg,png',

        ],
        [
            'name.required' => 'The user Name field is required.',
            'user_code.required' => 'The user id field is required.',
            'user_mobile.required' => 'The mobile number field is required.',
            'user_status.required' => 'The status field is required.'
        ]);
        //profile upload
        if ($request->hasfile('user_profile')) {
            $profile = 'admin_' . time() . '.' . $request->user_profile->extension();
            $request->user_profile->move(public_path('users/admin/profile/'), $profile);
            $input['user_profile'] = $profile;
        } else {
            $input['user_profile'] = NULL;
        }
        
      
        $input['tc_type'] = implode(',', $request->tc_type);
       $input['status'] = $request->user_status;
        $input['password'] = Hash::make($request->password);
        $input['created_by'] = Auth::id();
        unset($input['user_status']);

        unset($input['_tokens']);
        $User = User::create($input);
        $User->assignRole($request->input('roles'));

        $message = 'User successfully added.';
        if ($User) {
            $data = [
                'subject' => 'Login Credentials',
                'email' => $request->email,
                'name' => $request->name,
                'username' => $request->name,
                'password' => $request->password,
                'login_link' => 'https://newbpc.bpcpartners.in/public/tcuser/login'
            ];
            /*Mail::send('email.logintext', $data, function ($msg) use ($data) {
                $msg->from('vetron.marketing@gmail.com', 'Thomas Cook');
                $msg->to($data['email']);
                $msg->subject($data['subject']);
            });*/
	    Helper::sendMailCreateIncident($data['subject'],'Login Credentials',$data['email'],$data,'email.logintext');
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $User));
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
        return view('tcuser::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::where('name', '!=', 'Superadmin')->pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name');

        $data['data'] = $user;
        $data['roles'] = $roles;
        $data['userRole'] = $userRole[0];
        return view('tcuser::modal.edit')->with($data)->render();
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
            'name' => 'required|max:50|unique:users,name,' . $id . ',id,deleted_at,NULL',
            'user_code' => 'required|max:20|unique:users,user_code,' . $id . ',id,deleted_at,NULL',
            'gender' => 'required',
            'user_mobile' => 'numeric|digits:10|unique:users,user_mobile,' . $id . ',id,deleted_at,NULL',
            //'email' => 'required|unique:users,email,NULL,id,deleted_at,' . $id . '',. $id . ',id,deleted_at,NULL',
            'email' => 'required|unique:users,email,' . $id . ',id,deleted_at,NULL',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:20',
	        'password' => 'nullable|same:emp_confirm_password',
            'user_status' => 'required',
            'user_profile' => 'nullable',
            'tc_type' => 'required'
        ]);
    
    
        
        //profile upload
        if ($request->hasfile('user_profile')) {
            $profile = 'admin_' . time() . '.' . $request->user_profile->extension();
            $request->user_profile->move(public_path('users/admin/profile/'), $profile);
            $input['user_profile'] = $profile;
        } else {
            unset($input['user_profile']);
        }
        
        
        $input['tc_type'] = implode(',', $request->tc_type);
        $input['status'] = $request->agent_status;
        $input['agent_key'] = $request->agent_code;
        if ($request->password != '') {
            $input['password'] = Hash::make($request->password);
        } else {
            unset($input['password']);
        }
        $input['status'] = $request->user_status;
        $input['password'] = Hash::make($request->password);
        $input['updated_by'] = Auth::id();
        unset($input['user_status']);
        unset($input['_tokens']);
         
        $User = User::find($request->id);
        $User->update($input);

        $message = 'User successfully updated.';
        if ($User) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $User));
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
            User::where('id', $id)->delete();
            User::where('id', $id)->update(['updated_by' => Auth::id()]);
            DB::commit();
            $message = 'User deleted Successfully';
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

    //Update status
    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        $message = 'Status updated successfully.';
        if ($user) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $request->status));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }
	
	 public function export() 
    {
        return Excel::download(new TcUserExport, 'tcuser.csv');
    }
}
