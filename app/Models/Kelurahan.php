<?php

namespace App\Models;

use App\Models\Kecamatan;
use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelurahan extends Model
{
  use HasFactory;

  protected $table = 'm_kelurahans';
  protected $guarded = ['id'];

  public function kecamatan()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
  }

  public function daftarHajis()
  {
    return $this->hasMany(TDaftarHaji::class, 'kelurahan_id');
  }

  public function gabungHaji()
  {
    return $this->hasMany(TGabungHaji::class, 'kelurahan_id');
  }
}
