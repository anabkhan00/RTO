<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtoStudent extends Model
{
    use HasFactory;

    protected $fillable = ['rto_id', 'student_id'];

    public function rto()
    {
        return $this->belongsTo(User::class, 'rto_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}