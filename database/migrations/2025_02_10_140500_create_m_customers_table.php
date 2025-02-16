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
      $table->string('no_hp_1');
      $table->string('no_hp_2');
      $table->integer('tempat_lahir'); // diambil dari relasi tabel m_kota
      $table->date('tgl_lahir');
      $table->string('jenis_id');
      $table->string('no_id');
      $table->string('jenis_kelamin');
      $table->string('status_nikah');
      $table->text('alamat_ktp');
      $table->text('alamat_domisili');
      $table->foreignId('provinsi_id')->nullable()->constrained('m_provinsis')->onDelete('cascade');
      $table->foreignId('kota_id')->nullable()->constrained('m_kotas')->onDelete('cascade');
      $table->foreignId('kecamatan_id')->nullable()->constrained('m_kecamatans')->onDelete('cascade');
      $table->foreignId('kelurahan_id')->nullable()->constrained('m_kelurahans')->onDelete('cascade');
      $table->string('warga');
      $table->string('pekerjaan');
      $table->string('pendidikan');
      // $table->string('nama_pasport');
      // $table->string('tmp_lhr_pasport');
      // $table->date('tgl_lhr_pasport');
      // $table->string('no_pasport');
      // $table->string('kota_paspor_dibuat');
      // $table->date('tgl_terbit_pasport');
      // $table->date('tgl_kadaluarsa_pasport');
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
