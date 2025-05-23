<?php

namespace App\Models;

use App\Models\Kota;
use App\Models\Customer;
use App\Models\MDokHaji;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Pembayaran;
use App\Models\TDaftarHaji;
use App\Models\MPerlengkapan;
use App\Models\GroupKeberangkatan;
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

  public function getSelectedPerlengkapanAttribute()
  {
    return collect(json_decode($this->perlengkapan, true) ?? []);
  }

  public function getSelectedDokumenAttribute()
  {
    return collect(json_decode($this->dokumen, true) ?? []);
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
