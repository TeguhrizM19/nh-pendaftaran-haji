<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\TDaftarHaji;
use App\Models\TGabungHaji;
use App\Models\GroupKeberangkatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
  /** @use HasFactory<\Database\Factories\PembayaranFactory> */
  use HasFactory;

  protected $table = 'pembayarans';
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

  public function keberangkatan()
  {
    return $this->belongsTo(GroupKeberangkatan::class, 'keberangkatan_id');
  }
}
