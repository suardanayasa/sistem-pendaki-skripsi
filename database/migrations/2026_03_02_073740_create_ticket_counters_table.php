<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_counters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique(); // Loket pakai Email
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_counters');
    }
};