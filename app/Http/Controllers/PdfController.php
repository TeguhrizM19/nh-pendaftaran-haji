<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\MDokHaji;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\TDaftarHaji;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
  public function cetak($id)
  {
    $daftar = TDaftarHaji::with([
      'customer.tempatLahir',
      'customer.provinsi',
      'customer.kota',
      'customer.kecamatan',
      'customer.kelurahan',
      // 'customer.provinsiDomisili',
      // 'customer.kotaDomisili',
      // 'customer.kecamatanDomisili',
      // 'customer.kelurahanDomisili',
      'wilayahDaftar',
      'sumberInfo'
    ])->findOrFail($id);

    // ====================== Alamat KTP ======================
    $provinsi = optional($daftar->customer->provinsi)->provinsi ?? '-';
    $kota = optional($daftar->customer->kota)->kota ?? '-';
    $kecamatan = optional($daftar->customer->kecamatan)->kecamatan ?? '-';
    $kelurahan = optional($daftar->customer->kelurahan)->kelurahan ?? '-';

    // ====================== Alamat Domisili ======================
    $provinsiDomisili = optional($daftar->customer->provinsiDomisili)->provinsi ?? '-';
    $kotaDomisili = optional($daftar->customer->kotaDomisili)->kota ?? '-';
    $kecamatanDomisili = optional($daftar->customer->kecamatanDomisili)->kecamatan ?? '-';
    $kelurahanDomisili = optional($daftar->customer->kelurahanDomisili)->kelurahan ?? '-';
    $kodePosDomisili = optional($daftar->customer->kelurahanDomisili)->kode_pos ?? '-';

    // ====================== Dokumen ======================
    $dokumenIds = is_array($daftar->dokumen) ? $daftar->dokumen : json_decode($daftar->dokumen, true) ?? [];
    $dokumen = MDokHaji::whereIn('id', $dokumenIds)->get(['id', 'dokumen']);

    // Kirim semua data ke view PDF
    $pdf = Pdf::loadView('pdf.daftar_haji', [
      'daftar' => $daftar,

      // Data Alamat KTP
      'provinsi' => $provinsi,
      'kota' => $kota,
      'kecamatan' => $kecamatan,
      'kelurahan' => $kelurahan,

      // Data Alamat Domisili
      'provinsi_domisili' => $provinsiDomisili,
      'kota_domisili' => $kotaDomisili,
      'kecamatan_domisili' => $kecamatanDomisili,
      'kelurahan_domisili' => $kelurahanDomisili,
      'kode_pos_domisili' => $kodePosDomisili,

      // Data Dokumen
      'dokumen' => $dokumen,
    ]);

    return $pdf->stream('pendaftaran-haji.pdf'); // Bisa juga pakai ->download()
  }
}
