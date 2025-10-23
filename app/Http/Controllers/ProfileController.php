<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\RtoDocument;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load('rtoDocuments');
        
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

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'labels' => 'required|array',
            'labels.*' => 'required|string|max:255',
            'documents' => 'required|array',
            'documents.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        $user = Auth::user();
        
        foreach ($request->file('documents') as $index => $file) {
            $label = $request->labels[$index];
            
            $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('rto_documents/' . $user->id, $fileName, 'public');
            
            RtoDocument::create([
                'user_id' => $user->id,
                'label' => $label,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize()
            ]);
        }

        return back()->with('success', 'Documents uploaded successfully');
    }
}