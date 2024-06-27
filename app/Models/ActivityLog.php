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

    // Dalam model Log

    // Relasi ke Prioritas
    public function oldPrioritas()
    {
        return $this->belongsTo(Priority::class, 'old_value');
    }

    public function newPrioritas()
    {
        return $this->belongsTo(Priority::class, 'new_value');
    }

    // Relasi ke Category
    public function oldCategory()
    {
        return $this->belongsTo(Category::class, 'old_value');
    }

    public function newCategory()
    {
        return $this->belongsTo(Category::class, 'new_value');
    }

    // Relasi ke Users
    public function oldUser()
    {
        return $this->belongsTo(User::class, 'old_value');
    }

    public function newUser()
    {
        return $this->belongsTo(User::class, 'new_value');
    }

    // Relasi ke Status
    public function oldStatus()
    {
        return $this->belongsTo(Status::class, 'old_value');
    }

    public function newStatus()
    {
        return $this->belongsTo(Status::class, 'new_value');
    }
}
