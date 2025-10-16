<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function createUsers()
    {
        $roles = Role::all();
        return view('admin.pages.create-users', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,name',
        ];

        // Add conditional validation
        if ($request->role === 'user') {
            $validationRules['address'] = 'required|string|max:255';
        } elseif ($request->role === 'rto') {
            $validationRules['rto_number'] = 'required|string|max:255';
        }

        $request->validate($validationRules);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        // Add role-specific fields
        if ($request->role === 'user' && $request->address) {
            $userData['address'] = $request->address;
        } elseif ($request->role === 'rto' && $request->rto_number) {
            $userData['rto_number'] = $request->rto_number;
        }

        $user = User::create($userData);
        $user->assignRole($request->role);

        return back()->with('success', 'User created successfully');
    }
}