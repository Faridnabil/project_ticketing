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
            $table->foreignId('h_regional_id')->nullable()->constrained('regionals');
            $table->foreignId('h_provinsi_id')->nullable()->constrained('provinsis');
            $table->foreignId('h_kabupaten_id')->nullable()->constrained('kabupatens');
            $table->foreignId('h_level1')->nullable()->constrained('roles');
            $table->foreignId('h_level2')->nullable()->constrained('roles');
            $table->foreignId('h_level3')->nullable()->constrained('roles');
            $table->foreignId('h_level4')->nullable()->constrained('roles');
            $table->foreignId('h_level5')->nullable()->constrained('roles');

            $table->foreignId('h_priority_id')->nullable()->constrained('priorities')->cascadeOnDelete();
            $table->foreignId('h_status_id')->nullable()->constrained('statuses')->cascadeOnDelete();
            $table->foreignId('h_category_id')->constrained('categories')->cascadeOnDelete();
            $table->text('h_description');
            $table->text('h_attachments')->nullable();
            $table->string('h_pic')->nullable();
            $table->string('h_jabatan')->nullable();
            $table->string('h_no_hp')->nullable();
            $table->text('h_completion_notes')->nullable();

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
