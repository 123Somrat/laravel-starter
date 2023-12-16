<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    public function index(): View
    {
        return view('permissions.index')->with('permissions', Permission::all());
    }

    public function create(): View
    {
        return view('permissions.create')->with('roles', Role::get());
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|max:40',
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) { //If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::whereId($role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
                $r->givePermissionTo($permission);
            }
        }

        return redirect(route('permissions.index'))->with('flash_message', 'Permission' . $permission->name . ' added!');
    }

    public function show($id): RedirectResponse
    {
        return redirect('permissions');
    }

    public function edit($id): View
    {
        return view('permissions.edit', ['permission' => Permission::findOrFail($id)]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:40',
        ]);
        $input = $request->all();
        $permission->fill($input)->save();

        return redirect(route('permissions.index'))->with('flash_message', 'Permission' . $permission->name . ' updated!');
    }

    public function destroy($id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);

        if ($permission->name == "Administer roles & permissions") {
            return redirect(route('permissions.index'))->with('flash_message', 'Cannot delete this Permission!');
        }

        $permission->delete();

        return redirect(route('permissions.index'))->with('flash_message', 'Permission deleted!');
    }
}
