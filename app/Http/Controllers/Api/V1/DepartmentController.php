<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
        $this->authorize("department_view");

        $departments = Department::query()->with('college:id,name')->select('id', 'name','college_id')->get();
        return $this->josnResponse(true, "All departments.", Response::HTTP_OK, $departments);
    }

    /**
     * Display a listing of array of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function list()
    {
        //check permission
        $this->authorize("department_view");
        $departments = Department::query()->pluck('name', 'id')->toArray();
        return $this->josnResponse(true, "List Of departments.", Response::HTTP_OK, $departments);
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
        $this->authorize("department_add");

        $validator = Validator::make($request->all(), [
            "name" => ['required', 'unique:departments,name'],
            "college_id" => ['required','exists:colleges,id']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        Department::create([
            "name" => $request->name,
            "college_id" => $request->college_id
        ]);

        return $this->josnResponse(true, "Department created successfully.", Response::HTTP_CREATED);
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
        $this->authorize("department_edit");

        $validator = Validator::make($request->all(), [
            "name" => ['required', 'unique:departments,name,' . $department->id],
            "college_id" => ['required', 'exists:colleges,id']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        $department->update([
            "name" => $request->name,
            "college_id" => $request->college_id
        ]);

        return $this->josnResponse(true, "Department updated successfully.", Response::HTTP_OK);
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
        $this->authorize("department_delete");

        $department->delete();
        return $this->josnResponse(true, "Department deleted successfully.", Response::HTTP_OK);
    }
}
