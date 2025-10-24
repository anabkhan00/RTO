<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentDocument;
use App\Models\RtoStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudentDocumentController extends Controller
{
    public function index($studentId)
    {
        $student = User::findOrFail($studentId);

        if (Auth::user()->hasRole('rto')) {
            $rtoStudentExists = RtoStudent::where('rto_id', Auth::id())
                ->where('student_id', $studentId)
                ->exists();
            if (!$rtoStudentExists) {
                abort(403, 'Unauthorized access to student documents.');
            }
            return view('rto.student_documents.index', compact('student'));
        }

        return view('admin.student_documents.index', compact('student'));
    }

    public function store(Request $request, $studentId)
    {
        $request->validate([
            'documents' => 'required|array',
            'documents.*.label' => 'required|string|max:255',
            'documents.*.file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        foreach ($request->documents as $document) {
            if (isset($document['file']) && isset($document['label'])) {
                $file = $document['file'];
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('student_documents', $fileName, 'public');

                StudentDocument::create([
                    'student_id' => $studentId,
                    'uploaded_by' => Auth::id(),
                    'label' => $document['label'],
                    'file_path' => $filePath,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Documents uploaded successfully!');
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
