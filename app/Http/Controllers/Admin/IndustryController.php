<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industry;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::latest()->get();
        return view('admin.pages.Industries', compact('industries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:industries',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'website' => 'nullable|url',
        ]);

        Industry::create($request->all());
        return back()->with('success', 'Industry created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:industries,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'website' => 'nullable|url',
        ]);

        $industry = Industry::findOrFail($id);
        $industry->update($request->all());
        return back()->with('success', 'Industry updated successfully');
    }

    public function destroy($id)
    {
        $industry = Industry::findOrFail($id);
        $industry->delete();
        return back()->with('success', 'Industry deleted successfully');
    }

    public function toggleStatus($id)
    {
        $industry = Industry::findOrFail($id);
        $industry->update(['status' => !$industry->status]);
        return back()->with('success', 'Industry status updated successfully');
    }
}