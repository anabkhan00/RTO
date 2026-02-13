<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Industry;
use App\Models\RtoStudent;
use App\Models\StudentNote;
use Illuminate\Http\Request;
use App\Models\StudentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $students = User::with(['course', 'studentDetail'])->whereIn('id', $studentIds)->latest()->get();
        $mapStudents = User::with(['course', 'studentDetail'])
            ->whereIn('id', $studentIds)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();
        $mapIndustries = Industry::whereNotNull('latitude')->whereNotNull('longitude')->get();

        return view('rto.pages.dashboard', compact(
            'totalStudents',
            'activeCourses',
            'thisMonthStudents',
            'completedStudents',
            'recentStudents',
            'students',
            'mapStudents',
            'mapIndustries'
        ));
    }

    public function students()
    {
        $courses = Course::where('status', true)->get();
        return view('rto.pages.students', compact('courses'));
    }

    public function create()
    {
        $courses = Course::where('status', true)->get();
        $industries = Industry::all();
        return view('rto.pages.create_student', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'course_id' => 'nullable|exists:courses,id',
            'priority' => 'nullable|string',
            'industry_id' => 'nullable|exists:industries,id',
            'emergency_contact' => 'nullable|string|max:20',
            'placement_hours' => 'nullable|numeric|min:0',
            'student_status' => 'nullable|in:active,inactive,blocked',
            'interview_status' => 'nullable|string',
            'medical_condition' => 'nullable|string',
            'transport' => 'nullable|string|max:255',
            'placement_data' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'course_id' => $request->course_id,
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        if ($request->rto_id) {
            RtoStudent::create([
                'rto_id' => $request->rto_id,
                'student_id' => $student->id,
            ]);
        } else {
            RtoStudent::create([
                'rto_id' => Auth::id(),
                'student_id' => $student->id,
            ]);
        }

        $daysLeft = null;
        $placementBookedAt = null;

        StudentDetail::create([
            'user_id' => $student->id,
            'priority' => $request->priority,
            'industry_id' => $request->industry_id,
            'days_left' => $daysLeft,
            'placement_booked_at' => $placementBookedAt,
            'emergency_contact' => $request->emergency_contact,
            'placement_hours' => $request->placement_hours,
            'student_status' => $request->student_status ?? 'active',
            'interview_status' => $request->interview_status,
            'medical_condition' => $request->medical_condition,
            'transport' => $request->transport,
            'placement_data' => $request->placement_data,
            'gender' => $request->gender,
        ]);

        $student->assignRole('user');
        return redirect()->route('rto.students')->with('success', 'Student created successfully');
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'course_id' => 'nullable|exists:courses,id',
            'rto_id' => 'nullable|exists:users,id',
            'priority' => 'nullable|string',
            'progress_status' => 'nullable|string',
            'industry_id' => 'nullable|exists:industries,id',
            'emergency_contact' => 'nullable|string|max:20',
            'placement_hours' => 'nullable|numeric|min:0',
            'student_status' => 'nullable|in:active,inactive,blocked',
            'interview_status' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'medical_condition' => 'nullable|string',
            'transport' => 'nullable|string|max:255',
            'placement_data' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $student = User::findOrFail($id);

        $profileImagePath = $student->profile_image;

        if ($request->hasFile('profile_image')) {
            if ($profileImagePath && Storage::disk('public')->exists($profileImagePath)) {
                Storage::disk('public')->delete($profileImagePath);
            }
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'course_id' => $request->course_id,
            'profile_image' => $profileImagePath,
        ]);

        if ($request->rto_id) {
            RtoStudent::updateOrCreate(
                ['student_id' => $student->id],
                ['rto_id' => $request->rto_id]
            );
        }

        $daysLeft = null;
        $placementBookedAt = null;

        if ($request->progress_status === 'booked_placements') {
            $existingDetail = StudentDetail::where('user_id', $student->id)->first();
            if (!$existingDetail || $existingDetail->progress_status !== 'booked_placements') {
                $daysLeft = 120;
                $placementBookedAt = now();
            }
        }

        StudentDetail::updateOrCreate(
            ['user_id' => $student->id],
            [
                'priority' => $request->priority,
                'progress_status' => $request->progress_status ?? 'awaiting_placements',
                'industry_id' => $request->industry_id,
                'days_left' => $daysLeft,
                'placement_booked_at' => $placementBookedAt,
                'emergency_contact' => $request->emergency_contact,
                'placement_hours' => $request->placement_hours,
                'student_status' => $request->student_status,
                'interview_status' => $request->interview_status,
                'medical_condition' => $request->medical_condition,
                'transport' => $request->transport,
                'placement_data' => $request->placement_data,
                'gender' => $request->gender,
            ]
        );

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
        try {
            $rtoId = Auth::id();

            // Remove current RTO-student relationship.
            RtoStudent::where('rto_id', $rtoId)->where('student_id', $id)->delete();

            // Delete student only if no other RTO links remain.
            $otherRtoLinks = RtoStudent::where('student_id', $id)->count();
            if ($otherRtoLinks === 0) {
                $student = User::findOrFail($id);
                $student->delete();
            }

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Student removed successfully',
                ]);
            }

            return back()->with('success', 'Student removed successfully');
        } catch (\Throwable $e) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove student',
                ], 500);
            }

            return back()->with('error', 'Failed to remove student');
        }
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

    public function industries()
    {
        $industries = Industry::latest()->get();

        return view('rto.pages.industries', compact('industries'));
    }

    public function data(Request $request)
    {
        $rtoId = Auth::id();

        // Get only students assigned to this RTO
        $studentIds = RtoStudent::where('rto_id', $rtoId)
            ->pluck('student_id');

        $query = User::with([
            'course',
            'studentDetail.industry',
            'assignmentRequests.sourcingCoordinator'
        ])
            ->where('role', 'user')
            ->whereIn('id', $studentIds);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('address', 'like', "%{$request->location}%");
        }

        if ($request->filled('priority')) {
            $query->whereHas('studentDetail', function ($q) use ($request) {
                $q->where('priority', $request->priority);
            });
        }

        if ($request->filled('course')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->course}%");
            });
        }

        if ($request->filled('progress')) {
            $query->whereHas('studentDetail', function ($q) use ($request) {
                $q->where('progress_status', $request->progress);
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $start = $request->get('start', 0);
        $length = $request->get('length', 25);
        $orderColumn = $request->get('order.0.column', 6);
        $orderDir = $request->get('order.0.dir', 'desc');

        $columns = ['name', 'industry', 'course', 'days_left', 'progress', 'status', 'coordinator', 'address', 'created_at', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        if ($orderBy === 'created_at') {
            $query->orderBy('created_at', $orderDir);
        } elseif ($orderBy === 'address') {
            $query->orderBy('address', $orderDir);
        } elseif ($orderBy === 'name') {
            $query->orderBy('name', $orderDir);
        }

        $totalRecords = User::where('role', 'user')
            ->whereIn('id', $studentIds)
            ->count();
        $filteredRecords = $query->count();

        $students = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($students as $student) {
            $detail = $student->studentDetail;
            $industry = $detail && $detail->industry ? $detail->industry->name : 'N/A';
            $courseName = $student->course->name ?? 'No Course';

            $daysLeft = $detail ? intval($detail->days_left ?? 0) : 0;

            $progressFull = $detail && $detail->progress_status ? str_replace('_', ' ', ucwords($detail->progress_status, '_')) : 'Awaiting Placements';
            $progress = explode(' ', $progressFull)[0];

            $industryColors = ['bg-blue-50 text-blue-700 border-blue-100', 'bg-purple-50 text-purple-700 border-purple-100', 'bg-emerald-50 text-emerald-700 border-emerald-100'];
            $courseColors = ['bg-orange-50 text-orange-700 border-orange-100', 'bg-pink-50 text-pink-700 border-pink-100', 'bg-indigo-50 text-indigo-700 border-indigo-100'];

            $industryColor = $industryColors[abs(crc32($industry)) % count($industryColors)];
            $courseColor = $courseColors[abs(crc32($courseName)) % count($courseColors)];
            $daysColor = $daysLeft > 90 ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : ($daysLeft >= 30 ? 'bg-orange-50 text-orange-700 border-orange-100' : 'bg-red-50 text-red-700 border-red-100');

            $actionsHtml = '';

            // Get assigned sourcing coordinator
            $assignedCoordinator = $student->assignmentRequests()->whereIn('status', ['pending', 'in_progress'])->with('sourcingCoordinator')->first();
            $coordinatorDisplay = $assignedCoordinator && $assignedCoordinator->sourcingCoordinator
                ? '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border-blue-100 border shadow-sm">' . $assignedCoordinator->sourcingCoordinator->name . '</span>'
                : '<span class="text-sm text-gray-600">Not Assigned</span>';


            $actionsHtml = '
        <div class="text-center flex justify-center gap-2">
            <div class="relative inline-block dropdown-container" onclick="event.stopPropagation()">
                <button onclick="toggleDropdown(' . $student->id . ')"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200">
                    <i class="bi bi-three-dots-vertical text-gray-700"></i>
                </button>
                <div id="dropdown-' . $student->id . '"
                     class="dropdown-menu hidden absolute right-0 mt-2 w-32 z-[9999] bg-white shadow-lg rounded-md border py-1">
                    <a href="#" class="delete-student block px-3 py-2 text-sm text-red-600 hover:bg-red-50" data-student-id="' . $student->id . '" onclick="deleteStudent(this.dataset.studentId); return false;">
                       <i class="bi bi-trash mr-2"></i>Delete
                    </a>
                </div>
            </div>
        </div>';

            $data[] = [
                'row_url' => route('rto.student-documents.index', $student->id),
                'checkbox' => Auth::user()->hasRole('placement_coordinator') ? '<input type="checkbox" class="student-checkbox rounded border-gray-300" value="' . $student->id . '">' : '',
                'name' => '<div class="flex items-center"><div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">' . substr($student->name, 0, 1) . '</div><div class="text-sm font-medium text-gray-900">' . $student->name . '</div></div>',
                'industry' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $industryColor . ' border shadow-sm">' . $industry . '</span>',
                'course' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $courseColor . ' border shadow-sm">' . $courseName . '</span>',
                // 'days_left' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $daysColor . ' border shadow-sm">' . $daysLeft . ' Days left</span>',
                'progress' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border-indigo-100 border shadow-sm"><i class="bi bi-person mr-1"></i>' . $progress . '</span>',
                'status' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-green-50 text-green-700 border-green-100 border shadow-sm">Active</span>',
                'coordinator' => $coordinatorDisplay,
                'address' => $student->address ?? '-----',
                'created_at' => $student->created_at->format('j M Y'),
                'actions' => $actionsHtml,
            ];
        }

        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
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
