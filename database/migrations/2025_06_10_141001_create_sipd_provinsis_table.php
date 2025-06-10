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
        Schema::create('sipd_provinsis', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->foreignId('regional_id')->constrained('regionals')->cascadeOnDelete();
            $table->String("id_daerah")->nullable();
            $table->String("nama_daerah")->nullable();
            $table->String("kode_ddn")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipd_provinsis');
    }
};
