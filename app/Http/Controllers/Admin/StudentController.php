<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'user')->latest()->get();
        return view('admin.pages.students', compact('students'));
    }

    public function download()
    {
        $students = User::where('role', 'user')->get();
        
        $csvData = "Name,Email,Address,Created Date\n";
        foreach ($students as $student) {
            $csvData .= '"' . $student->name . '","' . $student->email . '","' . ($student->address ?? 'N/A') . '","' . $student->created_at->format('Y-m-d') . '"' . "\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students_' . date('Y-m-d') . '.csv"',
        ]);
    }
}