<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class PlacementOpportunity extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'industry_id',
        'sourcing_coordinator_id',
        'total_slots',
        'filled_slots',
        'requirements',
        'status'
    ];

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function sourcingCoordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sourcing_coordinator_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(PlacementAssignment::class);
    }

    public function getAvailableSlotsAttribute(): int
    {
        return $this->total_slots - $this->filled_slots;
    }
}