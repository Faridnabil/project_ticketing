<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqChatLog extends Model
{
    use HasFactory;

    protected $table = 'faq_chat_logs';

    protected $fillable = [
        'user_id',
        'session_id',
        'question',
        'faq_id',
        'source',
        'ai_response',
        'confidence_score',
        'is_answer_found',
        'feedback_status',
        'escalation_action',
        'is_reviewed',
        'reviewed_at',
    ];

    protected $casts = [
        'is_answer_found' => 'boolean',
        'is_reviewed' => 'boolean',
        'reviewed_at' => 'datetime',
        'confidence_score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faq_id');
    }
}
