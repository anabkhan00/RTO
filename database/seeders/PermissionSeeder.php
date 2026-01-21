<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $placementCooRole = Role::firstOrCreate(['name' => 'placement_coordinator']);
        $sourcingCooRole = Role::firstOrCreate(['name' => 'sourcing_coordinator']);
        $rtoRole = Role::firstOrCreate(['name' => 'rto']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Define all permissions by module
        $permissions = [
            // Dashboard
            'dashboard.view',

            // User Management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.reset_password',
            'users.toggle_status',

            // RTO Management
            'rtos.view',
            'rtos.create',
            'rtos.edit',
            'rtos.delete',
            'rtos.reset_password',
            'rtos.toggle_status',

            // Coordinator Management
            'coordinators.view',
            'coordinators.create',
            'coordinators.edit',
            'coordinators.delete',
            'coordinators.reset_password',
            'coordinators.toggle_status',

            // Student Management
            'students.view',
            'students.create',
            'students.edit',
            'students.delete',
            'students.reset_password',
            'students.toggle_status',
            'students.assign_rto',
            'students.assign_industry',
            'students.documents',
            'students.appointments',
            'students.schedules',

            // Course Management
            'courses.view',
            'courses.create',
            'courses.edit',
            'courses.delete',
            'courses.checklists',

            // Industry Management
            'industries.view',
            'industries.create',
            'industries.edit',
            'industries.delete',
            'industries.keywords',
            'industries.schedules',
            'industries.courses',

            // Document Management
            'documents.view',
            'documents.upload',
            'documents.download',
            'documents.delete',
            'documents.checklists',

            // Placement Management
            'placements.view',
            'placements.create',
            'placements.edit',
            'placements.delete',
            'placements.opportunities',
            'placements.assignments',

            // Contract Management
            'contracts.view',
            'contracts.create',
            'contracts.edit',
            'contracts.delete',

            // E-signature Management
            'esignatures.view',
            'esignatures.create',
            'esignatures.edit',
            'esignatures.delete',

            // Role & Permission Management
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.view',
            'permissions.assign',

            // Reports
            'reports.view',
            'reports.export',

            // Settings
            'settings.view',
            'settings.edit',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin gets all permissions
        $adminRole->syncPermissions(Permission::all());

        // Placement Coordinator permissions (Student module focused)
        $placementPermissions = [
            'dashboard.view',
            'students.view',
            'students.create',
            'students.edit',
            'students.delete',
            'students.reset_password',
            'students.toggle_status',
            'students.assign_rto',
            'students.assign_industry',
            'students.documents',
            'students.appointments',
            'students.schedules',
            'courses.view',
            'documents.view',
            'documents.upload',
            'documents.download',
            'documents.checklists',
            'placements.view',
            'placements.create',
            'placements.edit',
            'placements.delete',
            'placements.opportunities',
            'placements.assignments',
            'contracts.view',
            'contracts.create',
            'contracts.edit',
            'esignatures.view',
            'esignatures.create',
            'reports.view',
        ];

        $placementCooRole->syncPermissions($placementPermissions);

        // Sourcing Coordinator permissions (Industry module focused)
        $sourcingPermissions = [
            'dashboard.view',
            'industries.view',
            'industries.create',
            'industries.edit',
            'industries.delete',
            'industries.keywords',
            'industries.schedules',
            'industries.courses',
            'courses.view',
            'students.view',
            'students.assign_industry',
            'documents.view',
            'documents.upload',
            'documents.download',
            'placements.view',
            'placements.opportunities',
            'reports.view',
        ];

        $sourcingCooRole->syncPermissions($sourcingPermissions);

        // RTO permissions
        $rtoPermissions = [
            'dashboard.view',
            'students.view',
            'students.edit',
            'students.documents',
            'students.appointments',
            'students.schedules',
            'courses.view',
            'courses.create',
            'courses.edit',
            'courses.checklists',
            'documents.view',
            'documents.upload',
            'documents.download',
            'documents.delete',
            'documents.checklists',
            'contracts.view',
            'contracts.create',
            'contracts.edit',
            'esignatures.view',
            'esignatures.create',
            'esignatures.edit',
            'reports.view',
        ];

        $rtoRole->syncPermissions($rtoPermissions);

        // Create admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 1,
            ]
        );
        $admin->assignRole('admin');
    }
}
