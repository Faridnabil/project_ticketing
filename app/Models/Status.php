<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Status extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'status_name', 'color'
    ] ;

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'status_id');
    }
}
