<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\MCabang;
use App\Models\Customer;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TGabungHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('gabung-haji.index', [
      'gabung_haji' => TGabungHaji::with('customer')->latest()->get()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */

  public function create()
  {
    $kota = Kota::all();

    return view('gabung-haji.create', [
      'kotaBank' => $kota,
      'tempatLahir' => $kota,
      'provinsi' => Provinsi::all(),

      // KTP
      'selectedProvinsi' => old('provinsi_ktp'),
      'selectedKota' => old('kota_ktp'),
      'selectedKecamatan' => old('kecamatan_ktp'),
      'selectedKelurahan' => old('kelurahan_ktp'),
      'selectedKotaBank' => old('kota_bank'),
      'namaKota' => Kota::find(old('kota_ktp'))?->kota,
      'namaKecamatan' => Kecamatan::find(old('kecamatan_ktp'))?->kecamatan,
      'namaKelurahan' => Kelurahan::find(old('kelurahan_ktp'))?->kelurahan,

      // Domisili
      'selectedProvinsiDom' => old('provinsi_domisili'),
      'selectedKotaDom' => old('kota_domisili'),
      'selectedKecamatanDom' => old('kecamatan_domisili'),
      'selectedKelurahanDom' => old('kelurahan_domisili'),
      'namaKotaDom' => Kota::find(old('kota_domisili'))?->kota,
      'namaKecamatanDom' => Kecamatan::find(old('kecamatan_domisili'))?->kecamatan,
      'namaKelurahanDom' => Kelurahan::find(old('kelurahan_domisili'))?->kelurahan,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */

  public function store(Request $request)
  {
    $validated = $request->validate([
      'nama' => 'nullable|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => 'required|integer|unique:m_customers,no_id',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'warga' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      // Alamat KTP
      'alamat_ktp' => 'nullable|string',
      'provinsi_ktp' => 'nullable|exists:m_provinsis,id',
      'kota_ktp' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      'no_spph' => 'nullable|integer',
      'no_porsi' => 'nullable|integer',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|string',
      'catatan' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated) {
      $customer = Customer::create([
        'nama' => strtoupper($validated['nama']),
        'panggilan' => strtoupper($validated['panggilan']),
        'no_hp_1' => $validated['no_hp_1'],
        'no_hp_2' => $validated['no_hp_2'],
        'tempat_lahir' => $validated['tempat_lahir'],
        'tgl_lahir' => $validated['tgl_lahir'],
        'jenis_id' => $validated['jenis_id'],
        'no_id' => $validated['no_id'],
        'jenis_kelamin' => $validated['jenis_kelamin'],
        'status_nikah' => $validated['status_nikah'],
        'warga' => $validated['warga'],
        'pekerjaan' => $validated['pekerjaan'],
        'pendidikan' => $validated['pendidikan'],
        // Alamat KTP
        'alamat_ktp' => $validated['alamat_ktp'],
        'provinsi_ktp' => $validated['provinsi_ktp'],
        'kota_ktp' => $validated['kota_ktp'],
        'kecamatan_ktp' => $validated['kecamatan_ktp'],
        'kelurahan_ktp' => $validated['kelurahan_ktp'],
        // Alamat Domisili
        'alamat_domisili' => $validated['alamat_domisili'],
        'provinsi_domisili' => $validated['provinsi_domisili'],
        'kota_domisili' => $validated['kota_domisili'],
        'kecamatan_domisili' => $validated['kecamatan_domisili'],
        'kelurahan_domisili' => $validated['kelurahan_domisili'],
      ]);

      TGabungHaji::create([
        'customer_id' => $customer->id,
        'no_spph' => $validated['no_spph'],
        'no_porsi' => $validated['no_porsi'],
        'nama_bank' => $validated['nama_bank'],
        'kota_bank' => $validated['kota_bank'],
        'depag' => $validated['depag'],
        'catatan' => $validated['catatan'],
      ]);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil disimpan!');
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

  public function edit($id)
  {
    // Sama seperti function ambilSemuaData: Load semua relasi dalam satu query
    $gabung_haji = TGabungHaji::with(['customer', 'kotaBank'])->find($id);

    $customer = $gabung_haji->customer;

    return view('gabung-haji.edit', [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'kotaBank' => Kota::find($gabung_haji->kota_bank),
      // Alamat KTP
      'alamatKtp' => $customer->alamat_ktp,
      'provinsi_ktp' => Provinsi::find($customer->provinsi_ktp),
      'kota_ktp' => Kota::find($customer->kota_ktp),
      'kecamatan_ktp' => Kecamatan::find($customer->kecamatan_ktp),
      'kelurahan_ktp' => Kelurahan::find($customer->kelurahan_ktp),
      // Alamat Domisili
      'alamatDomisili' => $customer->alamat_domisili,
      'provinsi_domisili' => Provinsi::find($customer->provinsi_domisili),
      'kota_domisili' => Kota::find($customer->kota_domisili),
      'kecamatan_domisili' => Kecamatan::find($customer->kecamatan_domisili),
      'kelurahan_domisili' => Kelurahan::find($customer->kelurahan_domisili),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */

  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      'nama' => 'nullable|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => 'nullable|string',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'warga' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      // Alamat KTP
      'alamat_ktp' => 'nullable|string',
      'provinsi_ktp' => 'nullable|exists:m_provinsis,id',
      'kota_ktp' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',
      // Data t_gabung_hajis
      'no_spph' => 'nullable|integer',
      'no_porsi' => 'nullable|integer',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|string',
      'catatan' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated, $id) {
      // Ambil data t_gabung_hajis berdasarkan ID
      $gabung_haji = TGabungHaji::findOrFail($id);

      // Ambil customer_id dari data haji
      $customer = Customer::findOrFail($gabung_haji->customer_id);

      // Update data customer
      $customer->update([
        'nama' => strtoupper($validated['nama']),
        'panggilan' => strtoupper($validated['panggilan']),
        'no_hp_1' => $validated['no_hp_1'],
        'no_hp_2' => $validated['no_hp_2'],
        'tempat_lahir' => $validated['tempat_lahir'],
        'tgl_lahir' => $validated['tgl_lahir'],
        'jenis_id' => $validated['jenis_id'],
        'no_id' => $validated['no_id'],
        'jenis_kelamin' => $validated['jenis_kelamin'],
        'status_nikah' => $validated['status_nikah'],
        'warga' => $validated['warga'],
        'pekerjaan' => $validated['pekerjaan'],
        'pendidikan' => $validated['pendidikan'],
        // Alamat KTP
        'alamat_ktp' => $validated['alamat_ktp'],
        'provinsi_ktp' => $validated['provinsi_ktp'],
        'kota_ktp' => $validated['kota_ktp'],
        'kecamatan_ktp' => $validated['kecamatan_ktp'],
        'kelurahan_ktp' => $validated['kelurahan_ktp'],
        // Alamat Domisili
        'alamat_domisili' => $validated['alamat_domisili'],
        'provinsi_domisili' => $validated['provinsi_domisili'],
        'kota_domisili' => $validated['kota_domisili'],
        'kecamatan_domisili' => $validated['kecamatan_domisili'],
        'kelurahan_domisili' => $validated['kelurahan_domisili'],
      ]);

      // Update data t_gabung_hajis
      $gabung_haji->update([
        'no_spph' => $validated['no_spph'],
        'no_porsi' => $validated['no_porsi'],
        'nama_bank' => $validated['nama_bank'],
        'kota_bank' => $validated['kota_bank'],
        'depag' => $validated['depag'],
        'catatan' => $validated['catatan'],
      ]);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil diperbarui!');
  }

  /**
   * Remove the specified resource from storage.
   */

  public function destroy($id)
  {
    DB::transaction(function () use ($id) {
      $gabungHaji = TGabungHaji::findOrFail($id);

      // Ambil ID customer sebelum menghapus
      $customerId = $gabungHaji->customer_id;

      // Hapus data di t_gabung_hajis
      $gabungHaji->delete();

      // Cek apakah masih ada data di t_gabung_hajis dengan customer_id yang sama
      $customerExists = TGabungHaji::where('customer_id', $customerId)->exists();

      if (!$customerExists) {
        // Jika tidak ada lagi data di t_gabung_hajis untuk customer ini, hapus customer
        Customer::where('id', $customerId)->delete();
      }
    });

    return redirect('/gabung-haji')->with('success', 'Data Dihapus');
  }

  public function search(Request $request)
  {
    $query = $request->input('query');

    // Ambil data no_porsi_haji beserta nama customer dari tabel relasi
    $gabungHaji = TGabungHaji::whereHas('customer', function ($q) use ($query) {
      $q->where('nama', 'like', "%{$query}%");
    })
      ->orWhere('no_porsi', 'like', "%{$query}%") // Bisa cari berdasarkan no_porsi_haji
      ->with('customer:id,nama') // Ambil hanya id dan nama dari tabel customer
      ->select('id', 'customer_id', 'no_porsi')
      ->latest()
      ->get();

    return response()->json($gabungHaji);
  }

  public function repeatDataGabung($id)
  {
    // Sama seperti function ambilSemuaData: Load semua relasi dalam satu query
    $gabung_haji = TGabungHaji::with(['customer', 'kotaBank'])->find($id);

    $customer = $gabung_haji->customer;

    return view('gabung-haji.repeat-data', [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'kotaBank' => Kota::find($gabung_haji->kota_bank),
      // Alamat KTP
      'alamatKtp' => $customer->alamat_ktp,
      'provinsi_ktp' => Provinsi::find($customer->provinsi_ktp),
      'kota_ktp' => Kota::find($customer->kota_ktp),
      'kecamatan_ktp' => Kecamatan::find($customer->kecamatan_ktp),
      'kelurahan_ktp' => Kelurahan::find($customer->kelurahan_ktp),
      // Alamat Domisili
      'alamatDomisili' => $customer->alamat_domisili,
      'provinsi_domisili' => Provinsi::find($customer->provinsi_domisili),
      'kota_domisili' => Kota::find($customer->kota_domisili),
      'kecamatan_domisili' => Kecamatan::find($customer->kecamatan_domisili),
      'kelurahan_domisili' => Kelurahan::find($customer->kelurahan_domisili),
    ]);
  }

  public function storeRepeatData(Request $request, $id)
  {
    $validated = $request->validate([
      'nama' => 'nullable|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => 'nullable|string',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'warga' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      // Alamat KTP
      'alamat_ktp' => 'nullable|string',
      'provinsi_ktp' => 'nullable|exists:m_provinsis,id',
      'kota_ktp' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',
      // Data t_gabung_hajis
      'no_spph' => 'nullable|integer',
      'no_porsi' => 'nullable|integer',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|string',
      'catatan' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated, $id) {
      // Ambil data t_gabung_hajis berdasarkan ID
      $gabung_haji = TGabungHaji::findOrFail($id);

      // Ambil customer_id dari data haji
      $customer = Customer::findOrFail($gabung_haji->customer_id);

      // Update data customer
      $customer->update([
        'nama' => strtoupper($validated['nama']),
        'panggilan' => strtoupper($validated['panggilan']),
        'no_hp_1' => $validated['no_hp_1'],
        'no_hp_2' => $validated['no_hp_2'],
        'tempat_lahir' => $validated['tempat_lahir'],
        'tgl_lahir' => $validated['tgl_lahir'],
        'jenis_id' => $validated['jenis_id'],
        'no_id' => $validated['no_id'],
        'jenis_kelamin' => $validated['jenis_kelamin'],
        'status_nikah' => $validated['status_nikah'],
        'warga' => $validated['warga'],
        'pekerjaan' => $validated['pekerjaan'],
        'pendidikan' => $validated['pendidikan'],
        // Alamat KTP
        'alamat_ktp' => $validated['alamat_ktp'],
        'provinsi_ktp' => $validated['provinsi_ktp'],
        'kota_ktp' => $validated['kota_ktp'],
        'kecamatan_ktp' => $validated['kecamatan_ktp'],
        'kelurahan_ktp' => $validated['kelurahan_ktp'],
        // Alamat Domisili
        'alamat_domisili' => $validated['alamat_domisili'],
        'provinsi_domisili' => $validated['provinsi_domisili'],
        'kota_domisili' => $validated['kota_domisili'],
        'kecamatan_domisili' => $validated['kecamatan_domisili'],
        'kelurahan_domisili' => $validated['kelurahan_domisili'],
      ]);

      // Buat data baru di t_gabung_hajis
      TGabungHaji::create([
        'customer_id' => $customer->id, // Ambil ID dari customer yang sudah diupdate
        'no_spph' => $validated['no_spph'],
        'no_porsi' => $validated['no_porsi'],
        'nama_bank' => $validated['nama_bank'],
        'kota_bank' => $validated['kota_bank'],
        'depag' => $validated['depag'],
        'catatan' => $validated['catatan'],
      ]);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil diperbarui dan ditambahkan!');
  }

  public function ambilSemuaData($id)
  {
    // Sama seperti function ambilSemuaData: Load semua relasi dalam satu query
    $gabung_haji = TGabungHaji::with(['customer', 'kotaBank'])->find($id);

    $customer = $gabung_haji->customer;

    return view('gabung-haji.ambil-semua-data', [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'kotaBank' => Kota::find($gabung_haji->kota_bank),
      // Alamat KTP
      'alamatKtp' => $customer->alamat_ktp,
      'provinsi_ktp' => Provinsi::find($customer->provinsi_ktp),
      'kota_ktp' => Kota::find($customer->kota_ktp),
      'kecamatan_ktp' => Kecamatan::find($customer->kecamatan_ktp),
      'kelurahan_ktp' => Kelurahan::find($customer->kelurahan_ktp),
      // Alamat Domisili
      'alamatDomisili' => $customer->alamat_domisili,
      'provinsi_domisili' => Provinsi::find($customer->provinsi_domisili),
      'kota_domisili' => Kota::find($customer->kota_domisili),
      'kecamatan_domisili' => Kecamatan::find($customer->kecamatan_domisili),
      'kelurahan_domisili' => Kelurahan::find($customer->kelurahan_domisili),
    ]);
  }

  public function storeAmbilSemuaData(Request $request)
  {
    $validated = $request->validate([
      'nama' => 'nullable|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => 'required|integer|unique:m_customers,no_id',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'warga' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      // Alamat KTP
      'alamat_ktp' => 'nullable|string',
      'provinsi_ktp' => 'nullable|exists:m_provinsis,id',
      'kota_ktp' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      'no_spph' => 'nullable|integer',
      'no_porsi' => 'nullable|integer',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|string',
      'catatan' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated) {
      $customer = Customer::create([
        'nama' => strtoupper($validated['nama']),
        'panggilan' => strtoupper($validated['panggilan']),
        'no_hp_1' => $validated['no_hp_1'],
        'no_hp_2' => $validated['no_hp_2'],
        'tempat_lahir' => $validated['tempat_lahir'],
        'tgl_lahir' => $validated['tgl_lahir'],
        'jenis_id' => $validated['jenis_id'],
        'no_id' => $validated['no_id'],
        'jenis_kelamin' => $validated['jenis_kelamin'],
        'status_nikah' => $validated['status_nikah'],
        'warga' => $validated['warga'],
        'pekerjaan' => $validated['pekerjaan'],
        'pendidikan' => $validated['pendidikan'],
        // Alamat KTP
        'alamat_ktp' => $validated['alamat_ktp'],
        'provinsi_ktp' => $validated['provinsi_ktp'],
        'kota_ktp' => $validated['kota_ktp'],
        'kecamatan_ktp' => $validated['kecamatan_ktp'],
        'kelurahan_ktp' => $validated['kelurahan_ktp'],
        // Alamat Domisili
        'alamat_domisili' => $validated['alamat_domisili'],
        'provinsi_domisili' => $validated['provinsi_domisili'],
        'kota_domisili' => $validated['kota_domisili'],
        'kecamatan_domisili' => $validated['kecamatan_domisili'],
        'kelurahan_domisili' => $validated['kelurahan_domisili'],
      ]);

      TGabungHaji::create([
        'customer_id' => $customer->id,
        'no_spph' => $validated['no_spph'],
        'no_porsi' => $validated['no_porsi'],
        'nama_bank' => $validated['nama_bank'],
        'kota_bank' => $validated['kota_bank'],
        'depag' => $validated['depag'],
        'catatan' => $validated['catatan'],
      ]);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil disimpan!');
  }
}
