<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            if ($user->hasRole('admin') || $user->hasRole('coordinator')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('rto')) {
                return redirect()->route('rto.dashboard');
            } elseif ($user->hasRole('user')) {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,rto',
        ];

        // Add conditional validation based on role
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
        Auth::login($user);

        if ($user->hasRole('rto')) {
            return redirect()->route('rto.dashboard');
        }
        
        return redirect()->route('user.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}