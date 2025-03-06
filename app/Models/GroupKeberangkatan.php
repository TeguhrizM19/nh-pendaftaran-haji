<?php

namespace App\Models;

use App\Models\TGabungHaji;
use Illuminate\Database\Eloquent\Model;

class GroupKeberangkatan extends Model
{
  protected $table = 'group_keberangkatan';

  protected $guarded = ['id'];

  public function gabungHaji()
  {
    return $this->hasMany(TGabungHaji::class, 'keberangkatan_id');
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id');
  }

  public function daftarHaji()
  {
    return $this->belongsTo(TDaftarHaji::class, 'daftar_haji_id');
  }
}
