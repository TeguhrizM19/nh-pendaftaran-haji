<?php

namespace App\Models;

use App\Models\Kota;
use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Model
{
  use HasFactory;

  protected $table = 'm_provinsis';
  protected $guarded = ['id'];

  // Relasi ke Kota (One to Many)
  public function kotas()
  {
    return $this->hasMany(Kota::class, 'provinsi_id', 'id');
  }

  public function daftarHajis()
  {
    return $this->hasMany(TDaftarHaji::class, 'provinsi_id');
  }

  public function gabungHaji()
  {
    return $this->hasMany(TGabungHaji::class, 'provinsi_id');
  }

  public function kota()
  {
    return $this->hasMany(Kota::class, 'provinsi_id');
  }
}
