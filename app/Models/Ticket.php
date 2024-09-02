<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_ticket',
        'title',
        'name',
        // 't_users',
        'assign_to',
        'priority_id',
        'due_date',
        'status_id',
        'category_id',
        'service_id',
        'description',
        'solution',
        'status',
        'attachments',
        'status_changed_by_id',
        'no_telp',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $changes = $model->getDirty();
            foreach ($changes as $attribute => $newValue) {
                $oldValue = $model->getOriginal($attribute);

                ActivityLog::create([
                    'model_type' => get_class($model),
                    'model_id' => $model->id,
                    'attribute' => $attribute,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'reason' => request()->input('reason'), // Ambil reason dari request
                    'user_id' => auth()->id(),
                ]);
            }
        });
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    // public function user_s()
    // {
    //     return $this->belongsTo(User::class, 't_users');
    // }

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function statusChangedByUser()
    {
        return $this->belongsTo(User::class, 'status_changed_by_id');
    }
}
