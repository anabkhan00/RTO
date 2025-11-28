<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Models\RtoStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RtoController extends Controller
{
    public function dashboard()
    {
        $studentIds = RtoStudent::pluck('student_id');

        $totalStudents = $studentIds->count();
        $activeCourses = Course::count();
        $thisMonthStudents = User::whereIn('id', $studentIds)
            ->whereMonth('created_at', now()->month)
            ->count();
        $completedStudents = 0; // Placeholder
        $recentStudents = User::whereIn('id', $studentIds)
            ->latest()
            ->take(5)
            ->get();
        $students = User::with('course')->whereIn('id', $studentIds)->latest()->get();

        return view('admin.pages.dashboard', compact(
            'totalStudents',
            'activeCourses',
            'thisMonthStudents',
            'completedStudents',
            'recentStudents',
            'students'
        ));
    }

    public function index()
    {
        $rtos = User::where('role', 'rto')->latest()->get();
        return view('admin.pages.add_rto', compact('rtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'contact_person' => 'required|string|max:255',
            'website' => 'nullable|url',
        ]);

        $rto = User::create([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make('password'),
            'role' => 'rto',
            'contact_person' => $request->contact_person,
            'website' => $request->website,
            'status' => true,
        ]);

        $rto->assignRole('rto');
        return back()->with('success', 'RTO created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|unique:users,code,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'contact_person' => 'required|string|max:255',
            'website' => 'nullable|url',
        ]);

        $rto = User::findOrFail($id);
        $rto->update([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'contact_person' => $request->contact_person,
            'website' => $request->website,
        ]);
        return back()->with('success', 'RTO updated successfully');
    }

    public function destroy($id)
    {
        $rto = User::findOrFail($id);
        $rto->delete();
        return back()->with('success', 'RTO deleted successfully');
    }

    public function toggleStatus($id)
    {
        $rto = User::findOrFail($id);
        $rto->update(['status' => !$rto->status]);
        return back()->with('success', 'RTO status updated successfully');
    }

    public function details($id)
    {
        $rto = User::with('rtoDocuments')->findOrFail($id);
        return view('admin.pages.rto_details', compact('rto'));
    }
}
