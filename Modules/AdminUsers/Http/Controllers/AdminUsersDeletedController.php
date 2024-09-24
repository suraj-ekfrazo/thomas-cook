<?php

namespace Modules\AdminUsers\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminUsersDeletedController extends Controller
{
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
        return view('adminusers::deleted');
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $array = ['id', 'name', 'user_code', 'user_mobile', 'email', 'email_verified_at', 'user_profile', 'create_date'];
        $column = $input['order'][0]['column'];
        $query = User::onlyTrashed()->with('roles', 'createdBy', 'updatedBy')
                    ->where('id', '!=', 1)->orderBy($array[$column], $input['order'][0]['dir']);

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
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $result = User::withTrashed()->with('roles')->where('id', $id)->first();
        $data['data'] = $result;
        return view('adminusers::modal.view')->with($data)->render();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function reactive($id)
    {
        try {
            $input['updated_by'] = Auth::id();
            $input['deleted_at'] = NULL;
            $User = User::withTrashed()->find($id);
            $User->update($input);

            DB::commit();
            $message = 'User activated successfully.';
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
