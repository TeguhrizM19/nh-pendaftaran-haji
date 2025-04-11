<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kota;
use App\Models\User;
use App\Models\MCabang;
use App\Models\MDokHaji;
use App\Models\Pembayaran;
use App\Models\TDaftarHaji;
use App\Models\TGabungHaji;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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

  private function terbilang($angka)
  {
    $angka = abs($angka);
    $baca = ["", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS"];
    $hasil = "";

    if ($angka < 12) {
      $hasil = " " . $baca[$angka];
    } elseif ($angka < 20) {
      $hasil = $this->terbilang($angka - 10) . " BELAS";
    } elseif ($angka < 100) {
      $hasil = $this->terbilang(floor($angka / 10)) . " PULUH" . $this->terbilang($angka % 10);
    } elseif ($angka < 200) {
      $hasil = " SERATUS" . $this->terbilang($angka - 100);
    } elseif ($angka < 1000) {
      $hasil = $this->terbilang(floor($angka / 100)) . " RATUS" . $this->terbilang($angka % 100);
    } elseif ($angka < 2000) {
      $hasil = " SERIBU" . $this->terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
      $hasil = $this->terbilang(floor($angka / 1000)) . " RIBU" . $this->terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
      $hasil = $this->terbilang(floor($angka / 1000000)) . " JUTA" . $this->terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
      $hasil = $this->terbilang(floor($angka / 1000000000)) . " MILYAR" . $this->terbilang($angka % 1000000000);
    }

    return trim($hasil);
  }

  public function cetakPembayaran($id)
  {
    $pembayaran = Pembayaran::findOrFail($id);
    $semuaPembayaran = Pembayaran::where('gabung_haji_id', $pembayaran->gabung_haji_id)->get();

    $pembayaranList = collect([$pembayaran]);
    $totalOperasional = $pembayaranList->sum('operasional');
    $totalManasik = $pembayaranList->sum('manasik');
    $totalDam = $pembayaranList->sum('dam');
    $totalKeseluruhan = $totalOperasional + $totalManasik + $totalDam;

    $gabungHaji = TGabungHaji::with(['customer', 'daftarHaji', 'keberangkatan'])->find($pembayaran->gabung_haji_id);
    $user = User::where('name', $pembayaran->create_user)->first();
    $cabang = MCabang::where('id', $user->cabang_id)->first();

    // ✅ Ambil total biaya dari keberangkatan
    $biayaOperasional = $gabungHaji->keberangkatan->operasional ?? 0;
    $biayaManasik = $gabungHaji->keberangkatan->manasik ?? 0;
    $biayaDam = $gabungHaji->keberangkatan->dam ?? 0;
    $totalBiayaResmi = $biayaOperasional + $biayaManasik + $biayaDam;

    // Total yang sudah dibayarkan sejauh ini
    $totalSudahBayar = Pembayaran::where('gabung_haji_id', $pembayaran->gabung_haji_id)
      ->sum(DB::raw('operasional + manasik + dam'));

    // Hitung kekurangannya
    $totalKekurangan = $totalBiayaResmi - $totalSudahBayar;

    // Hitung kekurangan dan kelebihan
    $totalKekurangan = max($totalBiayaResmi - $totalSudahBayar, 0);
    $totalLebih = max($totalSudahBayar - $totalBiayaResmi, 0);

    $pdf = Pdf::loadView('pdf.pembayaran', [
      'pembayaranList' => $pembayaranList,
      'pembayaran' => $pembayaran,
      'semuaPembayaran' => $semuaPembayaran,
      'gabungHaji' => $gabungHaji,
      'cabang' => $cabang,
      'metodeList' => [
        '1-111001' => 'Tunai',
        '1-113001' => 'CIMB NIAGA - 860055550500',
        '1-113002' => 'BSI (BSM) - 7119135456',
      ],
      'totalOperasional' => $totalOperasional,
      'totalManasik' => $totalManasik,
      'totalDam' => $totalDam,
      'totalKeseluruhan' => $totalKeseluruhan,
      'terbilangOperasional' => $this->terbilang($totalOperasional),
      'terbilangManasik' => $this->terbilang($totalManasik),
      'terbilangDam' => $this->terbilang($totalDam),
      'terbilangTotal' => $this->terbilang($totalKeseluruhan),

      // ✅ kirim juga total biaya keseluruhan (resmi) dari keberangkatan
      'totalBiayaResmi' => $totalBiayaResmi,
      'totalKekurangan' => $totalKekurangan,
      'totalLebih' => $totalLebih,
    ]);

    return $pdf->stream('pembayaran.pdf');
  }
}
