<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin' || $user->role === 'coordinator') {
            return view('admin.pages.profile', compact('user'));
        } elseif ($user->role === 'rto') {
            return view('rto.pages.profile', compact('user'));
        } else {
            return view('user.pages.profile', compact('user'));
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ];

        if ($user->role === 'rto') {
            $rules['code'] = 'required|string|unique:users,code,' . $user->id;
            $rules['contact_person'] = 'required|string|max:255';
            $rules['website'] = 'nullable|url';
        } elseif ($user->role === 'user') {
            $rules['address'] = 'nullable|string';
        }

        $request->validate($rules);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($user->role === 'rto') {
            $updateData['code'] = $request->code;
            $updateData['contact_person'] = $request->contact_person;
            $updateData['website'] = $request->website;
        } elseif ($user->role === 'user') {
            $updateData['address'] = $request->address;
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);
        return back()->with('success', 'Profile updated successfully');
    }
}