<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class Contract extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'rto_id',
        'title',
        'file_path',
        'original_name',
        'file_size',
        'is_signed',
        'signed_at'
    ];

    protected $casts = [
        'is_signed' => 'boolean',
        'signed_at' => 'datetime'
    ];

    public function rto(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rto_id');
    }
}
