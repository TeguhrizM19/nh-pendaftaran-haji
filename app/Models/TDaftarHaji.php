<?php

namespace App\Models;

use App\Models\Kota;
use App\Models\MCabang;
use App\Models\Customer;
use App\Models\MDokHaji;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\MSumberInfo;
use App\Models\GroupKeberangkatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TDaftarHaji extends Model
{
  /** @use HasFactory<\Database\Factories\TDaftarHajiFactory> */
  use HasFactory;

  protected $table = 't_daftar_hajis';
  protected $guarded = ['id'];
  protected $casts = [
    'dokumen' => 'array',
    'perlengkapan' => 'array',
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }

  public function cabang()
  {
    return $this->belongsTo(MCabang::class, 'cabang_id');
  }

  public function sumberInfo()
  {
    return $this->belongsTo(MSumberInfo::class, 'sumber_info_id');
  }

  public function wilayahDaftar()
  {
    return $this->belongsTo(Kota::class, 'wilayah_daftar', 'id');
  }

  // public function dokumen()
  // {
  //   return $this->belongsToMany(MDokHaji::class, 't_daftar_haji_documents', 'daftar_haji_id', 'dokumen_id');
  // }

  public function getDokumenItemsAttribute()
  {
    return MDokHaji::whereIn('id', $this->dokumen ?? [])->get();
  }

  public function tempatLahir()
  {
    return $this->belongsTo(Kota::class, 'tempat_lahir');
  }

  public function keberangkatan()
  {
    return $this->belongsTo(GroupKeberangkatan::class, 'keberangkatan_id');
  }

  // Awal Relasi Wilayah Indonesia
  public function provinsi()
  {
    return $this->belongsTo(Provinsi::class, 'provinsi_id');
  }

  public function kota()
  {
    return $this->belongsTo(Kota::class, 'kota_id');
  }

  public function kecamatan()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
  }

  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
  }
  // Akhir Relasi Wilayah Indonesia
}
