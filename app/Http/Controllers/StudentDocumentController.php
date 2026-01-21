<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Industry;
use App\Models\RtoStudent;
use App\Models\StudentNote;
use Illuminate\Http\Request;
use App\Models\StudentDocument;
use App\Models\DocumentChecklist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    public function index($studentId)
    {
        $student = User::with('rtos')->findOrFail($studentId); // eager load RTOs
        $courses = Course::all();

        // Get checklists based on student's course
        if ($student->course_id && $student->course->courseChecklist) {
            $checklists = DocumentChecklist::whereIn('id', $student->course->courseChecklist->checklist_ids)
                ->where('status', true)
                ->get();
        } else {
            $checklists = null;
        }

        $industries = Industry::all();
        $rtos = User::where('role', 'rto')->latest()->get();
        $notes = StudentNote::where('student_id', $studentId)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();

        $studentRtoId = $student->rtos->first()?->id ?? null;

        // Get coordinators for assignment
        $placementCoordinators = User::whereHas('roles', function($q) {
            $q->where('name', 'placement_coordinator');
        })->get();
        $sourcingCoordinators = User::whereHas('roles', function($q) {
            $q->where('name', 'sourcing_coordinator');
        })->get();

        if (Auth::user()->hasRole('rto')) {
            $rtoStudentExists = RtoStudent::where('rto_id', Auth::id())
                ->where('student_id', $studentId)
                ->exists();
            if (!$rtoStudentExists) {
                abort(403, 'Unauthorized access to student documents.');
            }
            return view('rto.student_documents.index', compact('student', 'checklists', 'notes', 'courses', 'industries'));
        }

        return view('admin.student_documents.index', compact('student', 'checklists', 'notes', 'courses', 'industries', 'rtos','studentRtoId', 'placementCoordinators', 'sourcingCoordinators'));
    }

    public function store(Request $request, $studentId)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'files' => 'required|array',
            'files.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:51200',
        ]);

        $documentIds = [];

        foreach ($request->file('files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('student_documents', $fileName, 'public');

            $document = StudentDocument::create([
                'student_id' => $studentId,
                'uploaded_by' => Auth::id(),
                'label' => $request->label,
                'file_path' => $filePath,
                'original_name' => $file->getClientOriginalName(),
            ]);

            $documentIds[] = $document->id;
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'document_ids' => $documentIds
            ]);
        }

        return redirect()->back()->with('success', 'Documents uploaded successfully!');
    }

    public function assignTypes(Request $request, $studentId)
    {
        $request->validate([
            'document_ids' => 'required|string',
            'checklist_ids' => 'nullable|array',
            'checklist_ids.*' => 'exists:document_checklists,id',
        ]);

        $documentIds = explode(',', $request->document_ids);

        if ($request->checklist_ids) {
            foreach ($documentIds as $documentId) {
                StudentDocument::where('id', $documentId)
                    ->update(['checklist_ids' => $request->checklist_ids]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function getExistingChecklists($studentId)
    {
        $existingChecklistIds = StudentDocument::where('student_id', $studentId)
            ->whereNotNull('checklist_ids')
            ->get()
            ->pluck('checklist_ids')
            ->flatten()
            ->unique()
            ->values()
            ->toArray();

        return response()->json(['existing_checklist_ids' => $existingChecklistIds]);
    }

    public function assignCoordinator(Request $request, $studentId)
    {
        $request->validate([
            'placement_coordinator_id' => 'nullable|exists:users,id',
            'sourcing_coordinator_id' => 'nullable|exists:users,id',
        ]);

        $student = User::findOrFail($studentId);
        $student->studentDetail()->updateOrCreate(
            ['user_id' => $student->id],
            [
                'placement_coordinator_id' => $request->placement_coordinator_id,
                'sourcing_coordinator_id' => $request->sourcing_coordinator_id,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $document = StudentDocument::findOrFail($id);

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json(['success' => true]);
    }
}
