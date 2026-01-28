<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StudentAssignmentRequest extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'student_id',
        'placement_coordinator_id',
        'sourcing_coordinator_id',
        // 'industry_preference',
        // 'special_requirements',
        'status',
        'progress_notes',
        'assigned_at',
        'started_at',
        'completed_at'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function placementCoordinator()
    {
        return $this->belongsTo(User::class, 'placement_coordinator_id');
    }

    public function sourcingCoordinator()
    {
        return $this->belongsTo(User::class, 'sourcing_coordinator_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForSourcingCoordinator($query, $coordinatorId)
    {
        return $query->where('sourcing_coordinator_id', $coordinatorId);
    }

    // Helper methods
    public function markAsStarted()
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now()
        ]);
    }

    public function markAsCompleted($notes = null)
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_notes' => $notes ?: $this->progress_notes
        ]);
    }

    public function updateProgress($notes)
    {
        $this->update([
            'progress_notes' => $notes,
            'status' => 'in_progress'
        ]);
    }
}
