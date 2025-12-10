<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentWeeklySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'week_start_date',
        'week_end_date',
        'hours_assigned',
        'total_hours',
        'selected_time_slots',
        'notes'
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'selected_time_slots' => 'array',
        'total_hours' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
