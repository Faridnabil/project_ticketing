<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class IncidentalActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'start_time',
        'end_time',
        'users',
        'mitigation',
        'impact',
        'status_id',
        'file_path',
        'user_id',
    ];

    protected $casts = [
        'users' => 'array', // Cast the users attribute as an array
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function category()
    {
        return $this->belongsTo(IncidentalActivityCategory::class, 'category_id');
    }

    /**
     * Retrieve the users associated with this incidental activity.
     */
    public function getAssignedUsers()
    {
        // Decode data 'users' jika berbentuk string JSON, lalu ubah menjadi array
        $userIds = is_string($this->users) ? json_decode($this->users, true) : $this->users;

        // Pastikan $userIds adalah array sebelum menggunakan count()
        if (is_array($userIds)) {
            return User::whereIn('id', $userIds)->get();
        }

        // Kembalikan koleksi kosong jika userIds tidak valid
        return collect();
    }
}
