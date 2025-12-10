<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedIndustryKeyword extends Model
{
    protected $fillable = ['coordinator_id', 'keyword', 'industry_name', 'notes'];

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }
}
