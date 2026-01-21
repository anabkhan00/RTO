<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StudentDocument extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'student_id',
        'uploaded_by',
        'label',
        'file_path',
        'original_name',
        'checklist_ids',
    ];

    protected $casts = [
        'checklist_ids' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function checklists()
    {
        return DocumentChecklist::whereIn('id', $this->checklist_ids ?? [])->get();
    }
}
