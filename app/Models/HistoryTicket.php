<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class HistoryTicket extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'h_no_ticket',
        'h_priority_id',
        'h_status_id',
        'h_category_id',
        'h_service_id',
        'h_description',
        'h_attachments',
        'status_changedBy',
        'h_title',
        // 'h_t_users',
        'h_assign_to',
        'h_due_date',
        'h_solution',
        'h_no_telp',
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
        return $this->belongsTo(Status::class, 'h_status_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'h_service_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'h_category_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'h_priority_id');
    }

    public function statusChangedBy()
    {
        return $this->belongsTo(User::class, 'status_changedBy');
    }


    // public function user_s()
    // {
    //     return $this->belongsTo(User::class, 't_users');
    // }

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'h_assign_to', 'id');
    }

}
