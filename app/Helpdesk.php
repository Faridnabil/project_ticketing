<?php

namespace App;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Helpdesk extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'email_address',
        'message',
        'user_id',
        'priority_id',
        // 'category_id',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function getEscalationDetailsAttribute()
    {
        return [
            'level' => $this->priority->level,
            'escalation_time' => $this->priority->escalation_time
        ];
    }
}
