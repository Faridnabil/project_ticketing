<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentalActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('incidental_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Aktivitas
            $table->text('description'); // Deskripsi Aktivitas
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->date('start_time'); // Tanggal Mulai
            $table->date('end_time'); // Tanggal Selesai
            $table->string('executor'); // Pelaksana Aktivitas
            $table->string('department'); // Departemen/Tim
            $table->text('mitigation'); // Mitigasi
            $table->text('impact'); // Dampak terhadap Sistem
            $table->foreignId('status_id')->nullable()->constrained()->cascadeOnDelete(); // Status Aktivitas
            $table->string('file_path')->nullable(); // Path untuk File yang Diunggah
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key ke User
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incidental_activities');
    }
};
