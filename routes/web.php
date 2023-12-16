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

Route::prefix('administrator')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('home');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('', [UserController::class, 'index'])->middleware('can:users.view')->name('index');
        Route::get('create', [UserController::class, 'create'])->middleware('can:users.create')->name('create');
        Route::post('users', [UserController::class, 'store'])->middleware('can:users.create')->name('store');
        Route::get('{user}/edit', [UserController::class, 'edit'])->middleware('can:users.edit')->name('edit');
        Route::put('{user}', [UserController::class, 'update'])->middleware('can:users.edit')->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])->middleware('can:users.delete')->name('destroy');
    });

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('', [RoleController::class, 'index'])->middleware('can:roles.view')->name('index');
        Route::get('create', [RoleController::class, 'create'])->middleware('can:roles.create')->name('create');
        Route::post('roles', [RoleController::class, 'store'])->middleware('can:roles.create')->name('store');
        Route::get('{role}/edit', [RoleController::class, 'edit'])->middleware('can:roles.edit')->name('edit');
        Route::put('{role}', [RoleController::class, 'update'])->middleware('can:roles.edit')->name('update');
        Route::delete('{role}', [RoleController::class, 'destroy'])->middleware('can:roles.delete')->name('destroy');
    });

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('', [AdminPostController::class, 'index'])->middleware('can:posts.view')->name('index');
        Route::get('create', [AdminPostController::class, 'create'])->middleware('can:posts.create')->name('create');
        Route::post('posts', [AdminPostController::class, 'store'])->middleware('can:posts.create')->name('store');
        Route::get('{post}', [AdminPostController::class, 'show'])->middleware('can:posts.view')->name('show');
        Route::get('{post}/edit', [AdminPostController::class, 'edit'])->middleware('can:posts.edit')->name('edit');
        Route::put('{post}', [AdminPostController::class, 'update'])->middleware('can:posts.edit')->name('update');
        Route::delete('{post}', [AdminPostController::class, 'destroy'])->middleware('can:posts.delete')->name('destroy');
    });
});

Route::resource('posts', PostController::class);
