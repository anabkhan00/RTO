<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseChecklist extends Model
{
    protected $fillable = ['course_id', 'checklist_ids'];
    
    protected $casts = [
        'checklist_ids' => 'array'
    ];
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}