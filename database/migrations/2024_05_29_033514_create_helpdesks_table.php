<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpdesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpdesks', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('email_address');
            $table->text('message');
            $table->unsignedInteger('priority_id'); // Pastikan tipe data sesuai
            $table->string('ticket_id'); // Pastikan tipe data sesuai
            // $table->unsignedInteger('category_id'); // Pastikan tipe data sesuai
            $table->unsignedInteger('user_id'); // Pastikan tipe data sesuai
            $table->unsignedInteger('status_id'); // Pastikan tipe data sesuai
            $table->timestamps();

            $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('cascade');
            $table->foreign('ticket_id')->references('ticket_id')->on('tickets')->onDelete('cascade');
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('helpdesks');
    }
}
