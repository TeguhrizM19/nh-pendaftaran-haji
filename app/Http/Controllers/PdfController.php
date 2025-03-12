<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kota;
use App\Models\MDokHaji;
use App\Models\TDaftarHaji;
use App\Models\TGabungHaji;
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
    \Carbon\Carbon::setLocale('id');

    $gabung = TGabungHaji::with([
      'customer.provinsiKtp',
      'customer.kotaKtp',
      'customer.kecamatanKtp',
      'customer.kelurahanKtp',
      'customer.provinsiDomisili',
      'customer.kotaDomisili',
      'customer.kecamatanDomisili',
      'customer.kelurahanDomisili',
    ])->findOrFail($id);

    // ====================== Dokumen ======================
    // $dokumenIds = is_array($daftar->dokumen) ? $daftar->dokumen : json_decode($daftar->dokumen, true) ?? [];
    // $dokumen = MDokHaji::whereIn('id', $dokumenIds)->get(['id', 'dokumen']);

    // Kirim semua data ke view PDF
    $pdf = Pdf::loadView('pdf.gabung_haji', [
      'gabung' => $gabung,
      'depag' => Kota::find($gabung->depag),
      // 'dokumen' => $dokumen,
    ]);

    return $pdf->stream('gabung-haji.pdf'); // Bisa juga pakai ->download()
  }
}
