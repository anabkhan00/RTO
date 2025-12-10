<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlacementAssignment extends Model
{
    protected $fillable = [
        'placement_opportunity_id',
        'student_id',
        'placement_coordinator_id'
    ];

    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(PlacementOpportunity::class, 'placement_opportunity_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function placementCoordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'placement_coordinator_id');
    }
}