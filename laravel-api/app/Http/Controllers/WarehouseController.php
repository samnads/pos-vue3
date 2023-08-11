<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Warehouse;
use DB;
use Illuminate\Http\Request;
use Validator;

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
                    ->join('countries', 'warehouses.country_id', '=', 'countries.id')
                    ->where('warehouses.name', 'LIKE', '%' . $search . '%')
                    ->orderBy($order_by, $order);
                $data["recordsFiltered"] = $data['data']->count();
                $data['data'] = $data['data']->skip($offset)
                    ->take($limit)
                    ->get(['warehouses.*', 'statuses.name as status_name', 'countries.name as country_name']);
                /****************************************************** */
                $data["draw"] = $request->input('draw');
                $data["recordsTotal"] = Warehouse::count();
                $data['success'] = true;
                return response()->json($data = $data, $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
                break;
            default:
        }
        switch ($request->input('dropdown')) {
            case 'status':
                $data['data'] = Status::where('warehouse_status', '=', 1)->get(['statuses.id', 'statuses.name']);
                $data['success'] = true;
                return response()->json($data = $data, $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Warehouse::unguard(true); // need to add code
        $id = DB::table('INFORMATION_SCHEMA.TABLES')->select('AUTO_INCREMENT as id')->where('TABLE_SCHEMA', \DB::connection()->getDatabaseName())->where('TABLE_NAME', 'warehouses')->first()->id;
        $data = array_merge($request->data, ['code' => sprintf("WH-%05s", $id)]);
        unset($data['created_at'], $data['updated_at'], $data['deleted_at']); // to prevent hijack
        /************************* VALIDATION ************************* */
        //$data['code'] = 'WH-00958';
        $nice_names = array(
            'status_id' => 'status',
        );
        $validator = Validator::make($data, [
            'code' => 'required|unique:warehouses,code|max:255',
            'email' => 'required|email|unique:warehouses,email|max:255',
            'status_id' => 'in:16,17,18,19',
        ], [], $nice_names);
        if ($validator->fails()) {
            return response()->json($data = array('success' => false, 'errors' => $validator->errors()), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
        /************************************************** */
        $insert = Warehouse::create($data);
        return response()->json($data = array('success' => true, 'type' => 'success', 'id' => $insert->id, 'message' => 'Successfully added new warehouse <strong><em>' . $data['name'] . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
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
        if ($warehouse->locked == null) {
            /************************* VALIDATION ************************* */
            $nice_names = array(
                'status_id' => 'status',
            );
            $validator = Validator::make($request->data, [
                'email' => 'required|email|unique:warehouses,email,' . $warehouse->id . '|max:255',
                'status_id' => 'in:16,17,18,19',
            ], [], $nice_names);
            if ($validator->fails()) {
                return response()->json($data = array('success' => false, 'errors' => $validator->errors()), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
            }
            /************************************************** */
            $warehouse->fill($request->data);
            $dirty = $warehouse->isDirty();
            $warehouse->save();
            if ($dirty) {
                return response()->json($data = array('success' => true, 'type' => 'success', 'id' => $warehouse->id, 'message' => 'Successfully updated warehouse <strong><em>' . $request['data']['db']['name'] . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
            }
            return response()->json($data = array('success' => true, 'type' => 'notice', 'id' => $warehouse->id, 'message' => 'Nothing Changed !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
        return response()->json($data = array('success' => false, 'type' => 'danger', 'id' => $warehouse->id, 'message' => 'Warehouse <strong><em>' . $warehouse->name . '</strong></em> is locked !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
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
        return response()->json($data = array('success' => true, 'type' => 'success', 'id' => $warehouse->id, 'message' => 'Successfully deleted warehouse <strong><em>' . $warehouse->name . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }
}
