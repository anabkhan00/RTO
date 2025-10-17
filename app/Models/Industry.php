<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'contact_person',
        'email',
        'phone',
        'address',
        'website',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}