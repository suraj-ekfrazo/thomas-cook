<?php

namespace Modules\Holidays\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Holidays\Entities\Holiday;

class HolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('holidays::index');
    }

    public function api(Request $request) {
        return $request->user();
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $array = ['id', 'holiday_name', 'holiday_date', 'created_at', 'updated_at', 'action'];
        $column = $input['order'][0]['column'];
        $query = Holiday::orderBy($array[$column], $input['order'][0]['dir']);
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
        return view('holidays::modal.add');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function save(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'holiday_name' => 'required',
            'holiday_date' => 'required|date_format:Y-m-d',
        ]);
        unset($input['_tokens']);
        $result = Holiday::create($input);
        $message = 'Holiday successfully added.';
        if ($result) {
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
        return view('holidays::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $result = Holiday::where('id', $id)->first();
        $data['data'] = $result;
        return view('holidays::modal.edit')->with($data)->render();
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
        $request->validate([
            'holiday_name' => 'required',
            'holiday_date' => 'required|date_format:Y-m-d',
        ]);
        unset($input['_token']);
        $result = Holiday::where('id', $input['id'])->update($input);
        $message = 'Holiday successfully updated.';
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
            Holiday::where('id', $id)->delete();
            DB::commit();
            $message = 'Holiday deleted Successfully';
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
