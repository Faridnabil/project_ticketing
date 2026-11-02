<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqApiKey extends Model
{
    use HasFactory;

    protected $table = 'faq_api_keys';

    protected $fillable = [
        'name',
        'api_key',
        'is_active',
        'daily_limit',
        'model',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'daily_limit' => 'integer',
    ];

    /**
     * Get masked API key for display.
     */
    public function getMaskedKeyAttribute(): string
    {
        $key = (string) $this->api_key;
        if (strlen($key) < 12) {
            return '••••••••';
        }
        return substr($key, 0, 8) . '••••••••••••' . substr($key, -4);
    }
}
