<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rto;
use App\Models\User;
use App\Models\Course;
use App\Models\RtoStudent;
use App\Models\RtoDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RtoController extends Controller
{
    public function dashboard()
    {
        $data = [];

        if (auth()->user()->can('students.view')) {
            $studentIds = RtoStudent::pluck('student_id');
            $data['totalStudents'] = User::where('role', 'user')->count();
            $data['thisMonthStudents'] = User::where('role', 'user')
                ->whereMonth('created_at', now()->month)
                ->count();
            $data['students'] = User::with(['course', 'studentDetail.industry'])
                ->where('role', 'user')
                ->latest()
                ->take(10)
                ->get();
        }

        if (auth()->user()->can('placements.view')) {
            $data['activePlacements'] = User::whereHas('studentDetail', function ($q) {
                $q->where('progress_status', 'active_placements');
            })->count();
            $data['completedPlacements'] = User::whereHas('studentDetail', function ($q) {
                $q->where('progress_status', 'completed_placements');
            })->count();
        }

        if (auth()->user()->can('courses.view')) {
            $data['activeCourses'] = Course::where('status', true)->count();
        }

        return view('admin.pages.dashboard', $data);
    }

    public function index()
    {
        $query = User::with('rtoDetail')->where('role', 'rto');

        if (auth()->user()->hasRole('placement_coordinator')) {
            $query->whereHas('coordinatorAssignments', function ($q) {
                $q->where('coordinator_id', auth()->id());
            });
        }

        $rtos = $query->latest()->get();
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
            'rto_number' => 'nullable|string|unique:rto_details,rto_number',
            'code' => 'required|string|unique:rto_details,code',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'rto',
            'password' => bcrypt('password'),
            'status' => true,
        ]);

        $user->rtoDetail()->create([
            'rto_number' => $request->rto_number,
            'code' => $request->code,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
        ]);

        $user->assignRole('rto');

        return redirect()->route('admin.rtos')->with('success', 'RTO created successfully');
    }


    public function edit($id)
    {
        $rto = User::with('rtoDetail')->where('role', 'rto')->findOrFail($id);
        return view('admin.pages.edit_rto', compact('rto'));
    }

    public function update(Request $request, $id)
    {
        $rto = User::with('rtoDetail')->where('role', 'rto')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'rto_number' => 'nullable|string|unique:rto_details,rto_number,' . $rto->rtoDetail?->id,
            'code' => 'nullable|string|unique:rto_details,code,' . $rto->rtoDetail?->id,
            'email' => 'required|email|unique:users,email,' . $rto->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $rto->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $rto->rtoDetail()->updateOrCreate(
            ['user_id' => $rto->id],
            [
                'rto_number' => $request->rto_number,
                'code' => $request->code,
                'website' => $request->website,
                'contact_person' => $request->contact_person,
            ]
        );

        return redirect()->route('admin.rtos')->with('success', 'RTO updated successfully');
    }


    public function destroy($id)
    {
        $rto = User::findOrFail($id);
        $rto->delete();
        return back()->with('success', 'RTO deleted successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $rto = User::findOrFail($id);

        $status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);

        $rto->update([
            'status' => $status
        ]);

        return response()->json(['success' => true]);
    }


    public function data(Request $request)
    {
        $query = User::with('rtoDetail')->where('role', 'rto');

        if (auth()->user()->hasRole('placement_coordinator')) {
            $query->whereHas('coordinatorAssignments', function ($q) {
                $q->where('coordinator_id', auth()->id());
            });
        }

        // Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('rtoDetail', function ($rtoQ) use ($search) {
                        $rtoQ->where('rto_number', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }

        if ($request->filled('contact_person')) {
            $query->whereHas('rtoDetail', function ($q) use ($request) {
                $q->where('contact_person', 'like', "%{$request->contact_person}%");
            });
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
        $orderColumn = $request->get('order.0.column', 0);
        $orderDir = $request->get('order.0.dir', 'desc');

        $columns = ['name', 'code', 'contact_info', 'contact_person', 'website', 'status', 'created_at', 'actions'];
        $orderBy = $columns[$orderColumn] ?? 'created_at';

        $query->orderBy($orderBy, $orderDir);

        $totalRecords = User::where('role', 'rto')->count();
        $filteredRecords = $query->count();

        $rtos = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($rtos as $rto) {
            $rtoDetail = $rto->rtoDetail;
            $code = $rtoDetail?->code ?? 'N/A';
            $contactPerson = $rtoDetail?->contact_person ?? '-----';
            $website = $rtoDetail?->website;
            $status = $rto->status;

            $rtoColors = ['bg-blue-50 text-blue-700 border-blue-100', 'bg-purple-50 text-purple-700 border-purple-100', 'bg-emerald-50 text-emerald-700 border-emerald-100'];
            $rtoColor = $rtoColors[abs(crc32($code)) % count($rtoColors)];

            $deleteAction = '';

            if (auth()->user()->can('rtos.delete')) {
                $deleteAction = '
        <a href="#" onclick="deleteRto(' . $rto->id . ')"
           class="block px-3 py-2 text-sm text-red-600 hover:bg-red-50">
            <i class="bi bi-trash mr-2"></i>Delete
        </a>';
            }

            $actions = '
<div class="text-center">
    <div class="relative inline-block dropdown-container" onclick="event.stopPropagation()">
        <button onclick="toggleDropdown(' . $rto->id . ')"
            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200">
            <i class="bi bi-three-dots-vertical text-gray-700"></i>
        </button>

        <div id="dropdown-' . $rto->id . '"
            class="dropdown-menu hidden absolute right-0 mt-2 w-40 z-[9999] bg-white shadow-lg rounded-md border py-1">

           <a href="' . route('admin.students', ['rto_id' => $rto->id]) . '"
   class="block px-3 py-2 text-sm text-blue-600 hover:bg-blue-50">
    <i class="bi bi-people mr-2"></i>Students
</a>


            ' . $deleteAction . '

        </div>
    </div>
</div>';


            $data[] = [
                'row_url' => route('admin.rtos.edit', $rto->id),
                'name' => '<div class="flex items-center"><div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">' . substr($rto->name, 0, 1) . '</div><div class="text-sm font-medium text-gray-900">' . $rto->name . '</div></div>',
                'code' => '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ' . $rtoColor . ' border shadow-sm">' . $code . '</span>',
                'contact_info' => '<div class="space-y-1"><div class="flex items-center text-xs"><i class="bi bi-envelope mr-1"></i>' . $rto->email . '</div><div class="flex items-center text-xs"><i class="bi bi-phone mr-1"></i>' . ($rto->phone ?? 'N/A') . '</div></div>',
                'contact_person' => $contactPerson,
                'website' => $website ? '<a href="' . $website . '" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center text-xs"><i class="bi bi-globe mr-1"></i>Visit</a>' : '<span class="text-gray-400 text-xs">N/A</span>',
                'status' => '<select onchange="updateStatus(' . $rto->id . ', this.value)" onclick="event.stopPropagation()" class="border border-gray-300 text-xs px-2 py-1 rounded-md ' . ($status ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200') . ' focus:ring-brand focus:border-brand"><option value=1' . ($status ? ' selected' : '') . '>Active</option><option value=0' . (!$status ? ' selected' : '') . '>Inactive</option></select>',
                'created_at' => $rto->created_at->format('j M Y'),
                'actions' => $actions
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
