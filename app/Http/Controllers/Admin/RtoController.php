<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rto;
use App\Models\User;
use App\Models\Course;
use App\Models\RtoStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RtoController extends Controller
{
    public function dashboard()
    {
        $rtoId = Auth::id();
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
        return view('admin.pages.rtos', compact('rtos'));
    }

    public function create()
    {
        return view('admin.pages.create_rto');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rto_number' => 'nullable|string|unique:users,rto_number',
            'code' => 'required|string|unique:users,code',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'rto_number' => $request->rto_number ?? '',
            'code' => $request->code,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
            'role' => 'rto',
            'password' => bcrypt('password'),
            'status' => true,
        ]);

        $user->assignRole('rto');

        return redirect()->route('admin.rtos')->with('success', 'RTO created successfully');
    }


    public function edit($id)
    {
        $rto = User::where('role', 'rto')->findOrFail($id);
        return view('admin.pages.edit_rto', compact('rto'));
    }

    public function update(Request $request, $id)
    {
        $rto = User::where('role', 'rto')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'rto_number' => 'nullable|string|unique:users,rto_number,' . $rto->id,
            'code' => 'nullable|string|unique:users,code,' . $rto->id,
            'email' => 'required|email|unique:users,email,' . $rto->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $rto->update([
            'name' => $request->name,
            'rto_number' => $request->rto_number ?? '',
            'code' => $request->code,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
        ]);

        return redirect()->route('admin.rtos')->with('success', 'RTO updated successfully');
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

    public function data(Request $request)
    {
        $query = User::where('role', 'rto'); // Only RTOs

        // Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('rto_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }

        if ($request->filled('contact_person')) {
            $query->where('contact_person', 'like', "%{$request->contact_person}%");
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Pagination & Ordering
        $start = $request->get('start', 0);
        $length = $request->get('length', 25);
        $orderColumn = $request->get('order.0.column', 0); // Default first column
        $orderDir = $request->get('order.0.dir', 'desc');

        // Columns order: Name first, then RTO Number
        $columns = ['name', 'code', 'contact_info', 'contact_person', 'website', 'status', 'created_at', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        $query->orderBy($orderBy, $orderDir);

        $totalRecords = User::where('role', 'rto')->count();
        $filteredRecords = $query->count();

        $rtos = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($rtos as $rto) {
            $rtoColors = ['bg-blue-50 text-blue-700 border-blue-100', 'bg-purple-50 text-purple-700 border-purple-100', 'bg-emerald-50 text-emerald-700 border-emerald-100'];
            $rtoColor = $rtoColors[abs(crc32($rto->code)) % count($rtoColors)];
            $statusColor = $rto->status ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100';

            $data[] = [
                'row_url' => route('admin.rtos.edit', $rto->id),
                'name' => '<div class="flex items-center"><div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">' . substr($rto->name, 0, 1) . '</div><div class="text-sm font-medium text-gray-900">' . $rto->name . '</div></div>',
                'code' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $rtoColor . ' border shadow-sm">' . $rto->code . '</span>',
                'contact_info' => '<div class="space-y-1"><div class="flex items-center text-xs"><i class="bi bi-envelope mr-1"></i>' . $rto->email . '</div><div class="flex items-center text-xs"><i class="bi bi-phone mr-1"></i>' . ($rto->phone ?? 'N/A') . '</div></div>',
                'contact_person' => $rto->contact_person ?? '-----',
                'website' => $rto->website ? '<a href="' . $rto->website . '" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center text-xs"><i class="bi bi-globe mr-1"></i>Visit</a>' : '<span class="text-gray-400 text-xs">N/A</span>',
                'status' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $statusColor . ' border shadow-sm">' . ($rto->status ? 'Active' : 'Inactive') . '</span>',
                'created_at' => $rto->created_at->format('j M Y'),
                'actions' => '<div class="relative"><button onclick="toggleDropdown(' . $rto->id . ')" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors"><i class="bi bi-three-dots-vertical"></i></button><div id="dropdown-' . $rto->id . '" class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border"><a href="' . route('admin.rtos.edit', $rto->id) . '" class="block px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md"><i class="bi bi-pencil mr-2"></i>Edit</a><a href="#" onclick="toggleStatus(' . $rto->id . ')" class="block px-4 py-2 text-sm text-green-600 hover:bg-green-50 rounded-md"><i class="bi bi-toggle-on mr-2"></i>Toggle Status</a><a href="#" onclick="deleteRto(' . $rto->id . ')" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md"><i class="bi bi-trash mr-2"></i>Delete</a></div></div>'
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
