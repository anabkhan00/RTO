<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlacementOpportunity;
use App\Models\Industry;

class PlacementOpportunityController extends Controller
{
    public function index()
    {
        $opportunities = PlacementOpportunity::with(['industry', 'sourcingCoordinator'])
            ->where('sourcing_coordinator_id', auth()->id())
            ->get();
        
        return view('admin.pages.placement_opportunities', compact('opportunities'));
    }

    public function create()
    {
        $industries = Industry::where('status', true)->get();
        return view('admin.pages.create_opportunity', compact('industries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'total_slots' => 'required|integer|min:1',
            'requirements' => 'nullable|string'
        ]);

        PlacementOpportunity::create([
            'industry_id' => $request->industry_id,
            'sourcing_coordinator_id' => auth()->id(),
            'total_slots' => $request->total_slots,
            'requirements' => $request->requirements
        ]);

        return redirect()->route('admin.placement-opportunities')->with('success', 'Placement opportunity created successfully');
    }

    public function edit($id)
    {
        $opportunity = PlacementOpportunity::where('sourcing_coordinator_id', auth()->id())->findOrFail($id);
        $industries = Industry::where('status', true)->get();
        return view('admin.pages.edit_opportunity', compact('opportunity', 'industries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'total_slots' => 'required|integer|min:1',
            'requirements' => 'nullable|string'
        ]);

        $opportunity = PlacementOpportunity::where('sourcing_coordinator_id', auth()->id())->findOrFail($id);
        $opportunity->update($request->only(['industry_id', 'total_slots', 'requirements']));

        return redirect()->route('admin.placement-opportunities')->with('success', 'Opportunity updated successfully');
    }

    public function destroy($id)
    {
        PlacementOpportunity::where('sourcing_coordinator_id', auth()->id())->findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $opportunity = PlacementOpportunity::where('sourcing_coordinator_id', auth()->id())->findOrFail($id);
        $opportunity->update(['status' => !$opportunity->status]);
        return response()->json(['success' => true]);
    }

    public function viewStudents($id)
    {
        $opportunity = PlacementOpportunity::with(['industry', 'assignments.student', 'assignments.placementCoordinator'])
            ->where('sourcing_coordinator_id', auth()->id())
            ->findOrFail($id);
        
        $assignments = $opportunity->assignments;
        
        return view('admin.pages.opportunity_students', compact('opportunity', 'assignments'));
    }

    public function viewStudentDocuments($opportunityId, $studentId)
    {
        $opportunity = PlacementOpportunity::where('sourcing_coordinator_id', auth()->id())->findOrFail($opportunityId);
        $student = \App\Models\User::findOrFail($studentId);
        $documents = \App\Models\StudentDocument::where('student_id', $studentId)->get();
        
        return view('admin.pages.student_documents_view', compact('opportunity', 'student', 'documents'));
    }

    public function getByIndustry($industryId)
    {
        $opportunities = PlacementOpportunity::with('course')
            ->where('industry_id', $industryId)
            ->get();
        
        return response()->json(['opportunities' => $opportunities]);
    }
}