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
    Schema::create('t_gabung_hajis', function (Blueprint $table) {
      $table->id();
      $table->integer('no_spph');
      $table->integer('no_porsi');
      $table->year('estimasi');
      $table->string('nama_bank');
      $table->string('kota_bank');
      $table->string('depag');
      $table->string('nama_lengkap');
      $table->string('panggilan');
      $table->string('jenis_kelamin');
      $table->string('tempat_lahir');
      $table->date('tgl_lahir');
      $table->string('alamat');
      $table->foreignId('provinsi_id')->constrained('m_provinsis')->onDelete('cascade');
      $table->foreignId('kota_id')->constrained('m_kotas')->onDelete('cascade');
      $table->foreignId('kecamatan_id')->constrained('m_kecamatans')->onDelete('cascade');
      $table->foreignId('kelurahan_id')->constrained('m_kelurahans')->onDelete('cascade');
      $table->string('no_hp');
      $table->string('pekerjaan');
      $table->string('pendidikan');
      $table->text('catatan')->nullable();
      $table->string('create_user', 100)->nullable();
      $table->date('create_date')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('t_gabung_hajis');
  }
};
