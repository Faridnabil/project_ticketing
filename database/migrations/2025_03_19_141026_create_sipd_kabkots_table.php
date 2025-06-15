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
        Schema::create('sipd_kabkots', function (Blueprint $table) {
            $table->id();
            $table->String("id_daerah")->nullable();
            $table->String("nama_daerah")->nullable();
            $table->String("kode_ddn")->nullable();
            $table->String("kode_ddn_2")->nullable();
            $table->String("logo")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sipd_kabkots');
    }
};
