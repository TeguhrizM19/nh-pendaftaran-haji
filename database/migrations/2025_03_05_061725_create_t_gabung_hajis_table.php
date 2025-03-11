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
      $table->foreignId('customer_id')->constrained('m_customers')->onDelete('cascade');
      $table->foreignId('daftar_haji_id')->nullable()->constrained('t_daftar_hajis')->onDelete('cascade');
      $table->foreignId('keberangkatan_id')->nullable()->constrained('group_keberangkatan')->onDelete('cascade');
      $table->bigInteger('no_spph')->nullable();
      $table->bigInteger('no_porsi')->nullable();
      $table->string('nama_bank')->nullable();
      $table->integer('kota_bank')->nullable();
      $table->integer('depag')->nullable();
      $table->text('dokumen')->nullable();
      $table->string('pelunasan')->nullable();
      $table->string('pelunasan_manasik', 25)->nullable();
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
