<?php

namespace Modules\AdminUsers\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Agent\Entities\Agent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use Helper;

class AdminUsersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    // function __construct()
    // {
    //     $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('adminusers::index');
    }

    public function getAgent(Request $request)
    {
        return $request->user();
    }


    public function tableData(Request $request)
    {
        $input = $request->all();

        $searchValue = $input['search_keywords']; // Search value

        $array = ['id', 'name', 'user_code', 'user_mobile', 'email', 'email_verified_at', 'user_profile', 'create_date'];
        $column = $input['order'][0]['column'];
        $query = User::with('roles', 'createdBy', 'updatedBy')->role('Admin')->where('id', '!=', 1)->where('name', 'like', '%' . $searchValue . '%')->orderBy($array[$column], $input['order'][0]['dir']);

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
        $data['roles'] = $roles;
        return view('adminusers::modal.add')->with($data)->render();
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
            'name' => 'required|max:30|unique:users,name,NULL,id,deleted_at,NULL',
            'user_code' => 'required|max:20|unique:users,user_code,NULL,id,deleted_at,NULL',
            'email' => 'required|max:50|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required',
            'gender' => 'required',
            'user_mobile' => 'required|numeric|digits:10|unique:users,user_mobile,NULL,id,deleted_at,NULL',
            'user_profile' => 'nullable|max:2048|mimes:jpg,jpeg,png',
            'user_status' => 'required',
            //'first_name' => 'required|max:20',
            //'last_name' => 'required|max:20',
            //'roles' => 'required',


        ],[
            'name.required' => 'The user Name is required.',
            'name.unique' => 'The user name has already been taken.',
            'user_code.required' => 'The user id field is required.',
            'user_code.unique' => 'The user id has already been taken.',
            'user_mobile.required' => 'The mobile number is required.',
            'user_mobile.unique' => 'The user mobile number has already been taken.',
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
        $input['status'] = $request->user_status;
        $input['password'] = Hash::make($request->password);
        $input['created_by'] = Auth::id();
        unset($input['user_status']);
        //unset($input['emp_confirm_password']);
        unset($input['_tokens']);
        $User = User::create($input);
        $User->assignRole($request->input('roles'));

        $message = 'Admin successfully added.';
        if ($User) {
            $data = [
                'subject' => 'Login Credentials',
                'email' => $request->email,
                'name' => $request->name,
                'username' => $request->email,
                'password' => $request->password,
                'login_link' => 'https://newbpc.bpcpartners.in/public/login'
            ];
	//Helper::sendMailCreateIncident($data['subject'],'Login Credentials',$data['email'],$data,'email.logintext');

            /*Mail::send('email.logintext', $data, function ($msg) use ($data) {
                $msg->from('vetron.marketing@gmail.com', 'Thomas Cook');
                $msg->to($data['email']);
                $msg->subject($data['subject']);
            });*/
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
        $result = User::with('roles')->where('id', $id)->first();
        $data['data'] = $result;
        return view('adminusers::modal.view')->with($data)->render();
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
        return view('adminusers::modal.edit')->with($data)->render();
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
            'name' => 'required|max:30|unique:users,name,' . $id . ',id,deleted_at,NULL',
            'user_code' => 'required|max:20|unique:users,user_code,' . $id . ',id,deleted_at,NULL',
            // 'user_status' => 'required',
            // 'first_name' => 'required|max:20',
            // 'last_name' => 'required|max:20',
            // 'roles' => 'required',
            'gender' => 'required',
            'user_mobile' => 'numeric|digits:10|unique:users,user_mobile,' . $id . ',id,deleted_at,NULL',
            'email' => 'required|max:30|unique:users,email,NULL,id,deleted_at,' . $id . '',
            //'password' => 'same:emp_confirm_password',
            'user_profile' => 'nullable',
        ]);
        // profile upload
        if ($request->hasfile('user_profile')) {
            $profile = 'admin_' . time() . '.' . $request->user_profile->extension();
            $request->user_profile->move(public_path('users/admin/profile/'), $profile);
            $input['user_profile'] = $profile;
        } else {
            unset($input['user_profile']);
        }
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
        // unset($input['emp_confirm_password']);
        unset($input['_tokens']);

        $User = User::find($request->id);
        $User->update($input);
        // DB::table('model_has_roles')->where('model_id', $id)->delete();
        // $User->assignRole($request->input('roles'));

        $message = 'Admin successfully updated.';
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
}
