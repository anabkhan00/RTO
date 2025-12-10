<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAppointment extends Model
{
    protected $fillable = ['student_id', 'title', 'date', 'time', 'notes', 'created_by'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
