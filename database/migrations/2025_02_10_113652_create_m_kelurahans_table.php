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
        Schema::create('m_kelurahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('m_kecamatans')->onDelete('cascade');
            $table->string('kelurahan');
            $table->string('kode_pos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kelurahans');
    }
};
