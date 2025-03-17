<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use App\Models\GroupKeberangkatan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    return view('dashboard', [
      'keberangkatan' => GroupKeberangkatan::all(),
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
        'belumLunasManasik' => 0,
        'ageRanges' => [
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
        ],
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

    // Hitung Rentang Usia
    $ageRanges = [
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

    $customers = Customer::whereHas('gabungHaji', function ($query) use ($tahun_id) {
      $query->where('keberangkatan_id', $tahun_id);
    })->get();

    foreach ($customers as $customer) {
      $birthDate = Carbon::parse($customer->tgl_lahir);
      $age = $birthDate->diffInYears(Carbon::now());

      if ($age <= 20) {
        $ageRanges['<= 20']++;
      } elseif ($age >= 21 && $age <= 25) {
        $ageRanges['21-25']++;
      } elseif ($age >= 26 && $age <= 30) {
        $ageRanges['26-30']++;
      } elseif ($age >= 31 && $age <= 35) {
        $ageRanges['31-35']++;
      } elseif ($age >= 36 && $age <= 40) {
        $ageRanges['36-40']++;
      } elseif ($age >= 41 && $age <= 45) {
        $ageRanges['41-45']++;
      } elseif ($age >= 46 && $age <= 50) {
        $ageRanges['46-50']++;
      } elseif ($age >= 51 && $age <= 60) {
        $ageRanges['51-60']++;
      } elseif ($age >= 61 && $age <= 65) {
        $ageRanges['61-65']++;
      } elseif ($age >= 66 && $age <= 70) {
        $ageRanges['66-70']++;
      } else {
        $ageRanges['>= 70']++;
      }
    }

    return response()->json([
      'total' => $totalJamaah,
      'laki' => $jumlahLaki,
      'perempuan' => $jumlahPerempuan,
      'pelunasanHaji' => $pelunasanHaji,
      'belumLunasHaji' => $belumLunasHaji,
      'pelunasanManasik' => $pelunasanManasik,
      'belumLunasManasik' => $belumLunasManasik,
      'ageRanges' => $ageRanges,
    ]);
  }
}
