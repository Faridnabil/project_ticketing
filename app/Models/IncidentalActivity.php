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
        'category',
        'start_time',
        'end_time',
        'executor',
        'department',
        'mitigation',
        'impact',
        'status',
        'file_path',
        'user_id',
    ];
}
