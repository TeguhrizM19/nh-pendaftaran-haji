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
  protected $casts = [
    'alamat_ktp' => 'array', // Mengubah alamat_ktp menjadi array
  ];

  // Awal Relasi Wilayah Indonesia
  // Relasi Wilayah Indonesia
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
  public function kota_lahir()
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
}
