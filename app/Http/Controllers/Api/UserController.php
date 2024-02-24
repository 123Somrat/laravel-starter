<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserDetails;
use App\Http\Traits\ApiStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiStatus;

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
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

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
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


    public function logout(Request $request): JsonResponse
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            $response['message'] = "Logout succesfull";

            return $this->successResponse($response);
        }

        $response['message'] = "Unauthorised Attempt!";

        return $this->failureResponse($response);
    }

    public function userDetails(): JsonResponse
    {
        $user = Auth::user();
        if ($user) {
            $response['user'] = new UserDetails($user);
            $response['permissions'] = $user->getAllPermissions()->pluck('display_name', 'id');
            $response['message'] = "User Information";

            return $this->successResponse($response);
        } else {
            $response['message'] = "No user found";

            return $this->failureResponse($response);

        }

    }

    public function show($id): JsonResponse
    {
        $user = User::whereId($id)->first();

        if ($user) {
            $response['user'] = new UserDetails($user);
            $response['message'] = "User Information";

            return $this->successResponse($response);
        } else {
            $response['message'] = "No user found";

            return $this->failureResponse($response);

        }
    }

    public function index(): JsonResponse
    {
        $response = array();
        $users = User::orderBy('id', 'desc')->get();
        $response['users'] = UserDetails::collection($users);
        $response['message'] = 'User List';
        return $this->successResponse($response);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'email'       => 'required|email|unique:users',
            'password'    => 'required',
            'roles'       => 'array',
            'permissions' => 'array',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();

            return $this->failureResponse($response);
        }

        $input = $request->all();

        DB::beginTransaction();

        try {
            $user = User::create($input);

            if ($request->has('roles')) {
                $user->assignRole(array_map('intval', $request->roles));
            }

            if ($request->has('permissions')) {
                $user->givePermissionTo(array_map('intval', $request->permissions));
            }

            DB::commit();

            $response['user'] = $user;
            $response['message'] = 'User Saved Successfully';

            return $this->successResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = 'User can not save properly';

            return $this->failureResponse($response);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'  => 'required|max:120',
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
                $user->roles()->sync($request->roles);
            } else {
                $user->roles()->detach();
            }
            if ($request->has('permissions')) {

                $user->permissions()->sync($request->permissions);
            } else {
                $user->permissions()->detach();
            }

            DB::commit();

            $response['user'] = $user;
            $response['message'] = 'User Updated Successfully';

            return $this->successResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = 'User can not save properly';

            return $this->failureResponse($response);
        }
    }

    public function delete($id): JsonResponse
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            $user->delete();
            DB::commit();
            $response['message'] = 'User Successfully Deleted';

            return $this->successResponse($response);
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = 'User can not Delete properly';

            return $this->failureResponse($response);
        }
    }

}
