<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = User::with('coordinatorDetail')
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', [
                    'sourcing_coordinator',
                    'placement_coordinator'
                ]);
            })
            ->latest()
            ->get();

        return view('admin.pages.coordinators', compact('coordinators'));
    }

    public function create()
    {
        $rtos = User::where('role', 'rto')->where('status', 1)->get();
        return view('admin.pages.create_coordinator', compact('rtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:coordinator_details,code',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string',
            'role_type' => 'required|in:sourcing_coordinator,placement_coordinator',
            'rto_ids' => 'nullable|array',
            'rto_ids.*' => 'exists:users,id',
        ]);

        $coordinator = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role_type,
            'status' => 1,
            'address' => $request->address,
        ]);

        $coordinator->coordinatorDetail()->create([
            'code' => $request->code,
        ]);

        $coordinator->assignRole($request->role_type);

        if ($request->role_type === 'placement_coordinator' && $request->has('rto_ids')) {
            $coordinator->assignedRtos()->sync($request->rto_ids);
        }

        return redirect()->route('admin.coordinators')->with('success', 'Coordinator created successfully');
    }

    public function edit($id)
    {
        $coordinator = User::with(['coordinatorDetail', 'assignedRtos'])
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', ['sourcing_coordinator', 'placement_coordinator']);
            })
            ->findOrFail($id);

        $rtos = User::where('role', 'rto')->where('status', 1)->get();

        return view('admin.pages.edit_coordinator', compact('coordinator', 'rtos'));
    }

    public function update(Request $request, $id)
    {
        $coordinator = User::with('coordinatorDetail')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:coordinator_details,code,' . $coordinator->coordinatorDetail?->id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'role_type' => 'required|in:sourcing_coordinator,placement_coordinator',
            'rto_ids' => 'nullable|array',
            'rto_ids.*' => 'exists:users,id',
        ]);

        $coordinator->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $coordinator->update([
                'password' => Hash::make($request->password),
            ]);
        }
        $coordinator->coordinatorDetail()->updateOrCreate(
            ['user_id' => $coordinator->id],
            [
                'code' => $request->code,
            ]
        );

        $coordinator->syncRoles([$request->role_type]);

        // Sync RTOs only for placement coordinators
        if ($request->role_type === 'placement_coordinator' && $request->has('rto_ids')) {
            $coordinator->assignedRtos()->sync($request->rto_ids);
        } else {
            $coordinator->assignedRtos()->detach();
        }

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

    public function data(Request $request)
    {
        $query = User::with('coordinatorDetail')
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['sourcing_coordinator', 'placement_coordinator']);
            });

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('coordinatorDetail', function ($detailQ) use ($search) {
                        $detailQ->where('code', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('type')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->type);
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
        $orderColumn = $request->get('order.0.column', 2);
        $orderDir = $request->get('order.0.dir', 'desc');

        // Order mapping
        $columns = ['name', 'code', 'coordinator_type', 'email', 'created_at', 'status', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        if ($orderBy === 'created_at') {
            $query->orderBy('created_at', $orderDir);
        } elseif ($orderBy === 'name') {
            $query->orderBy('name', $orderDir);
        } elseif ($orderBy === 'email') {
            $query->orderBy('email', $orderDir);
        }

        $totalRecords = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['sourcing_coordinator', 'placement_coordinator']);
        })->count();
        $filteredRecords = $query->count();

        $coordinators = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($coordinators as $coordinator) {
            $coordinatorDetail = $coordinator->coordinatorDetail;
            $code = $coordinatorDetail?->code ?? 'N/A';
            $status = $coordinator->status ?? 1;
            $role = $coordinator->getRoleNames()->first() ?? 'coordinator';

            $coordinatorColors = ['bg-blue-50 text-blue-700 border-blue-100', 'bg-purple-50 text-purple-700 border-purple-100', 'bg-emerald-50 text-emerald-700 border-emerald-100'];
            $coordinatorColor = $coordinatorColors[abs(crc32($code)) % count($coordinatorColors)];

            $typeColor = $role == 'sourcing_coordinator' ? 'bg-orange-50 text-orange-700 border-orange-100' : 'bg-indigo-50 text-indigo-700 border-indigo-100';
            $typeText = $role == 'sourcing_coordinator' ? 'Sourcing' : ($role == 'placement_coordinator' ? 'Placement' : 'Coordinator');

            $data[] = [
                'row_url' => route('admin.coordinators.edit', $coordinator->id),
                'name' => '<div class="flex items-center"><div class="h-[31px] w-[31px] rounded-full ' . $coordinatorColor . ' flex items-center justify-center text-[11px] font-semibold mr-3">CO</div><div class="text-sm font-medium text-gray-900">' . $coordinator->name . '</div></div>',
                'code' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $coordinatorColor . ' border shadow-sm">' . $code . '</span>',
                'coordinator_type' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $typeColor . ' border shadow-sm">' . $typeText . '</span>',
                'email' => $coordinator->email,
                'created_at' => '<span class="text-xs text-gray-600">' . $coordinator->created_at->format('j M Y') . '</span>',
                'status' => '<select onchange="updateStatus(' . $coordinator->id . ', this.value)" onclick="event.stopPropagation()" class="border border-gray-300 text-xs px-2 py-1 rounded-md ' . ($status ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200') . ' focus:ring-brand focus:border-brand"><option value="1"' . ($status ? ' selected' : '') . '>Active</option><option value="0"' . (!$status ? ' selected' : '') . '>Inactive</option></select>',
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
