<?php

namespace Modules\Roles\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Agent\Entities\Agent;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('roles::index');
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $array = ['id', 'name', 'guard_name', 'create_date'];
        $column = $input['order'][0]['column'];
        $query = Role::orderBy($array[$column], $input['order'][0]['dir']);
        $checkRole = DB::table('model_has_roles')->join('users', 'users.id', '=', 'model_has_roles.model_id')->where('users.deleted_at', NULL)->select('model_has_roles.role_id')->pluck('model_has_roles.role_id', 'model_has_roles.role_id')->all();

        $result['draw'] = $input['draw'];
        $result['recordsTotal'] = $query->count();
        $result['recordsFiltered'] = $query->count();
        $result['data'] = $query->skip($input['start'])->take($input['length'])->get()->toArray();
        if ($result) {
            return response()->json(array(
                'type' => 'SUCCESS', 'message' => 'Success', 'data' => $result['data'], 'checkRole' => $checkRole,
                'recordsTotal' => $result['recordsTotal'], 'recordsFiltered' => $result['recordsFiltered']
            ));
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
        $permission = array_chunk((Permission::orderBy('id')->pluck('id', 'name')->all()), 4, true);
        $data['permission'] = $permission;
        return view('roles::modal.add')->with($data)->render();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        $message = 'Role successfully added.';
        if ($role) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $role));
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
        $role = Role::find($id);
        $permission = array_chunk((Permission::orderBy('id')->pluck('id', 'name')->all()), 4, true);
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        $data['role'] = $role;
        $data['permission'] = $permission;
        $data['rolePermissions'] = $rolePermissions;
        return view('roles::modal.view')->with($data)->render();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = array_chunk((Permission::orderBy('id')->pluck('id', 'name')->all()), 4, true);
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        $data['role'] = $role;
        $data['permission'] = $permission;
        $data['rolePermissions'] = $rolePermissions;
        return view('roles::modal.edit')->with($data)->render();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        // Sync Permissions
        $role->syncPermissions($request->input('permission'));

        $message = 'Role successfully updated.';
        if ($role) {
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => $role));
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
            DB::table("roles")->where('id', $id)->delete();
            DB::commit();
            $message = 'Role deleted Successfully';
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
}
