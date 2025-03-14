<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TDaftarHaji;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use App\Models\GroupKeberangkatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
  public function index()
  {
    return view('dashboard', [
      'keberangkatan'        => GroupKeberangkatan::all(),
    ]);
  }

  public function filterKeberangkatan(Request $request)
  {
    $tahun_id = $request->tahun_id;

    if (!$tahun_id) {
      return response()->json([
        'total' => 0,
        'laki' => 0,
        'perempuan' => 0,
        'pelunasanHaji' => 0,
        'belumLunasHaji' => 0,
        'pelunasanManasik' => 0,
        'belumLunasManasik' => 0 // Tambahan untuk belum lunas manasik
      ]);
    }

    // Total seluruh jama'ah berdasarkan tahun keberangkatan
    $totalJamaah = TGabungHaji::where('keberangkatan_id', $tahun_id)->count();

    // Jama'ah Laki-Laki
    $jumlahLaki = TGabungHaji::where('keberangkatan_id', $tahun_id)
      ->whereHas('customer', function ($query) {
        $query->where('jenis_kelamin', 'Laki-laki');
      })
      ->count();

    // Jama'ah Perempuan
    $jumlahPerempuan = TGabungHaji::where('keberangkatan_id', $tahun_id)
      ->whereHas('customer', function ($query) {
        $query->where('jenis_kelamin', 'Perempuan');
      })
      ->count();

    // Menghitung jumlah customer yang sudah melunasi haji
    $pelunasanHaji = DB::table('t_gabung_hajis')
      ->select('customer_id')
      ->where('keberangkatan_id', $tahun_id)
      ->where('pelunasan', 'Lunas')
      ->union(
        DB::table('t_daftar_hajis')
          ->select('customer_id')
          ->where('keberangkatan_id', $tahun_id)
          ->where('pelunasan', 'Lunas')
      )
      ->groupBy('customer_id')
      ->get()
      ->count();

    // Menghitung jumlah total customer berdasarkan tahun keberangkatan
    $totalCustomer = DB::table('t_gabung_hajis')
      ->select('customer_id')
      ->where('keberangkatan_id', $tahun_id)
      ->union(
        DB::table('t_daftar_hajis')
          ->select('customer_id')
          ->where('keberangkatan_id', $tahun_id)
      )
      ->groupBy('customer_id')
      ->get()
      ->count();

    // Jumlah yang belum lunas haji = total customer - yang sudah lunas
    $belumLunasHaji = $totalCustomer - $pelunasanHaji;

    // Menghitung jumlah customer yang sudah melunasi manasik
    $pelunasanManasik = DB::table('t_gabung_hajis')
      ->select('customer_id')
      ->where('keberangkatan_id', $tahun_id)
      ->where('pelunasan_manasik', 'Lunas')
      ->union(
        DB::table('t_daftar_hajis')
          ->select('customer_id')
          ->where('keberangkatan_id', $tahun_id)
          ->where('pelunasan_manasik', 'Lunas')
      )
      ->groupBy('customer_id')
      ->get()
      ->count();

    // Jumlah yang belum lunas manasik = total customer - yang sudah lunas manasik
    $belumLunasManasik = $totalCustomer - $pelunasanManasik;

    return response()->json([
      'total' => $totalJamaah,
      'laki' => $jumlahLaki,
      'perempuan' => $jumlahPerempuan,
      'pelunasanHaji' => $pelunasanHaji,
      'belumLunasHaji' => $belumLunasHaji,
      'pelunasanManasik' => $pelunasanManasik,
      'belumLunasManasik' => $belumLunasManasik // Data belum lunas manasik
    ]);
  }
}
