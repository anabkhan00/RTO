<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StudentDetail extends Model
{
    protected $fillable = [
        'user_id',
        'priority',
        'progress_status',
        'days_left',
        'placement_booked_at',
        'industry_id',
        'emergency_contact',
        'placement_hours'
    ];

    protected $casts = [
        'placement_booked_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function calculateDaysLeft()
    {
        if ($this->progress_status === 'booked_placements' && $this->placement_booked_at) {
            $daysPassed = Carbon::now()->diffInDays($this->placement_booked_at);
            return max(0, 120 - $daysPassed);
        }
        return $this->days_left;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->progress_status === 'booked_placements' && !$model->placement_booked_at) {
                $model->placement_booked_at = now();
                $model->days_left = 120;
            } elseif ($model->progress_status === 'booked_placements' && $model->placement_booked_at) {
                $model->days_left = $model->calculateDaysLeft();
            }
        });
    }
}
