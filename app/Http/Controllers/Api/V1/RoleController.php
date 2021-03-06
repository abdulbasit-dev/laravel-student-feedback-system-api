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
        $roles = Role::query()->with('permissions')->get()->toArray();
        $roles = collect($roles)->map(function ($role) {
            if ($role["name"] == "admin") {
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
        $role = Role::create(["name" => $request->name]);
        $role->givePermissionTo($request->permssions);
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
        return $this->josnResponse(true, "Role with its permissions.", Response::HTTP_OK, $role->load('permissions'));
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
        $role->update(["name" => $request->name]);
        $role->givePermissionTo($request->permssions);
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
        return $this->josnResponse(true, "Role delete successfully.", Response::HTTP_OK);
    }

    public function userRole(User $user)
    {
        [$userRole['role']] = $user->hasRole(Role::all()) ? $user->getRoleNames() : null;
        return $this->josnResponse(true, "User Roles", Response::HTTP_OK, $userRole);
    }

    public function assignRole(Request $request)
    {
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
