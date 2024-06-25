<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_ticket',
        'title',
        'customer',
        'assign_to',
        'priority_id',
        'due_date',
        'status_id',
        'category_id',
        'description',
        'attachment',
        'status_changed_by_id'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function customers()
    {
        return $this->belongsTo(User::class, 'customer');
    }

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function statusChangedByUser()
    {
        return $this->belongsTo(User::class, 'status_changed_by_id');
    }
}
