<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function show(College $college)
    {
        //check permission
        //$this->authorize("_access");
        //return $this->josnResponse(true, " successfully.", Response::HTTP_);
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
        //return $this->josnResponse(true, " successfully.", Response::HTTP_);
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
        //return $this->josnResponse(true, " successfully.", Response::HTTP_);
    }
}
