<?php

namespace App\Models;

use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\MSumberInfo;
use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
  use HasFactory;

  protected $table = 'm_customers';
  protected $guarded = ['id'];

  // Awal Relasi Wilayah Indonesia
  public function provinsi()
  {
    return $this->belongsTo(Provinsi::class, 'provinsi_id', 'id');
  }

  public function kota()
  {
    return $this->belongsTo(Kota::class, 'kota_id', 'id');
  }

  public function kecamatan()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
  }

  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'id');
  }

  // Relasi Tempat Lahir ke Tabel Kota
  public function tempatLahir()
  {
    return $this->belongsTo(Kota::class, 'tempat_lahir', 'id');
  }

  // Relasi Sumber Info
  public function sumberInfo()
  {
    return $this->belongsTo(MSumberInfo::class, 'sumber_info_id');
  }

  // Relasi ke Daftar Haji
  public function daftarHaji()
  {
    return $this->hasMany(TDaftarHaji::class, 'customer_id');
  }

  public function cabang()
  {
    return $this->belongsTo(MCabang::class, 'cabang_id');
  }

  public function wilayahKota()
  {
    return $this->belongsTo(Kota::class, 'kota_id');
  }

  // Wilayah KTP
  public function provinsiKtp()
  {
    return $this->belongsTo(Provinsi::class, 'provinsi_ktp', 'id');
  }

  public function kotaKtp()
  {
    return $this->belongsTo(Kota::class, 'kota_ktp', 'id');
  }

  public function kecamatanKtp()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_ktp', 'id');
  }

  public function kelurahanKtp()
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_ktp', 'id');
  }

  // Relasi untuk alamat domisili
  public function provinsiDomisili()
  {
    return $this->belongsTo(Provinsi::class, 'provinsi_domisili', 'id');
  }

  public function kotaDomisili()
  {
    return $this->belongsTo(Kota::class, 'kota_domisili', 'id');
  }

  public function kecamatanDomisili()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_domisili', 'id');
  }

  public function kelurahanDomisili()
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_domisili', 'id');
  }
}
