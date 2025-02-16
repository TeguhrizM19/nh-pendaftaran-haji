<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\TDaftarHaji;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MSumberInfo extends Model
{
  /** @use HasFactory<\Database\Factories\MSumberInfoFactory> */
  use HasFactory;

  protected $table = 'm_sumber_infos';
  protected $guarded = ['id'];

  public function customer()
  {
    return $this->hasMany(Customer::class, 'sumber_info_id');
  }

  public function daftarHaji()
  {
    return $this->hasMany(TDaftarHaji::class, 'sumber_info_id');
  }
}
