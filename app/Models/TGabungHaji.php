<?php

namespace App\Models;

use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TGabungHaji extends Model
{
  /** @use HasFactory<\Database\Factories\TGabungHajiFactory> */
  use HasFactory;

  protected $guarded = ['id'];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }

  public function daftarHaji()
  {
    return $this->belongsTo(TDaftarHaji::class, 'daftar_haji_id');
  }

  public function keberangkatan()
  {
    return $this->belongsTo(GroupKeberangkatan::class, 'keberangkatan_id');
  }

  public function tempatLahir()
  {
    return $this->belongsTo(Kota::class, 'tempat_lahir', 'id');
  }

  // Relasi ke Provinsi
  public function provinsi()
  {
    return $this->belongsTo(Provinsi::class, 'provinsi_id');
  }

  public function kotaBank()
  {
    return $this->belongsTo(Kota::class, 'kota_bank', 'id');
  }

  // Relasi ke Kota
  public function kota()
  {
    return $this->belongsTo(Kota::class, 'kota_id');
  }


  // Relasi ke Kecamatan
  public function kecamatan()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
  }

  // Relasi ke Kelurahan
  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
  }
}
