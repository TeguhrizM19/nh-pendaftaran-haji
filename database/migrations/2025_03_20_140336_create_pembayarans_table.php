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
    Schema::create('pembayarans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('customer_id')->nullable()->constrained('m_customers')->onDelete('cascade');
      $table->foreignId('keberangkatan_id')->nullable()->constrained('group_keberangkatan')->onDelete('cascade');
      $table->date('tgl_bayar')->nullable();
      $table->string('metode_bayar')->nullable();
      $table->string('kwitansi')->nullable();
      $table->string('keterangan')->nullable();
      $table->string('create_user', 100)->nullable();
      $table->string('update_user', 50)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pembayarans');
  }
};
