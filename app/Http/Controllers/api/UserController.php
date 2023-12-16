<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\UserDetails;
use App\Http\Traits\ApiStatus;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiStatus;

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failureResponse($response);
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = Auth::user();
            $response['token'] = 'Bearer ' . $user->createToken('Secret123456')->accessToken;
            $response['message'] = "Login Successfull";
            return $this->successResponse($response);
        } else {
            $response['message'] = "Credentials do not match";
            return $this->failureResponse($response);
        }
    }

    /*Register function*/
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failureResponse($response);
        }

        $input = $request->all();

        $user = User::create($input);
        $response['token'] = 'Bearer ' . $user->createToken('Secret123456')->accessToken;
        $response['user_id'] = $user->id;
        return $this->successResponse($response);
    }


    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            $response['message'] = "Logout succesfull";
            return $this->successResponse($response);
        }
    }

    public function userDetails()
    {
        $user = Auth::user();
        if ($user) {
            $response['user'] = $user;
            $response['message'] = "User Information";
            return $this->successResponse($response);
        } else {
            $response['message'] = "No user found";
            return $this->failureResponse($response);

        }

    }

    public function userDetailsById($id)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            $response['user'] = new UserDetails($user);
            $response['message'] = "User Information";
            return $this->successResponse($response);
        } else {
            $response['message'] = "No user found";
            return $this->failureResponse($response);

        }
    }

    public function userList()
    {
        $response = array();
        $users = User::orderBy('id', 'desc')->get();
        $response['users'] = UserDetails::collection($users);
        $response['message'] = 'User List';
        return $this->successResponse($response);
    }

    public function userCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failureResponse($response);
        }

        $input = $request->all();

        DB::beginTransaction();

        try {
            $user = User::create($input);

            //Checking if a role was selected
            if ($request->has('roles')) {

                $user->assignRole($request->roles);
            }
            //Checking if a role was selected
            if ($request->has('permissions')) {

                $user->givePermissionTo($request->permissions);
            }

            DB::commit();

            $response['user'] = $user;
            $response['message'] = 'User Saved Successfully';
            return $this->successResponse($response);
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $response['message'] = 'User can not save properly';
            return $this->failureResponse($response);
        }
    }

    public function userEdit(Request $request,$id)
    {
        $user = User::findOrFail($id); //Get role specified by id
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failureResponse($response);
        }

        $input = $request->all();

        DB::beginTransaction();

        try {
            $user->fill($input)->save();

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

            DB::commit();

            $response['user'] = $user;
            $response['message'] = 'User Updated Successfully';
            return $this->successResponse($response);
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $response['message'] = 'User can not save properly';
            return $this->failureResponse($response);
        }
    }

    public function userDelete($id)
    {
        //Find a user with a given id and delete
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            $user->delete();
            DB::commit();
            $response['message'] = 'User Successfully Deleted';
            return $this->successResponse($response);
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $response['message'] = 'User can not Delete properly';
            return $this->failureResponse($response);
        }
    }

}
