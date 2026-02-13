<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PlacementAssignment;
use App\Http\Controllers\Controller;
use App\Models\PlacementOpportunity;
use Illuminate\Support\Facades\Auth;

class StudentIndustryController extends Controller
{
    public function index()
    {
        $opportunities = PlacementOpportunity::with(['industry', 'sourcingCoordinator', 'assignments.student'])
            ->where('status', true)
            ->get();

        $students = User::where('role', 'user')->get();

        $placementCoordinators = User::role('placement_coordinator')
            ->where('status', true)
            ->get();

        return view('admin.pages.assign_students', compact('opportunities', 'students', 'placementCoordinators'));
    }

    public function assignStudents(Request $request)
    {
        $request->validate([
            'opportunity_id' => 'required|exists:placement_opportunities,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        $opportunity = PlacementOpportunity::findOrFail($request->opportunity_id);

        if ($opportunity->available_slots < count($request->student_ids)) {
            return response()->json(['error' => 'Not enough available slots'], 400);
        }

        foreach ($request->student_ids as $studentId) {
            PlacementAssignment::updateOrCreate(
                [
                    'placement_opportunity_id' => $request->opportunity_id,
                    'student_id' => $studentId
                ],
                ['placement_coordinator_id' => Auth::id()]
            );
        }

        $opportunity->increment('filled_slots', count($request->student_ids));

        return response()->json(['success' => true]);
    }

    public function removeAssignment(Request $request)
    {
        $assignment = PlacementAssignment::where('placement_opportunity_id', $request->opportunity_id)
            ->where('student_id', $request->student_id)
            ->first();

        if ($assignment) {
            $assignment->delete();
            $assignment->opportunity->decrement('filled_slots');
        }

        return response()->json(['success' => true]);
    }
}
