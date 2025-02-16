<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelurahanSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Ambil daftar id kecamatan yang valid
    $validKecamatanIds = DB::table('m_kecamatans')->pluck('id')->toArray();

    // Ambil data dari tabel lama
    $kelurahanLama = DB::table('m_kelurahan')->get();

    foreach ($kelurahanLama as $kel) {
      // Pastikan id_kec ada di m_kecamatans
      if (!in_array($kel->id_kec, $validKecamatanIds)) {
        continue; // Lewati jika id_kec tidak valid
      }

      // Masukkan data ke tabel baru
      DB::table('m_kelurahans')->insert([
        'id' => $kel->id_kel, // Gunakan ID lama
        'kecamatan_id' => $kel->id_kec, // Ubah sesuai kolom baru
        'kelurahan' => $kel->kelurahan,
        'kode_pos' => $kel->kode_pos,
      ]);
    }
  }
}
