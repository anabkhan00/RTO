<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentDocument;
use App\Models\RtoStudent;
use App\Models\DocumentChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudentDocumentController extends Controller
{
    public function index($studentId)
    {
        $student = User::findOrFail($studentId);
        $checklists = DocumentChecklist::where('status', true)->get();

        if (Auth::user()->hasRole('rto')) {
            $rtoStudentExists = RtoStudent::where('rto_id', Auth::id())
                ->where('student_id', $studentId)
                ->exists();
            if (!$rtoStudentExists) {
                abort(403, 'Unauthorized access to student documents.');
            }
            return view('rto.student_documents.index', compact('student', 'checklists'));
        }

        return view('admin.student_documents.index', compact('student', 'checklists'));
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
                foreach ($request->checklist_ids as $checklistId) {
                    StudentDocument::where('id', $documentId)
                        ->update(['checklist_id' => $checklistId]);
                    break; // Only assign first selected checklist to each document
                }
            }
        }
        
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
