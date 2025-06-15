<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SipdProvinsi extends Model
{
    use HasFactory;
    protected $fillable = [
        'regional_id',
        'nama_daerah',
        'kode_ddn',
    ];

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function kabkot()
    {
        return $this->hasMany(SipdKabkot::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'sipd_provinsi_id');
    }

}
