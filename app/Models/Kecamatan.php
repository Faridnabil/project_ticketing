<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Kecamatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kabupaten_id',
        'name', 'code', 'full_code'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    // public function kelurahan()
    // {
    //     return $this->hasMany(Kelurahan::class);
    // }

}
