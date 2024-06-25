<?php

use App\Enums\TicketStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('no_tikcet');
            $table->string('title');
            $table->foreignId('customer')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assign_to')->nullable()->constrained('users');
            $table->foreignId('priority_id')->constrained()->cascadeOnDelete();
            $table->string('due_date');
            $table->foreignId('status_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->string('attachment')->nullable();
            $table->foreignId('status_changed_by_id')->nullable()->constrained('users');
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
