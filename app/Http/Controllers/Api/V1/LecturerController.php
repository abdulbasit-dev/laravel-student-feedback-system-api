<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Lecturer;
use App\Http\Controllers\Controller;
use App\Models\AcademicTitle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LecturerController extends Controller
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

        $lecturers = Lecturer::query()->paginate(20);
        return $this->josnResponse(true, "All Lecturers.", Response::HTTP_OK, $lecturers);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function academicTitle()
    {
        //check permission
        //$this->authorize("_access");

        $academicTitles = AcademicTitle::pluck('title','id');
        return $this->josnResponse(true, "All academic titles.", Response::HTTP_OK, $academicTitles);
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

        //validation
        $validator = Validator::make($request->all(),[
            "dept_id"=>['sometimes','required'],
            "title_id"=>['sometimes','required'],
            "name"=>['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        Lecturer::create([
            "name"=>$request->name
        ]);

        return $this->josnResponse(true, "Lecturer cretaed successfully.", Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function show(Lecturer $lecturer)
    {
        //check permission
        //$this->authorize("_access");

        $lecturer->load('college:id,name','dept:id,name');
        return $this->josnResponse(true, "Show Lecturer info.", Response::HTTP_OK, $lecturer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        //check permission
        //$this->authorize("_access");

        //validation
        $validator = Validator::make($request->all(),[
            "name"=>['required']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        $lecturer->update([
            "name"=>$request->name
        ]);

        return $this->josnResponse(true, "Lecturer updated successfully.", Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lecturer $lecturer)
    {
        //check permission
        //$this->authorize("_access");

        $lecturer->delete();
        return $this->josnResponse(true, "Lecturer deleted successfully.", Response::HTTP_OK);
    }
}
