<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;

class RoleController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['roles'] = Role::with('permissions')->get();//Get all roles
        return view('admin.pages.roles.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['permissions'] = Permission::all()->groupBy('module');//Get all permissions
        return view('admin.pages.roles.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate name and permissions field
        $this->validate($request, [
                'name' => 'required|unique:roles|max:10',
                'display_name' => 'required|max:25',
                'permissions' => 'required',
            ]
        );

        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->guard_name = 'web';
        $role->save();
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')
            ->with('msg',
                'Role ' . $role->display_name . ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['role'] = Role::findOrFail($id);
        $data['permissions'] = Permission::all()->groupBy('module');
        $data['role_permissions'] = $data['role']->permissions->pluck('id')->toArray();

        return view('admin.pages.roles.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validate name and permission fields
        $this->validate($request, [
                'name' => 'required|max:10|unique:roles,name,' . $id,
                'display_name' => 'required|max:25',
                'permissions' => 'required',
            ]
        );
        $role = Role::findOrFail($id);//Get role with the given id
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->guard_name = 'web';
        $role->save();
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')
            ->with('msg',
                'Role ' . $role->name . ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('msg',
                'Role deleted!');

    }
}
