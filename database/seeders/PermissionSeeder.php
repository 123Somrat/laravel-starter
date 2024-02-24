<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['name' => 'posts.create', 'display_name' => 'Create Post', 'module' => 'Post', 'guard_name' => 'web'],
            ['name' => 'posts.edit', 'display_name' => 'Edit Post', 'module' => 'Post', 'guard_name' => 'web'],
            ['name' => 'posts.delete', 'display_name' => 'Delete Post', 'module' => 'Post', 'guard_name' => 'web'],
            ['name' => 'posts.view', 'display_name' => 'View Post', 'module' => 'Post', 'guard_name' => 'web'],
            ['name' => 'roles.view', 'display_name' => 'View Role', 'module' => 'Role', 'guard_name' => 'web'],
            ['name' => 'roles.create', 'display_name' => 'Create Role', 'module' => 'Role', 'guard_name' => 'web'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Role', 'module' => 'Role', 'guard_name' => 'web'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Role', 'module' => 'Role', 'guard_name' => 'web'],
            ['name' => 'users.view', 'display_name' => 'View User', 'module' => 'User', 'guard_name' => 'web'],
            ['name' => 'users.create', 'display_name' => 'Create User', 'module' => 'User', 'guard_name' => 'web'],
            ['name' => 'users.edit', 'display_name' => 'Edit User', 'module' => 'User', 'guard_name' => 'web'],
            ['name' => 'users.delete', 'display_name' => 'Delete User', 'module' => 'User', 'guard_name' => 'web'],
            ['name' => 'users.assign_role', 'display_name' => 'Assign User Role', 'module' => 'User', 'guard_name' => 'web']
        ]);
    }
}
