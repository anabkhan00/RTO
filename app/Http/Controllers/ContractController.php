<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contract;
use App\Models\Esignature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function adminIndex()
    {
        $rtos = User::role('rto')->with('contracts')->get();
        return view('admin.pages.contracts', compact('rtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rto_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:51200',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('contracts', $fileName, 'public');

        Contract::create([
            'rto_id' => $request->rto_id,
            'title' => $request->title,
            'file_path' => $filePath,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->back()->with('success', 'Contract uploaded successfully!');
    }

    public function rtoIndex()
    {
        $contracts = Contract::where('rto_id', Auth::id())->latest()->get();
        $signature = Esignature::where('user_id', Auth::id())->first();
        return view('rto.pages.contracts', compact('contracts', 'signature'));
    }

    public function signContract(Request $request, Contract $contract)
    {
        if ($contract->rto_id !== Auth::id()) {
            abort(403);
        }

        $signature = Esignature::where('user_id', Auth::id())->first();
        if (!$signature) {
            return response()->json(['error' => 'E-signature required'], 400);
        }

        $contract->update([
            'is_signed' => true,
            'signed_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function viewContract(Contract $contract)
    {
        if ($contract->rto_id !== Auth::id()) {
            abort(403);
        }

        $signature = Esignature::where('user_id', Auth::id())->first();
        
        if (!$contract->is_signed || !$signature) {
            return redirect()->asset('storage/' . $contract->file_path);
        }

        // Generate PDF with signature
        $originalPdfPath = storage_path('app/public/' . $contract->file_path);
        $signaturePath = public_path($signature->signature_path);
        
        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile($originalPdfPath);
        
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
            
            if ($pageNo === $pageCount) {
                $pdf->Image($signaturePath, $size['width'] - 60, $size['height'] - 30, 50, 20);
            }
        }
        
        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $contract->title . '_signed.pdf"'
        ]);
    }

    public function adminViewContract(Contract $contract)
    {
        $signature = Esignature::where('user_id', $contract->rto_id)->first();
        
        if (!$contract->is_signed || !$signature) {
            return redirect()->to(asset('storage/' . $contract->file_path));
        }

        // Generate PDF with signature for admin view
        $originalPdfPath = storage_path('app/public/' . $contract->file_path);
        $signaturePath = public_path($signature->signature_path);
        
        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile($originalPdfPath);
        
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
            
            if ($pageNo === $pageCount) {
                $pdf->Image($signaturePath, $size['width'] - 60, $size['height'] - 30, 50, 20);
            }
        }
        
        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $contract->title . '_signed.pdf"'
        ]);
    }

    public function destroy(Contract $contract)
    {
        if (Storage::disk('public')->exists($contract->file_path)) {
            Storage::disk('public')->delete($contract->file_path);
        }

        $contract->delete();
        return response()->json(['success' => true]);
    }
}