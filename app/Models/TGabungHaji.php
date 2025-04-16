<?php

namespace App\Models;

use App\Models\MDokHaji;
use App\Models\Pembayaran;
use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TGabungHaji extends Model
{
  /** @use HasFactory<\Database\Factories\TGabungHajiFactory> */
  use HasFactory;

  protected $guarded = ['id'];

  // protected $casts = [
  //   'dokumen' => 'array',
  //   'perlengkapan' => 'array',
  // ];

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

  public function depag()
  {
    return $this->belongsTo(Kota::class, 'depag', 'id')->select(['id', 'kota']);
  }

  public function kotaBank()
  {
    return $this->belongsTo(Kota::class, 'kota_bank', 'id');
  }

  // public function dokumen()
  // {
  //   return $this->belongsToMany(MDokHaji::class, 't_gabung_haji_documents', 'gabung_haji_id', 'dokumen_id');
  // }

  public function perleng()
  {
    return $this->belongsToMany(MDokHaji::class, 't_gabung_haji_perlengkapan', 'gabung_haji_id', 'perlengkapan_id');
  }

  public function getDokumenItemsAttribute()
  {
    return MDokHaji::whereIn('id', $this->dokumen ?? [])->get();
  }

  public function pembayaran()
  {
    return $this->hasMany(Pembayaran::class, 'gabung_haji_id', 'id');
  }


  // Relasi Wilayah Indonesia
  // Relasi ke Provinsi
  public function provinsi()
  {
    return $this->belongsTo(Provinsi::class, 'provinsi_id');
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
