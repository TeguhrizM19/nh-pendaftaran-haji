<?php

namespace App\Http\Controllers;

use App\Models\MDokHaji;
use App\Models\TDaftarHaji;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use App\Models\MPerlengkapan;

class MPerlengkapanController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('perlengkapan.index', [
      'perlengkapan' => MPerlengkapan::all()
    ]);
  }

  public function indexKelengkapanCustomer($id)
  {
    // Ambil data gabung haji beserta relasi
    $gabungHaji = TGabungHaji::with(['customer', 'daftarHaji', 'keberangkatan'])->findOrFail($id);
    $jenisKelamin = strtolower($gabungHaji->customer->jenis_kelamin); // pastikan lowercase semua

    // Ambil semua dokumen yang status-nya aktif
    $dokumenAktif = MDokHaji::where('status', 'Aktif')->get();
    $perlengkapanAktif = MPerlengkapan::where('status', 'Aktif')
      ->where(function ($query) use ($jenisKelamin) {
        $query->whereRaw('LOWER(jenis_kelamin) = ?', [$jenisKelamin])
          ->orWhereRaw('LOWER(jenis_kelamin) = ?', ['laki-laki/perempuan']);
      })
      ->get();

    // Ambil dokumen yang tersimpan dalam kolom JSON 'dokumen' dari tabel t_gabung_hajis
    $selected_documents = is_array($gabungHaji->dokumen) ? $gabungHaji->dokumen : json_decode($gabungHaji->dokumen, true);
    $selected_perlengkapan = is_array($gabungHaji->perlengkapan) ? $gabungHaji->perlengkapan : json_decode($gabungHaji->perlengkapan, true);

    return view('perlengkapan.index-kelengkapan-customer', [
      'gabungHaji' => $gabungHaji,
      'dokumenAktif' => $dokumenAktif,
      'selected_documents' => $selected_documents ?? [],
      'perlengkapanAktif' => $perlengkapanAktif,
      'selected_perlengkapan' => $selected_perlengkapan ?? [],
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
  public function store(Request $request)
  {
    $validated = $request->validate([
      'perlengkapan' => 'required|string',
      'jenis_kelamin' => 'required|string',
    ]);

    MPerlengkapan::create($validated);

    return redirect()->back()->with('success', 'Perlengkapan berhasil ditambahkan!');
  }

  /**
   * Display the specified resource.
   */
  public function show(MPerlengkapan $mPerlengkapan)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Request $request, $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $perlengkapan = MPerlengkapan::findOrFail($id);

    $validated = $request->validate([
      'perlengkapan' => 'required|string',
      'jenis_kelamin' => 'nullable|string',
      'status' => 'nullable|string',
    ]);

    $perlengkapan->update($validated);

    return redirect()->back()->with('success', 'Perlengkapan berhasil diubah!');
  }

  public function updateKelengkapanCustomer(Request $request, $id)
  {
    $gabungHaji = TGabungHaji::findOrFail($id);

    $validated = $request->validate([
      'perlengkapan' => 'nullable|array',
      'perlengkapan.*' => 'exists:m_perlengkapans,id',
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    $gabungHaji->perlengkapan = $validated['perlengkapan'] ?? [];
    $gabungHaji->dokumen = $validated['dokumen'] ?? [];
    $gabungHaji->save();

    // Simpan juga ke TDaftarHaji
    $daftarHaji = TDaftarHaji::where('customer_id', $gabungHaji->customer_id)->first(); // Asumsinya ada relasi via customer_id

    if ($daftarHaji) {
      $daftarHaji->perlengkapan = $validated['perlengkapan'] ?? [];
      $daftarHaji->dokumen = $validated['dokumen'] ?? [];
      $daftarHaji->save();
    }

    return redirect('/gabung-haji')->with('success', 'Data kelengkapan berhasil disimpan.');
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(MPerlengkapan $mPerlengkapan)
  {
    //
  }
}
