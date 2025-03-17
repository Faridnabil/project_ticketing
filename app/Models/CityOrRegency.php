<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class CityOrRegency extends Model
{
    use HasApiTokens, HasFactory, HasRoles;

    protected $fillable = [
        'province_id',
        'no_city_or_regency',
        'city_or_regency_name',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'city_or_regency_id');
    }
    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'city_or_regency_id');
    }
}
