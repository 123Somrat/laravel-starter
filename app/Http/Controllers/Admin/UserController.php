<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $data = array();
        $data['users'] = User::all();
        return view('admin.pages.users.index')->with($data);
    }

    public function create():View
    {
        $data = array();

        $data['roles'] = Role::get();
        $data['permissions'] = Permission::all()->groupBy('module');
        return view('admin.pages.users.create')->with($data);
    }

    public function store(Request $request): RedirectResponse
    {
        $userdata = $this->validate($request, [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create($userdata);

        if ($request->has('roles')) {
            $user->roles()->attach($request->roles);
        }

        if ($request->has('permissions')) {
            $user->permissions()->attach($request->permissions);
        }

        return redirect(route('admin.users.index'))->with('msg', 'User successfully added.');
    }

    public function show($id): RedirectResponse
    {
        return redirect('admin.users.index');
    }

    public function edit($id): View
    {
        $data=array();
        $data['user'] = User::findOrFail($id); //Get user with specified id
        $data['roles'] = Role::get(); //Get all roles
        $data['permissions'] = Permission::all()->groupBy('module');
        $data['user_permissions'] = $data['user']->getDirectPermissions()->pluck('id')->toArray();
        $data['user_roles'] = $data['user']->roles->pluck('id')->toArray();

        return view('admin.pages.users.edit')->with($data);

    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user_data=$this->validate($request, [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->fill($user_data)->save();

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        } else {
            $user->roles()->detach();
        }

        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }else{
            $user->permissions()->detach();
        }

        return redirect(route('admin.users.index'))->with('msg', 'User successfully edited.');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('admin.users.index'))->with('msg', 'User successfully deleted.');
    }
}
