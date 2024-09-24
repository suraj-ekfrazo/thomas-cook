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

class AgentDeletedController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('agent::deleted');
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $array = ['id', 'agent_key', 'user_name', 'password', 'profile', 'gender', 'agent_code', 'status', 'agent_form', 'agent_to',
        'agent_buy', 'agent_sell', 'first_name', 'last_name', 'mobile_number', 'email', 'email_verified_at',
        'agent_otp', 'agent_change_pass', 'remember_token', 'create_date'];
        $column = $input['order'][0]['column'];
        $query = Agent::onlyTrashed()->with('createdBy', 'updatedBy')->orderBy($array[$column], $input['order'][0]['dir']);

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
        $result = Agent::withTrashed()->where('id', $id)->first();
        $data['data'] = $result;
        return view('agent::modal.view')->with($data)->render();
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
            $Agent = Agent::withTrashed()->find($id);
            $Agent->update($input);

            DB::commit();
            $message = 'Agent reactivated Successfully';
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
