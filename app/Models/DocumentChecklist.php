<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentChecklist extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function studentDocuments()
    {
        return $this->hasMany(StudentDocument::class, 'checklist_id');
    }
}