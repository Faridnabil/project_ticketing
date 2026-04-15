<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App\Models\ActivityLog;

class Comment extends Model
{
    use HasFactory, HasRoles;
    protected $fillable = [
        'ticket_id',
        'user_id',
        'message'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            ActivityLog::create([
                'model_type' => Ticket::class,
                'model_id'   => $model->ticket_id,
                'attribute'  => 'ADD_COMMENT',
                'old_value'  => null,
                'new_value'  => $model->message,
                'user_id'    => $model->user_id ?? auth()->id(),
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
