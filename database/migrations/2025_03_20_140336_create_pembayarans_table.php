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
    Schema::create('pembayarans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('daftar_haji_id')->nullable()->constrained('t_daftar_hajis')->onDelete('set null');
      $table->foreignId('gabung_haji_id')->nullable()->constrained('t_gabung_hajis')->onDelete('set null');
      $table->foreignId('keberangkatan_id')->nullable()->constrained('group_keberangkatan')->onDelete('set null');
      $table->foreignId('cabang_id')->nullable()->constrained('m_cabangs')->onDelete('set null');
      $table->date('tgl_bayar')->nullable();
      $table->string('metode_bayar')->nullable();
      $table->string('pilihan_biaya_operasional', 50)->nullable();
      $table->string('pilihan_biaya_manasik', 50)->nullable();
      $table->string('pilihan_biaya_dam', 50)->nullable();
      $table->string('operasional', 100)->nullable();
      $table->string('manasik', 100)->nullable();
      $table->string('dam', 100)->nullable();
      $table->string('tambahan', 100)->nullable();
      $table->string('nominal')->nullable();
      $table->string('kwitansi')->nullable();
      $table->string('keterangan')->nullable();
      $table->string('create_user', 100)->nullable();
      $table->string('update_user', 50)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pembayarans');
  }
};
