<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Regional extends Model
{
    use HasFactory;
    protected $fillable = [
        'regional_name','code'
    ];

    public function provinsi(): HasMany
    {
        return $this->hasMany(Provinsi::class);
    }

}
