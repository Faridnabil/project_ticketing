<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table ='services';
    protected $primaryKey = 'id';
    protected $fillable = [
        'service_name',
        'color',
    ];

    public function category()
    {
        return $this->hasMany(Category::class);
    }
}
