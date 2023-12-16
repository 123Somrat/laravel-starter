<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::get('/', [PostController::class, 'index'])->name('home');

Route::prefix('administrator/')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('home');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('', [UserController::class, 'index'])->middleware('permission:users.view')->name('index');
        Route::get('create', [UserController::class, 'create'])->middleware('permission:users.create')->name('create');
        Route::post('users', [UserController::class, 'store'])->middleware('permission:users.create')->name('store');
        Route::get('{user}/edit', [UserController::class, 'edit'])->middleware('permission:users.edit')->name('edit');
        Route::put('{user}', [UserController::class, 'update'])->middleware('permission:users.edit')->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])->middleware('permission:users.delete')->name('destroy');
    });

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('', [RoleController::class, 'index'])->middleware('permission:roles.view')->name('index');
        Route::get('create', [RoleController::class, 'create'])->middleware('permission:roles.create')->name('create');
        Route::post('roles', [RoleController::class, 'store'])->middleware('permission:roles.create')->name('store');
        Route::get('{role}/edit', [RoleController::class, 'edit'])->middleware('permission:roles.edit')->name('edit');
        Route::put('{role}', [RoleController::class, 'update'])->middleware('permission:roles.edit')->name('update');
        Route::delete('{role}', [RoleController::class, 'destroy'])->middleware('permission:roles.delete')->name('destroy');
    });

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('', [AdminPostController::class, 'index'])->middleware('permission:posts.view')->name('index');
        Route::get('create', [AdminPostController::class, 'create'])->middleware('permission:posts.create')->name('create');
        Route::post('posts', [AdminPostController::class, 'store'])->middleware('permission:posts.create')->name('store');
        Route::get('{post}', [AdminPostController::class, 'show'])->middleware('permission:posts.view')->name('show');
        Route::get('{post}/edit', [AdminPostController::class, 'edit'])->middleware('permission:posts.edit')->name('edit');
        Route::put('{post}', [AdminPostController::class, 'update'])->middleware('permission:posts.edit')->name('update');
        Route::delete('{post}', [AdminPostController::class, 'destroy'])->middleware('permission:posts.delete')->name('destroy');
    });
});

Route::resource('posts', PostController::class);
