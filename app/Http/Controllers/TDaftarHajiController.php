<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\MCabang;
use App\Models\Customer;
use App\Models\MDokHaji;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\MSumberInfo;
use App\Models\TDaftarHaji;
use Illuminate\Http\Request;

class TDaftarHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('pendaftaran-haji.index', [
      'daftar_haji' => TDaftarHaji::with('customer')->get()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('pendaftaran-haji.create', [
      'customers' => Customer::all(),
      'cabang' => MCabang::all(),
      'sumberInfo' => MSumberInfo::all(),
      'wilayahKota' => Kota::all(),
      'documents' => MDokHaji::all(),
      'provinsi' => Provinsi::all()->keyBy('id'), // Ubah ke associative array
      'kota' => Kota::all()->keyBy('id'), // Ubah ke associative array
      'kecamatan' => Kecamatan::all()->keyBy('id'),
      'kelurahan' => Kelurahan::all()->keyBy('id')
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */

  public function store(Request $request)
  {
    $validated = $request->validate([
      'no_porsi_haji' => 'required|integer|unique:t_daftar_hajis,no_porsi_haji',
      'customer_id' => 'required|exists:m_customers,id',
      'cabang_id' => 'required|exists:m_cabangs,id',
      'sumber_info_id' => 'required|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'required|exists:m_kotas,id',
      'estimasi' => 'required|integer',
      'bpjs' => 'nullable|string',
      'bank' => 'nullable|string',
      'paket_haji' => 'nullable|string',
      'catatan' => 'nullable|string',
    ]);

    // Ambil data customer berdasarkan customer_id
    $customer = Customer::find($request->customer_id);

    if ($customer) {
      // Data dari customer yang akan dimasukkan ke t_daftar_hajis
      $validated['no_hp_1'] = $customer->no_hp_1 ?? null;
      $validated['no_hp_2'] = $customer->no_hp_2 ?? null;
      $validated['tempat_lahir'] = $customer->tempat_lahir ?? null;
      $validated['tgl_lahir'] = $customer->tgl_lahir ?? null;
      $validated['jenis_id'] = $customer->jenis_id ?? null;
      $validated['no_id'] = $customer->no_id ?? null;
      $validated['warga'] = $customer->warga ?? null;
      $validated['jenis_kelamin'] = $customer->jenis_kelamin ?? null;
      $validated['status_nikah'] = $customer->status_nikah ?? null;
      $validated['pekerjaan'] = $customer->pekerjaan ?? null;
      $validated['pendidikan'] = $customer->pendidikan ?? null;
    }

    // Simpan data utama
    TDaftarHaji::create($validated);

    return redirect('/pendaftaran-haji')->with('success', 'Data Tersimpan');
  }


  /**
   * Display the specified resource.
   */
  public function show(TDaftarHaji $tDaftarHaji)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    // Ambil data pendaftaran haji berdasarkan ID, termasuk relasi customer dan cabang
    $daftar_haji = TDaftarHaji::with(['customer', 'cabang'])->findOrFail($id);

    return view('pendaftaran-haji.edit', [
      'daftar_haji' => $daftar_haji,
      'customers' => Customer::all(),
      'cabang' => MCabang::all(),
      'provinsi' => Provinsi::all(),
      'kota' => Kota::all(),
      'kecamatan' => Kecamatan::all(),
      'kelurahan' => Kelurahan::all(),
      'documents' => MDokHaji::all(),
      'selected_documents' => $daftar_haji->dokumen()->pluck('dok_id')->toArray(), // Mengambil dokumen yang sudah dipilih sebelumnya
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      'customer_id' => 'required|exists:m_customers,id',
      'cabang_id' => 'required|exists:m_cabangs,id',
      'provinsi_id' => 'required|exists:m_provinsis,id',
      'kota_id' => 'required|exists:m_kotas,id',
      'kecamatan_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_id' => 'required|exists:m_kelurahans,id',
      'dok_id' => 'nullable|array', // Pastikan ini bisa null
      'dok_id.*' => 'exists:m_dok_hajis,id',
      'domisili' => 'required|string',
      'wilayah_daftar' => 'required|string',
      'paket_haji' => 'required|string',
      'bpjs' => 'required|integer',
      'estimasi' => 'required|integer',
      'catatan' => 'required|string',
    ]);

    $daftarHaji = TDaftarHaji::findOrFail($id);

    // Update data utama
    $daftarHaji->update($validated);

    // Update dokumen di tabel pivot
    if ($request->has('dok_id')) {
      $daftarHaji->dokumen()->sync($request->dok_id); // sync() mengganti data lama dengan yang baru
    } else {
      $daftarHaji->dokumen()->detach(); // Hapus semua dokumen jika tidak ada yang dipilih
    }

    return redirect('/pendaftaran-haji')->with('success', 'Data Berhasil Diperbarui');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $daftarHaji = TDaftarHaji::find($id);

    $daftarHaji->delete();
    return redirect('/pendaftaran-haji')->with('success', 'Data Dihapus');
  }

  public function getCabang($id)
  {
    $cabang = MCabang::find($id);
    return response()->json([
      'kode_cab' => $cabang?->kode_cab ?? '',
      'alamat' => $cabang?->alamat ?? ''
    ]);
  }

  // function untuk wilayah indonasia
  public function getKota($provinsi_id)
  {
    $kota = Kota::where('provinsi_id', $provinsi_id)->get();
    return response()->json($kota);
  }

  public function getKecamatan($kota_id)
  {
    $kecamatan = Kecamatan::where('kota_id', $kota_id)->get();
    return response()->json($kecamatan);
  }

  public function getKelurahan($kecamatanID)
  {
    $kelurahan = Kelurahan::where('kecamatan_id', $kecamatanID)->select('id', 'kelurahan', 'kode_pos')->get();
    return response()->json($kelurahan);
  }

  public function getKodePos($kelurahan_id)
  {
    $kelurahan = Kelurahan::find($kelurahan_id);
    return response()->json(['kode_pos' => $kelurahan ? $kelurahan->kode_pos : '']);
  }
}
