<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPerlengkapan extends Model
{
  /** @use HasFactory<\Database\Factories\MPerlengkapanFactory> */
  use HasFactory;

  protected $table = 'm_perlengkapans';
  protected $guarded = ['id'];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }

  public function gabungHaji()
  {
    return $this->belongsTo(TGabungHaji::class, 'gabung_haji_id');
  }

  public function daftarHaji()
  {
    return $this->belongsTo(TDaftarHaji::class, 'daftar_haji_id');
  }

  public function dokumen()
  {
    return $this->belongsToMany(MDokHaji::class, 't_gabung_haji_documents', 'gabung_haji_id', 'dokumen_id');
  }
}
