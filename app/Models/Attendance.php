<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Attendance extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'user_id',
        'name',
        'check_in',
        'date_check_in',
        'check_out',
        'date_check_out',
        'activity',
        'status_activity',
        'attachment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
