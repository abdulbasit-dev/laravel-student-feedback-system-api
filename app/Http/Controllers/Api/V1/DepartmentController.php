<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
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
        //return $this->josnResponse(true, " successfully.", Response::HTTP_);
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
        //return $this->josnResponse(true, " successfully.", Response::HTTP_);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //check permission
        //$this->authorize("_access");
        //return $this->josnResponse(true, " successfully.", Response::HTTP_);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //check permission
        //$this->authorize("_access");
        //return $this->josnResponse(true, " successfully.", Response::HTTP_);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //check permission
        //$this->authorize("_access");
        //return $this->josnResponse(true, " successfully.", Response::HTTP_);
    }
}
