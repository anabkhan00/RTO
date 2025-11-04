<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'signature_path',
        'signature_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}