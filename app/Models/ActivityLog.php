<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'attribute',
        'old_value',
        'new_value',
        'reason',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
