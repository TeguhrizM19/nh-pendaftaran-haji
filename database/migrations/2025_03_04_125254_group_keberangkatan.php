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
    Schema::create('group_keberangkatan', function (Blueprint $table) {
      $table->id();
      $table->string('keberangkatan');
      $table->string('manasik')->nullable();
      $table->string('operasional')->nullable();
      $table->string('dam')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('group_keberangkatan');
  }
};
