<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        switch ($request->input('action')) {
            case 'datatable':
                $data = array();
                $limit = $request->input('length') <= 0 ? null : $request->input('length'); // limit
                $order_by = $request->input('columns')[$request->input('order')[0]['column']]['data']; // order by column
                $order = $request->input('order')[0]['dir']; // order asc or desc
                $search = $request->input('search')['value']; // search query
                $offset = $request->input('start'); // start position
                /****************************************************** */
                $data['data'] = Warehouse::join('statuses', 'warehouses.status_id', '=', 'statuses.id')
                    ->where('warehouses.name', 'LIKE', '%' . $search . '%')
                    ->orderBy($order_by, $order)
                    ->skip($offset)
                    ->take($limit)
                    ->get(['warehouses.*', 'statuses.name as status_name']);
                /****************************************************** */
                $data["draw"] = $request->input('draw');
                $data["recordsTotal"] = Warehouse::count();
                $data["recordsFiltered"] = $data['data']->count();
                $data['success'] = true;
                return response()->json($data = $data, $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
                break;
            case 'create':
                return response()->json($data = array(), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
                break;
            default:
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo 'create';

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        Warehouse::destroy($warehouse->id);
        return response()->json($data = array('success' => true, 'type' => 'success', 'id' => '$warehouse->id', 'message' => 'Successfully deleted warehouse <strong><em>' . $warehouse->name . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }
}
