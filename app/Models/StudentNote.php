<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StudentNote extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'student_id',
        'author_id', 
        'content',
        'author_role'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}