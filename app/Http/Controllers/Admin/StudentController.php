<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'user')->latest()->get();
        return view('admin.pages.students', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $student->assignRole('user');
        return back()->with('success', 'Student created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $student = User::findOrFail($id);
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Student updated successfully');
    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();
        return back()->with('success', 'Student deleted successfully');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);
        
        $imported = 0;
        foreach ($rows as $row) {
            if (count($row) >= 2 && !empty($row[0]) && !empty($row[1])) {
                $existingUser = User::where('email', $row[1])->first();
                if (!$existingUser) {
                    $student = User::create([
                        'name' => $row[0],
                        'email' => $row[1],
                        'phone' => $row[2] ?? null,
                        'address' => $row[3] ?? null,
                        'password' => Hash::make('password'),
                        'role' => 'user',
                    ]);
                    $student->assignRole('user');
                    $imported++;
                }
            }
        }

        return back()->with('success', "Successfully imported {$imported} students");
    }

    public function download()
    {
        $students = User::where('role', 'user')->get();
        
        $csvData = "Name,Email,Phone,Address,Created Date\n";
        foreach ($students as $student) {
            $csvData .= '"' . $student->name . '","' . $student->email . '","' . ($student->phone ?? 'N/A') . '","' . ($student->address ?? 'N/A') . '","' . $student->created_at->format('Y-m-d') . '"' . "\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students_' . date('Y-m-d') . '.csv"',
        ]);
    }
}