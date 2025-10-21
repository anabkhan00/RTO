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

    protected $casts = [
        'status' => 'boolean',
    ];
}