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
        return view('admin.pages.create_industry');
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
        ]);

        return redirect()->route('admin.industries')->with('success', 'Industry created successfully');
    }

    public function edit($id)
    {
        $industry = Industry::findOrFail($id);
        return view('admin.pages.edit_industry', compact('industry'));
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
                'status' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $statusColor . ' border shadow-sm">' . ($industry->status ? 'Active' : 'Inactive') . '</span>',
                'created_at' => $industry->created_at->format('j M Y'),
                'actions' => '<div class="relative"><button onclick="toggleDropdown(' . $industry->id . ')" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors"><i class="bi bi-three-dots-vertical"></i></button><div id="dropdown-' . $industry->id . '" class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border"><a href="' . route('admin.industries.edit', $industry->id) . '" class="block px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md"><i class="bi bi-pencil mr-2"></i>Edit</a><a href="#" onclick="toggleStatus(' . $industry->id . ')" class="block px-4 py-2 text-sm text-green-600 hover:bg-green-50 rounded-md"><i class="bi bi-toggle-on mr-2"></i>Toggle Status</a><a href="#" onclick="deleteIndustry(' . $industry->id . ')" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md"><i class="bi bi-trash mr-2"></i>Delete</a></div></div>'
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
