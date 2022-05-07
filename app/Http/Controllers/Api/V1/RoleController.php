<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('role_access');
        $roles = Role::query()->with('permissions')->get()->toArray();
        $roles = collect($roles)->map(function ($role) {
            if ($role["name"] == "Super Admin") {
                $role["permissions"] = Permission::all();
                return $role;
            }
            return $role;
        });
        return $this->josnResponse(true, "All roles", Response::HTTP_OK, $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('role_create');
        $role = Role::create($request->validated());
        return $this->josnResponse(true, "Role created successfully", Response::HTTP_CREATED, $role);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('role_access');
        return $this->josnResponse(true, "Role with its permissions ", Response::HTTP_OK, $role->load('permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return $this->josnResponse(true, "Role updated successfully", Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->josnResponse(true, "Role deleted", Response::HTTP_OK);
    }

    public function userRoles(Request $request)
    {
        //check permission
        $this->authorize('role_access');

        //get request values
        $name = $request->has('name') ? $request->name : null;
        $email = $request->has('email') ? $request->email : null;
        $phone = $request->has('phone') ? $request->phone : null;

        //create user query
        $usersQuery = User::query();

        //at least one value must be passed 
        if (!$name && !$email && !$phone) {
            return $this->josnResponse(false, "Pleas pass name or email or phone", Response::HTTP_BAD_REQUEST);
        }

        if ($name) {
            $usersQuery->where('name', 'like', "%$request->name%");
        }

        if ($email) {
            $usersQuery->where('email', 'like', "%$request->email%");
        }

        if ($phone) {
            $usersQuery->where('phone_number', 'like', "%$request->phone%");
        }

        $user = $usersQuery->first();
        $userRole['id'] = $user->id;
        $userRole['name'] = $user->name;
        $userRole['email'] = $user->email;
        $userRole['phone_number'] = $user->phone_number;
        $userRole['image'] = $user->image;

        //roles
        [$userRole['role']] = $user->getRoleNames();

        return $this->josnResponse(true, "User Roles", Response::HTTP_OK, $userRole);
    }

    public function assignRole(Request $request)
    {
        $this->authorize('role_assign');
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        try {
            // find user 
            $user = User::findOrfail($request->user_id);

            //current role will be removed from the user and replaced by the new one
            $user->syncRoles($request->role);

            return $this->josnResponse(true, "Role successfully assigned to user", Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, (array)$e->getMessage());
        }
    }

    public function removeRole(Request $request)
    {
        //check permission
        $this->authorize('role_revoke');
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'exists:roles,name']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        try {
            // find user 
            $user = User::findOrfail($request->user_id);

            //revoke role from user
            $user->removeRole($request->role);

            return $this->josnResponse(true, "Role revoked from user", Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $e->getMessage());
        }
    }
}
