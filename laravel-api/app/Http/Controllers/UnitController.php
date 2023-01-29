<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Validator;

class UnitController extends Controller
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
                $data['data'] = Unit::leftJoin('units as bu', 'units.base', '=', 'bu.id')
                    ->where('units.name', 'LIKE', '%' . $search . '%')
                    ->orderBy($order_by, $order);
                $data["recordsFiltered"] = $data['data']->count();
                $data['data'] = $data['data']->skip($offset)
                    ->take($limit)
                    ->get(['units.*', 'bu.name as base_name', 'bu.code as base_code']);
                /****************************************************** */
                $data["draw"] = $request->input('draw');
                $data["recordsTotal"] = Unit::count();
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
        $data = $request->data;
        $data['allow_decimal'] = $data['allow_decimal'] == 0 ? null : 1;
        unset($data['created_at'], $data['updated_at'], $data['deleted_at']); // to prevent hijack
        /************************* VALIDATION ************************* */
        $nice_names = array(
        );
        $validator = Validator::make($data, [
            'code' => 'required|unique:units,code|max:255',
            'name' => 'required|unique:units,name|max:255',
        ], [], $nice_names);
        if ($validator->fails()) {
            return response()->json($data = array('success' => false, 'errors' => $validator->errors()), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
        /************************************************** */
        $insert = Unit::create($data);
        return response()->json($data = array('success' => true, 'type' => 'success', 'id' => $insert->id, 'message' => 'Successfully added new unit <strong><em>' . $data['name'] . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        if ($unit->locked == null) {
            /************************* VALIDATION ************************* */
            $nice_names = array(
            );
            $validator = Validator::make($request->data, [
                'code' => 'required|unique:units,code,' . $unit->id . '|max:255',
                'name' => 'required|unique:units,name,' . $unit->id . '|max:255',
            ], [], $nice_names);
            if ($validator->fails()) {
                return response()->json($data = array('success' => false, 'errors' => $validator->errors()), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
            }
            /************************************************** */
            $data = $request->data;
            $data['allow_decimal'] = $data['allow_decimal'] == 0 ? null : 1;
            $unit->fill($data);
            $dirty = $unit->isDirty();
            $unit->save();
            if ($dirty) {
                return response()->json($data = array('success' => true, 'type' => 'success', 'id' => $unit->id, 'message' => 'Successfully updated unit <strong><em>' . $unit->name . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
            }
            return response()->json($data = array('success' => true, 'type' => 'notice', 'id' => $unit->id, 'message' => 'Nothing Changed !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
        return response()->json($data = array('success' => false, 'type' => 'danger', 'id' => $unit->id, 'message' => 'Unit <strong><em>' . $unit->name . '</strong></em> is locked !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        if ($unit->base == null && Unit::where('units.base', '=', $unit->id)->count() > 0) {
            return response()->json($data = array('success' => false, 'type' => 'danger', 'id' => $unit->id, 'message' => 'Can\'t delete, active sub unit found !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
        Unit::destroy($unit->id);
        return response()->json($data = array('success' => true, 'type' => 'success', 'id' => $unit->id, 'message' => 'Successfully deleted unit <strong><em>' . $unit->name . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }
}
