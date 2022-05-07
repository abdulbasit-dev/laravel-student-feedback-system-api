<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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

        $users = User::query()
            ->with('roles:id,name', 'college:id,name', 'department:id,name')
            ->select('id', 'name', 'user_name', 'email', 'college_id', 'dept_id')
            ->whereIsStudent(0)
            ->paginate(static::ITEM_PER_PAGE);

        return $this->josnResponse(true, "All Users.", Response::HTTP_OK, $users);
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
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ['required'],
                "user_name" => ['required'],
                "email" => ['required', 'email', 'unique:users,email', 'regex:/[\w]+@+((?i)(student.){0,1}su.edu.krd(?-i))$/im'],
                "dept_id" => ['required'],
                "password" => ['required'],
            ],
            [
                'email.regex' => 'Please provide a valid university email',
                'dept_id.required' => 'The department field is required.'
            ]
        );

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        $user = User::create([
            "name" => $request->name,
            "user_name" => $request->user_name,
            "email" => $request->email,
            "dept_id" => $request->dept_id,
            "password" => bcrypt($request->password),
        ]);

        //assign role
        $user->assignRole($request->role_id);

        return $this->josnResponse(true, "User cretaed successfully.", Response::HTTP_CREATED);
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
        //$this->authorize("_access");

        $user->load('college:id,name', 'dept:id,name', 'roles:id,name');

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
        //$this->authorize("_access");

        //validation
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ['sometimes', 'required'],
                "user_name" => ['sometimes', 'required'],
                "email" => ['sometimes', 'required', 'email', 'unique:users,email,' . $user->id, 'regex:/[\w]+@+((?i)(student.){0,1}su.edu.krd(?-i))$/im'],
                "dept_id" => ['sometimes', 'required'],
                "password" => ['sometimes', 'required'],
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
            "user_name" => $request->user_name,
            "email" => $request->email,
            "dept_id" => $request->dept_id,
            "password" => bcrypt($request->password),
        ]);

        //current role will be replaced with the new one
        $user->syncRoles($request->role_id);

        return $this->josnResponse(true, "User updated successfully.", Response::HTTP_OK);
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
        //$this->authorize("_access");

        $user->delete();
        return $this->josnResponse(true, "User deleted successfully.", Response::HTTP_OK);
    }
}
