<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\ActivityLog;

class Ticket extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'no_ticket',
        'priority_id',
        'status_id',
        'category_id',
        'description',
        'attachments',
        'province_id',
        'city_or_regency_id',
        'pic',
        'jabatan',
        'completion_notes',
        'created_by',
        'updated_by',
        'no_hp',
        'level1',
        'level2',
        'level3',
        'level4',
        'level5'

    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            ActivityLog::create([
                'model_type' => get_class($model),
                'model_id'   => $model->id,
                'attribute'  => 'CREATE_TICKET',
                'old_value'  => null,
                'new_value'  => $model->no_ticket,
                'user_id'    => auth()->id(),
            ]);

            // Log initial attachments if any
            if ($model->attachments) {
                ActivityLog::create([
                    'model_type' => get_class($model),
                    'model_id'   => $model->id,
                    'attribute'  => 'attachments',
                    'old_value'  => null,
                    'new_value'  => $model->attachments,
                    'user_id'    => auth()->id(),
                ]);
            }
        });

        static::updating(function ($model) {
            $changes = $model->getDirty();
            foreach ($changes as $attribute => $newValue) {
                // Skip timestamp updates
                if (in_array($attribute, ['updated_at', 'created_at'])) continue;

                $oldValue = $model->getOriginal($attribute);

                // Prevent duplicate logs (Literal duplicates within 2 seconds)
                $exists = ActivityLog::where('model_type', get_class($model))
                    ->where('model_id', $model->id)
                    ->where('attribute', $attribute)
                    ->where('old_value', (string)$oldValue)
                    ->where('new_value', (string)$newValue)
                    ->where('user_id', auth()->id())
                    ->where('created_at', '>=', now()->subSeconds(2))
                    ->exists();

                if (!$exists) {
                    ActivityLog::create([
                        'model_type' => get_class($model),
                        'model_id'   => $model->id,
                        'attribute'  => $attribute,
                        'old_value'  => $oldValue,
                        'new_value'  => $newValue,
                        'user_id'    => auth()->id(),
                    ]);
                }
            }
        });

        static::deleted(function ($model) {
            ActivityLog::create([
                'model_type' => get_class($model),
                'model_id'   => $model->id,
                'attribute'  => 'DELETE_TICKET',
                'old_value'  => $model->no_ticket,
                'new_value'  => null,
                'user_id'    => auth()->id(),
            ]);
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

    public function helpdesk()
    {
        return $this->belongsTo(Role::class, 'level1');
    }

    public function koordinator()
    {
        return $this->belongsTo(Role::class, 'level2');
    }

    public function staffSubdit()
    {
        return $this->belongsTo(Role::class, 'level3');
    }

    public function siakDev()
    {
        return $this->belongsTo(Role::class, 'level4');
    }

    public function pejabat()
    {
        return $this->belongsTo(Role::class, 'level5');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
    public function cityOrRegency()
    {
        return $this->belongsTo(CityOrRegency::class, 'city_or_regency_id');
    }

    public function latestHistory()
    {
        return $this->hasOne(HistoryTicket::class, 'h_no_ticket', 'no_ticket')
            ->latest('created_at');
    }
}
