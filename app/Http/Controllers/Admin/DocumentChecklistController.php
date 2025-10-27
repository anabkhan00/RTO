<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentChecklist;
use Illuminate\Http\Request;

class DocumentChecklistController extends Controller
{
    public function index()
    {
        $checklists = DocumentChecklist::latest()->get();
        return view('admin.pages.document_checklist', compact('checklists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DocumentChecklist::create($request->all());
        return back()->with('success', 'Document checklist created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $checklist = DocumentChecklist::findOrFail($id);
        $checklist->update($request->all());
        return back()->with('success', 'Document checklist updated successfully');
    }

    public function destroy($id)
    {
        DocumentChecklist::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $checklist = DocumentChecklist::findOrFail($id);
        $checklist->update(['status' => !$checklist->status]);
        return response()->json(['success' => true]);
    }
}