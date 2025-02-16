<?php

namespace App\Models;

use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MCabang extends Model
{
  /** @use HasFactory<\Database\Factories\MCabangFactory> */
  use HasFactory;

  protected $guarded = ['id'];

  public function daftarHajis()
  {
    return $this->hasMany(TDaftarHaji::class, 'cabang_id');
  }
}
