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
    Schema::create('t_daftar_hajis', function (Blueprint $table) {
      $table->id();
      $table->foreignId('customer_id')->constrained('m_customers')->onDelete('cascade');
      $table->foreignId('cabang_id')->constrained('m_cabangs')->onDelete('cascade');
      // $table->foreignId('provinsi_id')->constrained('m_provinsis')->onDelete('cascade');
      // $table->foreignId('kota_id')->constrained('m_kotas')->onDelete('cascade');
      // $table->foreignId('kecamatan_id')->constrained('m_kecamatans')->onDelete('cascade');
      // $table->foreignId('kelurahan_id')->constrained('m_kelurahans')->onDelete('cascade');
      $table->foreignId('sumber_info_id')->constrained('m_sumber_infos')->onDelete('cascade');
      $table->foreignId('wilayah_daftar')->constrained('m_kotas')->onDelete('cascade');
      $table->integer('no_porsi_haji');
      $table->integer('estimasi')->nullable();
      $table->integer('bpjs')->nullable();
      $table->string('bank')->nullable();
      $table->string('paket_haji')->nullable();
      $table->text('catatan')->nullable();
      $table->string('no_hp_1')->nullable();
      $table->string('no_hp_2')->nullable();
      $table->string('tempat_lahir')->nullable();
      $table->date('tgl_lahir')->nullable();
      $table->string('jenis_id')->nullable();
      $table->string('no_id')->nullable();
      $table->string('warga')->nullable();
      $table->text('dokumen')->nullable();
      $table->string('jenis_kelamin')->nullable();
      $table->string('status_nikah')->nullable();
      $table->string('pekerjaan')->nullable();
      $table->string('pendidikan')->nullable();
      $table->json('alamat_ktp')->nullable(); // Menyimpan dalam format JSON
      $table->json('alamat_domisili')->nullable();
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
    Schema::dropIfExists('t_daftar_hajis');
  }
};
