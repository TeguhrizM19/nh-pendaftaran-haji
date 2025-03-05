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
    return $this->belongsTo(TGabungHaji::class, 'gabung_haji_id');
  }
}
