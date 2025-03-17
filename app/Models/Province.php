<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Province extends Model
{
    use HasApiTokens, HasFactory, HasRoles;

    protected $fillable = [
        'no_province',
        'province_name'
    ];

    public function cityOrRegency()
    {
        return $this->hasMany(CityOrRegency::class, 'province_id');
    }
    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'province_id');
    }
}
