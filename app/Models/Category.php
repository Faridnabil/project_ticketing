<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Category extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_name'
    ] ;

    public function layanan()
    {
        return $this->belongsTo(Service::class);
    }
}
