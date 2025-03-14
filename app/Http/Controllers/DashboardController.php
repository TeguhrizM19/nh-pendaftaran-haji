<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Charts\UsiaChart;
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

    // Ambil data keberangkatan
    $keberangkatan = GroupKeberangkatan::all();

    // Ambil data usia dari customer
    $customers = Customer::select('tgl_lahir')->get();

    // Inisialisasi rentang usia
    $usiaCounts = [
      '<= 20' => 0,
      '21-25' => 0,
      '26-30' => 0,
      '31-35' => 0,
      '36-40' => 0,
      '41-45' => 0,
      '46-50' => 0,
      '51-60' => 0,
      '61-65' => 0,
      '66-70' => 0,
      '>= 70' => 0,
    ];

    // Hitung usia berdasarkan tanggal lahir
    foreach ($customers as $customer) {
      $usia = Carbon::parse($customer->tgl_lahir)->age;

      if ($usia <= 20) $usiaCounts['<= 20']++;
      elseif ($usia <= 25) $usiaCounts['21-25']++;
      elseif ($usia <= 30) $usiaCounts['26-30']++;
      elseif ($usia <= 35) $usiaCounts['31-35']++;
      elseif ($usia <= 40) $usiaCounts['36-40']++;
      elseif ($usia <= 45) $usiaCounts['41-45']++;
      elseif ($usia <= 50) $usiaCounts['46-50']++;
      elseif ($usia <= 60) $usiaCounts['51-60']++;
      elseif ($usia <= 65) $usiaCounts['61-65']++;
      elseif ($usia <= 70) $usiaCounts['66-70']++;
      else $usiaCounts['>= 70']++;
    }

    // Inisialisasi chart
    $usiaChart = new UsiaChart();
    $chart = $usiaChart->build($usiaCounts);

    // Return view dengan data keberangkatan dan chart usia
    return view('dashboard', compact('keberangkatan', 'chart'));
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
