<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RtoDocument extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'file_name',
        'file_path',
        'file_type',
        'file_size'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
