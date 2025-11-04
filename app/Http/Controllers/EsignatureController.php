<?php

namespace App\Http\Controllers;

use App\Models\Esignature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EsignatureController extends Controller
{
    public function index()
    {
        $signature = Esignature::where('user_id', Auth::id())->first();
        return view('rto.esign.index', compact('signature'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'signature_type' => 'required|in:drawn,uploaded',
            'signature_data' => 'required_if:signature_type,drawn',
            'signature_file' => 'required_if:signature_type,uploaded|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Check if user already has a signature
        $existingSignature = Esignature::where('user_id', Auth::id())->first();
        if ($existingSignature) {
            return response()->json(['error' => 'You already have a signature. Please update or delete it first.'], 400);
        }

        $signaturePath = $this->saveSignature($request);

        Esignature::create([
            'user_id' => Auth::id(),
            'signature_path' => $signaturePath,
            'signature_type' => $request->signature_type,
        ]);

        return response()->json(['success' => 'Signature saved successfully!']);
    }

    public function update(Request $request, Esignature $esignature)
    {
        // Ensure user can only update their own signature
        if ($esignature->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'signature_type' => 'required|in:drawn,uploaded',
            'signature_data' => 'required_if:signature_type,drawn',
            'signature_file' => 'required_if:signature_type,uploaded|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Delete old signature file
        if ($esignature->signature_path && Storage::exists('public/' . $esignature->signature_path)) {
            Storage::delete('public/' . $esignature->signature_path);
        }

        $signaturePath = $this->saveSignature($request);

        $esignature->update([
            'signature_path' => $signaturePath,
            'signature_type' => $request->signature_type,
        ]);

        return response()->json(['success' => 'Signature updated successfully!']);
    }

    public function destroy(Esignature $esignature)
    {
        // Ensure user can only delete their own signature
        if ($esignature->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($esignature->signature_path) {
            $filePath = public_path($esignature->signature_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Delete record
        $esignature->delete();

        return response()->json(['success' => 'Signature deleted successfully!']);
    }

    private function saveSignature(Request $request)
    {
        $folder = public_path('signatures');

        // Ensure folder exists in /public/signatures
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        if ($request->signature_type === 'drawn') {
            // Handle drawn (base64) signature
            $signatureData = $request->signature_data;
            $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
            $signatureData = str_replace(' ', '+', $signatureData);
            $signature = base64_decode($signatureData);

            // File name and full path
            $fileName = Auth::id() . '_' . time() . '.png';
            $filePath = $folder . '/' . $fileName;

            // Save the file to /public/signatures
            file_put_contents($filePath, $signature);
        } else {
            // Handle uploaded file
            $file = $request->file('signature_file');
            $fileName = Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $fileName);
            $filePath = $folder . '/' . $fileName;
        }

        // Return relative path (usable in Blade <img>)
        return 'signatures/' . $fileName;
    }
}
