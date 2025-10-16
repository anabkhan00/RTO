<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function roles()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.pages.roles', compact('roles'));
    }

    public function permissions()
    {
        $permissions = Permission::all();
        return view('admin.pages.permissions', compact('permissions'));
    }

    public function assignPermissions()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.pages.assign-permissions', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        Role::create(['name' => $request->name]);
        return back()->with('success', 'Role created successfully');
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:roles,name,' . $id]);
        $role = Role::findById($id);
        $role->update(['name' => $request->name]);
        return back()->with('success', 'Role updated successfully');
    }

    public function deleteRole($id)
    {
        $role = Role::findById($id);
        if (!in_array($role->name, ['admin', 'user', 'rto'])) {
            $role->delete();
            return back()->with('success', 'Role deleted successfully');
        }
        return back()->with('error', 'Cannot delete system roles');
    }

    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions']);
        Permission::create(['name' => $request->name]);
        return back()->with('success', 'Permission created successfully');
    }

    public function updatePermission(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $id]);
        $permission = Permission::findById($id);
        $permission->update(['name' => $request->name]);
        return back()->with('success', 'Permission updated successfully');
    }

    public function deletePermission($id)
    {
        $permission = Permission::findById($id);
        $permission->delete();
        return back()->with('success', 'Permission deleted successfully');
    }

    public function updateRolePermissions(Request $request)
    {
        $role = Role::findById($request->role_id);
        $role->syncPermissions($request->permissions ?? []);
        return back()->with('success', 'Permissions assigned successfully');
    }
}