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
        'customer',
        'assign_to',
        'changed_assign_to',
        'approval_assign_to',
        'priority_id',
        'due_date',
        'status_id',
        'approval_status',
        'category_id',
        'description',
        'attachments',
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
                    'user_id' => auth()->id(),
                ]);
            }
        });
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function customers()
    {
        return $this->belongsTo(User::class, 'customer');
    }

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function changedAssignTo()
    {
        return $this->belongsTo(User::class, 'changed_assign_to', 'id');
    }
}
