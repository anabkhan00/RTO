<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industry;
use Illuminate\Support\Facades\Response;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::latest()->get();
        return view('admin.pages.industries', compact('industries'));
    }

    public function create()
    {
        $courses = \App\Models\Course::where('status', true)->get();
        $checklists = \App\Models\DocumentChecklist::where('status', true)->get();
        return view('admin.pages.edit_industry', compact('courses', 'checklists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:industries',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'industry_status' => 'required|in:active,inactive,blocked',
            'course_ids' => 'nullable|array',
            'checklist_ids' => 'nullable|array',
            'availability' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        Industry::create([
            'name' => $request->name,
            'description' => $request->description,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
            'status' => true,
            'industry_status' => $request->industry_status,
            'course_ids' => $request->course_ids,
            'checklist_ids' => $request->checklist_ids,
            'availability' => $request->availability,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.industries')->with('success', 'Industry created successfully');
    }

    public function edit($id)
    {
        $industry = Industry::findOrFail($id);
        $courses = \App\Models\Course::where('status', true)->get();
        $checklists = \App\Models\DocumentChecklist::where('status', true)->get();
        return view('admin.pages.edit_industry', compact('industry', 'courses', 'checklists'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:industries,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'industry_status' => 'required|in:active,inactive,blocked',
            'course_ids' => 'nullable|array',
            'checklist_ids' => 'nullable|array',
            'availability' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $industry = Industry::findOrFail($id);
        $industry->update([
            'name' => $request->name,
            'description' => $request->description,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
            'industry_status' => $request->industry_status,
            'course_ids' => $request->course_ids,
            'checklist_ids' => $request->checklist_ids,
            'availability' => $request->availability,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.industries')->with('success', 'Industry updated successfully');
    }

    public function destroy($id)
    {
        $industry = Industry::findOrFail($id);
        $industry->delete();
        return back()->with('success', 'Industry deleted successfully');
    }

    public function toggleStatus($id)
    {
        $industry = Industry::findOrFail($id);
        $industry->update(['status' => !$industry->status]);
        return back()->with('success', 'Industry status updated successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $industry = Industry::findOrFail($id);
        $industry->update(['status' => $request->status]);
        return response()->json(['success' => true]);
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
            if (count($row) >= 1 && !empty($row[0])) {
                $existingIndustry = Industry::where('name', $row[0])->first();
                if (!$existingIndustry) {
                    Industry::create([
                        'name' => $row[0],
                        'description' => $row[1] ?? null,
                        'contact_person' => $row[2] ?? null,
                        'email' => $row[3] ?? null,
                        'phone' => $row[4] ?? null,
                        'address' => $row[5] ?? null,
                        'website' => $row[6] ?? null,
                        'status' => true,
                    ]);
                    $imported++;
                }
            }
        }

        return back()->with('success', "Successfully imported {$imported} industries");
    }

    public function download()
    {
        $industries = Industry::all();

        $csvData = "Name,Description,Contact Person,Email,Phone,Address,Website,Status,Created Date\n";
        foreach ($industries as $industry) {
            $csvData .= '"' . $industry->name . '","' . ($industry->description ?? 'N/A') . '","' . ($industry->contact_person ?? 'N/A') . '","' . ($industry->email ?? 'N/A') . '","' . ($industry->phone ?? 'N/A') . '","' . ($industry->address ?? 'N/A') . '","' . ($industry->website ?? 'N/A') . '","' . ($industry->status ? 'Active' : 'Inactive') . '","' . $industry->created_at->format('Y-m-d') . '"' . "\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="industries_' . date('Y-m-d') . '.csv"',
        ]);
    }

    public function csvFormat()
    {
        $csvData = "name,description,contact_person,email,phone,address,website\n";
        $csvData .= "Healthcare,Medical and healthcare services,John Doe,john@healthcare.com,1234567890,123 Health St,https://healthcare.com\n";
        $csvData .= "Technology,IT and software services,Jane Smith,jane@tech.com,0987654321,456 Tech Ave,https://tech.com\n";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="industry_import_format.csv"',
        ]);
    }

    public function data(Request $request)
    {
        $query = Industry::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
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
        $columns = ['name', 'contact_info', 'contact_person', 'status', 'created_at', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        if ($orderBy === 'created_at') {
            $query->orderBy('created_at', $orderDir);
        } elseif ($orderBy === 'name') {
            $query->orderBy('name', $orderDir);
        } elseif ($orderBy === 'status') {
            $query->orderBy('status', $orderDir);
        } elseif ($orderBy === 'contact_person') {
            $query->orderBy('contact_person', $orderDir);
        }

        $totalRecords = Industry::count();
        $filteredRecords = $query->count();

        $industries = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($industries as $industry) {
            $industryColors = ['bg-blue-50 text-blue-700 border-blue-100', 'bg-purple-50 text-purple-700 border-purple-100', 'bg-emerald-50 text-emerald-700 border-emerald-100'];
            $industryColor = $industryColors[abs(crc32($industry->name)) % count($industryColors)];
            $statusColor = $industry->status ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100';

            $data[] = [
                'row_url' => route('admin.industries.edit', $industry->id),
                'name' => '<div class="flex items-center"><div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">' . substr($industry->name, 0, 1) . '</div><div class="text-sm font-medium text-gray-900">' . $industry->name . '</div></div>',
                'contact_info' => '<div class="space-y-1"><div class="flex items-center text-xs"><i class="bi bi-envelope mr-1"></i>' . ($industry->email ?? 'N/A') . '</div><div class="flex items-center text-xs"><i class="bi bi-phone mr-1"></i>' . ($industry->phone ?? 'N/A') . '</div></div>',
                'contact_person' => $industry->contact_person ?? '-----',
                'status' => '<select onchange="updateStatus(' . $industry->id . ', this.value)" onclick="event.stopPropagation()" class="border border-gray-300 text-xs px-2 py-1 rounded-md ' . ($industry->status ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200') . ' focus:ring-brand focus:border-brand"><option value="1"' . ($industry->status ? ' selected' : '') . '>Active</option><option value="0"' . (!$industry->status ? ' selected' : '') . '>Inactive</option></select>',
                'created_at' => $industry->created_at->format('j M Y'),
                'actions' => '<div class="text-center"><div class="relative inline-block dropdown-container" onclick="event.stopPropagation()"><button onclick="toggleDropdown(' . $industry->id . ')" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200"><i class="bi bi-three-dots-vertical text-gray-700"></i></button><div id="dropdown-' . $industry->id . '" class="dropdown-menu hidden absolute right-0 mt-2 w-32 z-[9999] bg-white shadow-lg rounded-md border py-1"><a href="#" onclick="deleteIndustry(' . $industry->id . ')" class="block px-3 py-2 text-sm text-red-600 hover:bg-red-50"><i class="bi bi-trash mr-2"></i>Delete</a></div></div></div>'
            ];
        }

        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
    public function getWeekAvailability(Request $request, $id)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        // Extract dates
        $startDate = substr($start, 0, 10);
        $endDate = substr($end, 0, 10);

        // Fetch ALL schedules that overlap with the requested range
        $schedules = \App\Models\IndustryWeeklySchedule::where('industry_id', $id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('week_start_date', [$startDate, $endDate])
                      ->orWhereBetween('week_end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('week_start_date', '<', $startDate)
                            ->where('week_end_date', '>', $endDate);
                      });
            })
            ->get();

        $events = [];

        foreach ($schedules as $schedule) {
            if ($schedule->selected_time_slots) {
                foreach ($schedule->selected_time_slots as $slot) {
                    $slot = (array) $slot;
                    $events[] = [
                        'id' => uniqid(),
                        'title' => 'Available',
                        'start' => $slot['start'] ?? null,
                        'end' => $slot['end'] ?? null,
                        'color' => '#3788d8',
                    ];
                }
            }
        }

        return response()->json($events);
    }

    public function saveWeekAvailability(Request $request, $id)
    {
        $request->validate([
            'week_start' => 'required|date',
            'events' => 'present|array',
            'total_hours' => 'required|numeric'
        ]);

        // STRICTLY force Monday as start of week to normalize data
        $weekStart = \Carbon\Carbon::parse($request->week_start)->startOfWeek(\Carbon\Carbon::MONDAY);
        $weekEnd = $weekStart->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

        \App\Models\IndustryWeeklySchedule::updateOrCreate(
            [
                'industry_id' => $id,
                'week_start_date' => $weekStart->toDateString()
            ],
            [
                'week_end_date' => $weekEnd->toDateString(),
                'selected_time_slots' => $request->events,
                'total_hours' => $request->total_hours
            ]
        );

        return response()->json(['success' => true, 'message' => 'Schedule saved successfully']);
    }
}
