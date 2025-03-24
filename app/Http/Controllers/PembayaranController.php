<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
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

    // 5. Hitung kekurangan pembayaran
    $kurangManasik = max(0, $biayaManasik - $totalDibayarManasik); // Pastikan tidak negatif
    $kurangOperasional = max(0, $biayaOperasional - $totalDibayarOperasional);
    $kurangDam = max(0, $biayaDam - $totalDibayarDam);

    $totalKekurangan = $kurangManasik + $kurangOperasional + $kurangDam;

    // Jika semua data kosong (tidak ada biaya & tidak ada pembayaran), set totalKekurangan ke null
    if ($totalBiaya == 0 && $totalDibayar == 0) {
      $totalKekurangan = null;
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
      'totalKekurangan' => $totalKekurangan
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
    $gabungHaji = TGabungHaji::findOrFail($id);
    $user = Auth::user()->name;

    $validated = $request->validate([
      'tgl_bayar' => 'required|date',
      'metode_bayar' => 'required|string',
      'manasik_raw' => 'nullable|numeric',
      'operasional_raw' => 'nullable|numeric',
      'dam_raw' => 'nullable|numeric',
      'kwitansi' => 'nullable|string',
      'keterangan' => 'nullable|string',
    ]);

    Pembayaran::create([
      'gabung_haji_id' => $gabungHaji->id,
      'tgl_bayar' => $validated['tgl_bayar'],
      'metode_bayar' => $validated['metode_bayar'],
      'manasik' => $validated['manasik_raw'] ?? 0,
      'operasional' => $validated['operasional_raw'] ?? 0,
      'dam' => $validated['dam_raw'] ?? 0,
      'kwitansi' => $validated['kwitansi'],
      'keterangan' => $validated['keterangan'],
      'create_user' => $user
    ]);

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
