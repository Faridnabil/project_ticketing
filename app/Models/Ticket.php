<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Ticket extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'no_ticket',
        'priority_id',
        'sipd_kabkot_id',
        'status_id',
        'category_id',
        'description',
        'attachments',
        'sipd_provinsi_id',
        // 'kabupaten_id',
        'nip',
        // 'jabatan',
        'completion_notes',
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

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
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

    // public function user(){
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
