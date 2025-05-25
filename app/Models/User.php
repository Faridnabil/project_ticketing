<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nik',
        'email',
        'password',
        'gender',
        'photo',
        'surat_tugas',
        'kabupaten_id',
        'provinsi_id',
        'regional_id',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if ($user->kabupaten_id && !$user->provinsi_id) {
                $kabupaten = Kabupaten::with('provinsi.regional')->find($user->kabupaten_id);
                $user->provinsi_id = $kabupaten->provinsi->id ?? null;
                $user->regional_id = $kabupaten->provinsi->regional->id ?? null;
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hticket()
    {
        return $this->hasMany(HistoryTicket::class, 'customer');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

}
