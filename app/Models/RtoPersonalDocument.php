<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RtoPersonalDocument extends Model
{
    protected $fillable = [
        'rto_id',
        'label',
        'file_path',
        'original_name',
        'file_size',
    ];

    public function rto()
    {
        return $this->belongsTo(User::class, 'rto_id');
    }
}