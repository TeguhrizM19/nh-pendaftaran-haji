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
      $table->foreignId('cabang_id')->nullable()->constrained('m_cabangs')->onDelete('cascade');
      $table->foreignId('sumber_info_id')->nullable()->constrained('m_sumber_infos')->onDelete('cascade');
      $table->foreignId('wilayah_daftar')->nullable()->constrained('m_kotas')->onDelete('cascade');
      $table->bigInteger('no_porsi_haji')->nullable();
      $table->integer('estimasi')->nullable();
      $table->string('paket_haji')->nullable();
      $table->text('dokumen')->nullable();
      $table->text('catatan')->nullable();
      $table->bigInteger('bpjs')->nullable();
      $table->string('bank')->nullable();
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
