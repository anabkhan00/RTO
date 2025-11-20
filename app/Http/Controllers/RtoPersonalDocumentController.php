<?php

namespace App\Http\Controllers;

use App\Models\RtoPersonalDocument;
use App\Models\DocumentChecklist;
use App\Models\User;
use App\Models\Esignature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RtoPersonalDocumentController extends Controller
{
    public function index()
    {
        $documents = RtoPersonalDocument::where('rto_id', Auth::id())->latest()->get();
        $checklists = DocumentChecklist::where('status', 1)->get();
        $students = User::role('user')->with(['studentDocuments', 'course'])->get();
        $signature = Esignature::where('user_id', Auth::id())->first();

        return view('rto.pages.my_documents', compact('documents', 'checklists', 'students', 'signature'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'files' => 'required|array',
            'files.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:51200',
        ]);

        foreach ($request->file('files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('rto_personal_documents', $fileName, 'public');

            RtoPersonalDocument::create([
                'rto_id' => Auth::id(),
                'label' => $request->label,
                'file_path' => $filePath,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->back()->with('success', 'Documents uploaded successfully!');
    }

    public function destroy($id)
    {
        $document = RtoPersonalDocument::where('rto_id', Auth::id())->findOrFail($id);

        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json(['success' => true]);
    }
}
