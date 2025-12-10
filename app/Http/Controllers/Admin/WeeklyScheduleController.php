<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentWeeklySchedule;
use App\Models\User;
use Illuminate\Http\Request;

class WeeklyScheduleController extends Controller
{


    public function getWeekSchedule($studentId, $weekStart)
    {
        $schedule = StudentWeeklySchedule::where('student_id', $studentId)
            ->where('week_start_date', $weekStart)
            ->first();

        return response()->json($schedule);
    }

    public function getWeekAvailability(Request $request, $studentId)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        // Extract dates
        $startDate = substr($start, 0, 10);
        $endDate = substr($end, 0, 10);

        // Fetch ALL schedules that overlap with the requested range
        // This makes it robust against view changes (month/week) or boundary mismatches
        $schedules = StudentWeeklySchedule::where('student_id', $studentId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('week_start_date', [$startDate, $endDate])
                      ->orWhereBetween('week_end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('week_start_date', '<', $startDate)
                            ->where('week_end_date', '>', $endDate);
                      });
            })
            ->get();

        $events = [];

        foreach ($schedules as $schedule) {
            if ($schedule->selected_time_slots) {
                foreach ($schedule->selected_time_slots as $slot) {
                    $slot = (array) $slot;
                    $events[] = [
                        'id' => uniqid(), // Help FC distinguish events
                        'title' => 'Available',
                        'start' => $slot['start'] ?? null,
                        'end' => $slot['end'] ?? null,
                        'color' => '#3788d8',
                        // Optional: include other props if needed
                    ];
                }
            }
        }

        return response()->json($events);
    }

    public function saveWeekAvailability(Request $request, $studentId)
    {
        $request->validate([
            'week_start' => 'required|date',
            'events' => 'present|array',
            'total_hours' => 'required|numeric'
        ]);

        // STRICTLY force Monday as start of week to normalize data
        $weekStart = \Carbon\Carbon::parse($request->week_start)->startOfWeek(\Carbon\Carbon::MONDAY);
        // dd($weekStart);
        $weekEnd = $weekStart->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

        $schedule = StudentWeeklySchedule::updateOrCreate(
            [
                'student_id' => $studentId,
                'week_start_date' => $weekStart->toDateString()
            ],
            [
                'week_end_date' => $weekEnd->toDateString(),
                'selected_time_slots' => $request->events,
                'total_hours' => $request->total_hours,
                'hours_assigned' => floor($request->total_hours)
            ]
        );

        return response()->json(['success' => true, 'message' => 'Schedule saved successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'week_start_date' => 'required|date',
            'week_end_date' => 'required|date|after_or_equal:week_start_date',
            'hours_assigned' => 'required|integer|min:0',
            'selected_time_slots' => 'nullable|array',
            'notes' => 'nullable|string'
        ]);

        $schedule = StudentWeeklySchedule::findOrFail($id);
        $schedule->update($request->all());

        return response()->json(['success' => true, 'message' => 'Weekly schedule updated successfully']);
    }

    public function destroy($id)
    {
        StudentWeeklySchedule::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Weekly schedule deleted successfully']);
    }
}
