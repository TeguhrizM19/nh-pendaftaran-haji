<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel baru sebelum memasukkan data
        DB::table('m_provinsis')->truncate();

        // Ambil semua data dari tabel lama
        $data = DB::table('m_provinsi')->where('id_prov', '!=', 0)->get(); // Hindari ID 0

        foreach ($data as $item) {
            DB::table('m_provinsis')->insert([
                'id' => $item->id_prov,  // Gunakan id_prov sebagai id
                'provinsi' => $item->provinsi,
            ]);
        }
    }
}
