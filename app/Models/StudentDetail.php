<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class StudentDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'user_id',
        'priority',
        'progress_status',
        'days_left',
        'placement_booked_at',
        'industry_id',
        'emergency_contact',
        'placement_hours',
        'student_status',
        'interview_status',
        'student_availability',
        'assigned_coordinator_id',
        'placement_coordinator_id',
        'sourcing_coordinator_id',
        'medical_condition',
        'transport',
        'placement_data',
        'gender',
    ];

    protected $casts = [
        'placement_booked_at' => 'datetime',
        'student_availability' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function assignedCoordinator()
    {
        return $this->belongsTo(User::class, 'assigned_coordinator_id');
    }

    public function placementCoordinator()
    {
        return $this->belongsTo(User::class, 'placement_coordinator_id');
    }

    public function sourcingCoordinator()
    {
        return $this->belongsTo(User::class, 'sourcing_coordinator_id');
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
