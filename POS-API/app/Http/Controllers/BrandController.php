<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use DB;
use Illuminate\Http\Request;
use Validator;

class BrandController extends Controller
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
                $data['data'] = Brand::where('brands.name', 'LIKE', '%' . $search . '%')
                    ->orderBy($order_by, $order);
                $data["recordsFiltered"] = $data['data']->count();
                $data['data'] = $data['data']->skip($offset)
                    ->take($limit)
                    ->get();
                /****************************************************** */
                $data["draw"] = $request->input('draw');
                $data["recordsTotal"] = Brand::count();
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
        Brand::unguard(true); // need to add code
        $id = DB::table('INFORMATION_SCHEMA.TABLES')->select('AUTO_INCREMENT as id')->where('TABLE_SCHEMA', \DB::connection()->getDatabaseName())->where('TABLE_NAME', 'brands')->first()->id;
        $data = array_merge($request->data, ['code' => sprintf("BR-%05s", $id)]);
        unset($data['created_at'], $data['updated_at'], $data['deleted_at']); // to prevent hijack
        /************************* VALIDATION ************************* */
        //$data['code'] = 'WH-00958';
        $nice_names = array(
        );
        $validator = Validator::make($data, [
            'name' => 'required|unique:brands,name|max:255',
        ], [], $nice_names);
        if ($validator->fails()) {
            return response()->json($data = array('success' => false, 'errors' => $validator->errors()), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
        /************************************************** */
        $insert = Brand::create($data);
        return response()->json($data = array('success' => true, 'type' => 'success', 'id' => $insert->id, 'message' => 'Successfully added new brand <strong><em>' . $data['name'] . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //if ($brand->locked == null) {
        /************************* VALIDATION ************************* */
        $nice_names = array(
        );
        $validator = Validator::make($request->data, [
            'name' => 'required|unique:brands,name,' . $brand->id . '|max:255',
            'logo' => 'unique:brands,logo,' . $brand->id . '|max:255',
        ], [], $nice_names);
        if ($validator->fails()) {
            return response()->json($data = array('success' => false, 'errors' => $validator->errors()), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
        /************************************************** */
        $brand->fill($request->data);
        $dirty = $brand->isDirty();
        $brand->save();
        if ($dirty) {
            return response()->json($data = array('success' => true, 'type' => 'success', 'id' => $brand->id, 'message' => 'Successfully updated brand <strong><em>' . $request['data']['db']['name'] . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        }
        return response()->json($data = array('success' => true, 'type' => 'notice', 'id' => $brand->id, 'message' => 'Nothing Changed !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
        //}
        //return response()->json($data = array('success' => false, 'type' => 'danger', 'id' => $warehouse->id, 'message' => 'Brand <strong><em>' . $brand->name . '</strong></em> is locked !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        Brand::destroy($brand->id);
        return response()->json($data = array('success' => true, 'type' => 'success', 'id' => '$warehouse->id', 'message' => 'Successfully deleted brand <strong><em>' . $brand->name . '</em></strong> !'), $status = 200, $headers = [], $options = JSON_PRETTY_PRINT);
    }
}
