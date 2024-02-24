<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create([
            'name'         => 'super_admin',
            'display_name' => 'Super Admin',
            'guard_name'   => 'web'

        ]);

        $user = User::factory()->create([
            'email' => 'admin@admin.com'
        ]);

        $user->assignRole($role);
    }
}
