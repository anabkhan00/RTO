<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\RtoStudent;
use App\Models\StudentNote;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RtoController extends Controller
{
    public function dashboard()
    {
        $rtoId = Auth::id();
        $studentIds = RtoStudent::where('rto_id', $rtoId)->pluck('student_id');

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

        return view('rto.pages.dashboard', compact(
            'totalStudents',
            'activeCourses',
            'thisMonthStudents',
            'completedStudents',
            'recentStudents',
            'students'
        ));
    }

    public function students()
    {
        $rtoId = Auth::id();
        $studentIds = RtoStudent::where('rto_id', $rtoId)->pluck('student_id');
        $students = User::with('course')->whereIn('id', $studentIds)->latest()->get();
        $courses = Course::where('status', true)->get();
        return view('rto.pages.students', compact('students', 'courses'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'course_id' => $request->course_id,
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $student->assignRole('user');

        // Link student to current RTO
        RtoStudent::create([
            'rto_id' => Auth::id(),
            'student_id' => $student->id
        ]);

        return back()->with('success', 'Student created successfully');
    }

    public function updateStudent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student = User::findOrFail($id);
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'course_id' => $request->course_id,
        ]);

        return back()->with('success', 'Student updated successfully');
    }

    public function saveStudentNotes(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $userRole = $user->getRoleNames()->first() ?? 'user';

        $note = StudentNote::create([
            'student_id' => $id,
            'author_id' => $user->id,
            'content' => $request->content,
            'author_role' => $userRole
        ]);

        $note->load('author');

        return response()->json([
            'success' => true,
            'note' => [
                'content' => $note->content,
                'author_role' => $note->author_role,
                'author_name' => $note->author->name,
                'created_at' => $note->created_at->format('M j, Y')
            ]
        ]);
    }

    public function destroyStudent($id)
    {
        $rtoId = Auth::id();

        // Remove RTO-student relationship
        RtoStudent::where('rto_id', $rtoId)->where('student_id', $id)->delete();

        // Only delete user if they're not linked to other RTOs
        $otherRtoLinks = RtoStudent::where('student_id', $id)->count();
        if ($otherRtoLinks == 0) {
            $student = User::findOrFail($id);
            $student->delete();
        }

        return back()->with('success', 'Student removed successfully');
    }

    public function uploadStudents(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);

        $imported = 0;
        foreach ($rows as $row) {
            if (count($row) >= 2 && !empty($row[0]) && !empty($row[1])) {
                $existingUser = User::where('email', $row[1])->first();
                if (!$existingUser) {
                    $courseId = null;
                    if (!empty($row[4])) {
                        $course = Course::where('code', $row[4])->first();
                        $courseId = $course ? $course->id : null;
                    }

                    $student = User::create([
                        'name' => $row[0],
                        'email' => $row[1],
                        'phone' => $row[2] ?? null,
                        'address' => $row[3] ?? null,
                        'course_id' => $courseId,
                        'password' => Hash::make('password'),
                        'role' => 'user',
                    ]);
                    $student->assignRole('user');

                    // Link student to current RTO
                    RtoStudent::create([
                        'rto_id' => Auth::id(),
                        'student_id' => $student->id
                    ]);

                    $imported++;
                }
            }
        }

        return back()->with('success', "Successfully imported {$imported} students");
    }

    public function profile()
    {
        $user = Auth::user();
        return view('rto.pages.profile', compact('user'));
    }

    public function updateProfile(Request $request)
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

    public function csvFormat()
    {
        $csvData = "name,email,phone,address,course_code\n";
        $csvData .= "John Doe,john@example.com,1234567890,123 Main St,CS101\n";
        $csvData .= "Jane Smith,jane@example.com,0987654321,456 Oak Ave,IT201\n";

        return \Illuminate\Support\Facades\Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="student_import_format.csv"',
        ]);
    }
}
