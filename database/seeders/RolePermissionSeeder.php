<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $rtoRole = Role::create(['name' => 'rto']);
        $userRole = Role::create(['name' => 'user']);
        $coordinatorRole = Role::create(['name' => 'coordinator']);

        // Create permissions
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
            'view dashboard',
            'manage courses',
            'manage students',
            'manage rto',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign specific permissions to RTO
        $rtoRole->givePermissionTo(['view dashboard', 'manage courses', 'manage students']);

        // Assign permissions to coordinator (can access admin dashboard with limited permissions)
        $coordinatorRole->givePermissionTo(['view dashboard', 'manage students', 'manage courses']);

        // Assign basic permissions to user
        $userRole->givePermissionTo(['view dashboard']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');
    }
}