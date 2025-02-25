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
      'customer.kotaLahir',
      'customer.provinsi',
      'customer.kota',
      'customer.kecamatan',
      'customer.kelurahan',
      'wilayahKota',
      'sumberInfo'
    ])->findOrFail($id);

    // ====================== Alamat KTP ======================
    $alamatKtp = json_decode($daftar->customer->alamat_ktp, true) ?? [];
    $provinsi = optional(Provinsi::find($alamatKtp['provinsi_id']))->provinsi ?? '-';
    $kota = optional(Kota::find($alamatKtp['kota_id']))->kota ?? '-';
    $kecamatan = optional(Kecamatan::find($alamatKtp['kecamatan_id']))->kecamatan ?? '-';
    $kelurahan = optional(Kelurahan::find($alamatKtp['kelurahan_id']))->kelurahan ?? '-';

    // ====================== Alamat Domisili ======================
    $alamatDomisili = json_decode($daftar->customer->alamat_domisili, true) ?? [];
    $provinsiDomisili = optional(Provinsi::find($alamatDomisili['provinsi_id']))->provinsi ?? '-';
    $kotaDomisili = optional(Kota::find($alamatDomisili['kota_id']))->kota ?? '-';
    $kecamatanDomisili = optional(Kecamatan::find($alamatDomisili['kecamatan_id']))->kecamatan ?? '-';
    $kelurahanDomisili = optional(Kelurahan::find($alamatDomisili['kelurahan_id']))->kelurahan ?? '-';
    $kodePosDomisili = optional(Kelurahan::find($alamatDomisili['kelurahan_id']))->kode_pos ?? '-';

    // ====================== Dokumen ======================
    $dokumenIds = json_decode($daftar->dokumen, true) ?? []; // Ambil JSON ID dokumen
    $dokumen = MDokHaji::whereIn('id', $dokumenIds)->get(['id', 'dokumen']); // Ambil nama dokumen

    // Kirim semua data ke view PDF
    $pdf = Pdf::loadView('pdf.daftar_haji', [
      'daftar' => $daftar,

      // Data Alamat KTP
      'alamat_ktp' => $alamatKtp,
      'provinsi' => $provinsi,
      'kota' => $kota,
      'kecamatan' => $kecamatan,
      'kelurahan' => $kelurahan,

      // Data Alamat Domisili
      'alamat_domisili' => $alamatDomisili,
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
