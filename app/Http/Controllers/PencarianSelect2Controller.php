<?php

namespace App\Http\Controllers;

use App\Models\GroupKeberangkatan;
use App\Models\Kota;
use App\Models\MCabang;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\TDaftarHaji;
use Illuminate\Http\Request;

class PencarianSelect2Controller extends Controller
{
  public function searchCabang(Request $request)
  {
    $query = $request->q;

    // Cari cabang yang namanya mengandung teks yang diketik
    $cabang = MCabang::where('cabang', 'LIKE', "%$query%")
      ->select('id', 'cabang')
      ->get();

    return response()->json($cabang);
  }

  public function searchWilayah(Request $request)
  {
    $query = $request->q;

    // Cari wilayah (kota) yang namanya mengandung teks yang diketik
    $wilayah = Kota::where('kota', 'LIKE', "%$query%")
      ->select('id', 'kota')
      ->get();

    return response()->json($wilayah);
  }

  public function searchTempatLhr(Request $request)
  {
    $search = $request->q;

    $data = Kota::select('id', 'kota')
      ->where('kota', 'like', "%{$search}%")
      ->get();

    return response()->json($data);
  }

  public function searchDepag(Request $request)
  {
    $search = $request->q;

    $data = Kota::select('id', 'kota')
      ->where('kota', 'like', "%{$search}%")
      ->get();

    return response()->json($data);
  }

  public function searchKeberangkatan(Request $request)
  {
    $search = $request->q;

    $data = GroupKeberangkatan::select('id', 'keberangkatan')
      ->where('keberangkatan', 'like', "%{$search}%")
      ->get();

    return response()->json($data);
  }

  public function searchProvinsi(Request $request)
  {
    $search = $request->input('q');

    $provinsi = Provinsi::where('provinsi', 'LIKE', "%$search%")
      ->select('id', 'provinsi')
      ->get();

    return response()->json($provinsi);
  }

  public function searchKota(Request $request, $provinsi_id)
  {
    $search = $request->input('q');

    $kota = Kota::where('provinsi_id', $provinsi_id) // Pastikan ini benar
      ->where('kota', 'LIKE', "%$search%")
      ->select('id', 'kota')
      ->get();

    return response()->json($kota);
  }

  public function searchKecamatan(Request $request, $kota_id)
  {
    $search = $request->input('q'); // Ambil keyword pencarian

    $kecamatan = Kecamatan::where('kota_id', $kota_id)
      ->where('kecamatan', 'LIKE', "%$search%") // Bisa mencari kecamatan juga
      ->select('id', 'kecamatan')
      ->get();

    return response()->json($kecamatan);
  }

  public function searchKelurahan(Request $request, $kecamatan_id)
  {
    $search = $request->input('q'); // Ambil keyword pencarian

    $kelurahan = Kelurahan::where('kecamatan_id', $kecamatan_id)
      ->where('kelurahan', 'LIKE', "%$search%")
      ->select('id', 'kelurahan')
      ->get();

    return response()->json($kelurahan);
  }

  public function searchKotaBank(Request $request)
  {
    $query = $request->q;

    // Cari wilayah (kota) yang namanya mengandung teks yang diketik
    $wilayah = Kota::where('kota', 'LIKE', "%$query%")
      ->select('id', 'kota')
      ->get();

    return response()->json($wilayah);
  }

  public function searchNoPorsi(Request $request)
  {
    $query = $request->q;

    // Cari berdasarkan no_porsi_haji
    $noPorsi = TDaftarHaji::where('no_porsi_haji', 'LIKE', "%$query%")
      ->select('id', 'no_porsi_haji')
      ->get();

    return response()->json($noPorsi);
  }
}
