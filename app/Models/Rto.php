<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rto extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rto_number',
        'email',
        'phone',
        'address',
        'website',
        'contact_person',
        'status'
    ];

    // Add accessor for code (using rto_number as code)
    public function getCodeAttribute()
    {
        return $this->rto_number;
    }

    protected $casts = [
        'status' => 'boolean',
    ];
}