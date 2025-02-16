<?php

namespace App\Models;

use App\Models\Kota;
use App\Models\Kelurahan;
use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
  use HasFactory;

  protected $table = 'm_kecamatans';
  protected $guarded = ['id'];

  public function kota()
  {
    return $this->belongsTo(Kota::class, 'kota_id', 'id');
  }

  public function kelurahans()
  {
    return $this->hasMany(Kelurahan::class, 'kecamatan_id', 'id');
  }

  public function daftarHajis()
  {
    return $this->hasMany(TDaftarHaji::class, 'kecamatan_id');
  }

  public function gabungHaji()
  {
    return $this->hasMany(TGabungHaji::class, 'kecamatan_id');
  }
}
