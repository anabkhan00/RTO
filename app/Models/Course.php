<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'duration', 
        'price',
        'rto_id',
        'status',
        'placement_hours',
        'no_of_students'
    ];

    protected $casts = [
        'status' => 'boolean',
        'price' => 'decimal:2',
        'placement_hours' => 'integer',
        'no_of_students' => 'integer'
    ];

    public function rto()
    {
        return $this->belongsTo(User::class, 'rto_id');
    }
}