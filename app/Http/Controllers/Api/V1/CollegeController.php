<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\College;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check permission
        //$this->authorize("_access");

        $colleges = College::query()->with('departments:id,college_id,name')->select('id', 'name')->get();
        return $this->josnResponse(true, "All Collegs.", Response::HTTP_OK, $colleges);
    }

    /**
     * Display a listing of array of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function list()
    {
        //check permission
        //$this->authorize("_access");

        $colleges = College::query()->pluck('name','id')->toArray();
        return $this->josnResponse(true, "All Collegs.", Response::HTTP_OK, $colleges);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check permission
        //$this->authorize("_access");

        $validator = Validator::make($request->all(), [
            "name" => ['required', 'unique:colleges,name']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        College::create([
            "name" => $request->name
        ]);

        return $this->josnResponse(true, "College created successfully.", Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, College $college)
    {
        //check permission
        //$this->authorize("_access");

        $validator = Validator::make($request->all(), [
            "name" => ['required', 'unique:colleges,name,' . $college->id]
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        $college->update([
            "name" => $request->name
        ]);

        return $this->josnResponse(true, "College updated successfully.", Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy(College $college)
    {
        //check permission
        //$this->authorize("_access");

        $college->delete();
        return $this->josnResponse(true, "College deleted successfully.", Response::HTTP_OK);
    }
}
