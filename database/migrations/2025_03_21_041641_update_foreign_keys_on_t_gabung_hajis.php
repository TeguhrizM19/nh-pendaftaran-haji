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
    Schema::table('t_gabung_hajis', function (Blueprint $table) {
      // Hapus foreign key lama
      $table->dropForeign(['daftar_haji_id']);
      $table->dropForeign(['keberangkatan_id']);

      // Tambahkan kembali dengan ON DELETE SET NULL
      $table->foreign('daftar_haji_id')
        ->references('id')->on('t_daftar_hajis')
        ->onDelete('set null');

      $table->foreign('keberangkatan_id')
        ->references('id')->on('group_keberangkatan')
        ->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('t_gabung_hajis', function (Blueprint $table) {
      // Hapus foreign key yang baru ditambahkan
      $table->dropForeign(['daftar_haji_id']);
      $table->dropForeign(['keberangkatan_id']);

      // Kembalikan ke ON DELETE CASCADE jika rollback
      $table->foreign('daftar_haji_id')
        ->references('id')->on('t_daftar_hajis')
        ->onDelete('cascade');

      $table->foreign('keberangkatan_id')
        ->references('id')->on('group_keberangkatan')
        ->onDelete('cascade');
    });
  }
};
