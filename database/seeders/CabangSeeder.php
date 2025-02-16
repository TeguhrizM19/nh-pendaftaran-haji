<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_cabangs')->insertUsing(
            ['cabang', 'kode_cab', 'alamat', 'created_at', 'updated_at'],
            DB::table('m_cabang')->select('cabang', 'kode_cab', 'alamat', DB::raw('NOW() as created_at, NOW() as updated_at'))
        );
    }
}
