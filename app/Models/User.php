<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\MCabang;
use App\Models\Pembayaran;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  // protected $fillable = [
  //     'name',
  //     'email',
  //     'password',
  // ];

  protected $guarded = ['id'];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function cabang()
  {
    return $this->belongsTo(MCabang::class, 'cabang_id'); // asumsi FK-nya adalah 'cabang_id'
  }

  public function pembayaran()
  {
    return $this->hasMany(Pembayaran::class, 'cabang_id', 'cabang_id');
  }
}
