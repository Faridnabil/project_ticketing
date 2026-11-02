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
        Schema::create('faq_chat_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id', 100)->index();
            $table->text('question');
            $table->unsignedBigInteger('faq_id')->nullable();
            $table->enum('source', ['template', 'ai_search'])->default('template');
            $table->text('ai_response')->nullable();
            $table->integer('confidence_score')->default(0);
            $table->boolean('is_answer_found')->default(false);
            $table->string('feedback_status', 50)->nullable(); // 'helped', 'not_helped'
            $table->string('escalation_action', 50)->nullable(); // 'contact_admin', 'create_ticket'
            $table->boolean('is_reviewed')->default(false);
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('faq_id')->references('id')->on('faqs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_chat_logs');
    }
};
