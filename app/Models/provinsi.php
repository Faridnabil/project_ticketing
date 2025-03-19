<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class provinsi extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'name', 'regional_id'
    ];

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function kabupaten()    
    {
        return $this->hasMany(Kabupaten::class);
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }

}
