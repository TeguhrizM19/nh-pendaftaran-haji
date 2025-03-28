<?php

namespace App\Http\Controllers;

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

    // 2. Ambil data pembayaran terkait dengan gabungan haji ini
    $pembayaran = Pembayaran::where('gabung_haji_id', $id)->get();

    // 3. Hitung biaya yang harus dibayar berdasarkan data keberangkatan
    $biayaManasik = $gabungHaji->keberangkatan->manasik ?? 0; // Gunakan 0 jika null
    $biayaOperasional = $gabungHaji->keberangkatan->operasional ?? 0;
    $biayaDam = $gabungHaji->keberangkatan->dam ?? 0;

    $totalBiaya = $biayaManasik + $biayaOperasional + $biayaDam;

    // 4. Hitung total yang sudah dibayar dari tabel pembayaran
    $totalDibayarManasik = $pembayaran->sum('manasik');
    $totalDibayarOperasional = $pembayaran->sum('operasional');
    $totalDibayarDam = $pembayaran->sum('dam');

    $totalDibayar = $totalDibayarManasik + $totalDibayarOperasional + $totalDibayarDam;

    // 5. Hitung kekurangan atau kelebihan pembayaran
    $kurangManasik = max(0, $biayaManasik - $totalDibayarManasik);
    $kurangOperasional = max(0, $biayaOperasional - $totalDibayarOperasional);
    $kurangDam = max(0, $biayaDam - $totalDibayarDam);

    $lebihManasik = max(0, $totalDibayarManasik - $biayaManasik);
    $lebihOperasional = max(0, $totalDibayarOperasional - $biayaOperasional);
    $lebihDam = max(0, $totalDibayarDam - $biayaDam);

    $totalKekurangan = $kurangManasik + $kurangOperasional + $kurangDam;
    $totalLebih = $lebihManasik + $lebihOperasional + $lebihDam;

    // Jika semua data kosong (tidak ada biaya & tidak ada pembayaran), set totalKekurangan dan totalLebih ke null
    if ($totalBiaya == 0 && $totalDibayar == 0) {
      $totalKekurangan = null;
      $totalLebih = null;
    }

    // 6. Kirim data ke view untuk ditampilkan
    return view('pembayaran.index', [
      'gabungHaji' => $gabungHaji,
      'totalBiaya' => $totalBiaya,
      'pembayaran' => $pembayaran,
      'totalDibayar' => $totalDibayar,
      'totalDibayarManasik' => $totalDibayarManasik,
      'totalDibayarOperasional' => $totalDibayarOperasional,
      'totalDibayarDam' => $totalDibayarDam,
      'kurangManasik' => $kurangManasik,
      'kurangOperasional' => $kurangOperasional,
      'kurangDam' => $kurangDam,
      'totalKekurangan' => $totalKekurangan,
      'lebihManasik' => $lebihManasik,
      'lebihOperasional' => $lebihOperasional,
      'lebihDam' => $lebihDam,
      'totalLebih' => $totalLebih
    ]);
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
    $gabungHaji = TGabungHaji::with('keberangkatan', 'daftarHaji.cabang')->findOrFail($id);
    $user = Auth::user()->name;

    // Ambil ID keberangkatan
    $keberangkatanId = $gabungHaji->keberangkatan->id ?? null;
    $keberangkatan = $gabungHaji->keberangkatan->keberangkatan ?? 'Tanpa Tahun';

    // Ambil ID cabang dari user
    $cabangId = Auth::user()->cabang_id ?? null;

    // Ambil ID daftar haji dari relasi gabung haji
    $daftarHajiId = $gabungHaji->daftarHaji->id ?? null;

    // Validasi input
    $validated = $request->validate([
      'tgl_bayar' => 'required|date',
      'metode_bayar' => 'required|string',
      'pilihan_biaya' => 'nullable|array',
      'pilihan_biaya.*' => 'nullable|string',
      'nominal' => 'nullable|array',
      'nominal.*' => 'nullable|numeric',
      'keterangan' => 'nullable|string',
    ]);

    // Ambil tanggal sekarang (format YYMM)
    $prefix = date('y') . date('m'); // Contoh: 2503 (Tahun 2025, Bulan Maret)

    // Mapping value ke teks dari API (bisa juga dari database jika data sudah tersimpan)
    $biayaMapping = [
      "4-000001" => "Operasional",
      "4-000002" => "Manasik",
      "4-000003" => "DAM",
    ];

    // Fungsi untuk mendapatkan nomor kwitansi terbaru
    function getNewKwitansi($prefix)
    {
      $lastKwitansi = Pembayaran::where('kwitansi', 'LIKE', "{$prefix}%")->max('kwitansi');
      $lastNumber = $lastKwitansi ? (int) substr($lastKwitansi, -3) : 0;
      $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
      return $prefix . $newNumber; // Hasil: 2503001, 2503002, dst.
    }

    // Loop untuk menyimpan banyak data sekaligus
    foreach ($request->nominal as $index => $nominal) {
      $biayaValue = $request->pilihan_biaya[$index] ?? null;
      $biayaText = $biayaMapping[$biayaValue] ?? "Biaya Tidak Diketahui";

      Pembayaran::create([
        'gabung_haji_id' => $gabungHaji->id,
        'daftar_haji_id' => $daftarHajiId,
        'keberangkatan_id' => $keberangkatanId,
        'tgl_bayar' => $request->tgl_bayar,
        'metode_bayar' => $request->metode_bayar,
        'pilihan_biaya' => $biayaValue, // Tetap menyimpan value
        'nominal' => $nominal,
        'keberangkatan' => $keberangkatan,
        'kwitansi' => getNewKwitansi($prefix),
        'cabang_id' => $cabangId, // Simpan cabang_id
        'keterangan' => "DP Jamaah {$keberangkatan} {$biayaText} {$request->keterangan}",
        'create_user' => $user,
      ]);
    }

    return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan!');
  }



  // public function store(Request $request, $id)
  // {
  //   $gabungHaji = TGabungHaji::with('keberangkatan', 'daftarHaji.cabang')->findOrFail($id);
  //   $user = Auth::user()->name;

  //   // Ambil tahun keberangkatan jika ada
  //   $keberangkatan = $gabungHaji->keberangkatan->keberangkatan ?? 'Tanpa Tahun';

  //   // Ambil ID cabang
  //   $cabangId = $gabungHaji->daftarHaji->cabang->id ?? null;

  //   // Validasi input
  //   $validated = $request->validate([
  //     'tgl_bayar' => 'required|date',
  //     'metode_bayar' => 'required|string',
  //     'manasik_raw' => 'nullable|numeric',
  //     'operasional_raw' => 'nullable|numeric',
  //     'dam_raw' => 'nullable|numeric',
  //     'kwitansi' => 'nullable|string',
  //     'keterangan' => 'nullable|string',
  //   ]);

  //   DB::transaction(function () use ($validated, $gabungHaji, $user, $keberangkatan, $cabangId) {
  //     // Ambil tanggal sekarang (format YYMM)
  //     $prefix = date('y') . date('m'); // Contoh: 2503 (Tahun 2025, Bulan Maret)

  //     // Fungsi untuk mendapatkan nomor kwitansi terbaru
  //     function getNewKwitansi($prefix)
  //     {
  //       $lastKwitansi = Pembayaran::where('kwitansi', 'LIKE', "{$prefix}%")->max('kwitansi');
  //       $lastNumber = $lastKwitansi ? (int) substr($lastKwitansi, -3) : 0;
  //       $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
  //       return $prefix . $newNumber; // Hasil: 2503001, 2503002, dst.
  //     }

  //     if (!is_null($validated['manasik_raw'])) {
  //       Pembayaran::create([
  //         'gabung_haji_id' => $gabungHaji->id,
  //         'tgl_bayar' => $validated['tgl_bayar'],
  //         'metode_bayar' => $validated['metode_bayar'],
  //         'manasik' => $validated['manasik_raw'],
  //         'operasional' => null,
  //         'dam' => null,
  //         'kwitansi' => getNewKwitansi($prefix),
  //         'keterangan' => "DP Jamaah {$keberangkatan} Manasik " . ($validated['keterangan'] ?? ''),
  //         'create_user' => $user,
  //         'cabang_id' => $cabangId, // Simpan cabang_id
  //       ]);
  //     }

  //     if (!is_null($validated['operasional_raw'])) {
  //       Pembayaran::create([
  //         'gabung_haji_id' => $gabungHaji->id,
  //         'tgl_bayar' => $validated['tgl_bayar'],
  //         'metode_bayar' => $validated['metode_bayar'],
  //         'manasik' => null,
  //         'operasional' => $validated['operasional_raw'],
  //         'dam' => null,
  //         'kwitansi' => getNewKwitansi($prefix),
  //         'keterangan' => "DP Jamaah {$keberangkatan} Operasional " . ($validated['keterangan'] ?? ''),
  //         'create_user' => $user,
  //         'cabang_id' => $cabangId, // Simpan cabang_id
  //       ]);
  //     }

  //     if (!is_null($validated['dam_raw'])) {
  //       Pembayaran::create([
  //         'gabung_haji_id' => $gabungHaji->id,
  //         'tgl_bayar' => $validated['tgl_bayar'],
  //         'metode_bayar' => $validated['metode_bayar'],
  //         'manasik' => null,
  //         'operasional' => null,
  //         'dam' => $validated['dam_raw'],
  //         'kwitansi' => getNewKwitansi($prefix),
  //         'keterangan' => "DP Jamaah {$keberangkatan} Dam " . ($validated['keterangan'] ?? ''),
  //         'create_user' => $user,
  //         'cabang_id' => $cabangId, // Simpan cabang_id
  //       ]);
  //     }
  //   });

  //   return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan!');
  // }

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
  public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $pembayaran = Pembayaran::find($id);

    $pembayaran->delete();

    return redirect()->back()->with('success', 'Pembayaran berhasil dihapus!');
  }
}
