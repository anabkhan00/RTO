<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = User::where('role', 'coordinator')->latest()->get();
        return view('admin.pages.Coordinator', compact('coordinators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
        ]);

        $coordinator = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make('password'),
            'role' => 'coordinator',
        ]);

        $coordinator->assignRole('coordinator');
        return back()->with('success', 'Coordinator created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
        ]);

        $coordinator = User::findOrFail($id);
        $coordinator->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Coordinator updated successfully');
    }

    public function destroy($id)
    {
        $coordinator = User::findOrFail($id);
        $coordinator->delete();
        return back()->with('success', 'Coordinator deleted successfully');
    }

    public function resetPassword($id)
    {
        $coordinator = User::findOrFail($id);
        $coordinator->update(['password' => Hash::make('password')]);
        return back()->with('success', 'Password reset to "password" successfully');
    }
}