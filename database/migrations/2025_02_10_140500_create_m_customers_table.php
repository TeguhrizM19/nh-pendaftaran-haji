<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('m_customers', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('no_porsi_haji')->nullable();
      $table->foreignId('sumber_info_id')->nullable()->constrained('m_sumber_infos')->onDelete('cascade');
      $table->foreignId('wilayah_daftar')->nullable()->constrained('m_kotas')->onDelete('cascade');
      $table->string('nama')->nullable();
      $table->string('no_hp_1')->nullable();
      $table->string('no_hp_2')->nullable();
      $table->integer('tempat_lahir')->nullable(); // diambil dari relasi tabel m_kota
      $table->date('tgl_lahir')->nullable();
      $table->string('jenis_id')->nullable();
      $table->bigInteger('no_id')->nullable();
      $table->string('jenis_kelamin')->nullable();
      $table->string('status_nikah')->nullable();
      $table->string('warga')->nullable();
      $table->integer('estimasi')->nullable();
      $table->string('paket_haji')->nullable();
      $table->text('dokumen')->nullable();
      $table->text('catatan')->nullable();
      $table->bigInteger('bpjs')->nullable();
      $table->string('bank')->nullable();
      $table->string('pekerjaan')->nullable();
      $table->string('pendidikan')->nullable();
      $table->text('alamat_ktp')->nullable();
      $table->text('alamat_domisili')->nullable();
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
    Schema::dropIfExists('m_customers');
  }
};
