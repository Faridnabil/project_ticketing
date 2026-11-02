<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faq_unanswered_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question', 255)->unique();
            $table->integer('occurrence_count')->default(1);
            $table->text('ai_draft_answer')->nullable();
            $table->enum('status', ['pending', 'converted', 'ignored'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_unanswered_questions');
    }
};
