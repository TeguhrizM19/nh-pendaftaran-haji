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
    Schema::create('m_perlengkapans', function (Blueprint $table) {
      $table->id();
      $table->string('perlengkapan', 200);
      $table->string('jenis_kelamin', 50)->nullable();
      $table->string('status', 15);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('m_perlengkapans');
  }
};
