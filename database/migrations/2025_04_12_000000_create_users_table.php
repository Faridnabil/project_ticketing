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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->text('photo')->nullable();
            $table->text('surat_tugas')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('regional_id')->nullable()->constrained('regionals');
            $table->foreignId('sipd_provinsi_id')->nullable()->constrained('sipd_provinsis');
            $table->foreignId('sipd_kabkot_id')->nullable()->constrained('sipd_kabkots');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
