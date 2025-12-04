<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Industry;
use Illuminate\Http\Request;
use App\Models\StudentIndustry;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StudentIndustryController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'user')
            ->with(['assignedIndustries' => function($q) {
                $q->select('industries.id', 'industries.name');
            }])
            ->get();

        $industries = Industry::where('status', true)->get();

        return view('admin.pages.assign_industry', compact('students', 'industries'));
    }

    public function bulkAssign(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'industry_id' => 'required|exists:industries,id'
        ]);

        foreach ($request->student_ids as $studentId) {

            StudentIndustry::where('student_id', $studentId)
            ->delete();

            StudentIndustry::updateOrInsert(
                    ['student_id' => $studentId, 'industry_id' => $request->industry_id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
        }

        return response()->json(['success' => true]);
    }

    public function removeAssignment(Request $request)
    {
        DB::table('student_industries')
            ->where('student_id', $request->student_id)
            ->where('industry_id', $request->industry_id)
            ->delete();

        return response()->json(['success' => true]);
    }
}
