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
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAssignedUsers()
    {
        // Jika 'users' adalah array, langsung gunakan
        if (is_array($this->users)) {
            $userIds = $this->users;
        } else {
            // Jika 'users' adalah string, coba decode menjadi array
            $userIds = json_decode($this->users, true);
        }

        // Pastikan $userIds adalah array yang valid dan tidak kosong
        if (is_array($userIds) && !empty($userIds)) {
            return User::whereIn('id', $userIds)->get();
        }

        // Kembalikan koleksi kosong jika $userIds tidak valid
        return collect();
    }
}
