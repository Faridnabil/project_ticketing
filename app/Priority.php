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
        'level',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getEscalationTimeAttribute()
    {
        return match ($this->name) {
            'High' => 4,
            'Critical' => 2,
            'Medium' => 8,
            'Low' => "unlimated",
            default => 0,
        };
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'priority_id', 'id');
    }
}
