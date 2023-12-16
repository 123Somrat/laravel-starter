<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $data = array();
        $data['users'] = User::all();
        return view('admin.pages.users.index')->with($data);
    }

    public function create()
    {
        $data = array();

        $data['roles'] = Role::get();
        $data['permissions'] = Permission::all()->groupBy('module');
        return view('admin.pages.users.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userdata = $this->validate($request, [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create($userdata); //Retrieving only the email and password data

        //Checking if a role was selected
        if ($request->has('roles')) {

            $user->assignRole($request->roles);
        }
        //Checking if a role was selected
        if ($request->has('permissions')) {

            $user->givePermissionTo($request->permissions);
        }
        //Redirect to the users.index view and display message
        return redirect()->route('admin.users.index')
            ->with('msg', 'User successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=array();
        $data['user'] = User::findOrFail($id); //Get user with specified id
        $data['roles'] = Role::get(); //Get all roles
        $data['permissions'] = Permission::all()->groupBy('module');
        $data['user_permissions'] = $data['user']->getDirectPermissions()->pluck('id')->toArray();
        $data['user_roles'] = $data['user']->roles->pluck('id')->toArray();

        return view('admin.pages.users.edit')->with($data);

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
        $user = User::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $user_data=$this->validate($request, [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $user->fill($user_data)->save();

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);  //If one or more role is selected associate user to roles
        } else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        if ($request->has('permissions')) {

            $user->permissions()->sync($request->permissions);
        }else{
            $user->permissions()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        return redirect()->route('admin.users.index')
            ->with('msg',
                'User successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find a user with a given id and delete
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('msg',
                'User successfully deleted.');
    }
}
