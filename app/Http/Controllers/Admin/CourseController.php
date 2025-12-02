<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Response;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.pages.courses', compact('courses'));
    }

    public function create()
    {
        return view('admin.pages.create_course');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:courses',
            'credit_hours' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Course::create([
            'name' => $request->name,
            'code' => $request->code,
            'credit_hours' => $request->credit_hours,
            'description' => $request->description,
            'status' => true,
        ]);

        return redirect()->route('admin.courses')->with('success', 'Course created successfully');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.pages.edit_course', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:courses,code,' . $id,
            'credit_hours' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = Course::findOrFail($id);
        $course->update([
            'name' => $request->name,
            'code' => $request->code,
            'credit_hours' => $request->credit_hours,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return back()->with('success', 'Course deleted successfully');
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
                $existingCourse = Course::where('code', $row[1])->first();
                if (!$existingCourse) {
                    Course::create([
                        'name' => $row[0],
                        'code' => $row[1],
                        'credit_hours' => $row[2] ?? null,
                        'description' => $row[3] ?? null,
                        'status' => true,
                    ]);
                    $imported++;
                }
            }
        }

        return back()->with('success', "Successfully imported {$imported} courses");
    }

    public function download()
    {
        $courses = Course::all();

        $csvData = "Name,Code,Credit Hours,Description,Status,Created Date\n";
        foreach ($courses as $course) {
            $csvData .= '"' . $course->name . '","' . $course->code . '","' . ($course->credit_hours ?? 'N/A') . '","' . ($course->description ?? 'N/A') . '","' . ($course->status ? 'Active' : 'Inactive') . '","' . $course->created_at->format('Y-m-d') . '"' . "\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="courses_' . date('Y-m-d') . '.csv"',
        ]);
    }

    public function csvFormat()
    {
        $csvData = "name,code,credit_hours,description\n";
        $csvData .= "Web Development,WD101,40,Introduction to Web Development\n";
        $csvData .= "Data Science,DS201,60,Advanced Data Science Course\n";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="course_import_format.csv"',
        ]);
    }

    public function data(Request $request)
    {
        $query = Course::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
        $orderColumn = $request->get('order.0.column', 4);
        $orderDir = $request->get('order.0.dir', 'desc');

        // Order mapping
        $columns = ['name', 'code', 'credit_hours', 'status', 'created_at', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        if ($orderBy === 'created_at') {
            $query->orderBy('created_at', $orderDir);
        } elseif ($orderBy === 'name') {
            $query->orderBy('name', $orderDir);
        } elseif ($orderBy === 'code') {
            $query->orderBy('code', $orderDir);
        } elseif ($orderBy === 'status') {
            $query->orderBy('status', $orderDir);
        }

        $totalRecords = Course::count();
        $filteredRecords = $query->count();

        $courses = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($courses as $course) {
            $courseColors = ['bg-blue-50 text-blue-700 border-blue-100', 'bg-purple-50 text-purple-700 border-purple-100', 'bg-emerald-50 text-emerald-700 border-emerald-100'];
            $courseColor = $courseColors[abs(crc32($course->code)) % count($courseColors)];
            $statusColor = $course->status ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100';

            $data[] = [
                'row_url' => route('admin.courses.edit', $course->id),
                'name' => '<div class="flex items-center"><div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">' . substr($course->name, 0, 1) . '</div><div class="text-sm font-medium text-gray-900">' . $course->name . '</div></div>',
                'code' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $courseColor . ' border shadow-sm">' . $course->code . '</span>',
                'credit_hours' => $course->credit_hours ?? '-----',
                'status' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $statusColor . ' border shadow-sm">' . ($course->status ? 'Active' : 'Inactive') . '</span>',
                'created_at' => $course->created_at->format('j M Y'),
                'actions' => '<div class="relative"><button onclick="toggleDropdown(' . $course->id . ')" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors"><i class="bi bi-three-dots-vertical"></i></button><div id="dropdown-' . $course->id . '" class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border"><a href="' . route('admin.courses.edit', $course->id) . '" class="block px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md"><i class="bi bi-pencil mr-2"></i>Edit</a><a href="#" onclick="deleteCourse(' . $course->id . ')" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md"><i class="bi bi-trash mr-2"></i>Delete</a></div></div>'
            ];
        }

        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
}