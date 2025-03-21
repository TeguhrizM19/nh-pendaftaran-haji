<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::table('t_daftar_hajis', function (Blueprint $table) {
      // Hapus foreign key lama
      $table->dropForeign(['cabang_id']);
      $table->dropForeign(['sumber_info_id']);
      $table->dropForeign(['wilayah_daftar']);
      $table->dropForeign(['keberangkatan_id']);

      // Tambahkan kembali dengan ON DELETE SET NULL
      $table->foreign('cabang_id')
        ->references('id')->on('m_cabangs')
        ->onDelete('set null');

      $table->foreign('sumber_info_id')
        ->references('id')->on('m_sumber_infos')
        ->onDelete('set null');

      $table->foreign('wilayah_daftar')
        ->references('id')->on('m_kotas')
        ->onDelete('set null');

      $table->foreign('keberangkatan_id')
        ->references('id')->on('group_keberangkatan')
        ->onDelete('set null');
    });
  }

  public function down()
  {
    Schema::table('t_daftar_hajis', function (Blueprint $table) {
      // Hapus foreign key yang baru ditambahkan
      $table->dropForeign(['cabang_id']);
      $table->dropForeign(['sumber_info_id']);
      $table->dropForeign(['wilayah_daftar']);
      $table->dropForeign(['keberangkatan_id']);

      // Kembalikan ke ON DELETE CASCADE jika rollback
      $table->foreign('cabang_id')
        ->references('id')->on('m_cabangs')
        ->onDelete('cascade');

      $table->foreign('sumber_info_id')
        ->references('id')->on('m_sumber_infos')
        ->onDelete('cascade');

      $table->foreign('wilayah_daftar')
        ->references('id')->on('m_kotas')
        ->onDelete('cascade');

      $table->foreign('keberangkatan_id')
        ->references('id')->on('group_keberangkatan')
        ->onDelete('cascade');
    });
  }
};
