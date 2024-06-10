<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes;

    public $table = 'priorities';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'max_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getEscalationTimeAttribute()
    {
        return match ($this->name) {
            'High / Level 2' => 4,
            'Critical / Level 2' => 2,
            'Medium / Level 2' => 8,
            'Low / Level 2' => 16,
            'Low / Level 1' => "-",
            default => 0,
        };
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'priority_id', 'id');
    }
}
