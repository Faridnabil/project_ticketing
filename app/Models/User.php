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
    ];

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

    public function helpdesk()
    {
        return $this->hasMany(Ticket::class, 'level1');
    }

    public function koordinator()
    {
        return $this->hasMany(Ticket::class, 'level2');
    }

    public function staffSubdit()
    {
        return $this->hasMany(Ticket::class, 'level3');
    }

    public function siakDev()
    {
        return $this->hasMany(Ticket::class, 'level4');
    }

    public function pejabat()
    {
        return $this->hasMany(Ticket::class, 'level5');
    }

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
}
