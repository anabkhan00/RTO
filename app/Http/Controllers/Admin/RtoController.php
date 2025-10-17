<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rto;

class RtoController extends Controller
{
    public function index()
    {
        $rtos = Rto::latest()->get();
        return view('admin.pages.add_rto', compact('rtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rto_number' => 'required|string|unique:rtos',
            'email' => 'required|email|unique:rtos',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'website' => 'nullable|url',
            'contact_person' => 'required|string|max:255',
        ]);

        Rto::create($request->all());
        return back()->with('success', 'RTO created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rto_number' => 'required|string|unique:rtos,rto_number,' . $id,
            'email' => 'required|email|unique:rtos,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'website' => 'nullable|url',
            'contact_person' => 'required|string|max:255',
        ]);

        $rto = Rto::findOrFail($id);
        $rto->update($request->all());
        return back()->with('success', 'RTO updated successfully');
    }

    public function destroy($id)
    {
        $rto = Rto::findOrFail($id);
        $rto->delete();
        return back()->with('success', 'RTO deleted successfully');
    }

    public function toggleStatus($id)
    {
        $rto = Rto::findOrFail($id);
        $rto->update(['status' => !$rto->status]);
        return back()->with('success', 'RTO status updated successfully');
    }
}