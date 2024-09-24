<?php

namespace Modules\CurrentRate\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CurrentRateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('currentrate::index');
    }

    
    public function tableData(Request $request)
    { {
            $input = $request->all();
            $searchValue = $input['search_keywords']; // Search value
            $array = ['cur_id ', 'currency_name_key', 'cur_bye', 'cur_sell', 'datetime'];
            $column = $input['order'][0]['column'];
            $query = DB::table('currency')->where('currency_name_key', 'like', '%' . $searchValue . '%')->orderBy('cur_id', 'asc');

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
        
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('currentrate::create');
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
        return view('currentrate::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('currentrate::edit');
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
