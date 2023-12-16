<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    public function index(): View
    {
        return view('admin.pages.roles.index')->with(['roles' => Role::with('permissions')->get()]);
    }

    public function create(): View
    {
        return view('admin.pages.roles.create')->with(['permissions' => Permission::all()->groupBy('module')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
                'name'         => 'required|unique:roles|max:10',
                'display_name' => 'required|max:25',
                'permissions'  => 'required',
            ]
        );

        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->guard_name = 'web';
        $role->save();

        $role->permissions()->attach($request->permissions);

        return redirect(route('admin.roles.index'))->with('msg', 'Role ' . $role->display_name . ' added!');
    }

    public function show($id): RedirectResponse
    {
        return redirect('roles');
    }

    public function edit($id): View
    {
        $data = array();
        $data['role'] = Role::findOrFail($id);
        $data['permissions'] = Permission::all()->groupBy('module');
        $data['role_permissions'] = $data['role']->permissions->pluck('id')->toArray();

        return view('admin.pages.roles.edit')->with($data);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
                'name'         => 'required|max:10|unique:roles,name,' . $id,
                'display_name' => 'required|max:25',
                'permissions'  => 'required',
            ]
        );

        $role = Role::findOrFail($id);//Get role with the given id
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->guard_name = 'web';
        $role->save();

        $role->permissions()->sync($request->permissions);

        return redirect(route('admin.roles.index'))->with('msg', 'Role ' . $role->name . ' updated!');
    }

    public function destroy($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect(route('admin.roles.index'))->with('msg', 'Role deleted!');
    }
}
