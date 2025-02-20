<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Customer;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTGabungHajiRequest;

class TGabungHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('gabung-haji.index', [
      'gabung_haji' => TGabungHaji::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */

  public function create()
  {
    return view('gabung-haji.create', [
      'customers' => Customer::all(),
      'kotaBank' => Kota::all(),
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
      'no_spph' => 'required|integer',
      'no_porsi' => 'required|integer',
      'customer_id' => 'required|exists:m_customers,id',
      'nama_bank' => 'required|string',
      'kota_bank' => 'required|integer',
      'estimasi' => 'required|integer',
      'depag' => 'required|string',
      // 'paket_haji' => 'required|string',
      'catatan' => 'nullable|string',
    ]);

    $customer = Customer::find($request->customer_id);

    if ($customer) {
      // Data dari customer yang akan dimasukkan ke t_gabung_hajis
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

    TGabungHaji::create($validated);

    return redirect('/gabung-haji')->with('success', 'Data Tersimpan');
  }

  /**
   * Display the specified resource.
   */
  public function show(TGabungHaji $tGabungHaji)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */

  public function edit(TGabungHaji $tGabungHaji, $id)
  {
    $gabung_haji = TGabungHaji::with('kotaLahir')->where('id', $id)->first();
    $kotaBank = Kota::all();
    $customers = Customer::all();
    // dd($gabung_haji);

    // ====================== Alamat Sesuai KTP ======================
    $alamat_ktp = json_decode($gabung_haji->alamat_ktp, true) ?? [];

    // Ambil data berdasarkan ID dari alamat KTP
    $provinsi = Provinsi::find($alamat_ktp['provinsi_id'] ?? null);
    $kota = Kota::find($alamat_ktp['kota_id'] ?? null);
    $kecamatan = Kecamatan::find($alamat_ktp['kecamatan_id'] ?? null);
    $kelurahan = Kelurahan::find($alamat_ktp['kelurahan_id'] ?? null);
    $kode_pos = $kelurahan->kode_pos ?? null;

    // ====================== Alamat Domisili ======================
    $alamat_domisili = json_decode($gabung_haji->alamat_domisili, true) ?? [];

    // Ambil data berdasarkan ID dari alamat domisili
    $provinsi_domisili = Provinsi::find($alamat_domisili['provinsi_id'] ?? null);
    $kota_domisili = Kota::find($alamat_domisili['kota_id'] ?? null);
    $kecamatan_domisili = Kecamatan::find($alamat_domisili['kecamatan_id'] ?? null);
    $kelurahan_domisili = Kelurahan::find($alamat_domisili['kelurahan_id'] ?? null);
    $kode_pos_domisili = $kelurahan_domisili->kode_pos ?? null;

    return view('gabung-haji.edit', compact(
      'gabung_haji',
      'kotaBank',
      'customers',
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

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    // dd($request->all());
    $gabungHaji = TGabungHaji::findOrFail($id);

    $validated = $request->validate([
      'no_spph' => 'required|integer',
      'no_porsi' => 'required|integer',
      'customer_id' => 'required|exists:m_customers,id',
      'nama_bank' => 'required|string',
      'kota_bank' => 'required|integer',
      'estimasi' => 'required|integer',
      'depag' => 'required|string',
      // 'paket_haji' => 'required|string',
      'catatan' => 'nullable|string',
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
    $alamat_domisili_lama = json_decode($gabungHaji->alamat_domisili, true) ?? [];

    $validated['alamat_domisili'] = json_encode([
      'alamat'       => $request->alamat_domisili ?? $alamat_domisili_lama['alamat'] ?? '',
      'provinsi_id'  => $request->provinsi_domisili_id ?? $alamat_domisili_lama['provinsi_id'] ?? '',
      'kota_id'      => $request->kota_domisili_id ?? $alamat_domisili_lama['kota_id'] ?? '',
      'kecamatan_id' => $request->kecamatan_domisili_id ?? $alamat_domisili_lama['kecamatan_id'] ?? '',
      'kelurahan_id' => $request->kelurahan_domisili_id ?? $alamat_domisili_lama['kelurahan_id'] ?? '',
    ], JSON_UNESCAPED_UNICODE);

    $gabungHaji->update($validated);

    return redirect('/gabung-haji')->with('success', 'Data Berhasil Diperbarui');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $gabungHaji = TGabungHaji::find($id);

    $gabungHaji->delete();
    return redirect('/gabung-haji')->with('success', 'Data Dihapus');
  }
}
