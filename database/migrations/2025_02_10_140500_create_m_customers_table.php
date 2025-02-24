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
      $table->string('nama')->nullable();
      $table->string('panggilan')->nullable();
      $table->string('no_hp_1')->nullable();
      $table->string('no_hp_2')->nullable();
      $table->integer('tempat_lahir')->nullable(); // diambil dari relasi tabel m_kota
      $table->date('tgl_lahir')->nullable();
      $table->string('jenis_id')->nullable();
      $table->bigInteger('no_id')->nullable();
      $table->string('jenis_kelamin')->nullable();
      $table->string('status_nikah')->nullable();
      $table->string('warga')->nullable();
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
