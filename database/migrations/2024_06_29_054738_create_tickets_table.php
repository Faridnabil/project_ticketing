<?php

use App\Enums\TicketStatus;
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
            $table->string('no_ticket');
            $table->foreignId('province_id')->nullable()->constrained();
            $table->foreignId('city_or_regency_id')->nullable()->constrained('city_or_regencies');
            $table->foreignId('level1')->nullable()->constrained('roles');
            $table->foreignId('level2')->nullable()->constrained('roles');
            $table->foreignId('level3')->nullable()->constrained('roles');
            $table->foreignId('level4')->nullable()->constrained('roles');
            $table->foreignId('level5')->nullable()->constrained('roles');
            $table->foreignId('priority_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('status_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->text('completion_notes')->nullable();
            $table->text('attachments')->nullable();
            $table->string('pic')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
