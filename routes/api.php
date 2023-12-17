<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('sign-in', [UserController::class, 'login']);
    Route::post('sign-up', [UserController::class, 'register']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [UserController::class, 'logout']);

        Route::get('user-info', [UserController::class, 'userDetails']);
        Route::get('user-info/{user}', [UserController::class, 'userDetailsById'])->middleware('permission:users.view');

        Route::get('user-list', [UserController::class, 'userList'])->middleware('permission:users.view');
        Route::post('administrator/users/create', [UserController::class, 'userCreate'])->middleware('permission:users.create');
        Route::put('administrator/users/{user}', [UserController::class, 'userEdit'])->middleware('permission:users.edit');
        Route::delete('administrator/users/{user}', [UserController::class, 'userDelete'])->middleware('permission:users.delete');

        Route::get('roles-list', [RolePermissionController::class, 'getRoles']);
        Route::get('permissions-list', [RolePermissionController::class, 'getPermissions']);

        Route::get('administrator/posts', [PostController::class, 'index'])->middleware('permission:posts.view');
        Route::post('administrator/posts', [PostController::class, 'store'])->middleware('permission:posts.create');
        Route::get('administrator/posts/{post}', [PostController::class, 'show'])->middleware('permission:posts.view');
        Route::put('administrator/posts/{post}', [PostController::class, 'update'])->middleware('permission:posts.edit');
        Route::delete('administrator/posts/{post}', [PostController::class, 'destroy'])->middleware('permission:posts.delete');
    });

    Route::get('posts', [PostController::class, 'index']);
});
