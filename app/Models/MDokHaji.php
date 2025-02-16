<?php

namespace App\Models;

use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MDokHaji extends Model
{
  /** @use HasFactory<\Database\Factories\MDokHajiFactory> */
  use HasFactory;

  protected $guarded = ['id'];

  // Relasi Many to Many dg banyak dokumen
  public function daftarHaji()
  {
    return $this->belongsToMany(TDaftarHaji::class, 't_daftar_haji_dokumen', 'dok_id', 't_daftar_haji_id');
  }
}
