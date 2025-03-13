<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\GroupKeberangkatan;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    return view('dashboard', [
      'semua_customer' => Customer::count(),
      'customer_laki' => Customer::where('jenis_kelamin', 'Laki-laki')->count(),
      'customer_perempuan' => Customer::where('jenis_kelamin', 'Perempuan')->count(),
      'keberangkatan' => GroupKeberangkatan::all(),
    ]);
  }

  // Tambahkan fungsi untuk menangani filter berdasarkan tahun keberangkatan
  public function filterKeberangkatan(Request $request)
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
}
