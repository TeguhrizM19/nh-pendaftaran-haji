<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use App\Models\GroupKeberangkatan;

class DashboardController extends Controller
{
  public function index()
  {
    // Hitung jumlah transaksi yang sudah melunasi haji
    $sudahMelunasiHaji = TGabungHaji::where('pelunasan', 'Lunas')
      ->orWhereHas('daftarHaji', function ($q) {
        $q->where('pelunasan', 'Lunas');
      })
      ->count(); // TANPA DISTINCT

    // Hitung jumlah transaksi yang sudah melunasi manasik
    $sudahMelunasiManasik = TGabungHaji::where('pelunasan_manasik', 'Lunas')
      ->orWhereHas('daftarHaji', function ($q) {
        $q->where('pelunasan_manasik', 'Lunas');
      })
      ->count(); // TANPA DISTINCT

    // Hitung jumlah transaksi yang belum melunasi haji
    $belumLunasHaji = TGabungHaji::whereNull('pelunasan')
      ->orWhere('pelunasan', '!=', 'Lunas')
      ->count(); // TANPA DISTINCT

    // Hitung jumlah transaksi yang belum melunasi manasik
    $belumLunasManasik = TGabungHaji::whereNull('pelunasan_manasik')
      ->orWhere('pelunasan_manasik', '!=', 'Lunas')
      ->count(); // TANPA DISTINCT

    // Ambil semua ID customer yang belum melunasi haji (dengan duplikasi)
    $idBelumLunasHaji = TGabungHaji::whereNull('pelunasan')
      ->orWhere('pelunasan', '!=', 'Lunas')
      ->pluck('customer_id')
      ->toArray(); // TANPA DISTINCT

    // Ambil semua ID customer yang belum melunasi manasik (dengan duplikasi)
    $idBelumLunasManasik = TGabungHaji::whereNull('pelunasan_manasik')
      ->orWhere('pelunasan_manasik', '!=', 'Lunas')
      ->pluck('customer_id')
      ->toArray(); // TANPA DISTINCT

    // Log hasil untuk debugging
    Log::info('Total Customer: ' . Customer::count());
    Log::info('Sudah Melunasi Haji: ' . $sudahMelunasiHaji);
    Log::info('Sudah Melunasi Manasik: ' . $sudahMelunasiManasik);
    Log::info('Belum Melunasi Haji: ' . $belumLunasHaji);
    Log::info('Belum Melunasi Manasik: ' . $belumLunasManasik);
    Log::info('ID Customer Belum Melunasi Haji: ', $idBelumLunasHaji);
    Log::info('ID Customer Belum Melunasi Manasik: ', $idBelumLunasManasik);

    return view('dashboard', [
      'keberangkatan'        => GroupKeberangkatan::all(),
      'pelunasanHaji'        => $sudahMelunasiHaji,
      'pelunasanManasik'     => $sudahMelunasiManasik,
      'belumMelunasiHaji'    => $belumLunasHaji,
      'belumMelunasiManasik' => $belumLunasManasik,
    ]);
  }








  // Tambahkan fungsi untuk menangani filter berdasarkan tahun keberangkatan
  public function filterKeberangkatan_(Request $request)
  {
    $tahun_id = $request->tahun_id;

    // Hitung jumlah jama'ah berdasarkan tahun keberangkatan
    $jumlah_jamaah = TGabungHaji::where('keberangkatan_id', $tahun_id)->count();

    return response()->json(['jumlah' => $jumlah_jamaah]);
  }

  public function filterKeberangkatanLaki(Request $request)
  {
    $tahun_id = $request->tahun_id;

    // Hitung jumlah laki-laki berdasarkan tahun keberangkatan
    $jumlahLaki = TGabungHaji::where('keberangkatan_id', $tahun_id)
      ->whereHas('customer', function ($query) {
        $query->where('jenis_kelamin', 'Laki-laki');
      })
      ->count();

    return response()->json(['jumlah' => $jumlahLaki]);
  }

  public function filterKeberangkatanPerempuan(Request $request)
  {
    $tahun_id = $request->tahun_id;

    // Hitung jumlah laki-laki berdasarkan tahun keberangkatan
    $jumlahPerempuan = TGabungHaji::where('keberangkatan_id', $tahun_id)
      ->whereHas('customer', function ($query) {
        $query->where('jenis_kelamin', 'Perempuan');
      })
      ->count();

    return response()->json(['jumlah' => $jumlahPerempuan]);
  }

  public function filterKeberangkatan(Request $request)
  {
    $tahun_id = $request->tahun_id;

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

    return response()->json([
      'total' => $totalJamaah,
      'laki' => $jumlahLaki,
      'perempuan' => $jumlahPerempuan
    ]);
  }
}
