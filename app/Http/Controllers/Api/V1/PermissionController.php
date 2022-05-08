<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::query()->select('id', 'name')->paginate(static::ITEM_PER_PAGE);
        return $this->josnResponse(true, "All permissions", Response::HTTP_OK, $permissions);
    }

    public function assignPermissionsToRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => ['required', 'exists:roles,id'],
            'permssions' => ['required', 'array']
        ]);

        if ($validator->fails()) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $validator->errors()->all());
        }

        try {
            //find role
            $role = Role::findOrFail($request->role_id);

            $role->givePermissionTo($request->permssions);

            return $this->josnResponse(true, "Permissions successfully assigned to role", Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->josnResponse(false, "The given data was invalid.", Response::HTTP_UNPROCESSABLE_ENTITY, null, $e->getMessage());
        }
    }

    public function removePermissionsFromRole(Request $request)
    {
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
