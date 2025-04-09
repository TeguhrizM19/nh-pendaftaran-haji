<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Pembayaran;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePembayaranRequest;

class PembayaranController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index($id)
  {
    // 1. Ambil data gabungan haji berdasarkan ID
    $gabungHaji = TGabungHaji::with(['customer', 'daftarHaji', 'keberangkatan'])->find($id);

    // 2. Ambil semua pembayaran untuk gabung_haji_id tersebut
    $pembayaran = Pembayaran::where('gabung_haji_id', $id)->get();

    // 3. Ambil nilai biaya dari keberangkatan
    $biayaManasik = $gabungHaji->keberangkatan->manasik ?? 0;
    $biayaOperasional = $gabungHaji->keberangkatan->operasional ?? 0;
    $biayaDam = $gabungHaji->keberangkatan->dam ?? 0;

    $totalBiaya = $biayaManasik + $biayaOperasional + $biayaDam;

    // 4. Hitung total yang sudah dibayar berdasarkan masing-masing kolom
    $totalDibayarManasik = $pembayaran->sum('manasik');
    $totalDibayarOperasional = $pembayaran->sum('operasional');
    $totalDibayarDam = $pembayaran->sum('dam');

    $totalDibayar = $totalDibayarManasik + $totalDibayarOperasional + $totalDibayarDam;

    // 5. Hitung kekurangan atau kelebihan
    $kurangManasik = max(0, $biayaManasik - $totalDibayarManasik);
    $kurangOperasional = max(0, $biayaOperasional - $totalDibayarOperasional);
    $kurangDam = max(0, $biayaDam - $totalDibayarDam);

    $lebihManasik = max(0, $totalDibayarManasik - $biayaManasik);
    $lebihOperasional = max(0, $totalDibayarOperasional - $biayaOperasional);
    $lebihDam = max(0, $totalDibayarDam - $biayaDam);

    $totalKekurangan = $kurangManasik + $kurangOperasional + $kurangDam;
    $totalLebih = $lebihManasik + $lebihOperasional + $lebihDam;

    // 6. Set ke null jika tidak ada pembayaran & biaya
    if ($totalBiaya == 0 && $totalDibayar == 0) {
      $totalKekurangan = null;
      $totalLebih = null;
    }

    // 7. Metode Pembayaran
    $metodeList = [
      '1-111001' => 'Tunai',
      '1-113001' => 'CIMB NIAGA - 860055550500',
      '1-113002' => 'BSI (BSM) - 7119135456',
    ];

    // 8. Kirim ke view
    return view('pembayaran.index', compact(
      'gabungHaji',
      'totalBiaya',
      'pembayaran',
      'totalDibayar',
      'totalDibayarManasik',
      'totalDibayarOperasional',
      'totalDibayarDam',
      'kurangManasik',
      'kurangOperasional',
      'kurangDam',
      'totalKekurangan',
      'lebihManasik',
      'lebihOperasional',
      'lebihDam',
      'totalLebih',
      'metodeList'
    ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request, $id)
  {
    $gabungHaji = TGabungHaji::with(['keberangkatan', 'daftarHaji.cabang', 'pembayaran'])->findOrFail($id);
    $user = Auth::user()->name;

    $keberangkatanId = $gabungHaji->keberangkatan->id ?? null;
    $keberangkatan = $gabungHaji->keberangkatan->keberangkatan ?? 'Tanpa Tahun';
    $cabangId = Auth::user()->cabang_id ?? null;
    $daftarHajiId = $gabungHaji->daftarHaji->id ?? null;

    $validated = $request->validate([
      'tgl_bayar' => 'required|date',
      'metode_bayar' => 'required|string',
      'pilihan_biaya' => 'nullable|array',
      'pilihan_biaya.*' => 'nullable|string',
      'jenis_biaya' => 'nullable|array',
      'jenis_biaya.*' => 'nullable|string',
      'nominal' => 'nullable|array',
      'nominal.*' => 'nullable|string',
      'keterangan' => 'nullable|string',
    ]);

    $prefix = date('ym', strtotime($request->tgl_bayar));

    $biayaMapping = [
      "4-000001" => "Operasional",
      "4-000002" => "Manasik",
      "4-000003" => "DAM",
    ];

    function getNewKwitansi($prefix)
    {
      $lastKwitansi = Pembayaran::where('kwitansi', 'LIKE', "{$prefix}%")->max('kwitansi');
      $lastNumber = $lastKwitansi ? (int) substr($lastKwitansi, -3) : 0;
      $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
      return $prefix . $newNumber;
    }

    // Ambil inputan
    $inputBiaya = $request->pilihan_biaya;
    $inputJenis = $request->jenis_biaya;
    $inputNominal = $request->nominal;

    // Default kosong
    $operasional = 0;
    $manasik = 0;
    $dam = 0;
    $pilihan_biaya_operasional = null;
    $pilihan_biaya_manasik = null;
    $pilihan_biaya_dam = null;

    foreach ($inputBiaya as $index => $biayaValue) {
      $biayaText = $biayaMapping[$biayaValue] ?? "Biaya Tidak Diketahui";
      $nominalBersih = (int) str_replace('.', '', $inputNominal[$index]);

      if ($biayaText === 'Operasional') {
        $operasional = $nominalBersih;
        $pilihan_biaya_operasional = $biayaValue;
      } elseif ($biayaText === 'Manasik') {
        $manasik = $nominalBersih;
        $pilihan_biaya_manasik = $biayaValue;
      } elseif ($biayaText === 'DAM') {
        $dam = $nominalBersih;
        $pilihan_biaya_dam = $biayaValue;
      }
    }

    // Hitung total nominal
    $totalNominal = $operasional + $manasik + $dam;

    if ($operasional || $manasik || $dam) {
      Pembayaran::create([
        'gabung_haji_id' => $gabungHaji->id,
        'daftar_haji_id' => $daftarHajiId,
        'keberangkatan_id' => $keberangkatanId,
        'tgl_bayar' => $request->tgl_bayar,
        'metode_bayar' => $request->metode_bayar,
        'pilihan_biaya_operasional' => $pilihan_biaya_operasional,
        'pilihan_biaya_manasik' => $pilihan_biaya_manasik,
        'pilihan_biaya_dam' => $pilihan_biaya_dam,
        'operasional' => $operasional,
        'manasik' => $manasik,
        'dam' => $dam,
        'nominal' => $totalNominal, // <- ini penambahan kolom nominal
        'keberangkatan' => $keberangkatan,
        'kwitansi' => getNewKwitansi($prefix),
        'cabang_id' => $cabangId,
        'keterangan' => "DP Jamaah {$keberangkatan} {$request->keterangan}",
        'create_user' => $user,
      ]);
    }

    return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Pembayaran $pembayaran)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Pembayaran $pembayaran)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  // public function update(Request $request, $id)
  // {
  //   // Bersihkan format rupiah sebelum validasi
  //   $request->merge([
  //     'nominal' => str_replace(['Rp.', '.', ','], '', $request->nominal)
  //   ]);

  //   $pembayaran = Pembayaran::findOrFail($id);
  //   $gabungHaji = TGabungHaji::with(['keberangkatan', 'daftarHaji.cabang', 'pembayaran'])->findOrFail($pembayaran->gabung_haji_id);
  //   $user = Auth::user()->name;

  //   $keberangkatanId = $gabungHaji->keberangkatan->id ?? null;
  //   $keberangkatan = $gabungHaji->keberangkatan->keberangkatan ?? 'Tanpa Tahun';
  //   $cabangId = Auth::user()->cabang_id ?? null;

  //   $request->validate([
  //     'tgl_bayar' => 'required|date',
  //     'metode_bayar' => 'required|string',
  //     'nominal' => 'required|numeric',
  //     'keterangan' => 'nullable|string',
  //     'pilihan_biaya' => 'nullable|string',
  //   ]);

  //   // Mapping biaya
  //   $biayaMapping = [
  //     "4-000001" => "Operasional",
  //     "4-000002" => "Manasik",
  //     "4-000003" => "DAM",
  //   ];

  //   $biayaValue = $request->pilihan_biaya ?? $pembayaran->pilihan_biaya;
  //   $biayaText = $biayaMapping[$biayaValue] ?? "Biaya Tidak Diketahui";

  //   $pembayaran->update([
  //     'tgl_bayar' => $request->tgl_bayar,
  //     'metode_bayar' => $request->metode_bayar,
  //     'nominal' => $request->nominal, // Sudah dibersihkan
  //     'keberangkatan' => $keberangkatan,
  //     'keberangkatan_id' => $keberangkatanId,
  //     'cabang_id' => $cabangId,
  //     'pilihan_biaya' => $biayaValue,
  //     'keterangan' => "{$request->keterangan}",
  //     'update_user' => $user,
  //   ]);

  //   // Hitung ulang pelunasan
  //   $pembayaranTerbaru = Pembayaran::where('gabung_haji_id', $gabungHaji->id)->get();
  //   $totalDibayar = $pembayaranTerbaru->sum('nominal');

  //   $biayaOperasional = $gabungHaji->keberangkatan->operasional ?? 0;
  //   $biayaManasik     = $gabungHaji->keberangkatan->manasik ?? 0;
  //   $biayaDam         = $gabungHaji->keberangkatan->dam ?? 0;
  //   $totalBiaya       = $biayaOperasional + $biayaManasik + $biayaDam;

  //   $statusPelunasan = null;
  //   if (round($totalDibayar, 2) >= round($totalBiaya, 2)) {
  //     $statusPelunasan = 'LUNAS';
  //   } elseif ($totalDibayar > 0) {
  //     $statusPelunasan = 'Belum Lunas';
  //   }

  //   $gabungHaji->update([
  //     'pelunasan' => $statusPelunasan,
  //     'update_user' => $user,
  //   ]);

  //   return redirect()->back()->with('success', 'Pembayaran berhasil diperbarui!');
  // }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $pembayaran = Pembayaran::findOrFail($id);
    // $gabungHajiId = $pembayaran->gabung_haji_id;
    // $user = Auth::user()->name;

    // Hapus pembayaran
    $pembayaran->delete();

    // Ambil ulang data pembayaran sisa
    // $gabungHaji = TGabungHaji::with('keberangkatan')->find($gabungHajiId);
    // $pembayaranSisa = Pembayaran::where('gabung_haji_id', $gabungHajiId)->get();

    // $totalDibayar = $pembayaranSisa->sum('nominal');

    // // Hitung ulang total biaya
    // $biayaOperasional = $gabungHaji->keberangkatan->operasional ?? 0;
    // $biayaManasik     = $gabungHaji->keberangkatan->manasik ?? 0;
    // $biayaDam         = $gabungHaji->keberangkatan->dam ?? 0;
    // $totalBiaya       = $biayaOperasional + $biayaManasik + $biayaDam;

    // // Update status pelunasan
    // if (round($totalDibayar, 2) >= round($totalBiaya, 2)) {
    //   $statusPelunasan = 'LUNAS';
    // } elseif ($totalDibayar > 0) {
    //   $statusPelunasan = 'Belum Lunas';
    // } else {
    //   $statusPelunasan = null;
    // }

    // // Simpan kembali ke tabel
    // $gabungHaji->update([
    //   'pelunasan' => $statusPelunasan,
    //   'update_user' => $user,
    // ]);

    return redirect()->back()->with('success', 'Pembayaran berhasil dihapus!');
  }
}
