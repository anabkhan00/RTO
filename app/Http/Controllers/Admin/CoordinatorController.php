<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = User::where('role', 'coordinator')->latest()->get();
        return view('admin.pages.coordinators', compact('coordinators'));
    }

    public function create()
    {
        return view('admin.pages.create_coordinator');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $coordinator = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make('password'),
            'role' => 'coordinator',
            'status' => true,
        ]);

        $coordinator->assignRole('coordinator');
        return redirect()->route('admin.coordinators')->with('success', 'Coordinator created successfully');
    }

    public function edit($id)
    {
        $coordinator = User::where('role', 'coordinator')->findOrFail($id);
        return view('admin.pages.edit_coordinator', compact('coordinator'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $coordinator = User::findOrFail($id);
        $coordinator->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.coordinators')->with('success', 'Coordinator updated successfully');
    }

    public function destroy($id)
    {
        $coordinator = User::findOrFail($id);
        $coordinator->delete();
        return back()->with('success', 'Coordinator deleted successfully');
    }

    public function resetPassword($id)
    {
        $coordinator = User::findOrFail($id);
        $coordinator->update(['password' => Hash::make('password')]);
        return back()->with('success', 'Password reset to "password" successfully');
    }

    public function toggleStatus($id)
    {
        $coordinator = User::findOrFail($id);
        $coordinator->update(['status' => !$coordinator->status]);
        return back()->with('success', 'Coordinator status updated successfully');
    }

    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'csv_file' => 'required|file|mimes:csv,txt'
    //     ]);

    //     $file = $request->file('csv_file');
    //     $csvData = file_get_contents($file);
    //     $rows = array_map('str_getcsv', explode("\n", $csvData));
    //     $header = array_shift($rows);

    //     $imported = 0;
    //     foreach ($rows as $row) {
    //         if (count($row) >= 2 && !empty($row[0]) && !empty($row[1])) {
    //             $existingCoordinator = User::where('email', $row[1])->first();
    //             if (!$existingCoordinator) {
    //                 $coordinator = User::create([
    //                     'name' => $row[0],
    //                     'email' => $row[1],
    //                     'phone' => $row[2] ?? null,
    //                     'address' => $row[3] ?? null,
    //                     'password' => Hash::make('password'),
    //                     'role' => 'coordinator',
    //                 ]);
    //                 $coordinator->assignRole('coordinator');
    //                 $imported++;
    //             }
    //         }
    //     }

    //     return back()->with('success', "Successfully imported {$imported} coordinators");
    // }

    // public function download()
    // {
    //     $coordinators = User::where('role', 'coordinator')->get();

    //     $csvData = "Name,Email,Phone,Address,Created Date\n";
    //     foreach ($coordinators as $coordinator) {
    //         $csvData .= '"' . $coordinator->name . '","' . $coordinator->email . '","' . ($coordinator->phone ?? 'N/A') . '","' . ($coordinator->address ?? 'N/A') . '","' . $coordinator->created_at->format('Y-m-d') . '"' . "\n";
    //     }

    //     return Response::make($csvData, 200, [
    //         'Content-Type' => 'text/csv',
    //         'Content-Disposition' => 'attachment; filename="coordinators_' . date('Y-m-d') . '.csv"',
    //     ]);
    // }

    // public function csvFormat()
    // {
    //     $csvData = "name,email,phone,address\n";
    //     $csvData .= "John Coordinator,john@example.com,1234567890,123 Main St\n";
    //     $csvData .= "Jane Coordinator,jane@example.com,0987654321,456 Oak Ave\n";

    //     return Response::make($csvData, 200, [
    //         'Content-Type' => 'text/csv',
    //         'Content-Disposition' => 'attachment; filename="coordinator_import_format.csv"',
    //     ]);
    // }

    public function data(Request $request)
    {
        $query = User::where('role', 'coordinator');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', "%{$request->phone}%");
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
        $orderColumn = $request->get('order.0.column', 3);
        $orderDir = $request->get('order.0.dir', 'desc');

        // Order mapping
        $columns = ['name', 'email', 'phone', 'status', 'created_at', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        if ($orderBy === 'created_at') {
            $query->orderBy('created_at', $orderDir);
        } elseif ($orderBy === 'name') {
            $query->orderBy('name', $orderDir);
        } elseif ($orderBy === 'email') {
            $query->orderBy('email', $orderDir);
        } elseif ($orderBy === 'phone') {
            $query->orderBy('phone', $orderDir);
        }

        $totalRecords = User::where('role', 'coordinator')->count();
        $filteredRecords = $query->count();

        $coordinators = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($coordinators as $coordinator) {
            $statusColor = $coordinator->status ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100';

            $data[] = [
                'row_url' => route('admin.coordinators.edit', $coordinator->id),
                'name' => '<div class="flex items-center"><div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">' . substr($coordinator->name, 0, 1) . '</div><div class="text-sm font-medium text-gray-900">' . $coordinator->name . '</div></div>',
                'email' => $coordinator->email,
                'phone' => $coordinator->phone ?? '-----',
                'status' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $statusColor . ' border shadow-sm">' . ($coordinator->status ? 'Active' : 'Inactive') . '</span>',
                'created_at' => $coordinator->created_at->format('j M Y'),
                'actions' => '<div class="relative">
    <button onclick="toggleDropdown(' . $coordinator->id . ')" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
        <i class="bi bi-three-dots-vertical"></i>
    </button>
    <div id="dropdown-' . $coordinator->id . '" class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border">
        <a href="' . route('admin.coordinators.edit', $coordinator->id) . '" class="block px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md">
            <i class="bi bi-pencil mr-2"></i>Edit
        </a>
        <a href="#" onclick="toggleStatus(' . $coordinator->id . ')" class="block px-4 py-2 text-sm text-green-600 hover:bg-green-50 rounded-md">
            <i class="bi bi-toggle-on mr-2"></i>Toggle Status
        </a>
        <a href="#" onclick="deleteCoordinator(' . $coordinator->id . ')" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
            <i class="bi bi-trash mr-2"></i>Delete
        </a>
    </div>
</div>'

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
