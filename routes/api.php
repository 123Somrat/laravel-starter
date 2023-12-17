<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('sign-in', [UserController::class, 'login']);
    Route::post('sign-up', [UserController::class, 'register']);

    Route::get('posts', [PostController::class, 'index']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [UserController::class, 'logout']);
        Route::get('roles-list', [RolePermissionController::class, 'getRoles']);
        Route::get('permissions-list', [RolePermissionController::class, 'getPermissions']);

        Route::get('my-info', [UserController::class, 'userDetails']);

        Route::get('administrator/users', [UserController::class, 'index'])->middleware('can:users.view');
        Route::post('administrator/users', [UserController::class, 'store'])->middleware('can:users.create');
        Route::get('administrator/users/{user}', [UserController::class, 'show'])->middleware('can:users.view');
        Route::put('administrator/users/{user}', [UserController::class, 'update'])->middleware('can:users.edit');
        Route::delete('administrator/users/{user}', [UserController::class, 'delete'])->middleware('can:users.delete');

        Route::get('administrator/posts', [PostController::class, 'index'])->middleware('can:posts.view');
        Route::post('administrator/posts', [PostController::class, 'store'])->middleware('can:posts.create');
        Route::get('administrator/posts/{post}', [PostController::class, 'show'])->middleware('can:posts.view');
        Route::put('administrator/posts/{post}', [PostController::class, 'update'])->middleware('can:posts.edit');
        Route::delete('administrator/posts/{post}', [PostController::class, 'destroy'])->middleware('can:posts.delete');
    });
});
