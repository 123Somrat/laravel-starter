<?php

namespace App\Http\Controllers\api;

use App\Http\Traits\ApiStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    use ApiStatus;
    public function getRoles()
    {
        $response = array();
        $roles=Role::get()->pluck('display_name','id');
        $response['roles'] = $roles;
        $response['message'] = 'Role List';
        return $this->successResponse($response);

    }
    public function getPermissions()
    {
        $response = array();
        $roles=Permission::get()->pluck('display_name','id');
        $response['permissions'] = $roles;
        $response['message'] = 'Permissions List';
        return $this->successResponse($response);

    }
}
