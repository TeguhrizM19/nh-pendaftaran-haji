<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KecamatanSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('m_kecamatans')->delete(); // Kosongkan tabel

    $data = DB::table('m_kecamatan')->where('id_kec', '!=', 0)->get(); // Ambil semua kecamatan

    foreach ($data as $item) {
      DB::table('m_kecamatans')->insert([
        'id' => $item->id_kec,
        'kota_id' => $item->id_kota, // Asumsikan ada kolom ini
        'kecamatan' => $item->kecamatan,
      ]);
    }
  }
}
