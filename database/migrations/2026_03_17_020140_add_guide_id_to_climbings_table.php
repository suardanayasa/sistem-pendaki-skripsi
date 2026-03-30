<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('climbings', function (Blueprint $table) {
            // Kita buat 'laci' baru untuk menyimpan siapa Guide pendaki tersebut
            $table->unsignedBigInteger('guide_id')->nullable()->after('group_id');
            
            // Kita hubungkan ke tabel guides
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('climbings', function (Blueprint $table) {
            $table->dropForeign(['guide_id']);
            $table->dropColumn('guide_id');
        });
    }
};