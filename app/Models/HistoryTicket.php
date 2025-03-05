<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class HistoryTicket extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'h_no_ticket',
        'h_priority_id',
        'h_status_id',
        'h_category_id',
        'h_description',
        'h_attachments',
        'h_province_id',
        'h_city_or_regency_id',
        'h_pic',
        'h_jabatan',
        'h_no_hp',
        'h_level1',
        'h_level2',
        'h_level3',
        'h_level4',
        'h_level5',
        'h_completion_notes',
        'h_created_by',
        'h_updated_by',
        'status_changedBy',
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

    public function helpdesk()
    {
        return $this->belongsTo(Role::class, 'h_level1');
    }

    public function koordinator()
    {
        return $this->belongsTo(Role::class, 'h_level2');
    }

    public function staffSubdit()
    {
        return $this->belongsTo(Role::class, 'h_level3');
    }

    public function siakDev()
    {
        return $this->belongsTo(Role::class, 'h_level4');
    }

    public function pejabat()
    {
        return $this->belongsTo(Role::class, 'h_level5');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'h_province_id');
    }

    public function statusChangedBy()
    {
        return $this->belongsTo(User::class, 'status_changedBy');
    }

}
