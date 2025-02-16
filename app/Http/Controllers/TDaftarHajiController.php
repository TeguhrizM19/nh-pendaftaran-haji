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
      'dokumen' => MDokHaji::all(), // Menambahkan dokumen ke form
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
      'dokumen' => 'array', // Validasi input dokumen sebagai array
      'dokumen.*' => 'exists:m_dok_hajis,id', // Pastikan dokumen yang dipilih ada di database
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

      // ✅ Cek apakah `alamat_ktp` sudah dalam bentuk array
      $alamatKTP = is_array($customer->alamat_ktp) ? $customer->alamat_ktp : json_decode($customer->alamat_ktp, true);

      // ✅ Pastikan `alamat_ktp` tidak mengalami double encoding
      $validated['alamat_ktp'] = json_encode([
        'alamat'       => $alamatKTP['alamat'] ?? $customer->alamat_ktp ?? '',
        'provinsi_id'  => $alamatKTP['provinsi_id'] ?? $customer->provinsi_id ?? '',
        'kota_id'      => $alamatKTP['kota_id'] ?? $customer->kota_id ?? '',
        'kecamatan_id' => $alamatKTP['kecamatan_id'] ?? $customer->kecamatan_id ?? '',
        'kelurahan_id' => $alamatKTP['kelurahan_id'] ?? $customer->kelurahan_id ?? '',
      ], JSON_UNESCAPED_UNICODE);
    }

    // ✅ Simpan alamat domisili (pastikan ID wilayahnya benar)
    $validated['alamat_domisili'] = json_encode([
      'alamat'       => $request->alamat_domisili ?? '',
      'provinsi_id'  => $request->provinsi_domisili_id ?? '',
      'kota_id'      => $request->kota_domisili_id ?? '',
      'kecamatan_id' => $request->kecamatan_domisili_id ?? '',
      'kelurahan_id' => $request->kelurahan_domisili_id ?? '',
    ], JSON_UNESCAPED_UNICODE);

    // ✅ Simpan dokumen sebagai array JSON (ID dokumen)
    $validated['dokumen'] = json_encode($request->dokumen, JSON_UNESCAPED_UNICODE);

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
    $daftar_haji = TDaftarHaji::findOrFail($id);
    $customers = Customer::all();
    $cabang = MCabang::all();
    $wilayahKota = Kota::all();
    $sumberInfo = MSumberInfo::all();
    $dokumen = MDokHaji::all();

    // Konversi dokumen dari JSON ke array jika diperlukan
    $selected_documents = json_decode($daftar_haji->dokumen, true) ?? [];

    // ====================== Alamat Sesuai KTP ======================
    $alamat_ktp = json_decode($daftar_haji->alamat_ktp, true) ?? [];

    // Ambil data berdasarkan ID dari alamat KTP
    $provinsi = Provinsi::find($alamat_ktp['provinsi_id'] ?? null);
    $kota = Kota::find($alamat_ktp['kota_id'] ?? null);
    $kecamatan = Kecamatan::find($alamat_ktp['kecamatan_id'] ?? null);
    $kelurahan = Kelurahan::find($alamat_ktp['kelurahan_id'] ?? null);
    $kode_pos = $kelurahan->kode_pos ?? null;

    // ====================== Alamat Domisili ======================
    $alamat_domisili = json_decode($daftar_haji->alamat_domisili, true) ?? [];

    // Ambil data berdasarkan ID dari alamat domisili
    $provinsi_domisili = Provinsi::find($alamat_domisili['provinsi_id'] ?? null);
    $kota_domisili = Kota::find($alamat_domisili['kota_id'] ?? null);
    $kecamatan_domisili = Kecamatan::find($alamat_domisili['kecamatan_id'] ?? null);
    $kelurahan_domisili = Kelurahan::find($alamat_domisili['kelurahan_id'] ?? null);
    $kode_pos_domisili = $kelurahan_domisili->kode_pos ?? null;

    // Debugging untuk memastikan data alamat domisili benar
    // dd($alamat_domisili, $provinsi_domisili, $kota_domisili, $kecamatan_domisili, $kelurahan_domisili, $kode_pos_domisili);

    return view('pendaftaran-haji.edit', compact(
      'daftar_haji',
      'customers',
      'cabang',
      'wilayahKota',
      'sumberInfo',
      'dokumen',
      'selected_documents',
      'alamat_ktp',
      'provinsi',
      'kota',
      'kecamatan',
      'kelurahan',
      'kode_pos',
      'alamat_domisili',
      'provinsi_domisili',
      'kota_domisili',
      'kecamatan_domisili',
      'kelurahan_domisili',
      'kode_pos_domisili'
    ));
  }


  public function update(Request $request, $id)
  {
    $daftarHaji = TDaftarHaji::findOrFail($id);

    $validated = $request->validate([
      'no_porsi_haji' => 'required|integer|unique:t_daftar_hajis,no_porsi_haji,' . $id,
      'customer_id' => 'required|exists:m_customers,id',
      'cabang_id' => 'required|exists:m_cabangs,id',
      'sumber_info_id' => 'required|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'required|exists:m_kotas,id',
      'estimasi' => 'required|integer',
      'bpjs' => 'nullable|string',
      'bank' => 'nullable|string',
      'paket_haji' => 'nullable|string',
      'catatan' => 'nullable|string',
      'dokumen' => 'array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    $customer = Customer::find($request->customer_id);

    if ($customer) {
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

      // Mengambil alamat KTP dari database jika ada
      $alamatKTP = is_array($customer->alamat_ktp) ? $customer->alamat_ktp : json_decode($customer->alamat_ktp, true);

      $validated['alamat_ktp'] = json_encode([
        'alamat'       => $alamatKTP['alamat'] ?? $customer->alamat_ktp ?? '',
        'provinsi_id'  => $alamatKTP['provinsi_id'] ?? $customer->provinsi_id ?? '',
        'kota_id'      => $alamatKTP['kota_id'] ?? $customer->kota_id ?? '',
        'kecamatan_id' => $alamatKTP['kecamatan_id'] ?? $customer->kecamatan_id ?? '',
        'kelurahan_id' => $alamatKTP['kelurahan_id'] ?? $customer->kelurahan_id ?? '',
      ], JSON_UNESCAPED_UNICODE);
    }

    // Mengambil alamat domisili lama untuk mencegah data terhapus
    $alamat_domisili_lama = json_decode($daftarHaji->alamat_domisili, true) ?? [];

    $validated['alamat_domisili'] = json_encode([
      'alamat'       => $request->alamat_domisili ?? $alamat_domisili_lama['alamat'] ?? '',
      'provinsi_id'  => $request->provinsi_domisili_id ?? $alamat_domisili_lama['provinsi_id'] ?? '',
      'kota_id'      => $request->kota_domisili_id ?? $alamat_domisili_lama['kota_id'] ?? '',
      'kecamatan_id' => $request->kecamatan_domisili_id ?? $alamat_domisili_lama['kecamatan_id'] ?? '',
      'kelurahan_id' => $request->kelurahan_domisili_id ?? $alamat_domisili_lama['kelurahan_id'] ?? '',
    ], JSON_UNESCAPED_UNICODE);

    // Pastikan dokumen tetap terjaga dalam format JSON
    $validated['dokumen'] = json_encode($request->dokumen, JSON_UNESCAPED_UNICODE);

    $daftarHaji->update($validated);

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
