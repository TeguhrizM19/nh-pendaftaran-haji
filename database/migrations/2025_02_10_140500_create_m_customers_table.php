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
      $table->string('nama');
      $table->string('panggilan')->nullable();
      $table->string('no_hp_1');
      $table->string('no_hp_2')->nullable();
      $table->integer('tempat_lahir'); // diambil dari relasi tabel m_kota
      $table->date('tgl_lahir');
      $table->string('jenis_id');
      $table->bigInteger('no_id');
      $table->string('jenis_kelamin');
      $table->string('status_nikah');
      $table->string('warga');
      $table->string('pekerjaan');
      $table->string('pendidikan');
      // Alamat KTP
      $table->string('alamat_ktp');
      $table->integer('provinsi_ktp');
      $table->integer('kota_ktp');
      $table->integer('kecamatan_ktp');
      $table->integer('kelurahan_ktp');
      // Alamat Domisili
      $table->string('alamat_domisili');
      $table->integer('provinsi_domisili');
      $table->integer('kota_domisili');
      $table->integer('kecamatan_domisili');
      $table->integer('kelurahan_domisili');
      // Upload File
      $table->string('ktp')->nullable();
      $table->string('kk')->nullable();
      $table->string('surat')->nullable();
      $table->string('spph')->nullable();
      $table->string('bpih')->nullable();
      $table->string('photo')->nullable();
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
