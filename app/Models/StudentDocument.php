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
        'checklist_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function checklist()
    {
        return $this->belongsTo(DocumentChecklist::class, 'checklist_id');
    }
}
