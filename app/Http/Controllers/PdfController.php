<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\MDokHaji;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\TDaftarHaji;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
  public function cetakPendaftaran($id)
  {
    $daftar = TDaftarHaji::with([
      'customer.provinsiKtp',
      'customer.kotaKtp',
      'customer.kecamatanKtp',
      'customer.kelurahanKtp',
      'customer.provinsiDomisili',
      'customer.kotaDomisili',
      'customer.kecamatanDomisili',
      'customer.kelurahanDomisili',
      'wilayahDaftar',
      'sumberInfo'
    ])->findOrFail($id);

    // ====================== Dokumen ======================
    $dokumenIds = is_array($daftar->dokumen) ? $daftar->dokumen : json_decode($daftar->dokumen, true) ?? [];
    $dokumen = MDokHaji::whereIn('id', $dokumenIds)->get(['id', 'dokumen']);

    // Kirim semua data ke view PDF
    $pdf = Pdf::loadView('pdf.daftar_haji', [
      'daftar' => $daftar,
      'dokumen' => $dokumen,
    ]);

    return $pdf->stream('pendaftaran-haji.pdf'); // Bisa juga pakai ->download()
  }

  public function cetakGabung($id)
  {
    $gabung = TGabungHaji::with([
      'depag',
      'customer.provinsiKtp',
      'customer.kotaKtp',
      'customer.kecamatanKtp',
      'customer.kelurahanKtp',
      'customer.provinsiDomisili',
      'customer.kotaDomisili',
      'customer.kecamatanDomisili',
      'customer.kelurahanDomisili',
      // 'wilayahDaftar',
      // 'sumberInfo'
    ])->findOrFail($id);
    // dd($gabung->kotaBank);


    // ====================== Dokumen ======================
    // $dokumenIds = is_array($daftar->dokumen) ? $daftar->dokumen : json_decode($daftar->dokumen, true) ?? [];
    // $dokumen = MDokHaji::whereIn('id', $dokumenIds)->get(['id', 'dokumen']);

    // Kirim semua data ke view PDF
    $pdf = Pdf::loadView('pdf.gabung_haji', [
      'gabung' => $gabung,
      // 'dokumen' => $dokumen,
    ]);

    return $pdf->stream('gabung-haji.pdf'); // Bisa juga pakai ->download()
  }
}
