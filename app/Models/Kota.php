<?php

namespace App\Models;

use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kota extends Model
{
  use HasFactory;

  protected $table = 'm_kotas';
  protected $guarded = ['id'];

  public function provinsi()
  {
    return $this->belongsTo(Provinsi::class, 'provinsi_id', 'id');
  }

  public function kecamatans()
  {
    return $this->hasMany(Kecamatan::class, 'kota_id', 'id');
  }

  public function daftarHajis()
  {
    return $this->hasMany(TDaftarHaji::class, 'kota_id');
  }

  public function gabungHaji()
  {
    return $this->hasMany(TGabungHaji::class, 'kota_id');
  }
}
