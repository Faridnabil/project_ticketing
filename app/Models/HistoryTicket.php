<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'h_no_ticket',
        'h_title',
        'h_customer',
        'h_assign_to',
        'priority_id',
        'h_due_date',
        'status_id',
        'category_id',
        'h_description',
        'h_attachments',
        'h_status_changed_by_id',
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

    public function status()
    {
        return $this->belongsTo(Status::class, 'h_status_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'h_category_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'h_priority_id');
    }

    public function customers()
    {
        return $this->belongsTo(User::class, 'h_customer');
    }

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'h_assign_to', 'id');
    }

    public function statusChangedByUser()
    {
        return $this->belongsTo(User::class, 'h_status_changed_by_id');
    }

}
