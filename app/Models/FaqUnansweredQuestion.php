<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqUnansweredQuestion extends Model
{
    use HasFactory;

    protected $table = 'faq_unanswered_questions';

    protected $fillable = [
        'question',
        'occurrence_count',
        'ai_draft_answer',
        'status',
    ];

    protected $casts = [
        'occurrence_count' => 'integer',
    ];
}
