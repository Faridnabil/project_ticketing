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
        Schema::create('history_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('h_no_ticket');
            $table->string('h_title');
            $table->integer('h_no_telp');
            $table->string('h_email');
            $table->foreignId('h_users')->constrained('users')->cascadeOnDelete();
            $table->foreignId('h_assign_to')->nullable()->constrained('users');
            $table->foreignId('h_priority_id')->nullable()->constrained('priorities')->cascadeOnDelete();
            $table->foreignId('h_status_id')->nullable()->constrained('statuses')->cascadeOnDelete();
            $table->foreignId('h_service_id')->nullable()->constrained('services')->cascadeOnDelete();
            $table->foreignId('h_category_id')->constrained('categories')->cascadeOnDelete();
            $table->text('h_description');
            $table->text('h_solution')->nullable();
            $table->text('h_attachments')->nullable();
            $table->foreignId('status_changedBy')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_tickets');
    }
};
