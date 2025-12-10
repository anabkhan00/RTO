<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustryWeeklySchedule extends Model
{
    protected $fillable = [
        'industry_id',
        'week_start_date',
        'week_end_date',
        'selected_time_slots',
        'total_hours'
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'selected_time_slots' => 'array',
        'total_hours' => 'decimal:2',
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
