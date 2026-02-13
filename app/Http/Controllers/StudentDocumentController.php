<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Industry;
use App\Models\RtoStudent;
use App\Models\StudentNote;
use Illuminate\Http\Request;
use App\Models\StudentDocument;
use App\Models\StudentIndustryInterview;
use App\Models\DocumentChecklist;
use App\Models\IndustryCourseChecklist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    public function index($studentId)
    {
        $student = User::with('rtos')->findOrFail($studentId); // eager load RTOs

        $radiusKm = 20;

        $nearbyIndustries = [];

        if ($student->latitude && $student->longitude && $student->course_id) {
            $lat = $student->latitude;
            $lng = $student->longitude;

            $nearbyIndustries = Industry::selectRaw("
            industries.*,
            (6371 * acos(
                cos(radians(?)) * cos(radians(latitude))
                * cos(radians(longitude) - radians(?))
                + sin(radians(?)) * sin(radians(latitude))
            )) AS distance
        ", [$lat, $lng, $lat])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('status', true)
                ->whereHas('courses', function ($q) use ($student) {
                    $q->where('course_id', $student->course_id);
                })
                ->having('distance', '<=', $radiusKm)
                ->orderBy('distance')
                ->get();
        }


        $courses = Course::all();

        // Get checklists based on student's course
        if ($student->course_id && $student->course->courseChecklist) {
            $checklists = DocumentChecklist::whereIn('id', $student->course->courseChecklist->checklist_ids)
                ->where('status', true)
                ->get();
        } else {
            $checklists = null;
        }

        $industries = Industry::where('status', true)->get();
        $interviews = StudentIndustryInterview::with('industry')
            ->where('student_id', $studentId)
            ->latest()
            ->get();
        $rtos = User::where('role', 'rto')->latest()->get();
        $notes = StudentNote::where('student_id', $studentId)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();

        $studentRtoId = $student->rtos->first()?->id ?? null;

        // Get coordinators for assignment
        $placementCoordinators = User::whereHas('roles', function ($q) {
            $q->where('name', 'placement_coordinator');
        })->get();
        $sourcingCoordinators = User::whereHas('roles', function ($q) {
            $q->where('name', 'sourcing_coordinator');
        })->get();

        if (Auth::user()->hasRole('rto')) {
            $rtoStudentExists = RtoStudent::where('rto_id', Auth::id())
                ->where('student_id', $studentId)
                ->exists();
            if (!$rtoStudentExists) {
                abort(403, 'Unauthorized access to student documents.');
            }
            return view('rto.student_documents.index', compact(
                'student',
                'checklists',
                'notes',
                'courses',
                'industries',
                'rtos',
                'studentRtoId',
                'placementCoordinators',
                'sourcingCoordinators',
                'nearbyIndustries',
                'interviews'
            ));
        }

        return view('admin.student_documents.index', compact(
            'student',
            'checklists',
            'notes',
            'courses',
            'industries',
            'rtos',
            'studentRtoId',
            'placementCoordinators',
            'sourcingCoordinators',
            'nearbyIndustries',
            'interviews'
        ));
    }

    public function storeInterview(Request $request, $studentId)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'interview_at' => 'nullable|date',
            'status' => 'nullable|string|max:255',
        ]);

        $student = User::with(['course.courseChecklist', 'studentDocuments'])->findOrFail($studentId);
        $industry = Industry::findOrFail($request->industry_id);
        $match = $this->buildMatchStatus($student, $industry);

        if (!$match['all_required_met']) {
            $missingLabels = collect($match['missing'] ?? [])
                ->unique()
                ->values()
                ->take(8)
                ->implode(', ');
            $extraNote = count($match['missing'] ?? []) > 8 ? ' and more' : '';
            return back()->with('error', 'Missing required documents: ' . ($missingLabels ?: 'unknown') . $extraNote);
        }

        StudentIndustryInterview::create([
            'student_id' => $studentId,
            'industry_id' => $request->industry_id,
            'interview_at' => $request->interview_at,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Interview link saved successfully');
    }

    public function matchChecklist(Request $request, $studentId)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
        ]);

        $student = User::with(['course.courseChecklist', 'studentDocuments'])->findOrFail($studentId);
        $industry = Industry::with('courses')->findOrFail($request->industry_id);

        return response()->json($this->buildMatchStatus($student, $industry));
    }

    public function uploadAdditionalDocument(Request $request, $studentId)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'label' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:51200',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('student_documents', $fileName, 'public');

        $document = StudentDocument::create([
            'student_id' => $studentId,
            'uploaded_by' => Auth::id(),
            'label' => $request->label,
            'file_path' => $filePath,
            'original_name' => $file->getClientOriginalName(),
        ]);

        $student = User::with(['course.courseChecklist', 'studentDocuments'])->findOrFail($studentId);
        $industry = Industry::with('courses')->findOrFail($request->industry_id);

        return response()->json([
            'success' => true,
            'document' => [
                'id' => $document->id,
                'label' => $document->label,
                'file_path' => $document->file_path,
            ],
            'match' => $this->buildMatchStatus($student, $industry),
        ]);
    }

    private function buildMatchStatus(User $student, Industry $industry): array
    {
        $courseId = $student->course_id;
        $courseName = $student->course->name ?? null;

        $courseMatch = false;
        $additionalDocs = [];

        if ($courseId) {
            $coursePivot = $industry->courses()->where('course_id', $courseId)->first();
            if ($coursePivot) {
                $courseMatch = true;
                $additionalDocs = json_decode($coursePivot->pivot->additional_documents ?? '[]', true) ?: [];
            }
        }

        $courseChecklistIds = $student->course?->courseChecklist?->checklist_ids ?? [];
        $industryChecklistIds = IndustryCourseChecklist::where('industry_id', $industry->id)
            ->where('course_id', $courseId)
            ->value('checklist_ids') ?? [];

        if (!is_array($courseChecklistIds)) {
            $courseChecklistIds = [];
        }
        if (!is_array($industryChecklistIds)) {
            $industryChecklistIds = [];
        }

        $courseChecklistIds = array_values(array_unique(array_filter($courseChecklistIds)));
        $industryChecklistIds = array_values(array_unique(array_filter($industryChecklistIds)));

        $requiredChecklistIds = array_values(array_unique(array_merge($courseChecklistIds, $industryChecklistIds)));
        $checklistModels = DocumentChecklist::whereIn('id', $requiredChecklistIds)->get()->keyBy('id');

        $studentChecklistIds = $student->studentDocuments
            ->pluck('checklist_ids')
            ->flatten()
            ->filter()
            ->unique()
            ->values()
            ->all();

        $courseChecklist = array_map(function ($id) use ($checklistModels, $studentChecklistIds) {
            $available = in_array($id, $studentChecklistIds);
            return [
                'id' => $id,
                'name' => $checklistModels[$id]->name ?? ('Checklist #' . $id),
                'status' => $available ? 'available' : 'missing',
            ];
        }, $courseChecklistIds);

        $industryChecklist = array_map(function ($id) use ($checklistModels, $studentChecklistIds) {
            $available = in_array($id, $studentChecklistIds);
            return [
                'id' => $id,
                'name' => $checklistModels[$id]->name ?? ('Checklist #' . $id),
                'status' => $available ? 'available' : 'missing',
            ];
        }, $industryChecklistIds);

        $studentLabelIndex = $student->studentDocuments
            ->pluck('label')
            ->filter()
            ->map(fn($label) => $this->normalizeDocName($label))
            ->values()
            ->all();

        $additionalDocuments = collect($additionalDocs)
            ->filter(fn($doc) => trim((string) $doc) !== '')
            ->map(function ($doc) use ($studentLabelIndex) {
            $docName = trim((string) $doc);
            $normalized = $this->normalizeDocName($docName);
            $available = false;
            if ($normalized !== '') {
                foreach ($studentLabelIndex as $label) {
                    if (str_contains($label, $normalized)) {
                        $available = true;
                        break;
                    }
                }
            }
            return [
                'name' => $docName,
                'status' => $available ? 'available' : 'missing',
            ];
        })->values()->all();

        $missing = [];
        foreach ($courseChecklist as $item) {
            if ($item['status'] !== 'available') {
                $missing[] = $item['name'];
            }
        }
        foreach ($industryChecklist as $item) {
            if ($item['status'] !== 'available') {
                $missing[] = $item['name'];
            }
        }
        foreach ($additionalDocuments as $item) {
            if ($item['status'] !== 'available') {
                $missing[] = $item['name'];
            }
        }

        $allRequiredMet = $courseMatch
            && collect($courseChecklist)->every(fn($i) => $i['status'] === 'available')
            && collect($industryChecklist)->every(fn($i) => $i['status'] === 'available')
            && collect($additionalDocuments)->every(fn($i) => $i['status'] === 'available');

        return [
            'student' => [
                'id' => $student->id,
                'name' => $student->name,
                'course_id' => $courseId,
                'course_name' => $courseName,
            ],
            'industry' => [
                'id' => $industry->id,
                'name' => $industry->name,
            ],
            'course_match' => $courseMatch,
            'course_checklist' => $courseChecklist,
            'industry_checklist' => $industryChecklist,
            'additional_documents' => $additionalDocuments,
            'all_required_met' => $allRequiredMet,
            'missing' => $missing,
        ];
    }

    private function normalizeDocName(?string $value): string
    {
        $value = strtolower((string) $value);
        return preg_replace('/[^a-z0-9]+/', '', $value) ?? '';
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
