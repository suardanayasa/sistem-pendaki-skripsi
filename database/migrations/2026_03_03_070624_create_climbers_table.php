<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('climbings', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('residence');
            // Menambahkan kolom Nomor HP
            $table->string('phone_number'); 

            $table->foreignId('ticket_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('group_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            $table->enum('status', ['climbing', 'finished'])
                  ->default('climbing');

            $table->dateTime('check_in_date');
            $table->dateTime('check_out_date')->nullable();

            $table->foreignId('ticket_counter_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('climbings');
    }
};