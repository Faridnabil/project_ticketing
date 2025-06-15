<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipdKabkot extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_daerah',
        'kode_ddn',
        'kode_ddn_2',
        'logo',
    ];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'sipd_kabkot_id');
    }
}
