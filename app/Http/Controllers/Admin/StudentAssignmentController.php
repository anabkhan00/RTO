<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentAssignmentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentAssignmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('sourcing_coordinator')) {
            return $this->sourcingCoordinatorView();
        }

        return $this->adminView();
    }

    private function sourcingCoordinatorView()
    {
        $requests = StudentAssignmentRequest::with(['student.studentDetail', 'student.course', 'placementCoordinator'])
            ->forSourcingCoordinator(Auth::id())
            ->orderBy('assigned_at', 'desc')
            ->get();

        $stats = [
            'pending' => $requests->where('status', 'pending')->count(),
            'in_progress' => $requests->where('status', 'in_progress')->count(),
            'completed' => $requests->where('status', 'completed')->count(),
            'total' => $requests->count()
        ];

        return view('admin.pages.assigned_requests', compact('requests', 'stats'));
    }

    private function adminView()
    {
        $requests = StudentAssignmentRequest::with(['student', 'placementCoordinator', 'sourcingCoordinator'])
            ->orderBy('assigned_at', 'desc')
            ->paginate(20);

        return view('admin.pages.all_assignments', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'sourcing_coordinator_id' => 'required|exists:users,id',
            'industry_preference' => 'nullable|string|max:255',
            'special_requirements' => 'nullable|string'
        ]);

        // Check if user has permission to assign students
        if (!Auth::user()->hasRole(['admin', 'placement_coordinator'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if student already has pending/in-progress assignment
        $existingRequest = StudentAssignmentRequest::where('student_id', $request->student_id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->first();

        if ($existingRequest) {
            return response()->json(['error' => 'Student already has an active assignment request'], 400);
        }

        $assignment = StudentAssignmentRequest::create([
            'student_id' => $request->student_id,
            'placement_coordinator_id' => Auth::id(),
            'sourcing_coordinator_id' => $request->sourcing_coordinator_id,
            'industry_preference' => $request->industry_preference,
            'special_requirements' => $request->special_requirements,
            'assigned_at' => now()
        ]);

        return response()->json([
            'success' => 'Student assigned successfully',
            'assignment' => $assignment->load(['student', 'sourcingCoordinator'])
        ]);
    }

    public function show($id)
    {
        $request = StudentAssignmentRequest::with([
            'student.studentDetail',
            'student.course',
            'student.documents',
            'placementCoordinator',
            'sourcingCoordinator'
        ])->findOrFail($id);

        // Check permissions
        $user = Auth::user();
        if (
            !$user->hasRole('admin') &&
            $request->sourcing_coordinator_id !== $user->id &&
            $request->placement_coordinator_id !== $user->id
        ) {
            abort(403);
        }

        return response()->json($request);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'progress_notes' => 'nullable|string'
        ]);

        $assignment = StudentAssignmentRequest::findOrFail($id);

        // Check if user can update this assignment
        if (!Auth::user()->hasRole('admin') && $assignment->sourcing_coordinator_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $updateData = ['status' => $request->status];

        if ($request->progress_notes) {
            $updateData['progress_notes'] = $request->progress_notes;
        }

        if ($request->status === 'in_progress' && !$assignment->started_at) {
            $updateData['started_at'] = now();
        }

        if ($request->status === 'completed' && !$assignment->completed_at) {
            $updateData['completed_at'] = now();
        }

        $assignment->update($updateData);

        return response()->json([
            'success' => 'Status updated successfully',
            'assignment' => $assignment->fresh()
        ]);
    }

    public function getRequestsData(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasRole('sourcing_coordinator')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = StudentAssignmentRequest::with([
            'student.studentDetail',
            'student.course',
            'placementCoordinator'
        ])->forSourcingCoordinator($user->id);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $requests = $query->orderBy('assigned_at', 'desc')->get();

        return response()->json($requests);
    }

    public function bulkAssign(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'sourcing_coordinator_id' => 'required|exists:users,id',
            'industry_preference' => 'nullable|string|max:255',
            'special_requirements' => 'nullable|string'
        ]);

        if (!Auth::user()->hasRole(['admin', 'placement_coordinator'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $assignments = [];

            DB::transaction(function () use ($request, &$assignments) {
                foreach ($request->student_ids as $studentId) {

                    // Check if student already has an active assignment
                    $existingRequest = StudentAssignmentRequest::where('student_id', $studentId)
                        ->whereIn('status', ['pending', 'in_progress'])
                        ->first();

                    if (!$existingRequest) {
                        $assignment = StudentAssignmentRequest::create([
                            'student_id' => $studentId,
                            'placement_coordinator_id' => Auth::id(),
                            'sourcing_coordinator_id' => $request->sourcing_coordinator_id,
                            // 'industry_preference' => $request->industry_preference,
                            // 'special_requirements' => $request->special_requirements,
                            'assigned_at' => now()
                        ]);

                        $assignments[] = $assignment;
                    }
                }
            });

            return response()->json([
                'success' => count($assignments) . ' students assigned successfully',
                'assignments' => $assignments
            ]);
        } catch (\Throwable $e) {
dd($e);
            \Log::error('Bulk student assignment failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Something went wrong while assigning students. Please try again.'
            ], 500);
        }
    }
}
