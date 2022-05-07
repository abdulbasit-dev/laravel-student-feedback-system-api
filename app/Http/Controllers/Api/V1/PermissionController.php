<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $permissions = Permission::all();
        $permissions = DB::table('permissions')
            ->join("parent_permissions", 'permissions.parent_permission_id', '=', 'parent_permissions.id')
            ->select('permissions.id', 'permissions.name', 'permissions.code', 'parent_permissions.id as parent_menu_id', 'parent_permissions.name as parent_menu_name', 'parent_permissions.code as parent_menu_code')
            ->get();
        return $this->josnResponse(true, "All permissions", Response::HTTP_OK, $permissions);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $permissions = Permission::all();
        return $this->josnResponse(true, "All permissions", Response::HTTP_OK, $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $lastPermisionsCode =  Permission::orderByDesc('id')->first()->code;
        Permission::create($request->validated() + ['code' => $lastPermisionsCode + 1]);
        return $this->josnResponse(true, "Permission created successfully", Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return $this->josnResponse(true, "Permission updated successfully", Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $this->josnResponse(true, "Permission deleted", Response::HTTP_OK);
    }

    public function assignPermissionsToRole(Request $request)
    {
        $this->authorize('permission_assign');
        $validator = Validator::make($request->all(), [
            'role_id' => ['required', 'exists:roles,id'],
            'permssions' => ['required', 'array']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        //find role
        $role = Role::findOrFail($request->role_id);

        $role->givePermissionTo($request->permssions);

        return $this->josnResponse(true, "Permissions successfully assigned to role", Response::HTTP_OK);
    }

    public function removePermissionsFromRole(Request $request)
    {
        $this->authorize('permission_revoke');

        $validator = Validator::make($request->all(), [
            'role_id' => ['required', 'exists:roles,id'],
            'permssions' => ['required', 'array']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        //find role
        $role = Role::findOrFail($request->role_id);

        $role->revokePermissionTo($request->permssions);

        return $this->josnResponse(true, "Permissions revoked from role", Response::HTTP_OK);
    }
}
