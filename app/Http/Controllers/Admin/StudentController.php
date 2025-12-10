<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Models\Industry;
use App\Models\RtoStudent;
use App\Models\RTOIndustry;
use Illuminate\Http\Request;
use App\Models\StudentDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::with('course')->where('role', 'user')->latest()->get();
        $courses = Course::where('status', true)->get();
        $rtos = User::where('role', 'rto')->latest()->get();
        $industries = Industry::all();
        return view('admin.pages.students', compact('students', 'courses', 'rtos', 'industries'));
    }

    public function create()
    {
        $courses = Course::where('status', true)->get();
        $industries = Industry::all();
        $rtos = User::where('role', 'rto')->latest()->get();
        return view('admin.pages.create_student', compact('courses', 'industries', 'rtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'rto' => 'nullable|exists:users,id',
            'priority' => 'nullable|string',
            'progress_status' => 'nullable|string',
            'industry_id' => 'nullable|exists:industries,id',
        ]);

        $daysLeft = null;
        $placementBookedAt = null;

        if ($request->progress_status === 'booked_placements') {
            $daysLeft = 120;
            $placementBookedAt = now();
        }

        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'course_id' => $request->course_id,
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        RtoStudent::create([
            'rto_id' => $request->rto_id,
            'student_id' => $student->id,
        ]);

        StudentDetail::create([
            'user_id' => $student->id,
            'priority' => $request->priority,
            'progress_status' => $request->progress_status ?? 'awaiting_placements',
            'industry_id' => $request->industry_id,
            'days_left' => $daysLeft,
            'placement_booked_at' => $placementBookedAt,
        ]);

        $student->assignRole('user');
        return redirect()->route('admin.students')->with('success', 'Student created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'rto_id' => 'nullable|exists:users,id',
            'priority' => 'nullable|string',
            'progress_status' => 'nullable|string',
            'industry_id' => 'nullable|exists:industries,id',
            'emergency_contact' => 'nullable|string|max:20',
            'placement_hours'   => 'nullable|numeric|min:0',
            'student_status' => 'nullable|in:active,inactive,blocked',
            'profile_image' => 'nullable',
        ]);

        $student = User::findOrFail($id);

        $profileImagePath = $student->profile_image;

        if ($request->hasFile('profile_image')) {
            // delete old image if exists
            if ($profileImagePath && Storage::exists($profileImagePath)) {
                Storage::delete($profileImagePath);
            }

            // save new image
            $profileImagePath = $request->file('profile_image')->store('profile_images');
        }

        // Update student main info
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'emergency_contact' => $request->emergency_contact,
            'placement_hours' => $request->placement_hours,
            'student_status' => $request->student_status,
            'address' => $request->address,
            'course_id' => $request->course_id,
            'profile_image' => $profileImagePath,
        ]);

        // Update or create student RTO assignment
        RtoStudent::updateOrCreate(
            ['student_id' => $student->id],
            ['rto_id' => $request->rto_id]
        );

        // Update or create student detail
        $daysLeft = null;
        $placementBookedAt = null;

        if ($request->progress_status === 'booked_placements') {
            $daysLeft = 0;
            $placementBookedAt = now();
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
            ]
        );

        return back()->with('success', 'Student updated successfully');
    }


    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();
        return back()->with('success', 'Student deleted successfully');
    }

    public function upload(Request $request)
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
                        $course = \App\Models\Course::where('code', $row[4])->first();
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
                    $imported++;
                }
            }
        }

        return back()->with('success', "Successfully imported {$imported} students");
    }

    public function download()
    {
        $students = User::where('role', 'user')->get();

        $csvData = "Name,Email,Phone,Address,Created Date\n";
        foreach ($students as $student) {
            $csvData .= '"' . $student->name . '","' . $student->email . '","' . ($student->phone ?? 'N/A') . '","' . ($student->address ?? 'N/A') . '","' . $student->created_at->format('Y-m-d') . '"' . "\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students_' . date('Y-m-d') . '.csv"',
        ]);
    }

    public function csvFormat()
    {
        $csvData = "name,email,phone,address,course_code\n";
        $csvData .= "John Doe,john@example.com,1234567890,123 Main St,CS101\n";
        $csvData .= "Jane Smith,jane@example.com,0987654321,456 Oak Ave,IT201\n";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="student_import_format.csv"',
        ]);
    }

    public function data(Request $request)
    {
        $query = User::with(['course', 'studentDetail.industry', 'assignedCoordinator'])->where('role', 'user');
        
        // Filter by coordinator assignment
        if (auth()->user()->role === 'coordinator') {
            $query->where('assigned_coordinator_id', auth()->id());
        }

        // Apply filters
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

        // Get pagination parameters
        $start = $request->get('start', 0);
        $length = $request->get('length', 25);
        $orderColumn = $request->get('order.0.column', 6);
        $orderDir = $request->get('order.0.dir', 'desc');

        // Order mapping
        $columns = ['name', 'industry', 'course', 'days_left', 'progress', 'status', 'coordinator', 'address', 'created_at', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        if ($orderBy === 'created_at') {
            $query->orderBy('created_at', $orderDir);
        } elseif ($orderBy === 'address') {
            $query->orderBy('address', $orderDir);
        } elseif ($orderBy === 'name') {
            $query->orderBy('name', $orderDir);
        }

        $totalRecords = User::where('role', 'user')->count();
        $filteredRecords = $query->count();

        $students = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($students as $student) {
            $detail = $student->studentDetail;
            $industry = $detail && $detail->industry ? $detail->industry->name : 'Healthcare';
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

            $statusColor = $student->student_status === 'active' ? 'bg-green-50 text-green-700 border-green-200' :
                          ($student->student_status === 'inactive' ? 'bg-gray-50 text-gray-700 border-gray-200' : 'bg-red-50 text-red-700 border-red-200');

            $statusHtml = '<select onchange="updateStudentStatus(' . $student->id . ', this.value)" onclick="event.stopPropagation()" class="border border-gray-300 text-xs px-2 py-1 rounded-md ' . $statusColor . ' focus:ring-brand focus:border-brand">
                <option value="active"' . ($student->student_status === 'active' ? ' selected' : '') . '>Active</option>
                <option value="inactive"' . ($student->student_status === 'inactive' ? ' selected' : '') . '>Inactive</option>
                <option value="blocked"' . ($student->student_status === 'blocked' ? ' selected' : '') . '>Blocked</option>
            </select>';

            $actionsHtml = '';

            if (auth()->user()->role === 'admin') {
                // Admin: Assign Coordinator + Delete buttons
                $actionsHtml = '
                <div class="flex justify-center gap-2">
                    <button onclick="assignCoordinator(' . $student->id . ')" 
                            class="text-blue-600 hover:text-blue-800 transition-colors p-1 rounded-full hover:bg-blue-50" 
                            title="Assign Coordinator">
                        <i class="bi bi-person-plus"></i>
                    </button>
                    <button onclick="deleteStudent(' . $student->id . ')"
                            class="text-red-600 hover:text-red-800 transition-colors p-1 rounded-full hover:bg-red-50"
                            title="Delete Student">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>';
            }

            $coordinatorName = $student->assignedCoordinator ? $student->assignedCoordinator->name : 'Unassigned';
            $coordinatorColor = $student->assignedCoordinator ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-gray-50 text-gray-700 border-gray-100';
            
            $data[] = [
                'row_url' => route('admin.student-documents.index', $student->id),
                'name' => '<div class="flex items-center"><div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">' . substr($student->name, 0, 1) . '</div><div class="text-sm font-medium text-gray-900">' . $student->name . '</div></div>',
                'industry' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $industryColor . ' border shadow-sm">' . $industry . '</span>',
                'course' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $courseColor . ' border shadow-sm">' . $courseName . '</span>',
                'days_left' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $daysColor . ' border shadow-sm">' . $daysLeft . ' Days left</span>',
                'progress' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border-indigo-100 border shadow-sm"><i class="bi bi-person mr-1"></i>' . $progress . '</span>',
                'status' => $statusHtml,
                'coordinator' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $coordinatorColor . ' border shadow-sm">' . $coordinatorName . '</span>',
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

    public function updateAvailability(Request $request, $id)
    {
        $request->validate([
            'student_availability' => 'nullable|array'
        ]);

        $student = User::findOrFail($id);
        $student->update([
            'student_availability' => $request->student_availability
        ]);

        return response()->json(['success' => true, 'message' => 'Availability updated successfully']);
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     $student = User::findOrFail($id);
    //     $student->update(['student_status' => $request->status]);
    //     return response()->json(['success' => true]);
    // }

    public function getWeekAvailability(Request $request, $id)
    {
        $student = User::findOrFail($id);
        $weeklySchedule = $student->weeklySchedules()->whereBetween('week_start_date', [
            $request->query('start'),
            $request->query('end')
        ])->first();

        $events = $weeklySchedule ? json_decode($weeklySchedule->selected_time_slots, true) : [];

        return response()->json($events);
    }

    public function saveWeekAvailability(Request $request, $id)
    {
        $request->validate([
            'events' => 'required|array',
            'events.*.start' => 'required|date_format:Y-m-d\TH:i:s',
            'events.*.end' => 'required|date_format:Y-m-d\TH:i:s',
        ]);

        $student = User::findOrFail($id);

        $weekStartDate = $request->events[0]['start'];
        $weekEndDate = $request->events[count($request->events) - 1]['end'];

        $totalHours = array_reduce($request->events, function ($carry, $event) {
            $start = new \DateTime($event['start']);
            $end = new \DateTime($event['end']);
            return $carry + ($end->getTimestamp() - $start->getTimestamp()) / 3600;
        }, 0);

        $student->weeklySchedules()->updateOrCreate(
            ['week_start_date' => $weekStartDate, 'week_end_date' => $weekEndDate],
            [
                'selected_time_slots' => json_encode($request->events),
                'total_hours' => $totalHours
            ]
        );

        return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,blocked'
        ]);

        $student = User::findOrFail($id);
        $student->update(['student_status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function assignCoordinator(Request $request, $id)
    {
        $request->validate([
            'coordinator_id' => 'nullable|exists:users,id'
        ]);

        $student = User::findOrFail($id);
        $student->update(['assigned_coordinator_id' => $request->coordinator_id]);

        return response()->json(['success' => true, 'message' => 'Coordinator assigned successfully']);
    }

    public function getCoordinators()
    {
        $coordinators = User::where('role', 'coordinator')->select('id', 'name')->get();
        return response()->json($coordinators);
    }
}
