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
            'code' => 'required|string|max:50|unique:users,code',
            'email' => 'required|email|unique:users',
            'coordinator_type' => 'required|in:sourcing,placement',
        ]);

        $coordinator = User::create([
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'coordinator_type' => $request->coordinator_type,
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
            'code' => 'required|string|max:50|unique:users,code,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'coordinator_type' => 'required|in:sourcing,placement',
        ]);

        $coordinator = User::findOrFail($id);
        $coordinator->update([
            'name' => $request->name,
            'code' => $request->code,
            'email' => $request->email,
            'role' => 'coordinator',
            'coordinator_type' => $request->coordinator_type,
        ]);

        $coordinator->assignRole('coordinator');

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

    public function updateStatus(Request $request, $id)
    {
        $coordinator = User::findOrFail($id);
        $coordinator->update(['status' => $request->status]);
        return response()->json(['success' => true]);
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
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
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
        $orderColumn = $request->get('order.0.column', 3);
        $orderDir = $request->get('order.0.dir', 'desc');

        // Order mapping
        $columns = ['name', 'code', 'coordinator_type', 'email', 'status', 'created_at', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        if ($orderBy === 'created_at') {
            $query->orderBy('created_at', $orderDir);
        } elseif ($orderBy === 'name') {
            $query->orderBy('name', $orderDir);
        } elseif ($orderBy === 'code') {
            $query->orderBy('code', $orderDir);
        } elseif ($orderBy === 'coordinator_type') {
            $query->orderBy('coordinator_type', $orderDir);
        } elseif ($orderBy === 'email') {
            $query->orderBy('email', $orderDir);
        }

        $totalRecords = User::where('role', 'coordinator')->count();
        $filteredRecords = $query->count();

        $coordinators = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($coordinators as $coordinator) {
            $statusColor = $coordinator->status ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100';

            $coordinatorColors = ['bg-blue-50 text-blue-700 border-blue-100', 'bg-purple-50 text-purple-700 border-purple-100', 'bg-emerald-50 text-emerald-700 border-emerald-100'];
            $coordinatorColor = $coordinatorColors[abs(crc32($coordinator->code)) % count($coordinatorColors)];

            $typeColor = $coordinator->coordinator_type == 'sourcing' ? 'bg-orange-50 text-orange-700 border-orange-100' : 'bg-indigo-50 text-indigo-700 border-indigo-100';
            $typeText = $coordinator->coordinator_type == 'sourcing' ? 'Sourcing' : 'Placement';

            $data[] = [
                'row_url' => route('admin.coordinators.edit', $coordinator->id),
                'name' => '<div class="flex items-center"><div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">' . substr($coordinator->name, 0, 1) . '</div><div class="text-sm font-medium text-gray-900">' . $coordinator->name . '</div></div>',
                'code' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $coordinatorColor . ' border shadow-sm">' . $coordinator->code . '</span>',
                'coordinator_type' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $typeColor . ' border shadow-sm">' . $typeText . '</span>',
                'email' => $coordinator->email,
                'status' => '<select onchange="updateStatus(' . $coordinator->id . ', this.value)" onclick="event.stopPropagation()" class="border border-gray-300 text-xs px-2 py-1 rounded-md ' . ($coordinator->status ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200') . ' focus:ring-brand focus:border-brand"><option value="1"' . ($coordinator->status ? ' selected' : '') . '>Active</option><option value="0"' . (!$coordinator->status ? ' selected' : '') . '>Inactive</option></select>',
                'created_at' => $coordinator->created_at->format('j M Y'),
                'actions' => '<div class="text-center"><div class="relative inline-block dropdown-container" onclick="event.stopPropagation()"><button onclick="toggleDropdown(' . $coordinator->id . ')" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200"><i class="bi bi-three-dots-vertical text-gray-700"></i></button><div id="dropdown-' . $coordinator->id . '" class="dropdown-menu hidden absolute right-0 mt-2 w-32 z-[9999] bg-white shadow-lg rounded-md border py-1"><a href="#" onclick="deleteCoordinator(' . $coordinator->id . ')" class="block px-3 py-2 text-sm text-red-600 hover:bg-red-50"><i class="bi bi-trash mr-2"></i>Delete</a></div></div></div>'
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
