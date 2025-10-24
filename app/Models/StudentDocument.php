<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    protected $fillable = [
        'student_id',
        'uploaded_by',
        'label',
        'file_path',
        'original_name',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
