<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //check permission
        $this->authorize("student_view");

        //get query params from request
        $dept_id = $request->dept_id ?? null;
        $limit = $request->limit ?? null;

        $students = User::query()
            ->where('is_student', 1)
            ->when($dept_id, function ($query, $dept_id) {
                $query->whereDeptId($dept_id);
            })
            ->paginate($limit ?? static::ITEM_PER_PAGE);

        return $this->josnResponse(true, "All students.", Response::HTTP_OK, $students);
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
        $this->authorize("student_add");

        //validation
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ['required', 'string', 'min:3', 'max:60'],
                "email" => ['required', 'email', 'unique:users,email', 'regex:/[\w]+@+((?i)(student.){0,1}su.edu.krd(?-i))$/im'],
                "password" => ['required'],
                "entry_year" => ['required'],
                "stage" => ['required', 'integer', Rule::in([1, 2, 3, 4, 5, 6])],
                'dept_id' => ['required', 'exists:departments,id']
            ],
            [
                'email.regex' => 'Please provide a valid university email',
                'dept_id.required' => 'The department field is required.'
            ]
        );

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "entry_year" => $request->entry_year,
            "stage" => $request->stage,
            "dept_id" => $request->dept_id,
            "is_student" => 1
        ]);

        return $this->josnResponse(true, "Student cretaed successfully.", Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //check permission
        $this->authorize("student_view");

        $user->load('college:id,name', 'dept:id,name', 'dept.subjects:id,name,dept_id');

        return $this->josnResponse(true, "Show User info.", Response::HTTP_OK, $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //check permission
        $this->authorize("student_edit");

        //validation
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ['required', 'string', 'min:3', 'max:60'],
                "email" => ['required', 'email', 'unique:users,email,' . $user->id, 'regex:/[\w]+@+((?i)(student.){0,1}su.edu.krd(?-i))$/im'],
                "password" => ['required'],
                "entry_year" => ['required'],
                "stage" => ['required', 'integer', Rule::in([1, 2, 3, 4, 5, 6])],
                'dept_id' => ['required', 'exists:departments,id']
            ],
            [
                'email.regex' => 'Please provide a valid university email',
                'dept_id.required' => 'The department field is required.'
            ]
        );

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        $user->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "entry_year" => $request->entry_year,
            "stage" => $request->stage,
            "dept_id" => $request->dept_id,
            "is_student" => 1
        ]);

        return $this->josnResponse(true, "Student updated successfully.", Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //check permission
        $this->authorize("student_delete");

        $user->delete();
        return $this->josnResponse(true, "Student deleted successfully.", Response::HTTP_OK);
    }

    public function studentSubjects(User $user)
    {
        // get dept, lecturer, subject 
        $user->load('dept:id,name', 'dept.subjects:id,dept_id,name', 'dept.subjects.lecturers:id,name');
        return $this->josnResponse(true, "Student subjects.", Response::HTTP_OK, $user);
    }
}
