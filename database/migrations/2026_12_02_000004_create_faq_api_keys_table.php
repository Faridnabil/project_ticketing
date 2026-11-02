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
        Schema::create('faq_api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Kunci API');
            $table->text('api_key');
            $table->boolean('is_active')->default(false);
            $table->integer('daily_limit')->default(1500);
            $table->string('model')->default('gemini-3.5-flash');
            $table->timestamps();
        });

        if (!Schema::hasColumn('faq_chat_logs', 'is_reviewed')) {
            Schema::table('faq_chat_logs', function (Blueprint $table) {
                $table->boolean('is_reviewed')->default(false)->after('escalation_action');
                $table->timestamp('reviewed_at')->nullable()->after('is_reviewed');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_api_keys');

        if (Schema::hasColumn('faq_chat_logs', 'is_reviewed')) {
            Schema::table('faq_chat_logs', function (Blueprint $table) {
                $table->dropColumn(['is_reviewed', 'reviewed_at']);
            });
        }
    }
};
