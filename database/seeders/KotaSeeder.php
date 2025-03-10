<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KotaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('m_kotas')->delete(); // Hapus semua data tanpa menghapus struktur tabel

    $data = DB::table('m_kota')->where('id', '!=', 0)->get();

    foreach ($data as $item) {
      DB::table('m_kotas')->insert([
        'id' => $item->id,
        'provinsi_id' => $item->provinsi_id, // Asumsikan ada kolom ini
        'kota' => $item->kota,
        'kota_lahir' => $item->kota_lahir,
      ]);
    }
  }
}
