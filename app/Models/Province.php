<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Province extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'no_province',
        'province_name'
    ];

    public function cityOrRegency()
    {
        return $this->hasMany(CityOrRegency::class, 'province_id');
    }
}
