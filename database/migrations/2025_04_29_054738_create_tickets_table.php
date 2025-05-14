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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('no_ticket')->unique();
            $table->foreignId('regional_id')->nullable()->constrained('regionals');
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsis');
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupatens');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->cascadeOnDelete();
            $table->foreignId('level1')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->foreignId('level2')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->foreignId('level3')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->foreignId('level4')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->foreignId('level5')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->foreignId('priority_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('status_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->text('completion_notes')->nullable();
            $table->json('attachments')->nullable();
            $table->string('pic')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
