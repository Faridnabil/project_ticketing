<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Priority extends Model
{
    use HasApiTokens, HasFactory, HasRoles;

    protected $fillable = [
        'priority_name',
        'color'
    ];

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'priority_id');
    }
}
