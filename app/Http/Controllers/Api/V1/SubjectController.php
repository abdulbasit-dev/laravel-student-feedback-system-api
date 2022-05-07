<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
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

        $subjects = Subject::query()->orderByDesc('created_at')->paginate(static::ITEM_PER_PAGE);
        return $this->josnResponse(true, "All Subjects.", Response::HTTP_OK, $subjects);
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
        $validator = Validator::make($request->all(), [
            "dept_id" => ['required', 'exists:departments,id'],
            "name" => ['required'],
            "code" => ['required'],
            "stage" => ['required', Rule::in([1, 2, 3, 4, 5, 6])],
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        Subject::create($request->only([
            "dept_id",
            'name',
            'code',
            'stage'
        ]));

        return $this->josnResponse(true, "Subject cretaed successfully.", Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //check permission
        //$this->authorize("_access");

        $subject->load('college:id,name', 'dept:id,name');
        return $this->josnResponse(true, "Show Subject info.", Response::HTTP_OK, $subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //check permission
        //$this->authorize("_access");

        //validation
        $validator = Validator::make($request->all(), [
            "dept_id" => ['sometimes', 'required', 'exists:departments,id'],
            "name" => ['sometimes', 'required'],
            "code" => ['sometimes', 'required'],
            "stage" => ['sometimes', 'required', Rule::in([1, 2, 3, 4, 5, 6])],
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        $subject->update($request->only([
            "dept_id",
            'name',
            'code',
            'stage'
        ]));

        return $this->josnResponse(true, "Subject updated successfully.", Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //check permission
        //$this->authorize("_access");

        $subject->delete();
        return $this->josnResponse(true, "Subject deleted successfully.", Response::HTTP_OK);
    }
}
