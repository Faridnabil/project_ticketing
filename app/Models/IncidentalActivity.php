<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentalActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'start_time',
        'end_time',
        'executor',
        'sysdba',
        'mitigation',
        'impact',
        'status_id',
        'file_path',
        'user_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function category()
    {
        return $this->belongsTo(IncidentalActivityCategory::class, 'category_id');
    }
}
