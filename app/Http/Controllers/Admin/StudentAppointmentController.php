<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentAppointment;
use Illuminate\Http\Request;

class StudentAppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'notes' => 'nullable|string'
        ]);

        StudentAppointment::create([
            'student_id' => $request->student_id,
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'notes' => $request->notes,
            'created_by' => auth()->id()
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $appointment = StudentAppointment::findOrFail($id);
        
        $appointment->update([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'notes' => $request->notes
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        StudentAppointment::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function getByStudent($studentId)
    {
        $appointments = StudentAppointment::where('student_id', $studentId)
            ->with('creator')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($appointments);
    }
}
