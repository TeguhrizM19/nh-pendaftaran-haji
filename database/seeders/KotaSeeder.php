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

    $data = DB::table('m_kota')->where('id_kota', '!=', 0)->get();

    foreach ($data as $item) {
      DB::table('m_kotas')->insert([
        'id' => $item->id_kota,
        'provinsi_id' => $item->id_prov, // Asumsikan ada kolom ini
        'kota' => $item->kota,
      ]);
    }
  }
}
