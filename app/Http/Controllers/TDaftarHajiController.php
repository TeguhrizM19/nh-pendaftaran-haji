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
use Illuminate\Support\Facades\DB;

class TDaftarHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('pendaftaran-haji.index', [
      'daftar_haji' => TDaftarHaji::with('customer')->latest()->paginate(5)
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */

  public function create()
  {
    $kota = Kota::all();

    return view('pendaftaran-haji.create', [
      'wilayahKota' => $kota,
      'tempatLahir' => $kota,
      'cabang' => MCabang::all(),
      'sumberInfo' => MSumberInfo::all(),
      'dokumen' => MDokHaji::all(),
      'provinsi' => Provinsi::all(),

      // KTP
      'selectedProvinsi' => old('provinsi_ktp'),
      'selectedKota' => old('kota_ktp'),
      'selectedKecamatan' => old('kecamatan_ktp'),
      'selectedKelurahan' => old('kelurahan_ktp'),
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
      // Validasi untuk m_customers
      'nama'           => 'required|string|max:255',
      'no_hp_1'        => 'required|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'required|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'required|date',
      'jenis_id'       => 'required|string',
      'no_id'          => 'required|integer|unique:m_customers,no_id',
      'jenis_kelamin'  => 'required|string',
      'status_nikah'   => 'required|string',
      'warga'          => 'required|string',
      'pekerjaan'      => 'required|string',
      'pendidikan'     => 'required|string',
      // wilayah sesuai KTP
      'alamat_ktp'     => 'required|string',
      'provinsi_ktp' => 'required|exists:m_provinsis,id',
      'kota_ktp' => 'required|exists:m_kotas,id',
      'kecamatan_ktp' => 'required|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'required|exists:m_kelurahans,id',
      // wilayah sesuai Domisili
      'alamat_domisili' => 'required|string',
      'provinsi_domisili' => 'required|exists:m_provinsis,id',
      'kota_domisili' => 'required|exists:m_kotas,id',
      'kecamatan_domisili' => 'required|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'required|exists:m_kelurahans,id',

      // Validasi untuk t_daftar_hajis
      'no_porsi_haji' => 'required|numeric',
      'cabang_id' => 'required|exists:m_cabangs,id',
      'sumber_info_id' => 'required|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'required|exists:m_kotas,id',
      'paket_haji' => 'required|string',
      'bpjs' => 'required|string',
      'bank' => 'required|string',
      'catatan' => 'nullable|string',
      'dokumen' => 'array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    // Gunakan transaksi agar penyimpanan ke dua tabel berjalan bersama-sama
    DB::transaction(function () use ($validated) {
      // Simpan data pelanggan ke m_customers
      $customer = Customer::create([
        'nama' => strtoupper($validated['nama']),
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

      // Simpan data pendaftaran haji ke t_daftar_hajis
      TDaftarHaji::create([
        'customer_id' => $customer->id, // Ambil ID dari m_customers yang baru saja dibuat
        'no_porsi_haji' => $validated['no_porsi_haji'],
        'cabang_id' => $validated['cabang_id'],
        'sumber_info_id' => $validated['sumber_info_id'],
        'wilayah_daftar' => $validated['wilayah_daftar'],
        'paket_haji' => $validated['paket_haji'],
        'bpjs' => $validated['bpjs'],
        'bank' => $validated['bank'],
        'catatan' => $validated['catatan'],
        'dokumen' => json_encode($validated['dokumen'], JSON_UNESCAPED_UNICODE),
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data Tersimpan di kedua tabel');
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
    $daftar_haji = TDaftarHaji::with([
      'cabang',
      'wilayahDaftar',
      'sumberInfo',
      'customer'
    ])->findOrFail($id);

    // Pastikan relasi `customer` ada sebelum mengaksesnya
    $customer = $daftar_haji->customer ?? abort(404, 'Data pelanggan tidak ditemukan');

    // Decode dokumen dari JSON ke array, pastikan tidak null
    $selected_documents = json_decode($daftar_haji->dokumen, true) ?? [];

    return view('pendaftaran-haji.edit', [
      'daftar_haji' => $daftar_haji,
      'customer' => $customer,
      'sumberInfo' => MSumberInfo::all(),
      'cabang' => MCabang::find($daftar_haji->cabang_id),
      'wilayahDaftar' => Kota::find($daftar_haji->wilayah_daftar),
      'dokumen' => MDokHaji::all(),
      'selected_documents' => $selected_documents,
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

  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      // Validasi untuk m_customers
      'nama'            => 'nullable|string|max:255',
      'no_hp_1'         => 'nullable|string|max:15',
      'no_hp_2'         => 'nullable|string|max:15',
      'tempat_lahir'    => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir'       => 'nullable|date',
      'jenis_id'        => 'nullable|string',
      'no_id'           => 'nullable|string',
      'jenis_kelamin'   => 'nullable|string',
      'status_nikah'    => 'nullable|string',
      'warga'           => 'nullable|string',
      'pekerjaan'       => 'nullable|string',
      'pendidikan'      => 'nullable|string',
      // Alamat KTP
      'alamat_ktp'      => 'nullable|string',
      'provinsi_ktp'    => 'nullable|exists:m_provinsis,id',
      'kota_ktp'        => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp'   => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp'   => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili'    => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',
      // Validasi untuk t_daftar_hajis
      'no_porsi_haji'   => 'nullable|numeric',
      'cabang_id'       => 'nullable|numeric|exists:m_cabangs,id',
      'sumber_info_id'  => 'nullable|numeric|exists:m_sumber_infos,id',
      'wilayah_daftar'  => 'nullable|numeric|exists:m_kotas,id',
      'paket_haji'      => 'nullable|string',
      'bpjs'            => 'nullable|string',
      'bank'            => 'nullable|string',
      'catatan'         => 'nullable|string',
      'dokumen'         => 'nullable|array',
      'dokumen.*'       => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($validated, $id) {
      // Ambil data pendaftaran haji berdasarkan ID
      $haji = TDaftarHaji::findOrFail($id);

      // Ambil customer_id dari data haji
      $customer = Customer::findOrFail($haji->customer_id);

      // Update m_customers
      $customer->update([
        'nama'             => strtoupper($validated['nama']),
        'no_hp_1'          => $validated['no_hp_1'],
        'no_hp_2'          => $validated['no_hp_2'],
        'tempat_lahir'     => $validated['tempat_lahir'],
        'tgl_lahir'        => $validated['tgl_lahir'],
        'jenis_id'         => $validated['jenis_id'],
        'no_id'            => $validated['no_id'],
        'jenis_kelamin'    => $validated['jenis_kelamin'],
        'status_nikah'     => $validated['status_nikah'],
        'warga'            => $validated['warga'],
        'pekerjaan'        => $validated['pekerjaan'],
        'pendidikan'       => $validated['pendidikan'],
        // Alamat KTP
        'alamat_ktp'       => $validated['alamat_ktp'],
        'provinsi_ktp'     => $validated['provinsi_ktp'],
        'kota_ktp'         => $validated['kota_ktp'],
        'kecamatan_ktp'    => $validated['kecamatan_ktp'],
        'kelurahan_ktp'    => $validated['kelurahan_ktp'],
        // Alamat Domisili
        'alamat_domisili'  => $validated['alamat_domisili'],
        'provinsi_domisili' => $validated['provinsi_domisili'],
        'kota_domisili'    => $validated['kota_domisili'],
        'kecamatan_domisili' => $validated['kecamatan_domisili'],
        'kelurahan_domisili' => $validated['kelurahan_domisili'],
      ]);

      // Update t_daftar_hajis
      $haji->update([
        'no_porsi_haji'   => $validated['no_porsi_haji'],
        'cabang_id'       => $validated['cabang_id'],
        'sumber_info_id'  => $validated['sumber_info_id'],
        'wilayah_daftar'  => $validated['wilayah_daftar'],
        'paket_haji'      => $validated['paket_haji'],
        'bpjs'            => $validated['bpjs'],
        'bank'            => $validated['bank'],
        'catatan'         => $validated['catatan'],
        'dokumen'         => json_encode($validated['dokumen'] ?? [], JSON_UNESCAPED_UNICODE),
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data berhasil diperbarui di kedua tabel');
  }

  /**
   * Remove the specified resource from storage.
   */

  public function destroy($id)
  {
    DB::transaction(function () use ($id) {
      $daftarHaji = TDaftarHaji::findOrFail($id);

      // Ambil ID customer sebelum menghapus
      $customerId = $daftarHaji->customer_id;

      // Hapus data di t_daftar_hajis
      $daftarHaji->delete();

      // Cek apakah masih ada data di t_daftar_hajis dengan customer_id yang sama
      $customerExists = TDaftarHaji::where('customer_id', $customerId)->exists();

      if (!$customerExists) {
        // Jika tidak ada lagi data di t_daftar_hajis untuk customer ini, hapus customer
        Customer::where('id', $customerId)->delete();
      }
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data Dihapus');
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

  public function search(Request $request)
  {
    $query = $request->input('query');

    // Ambil data no_porsi_haji beserta nama customer dari tabel relasi
    $daftarHaji = TDaftarHaji::whereHas('customer', function ($q) use ($query) {
      $q->where('nama', 'like', "%{$query}%");
    })
      ->orWhere('no_porsi_haji', 'like', "%{$query}%") // Bisa cari berdasarkan no_porsi_haji
      ->with('customer:id,nama') // Ambil hanya id dan nama dari tabel customer
      ->select('id', 'customer_id', 'no_porsi_haji')
      ->latest()
      ->get();

    return response()->json($daftarHaji);
  }

  public function repeatDataPendaftaran($id)
  {
    $daftar_haji = TDaftarHaji::with([
      'cabang',
      'wilayahDaftar',
      'sumberInfo',
      'customer'
    ])->findOrFail($id);

    // Pastikan relasi `customer` ada sebelum mengaksesnya
    $customer = $daftar_haji->customer ?? abort(404, 'Data pelanggan tidak ditemukan');

    // Decode dokumen dari JSON ke array, pastikan tidak null
    $selected_documents = json_decode($daftar_haji->dokumen, true) ?? [];

    return view('pendaftaran-haji.repeat-data', [
      'daftar_haji' => $daftar_haji,
      'customer' => $customer,
      'sumberInfo' => MSumberInfo::all(),
      'cabang' => MCabang::find($daftar_haji->cabang_id),
      'wilayahDaftar' => Kota::find($daftar_haji->wilayah_daftar),
      'dokumen' => MDokHaji::all(),
      'selected_documents' => $selected_documents,
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
      // Validasi untuk m_customers
      'nama'            => 'nullable|string|max:255',
      'no_hp_1'         => 'nullable|string|max:15',
      'no_hp_2'         => 'nullable|string|max:15',
      'tempat_lahir'    => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir'       => 'nullable|date',
      'jenis_id'        => 'nullable|string',
      'no_id'           => 'nullable|string',
      'jenis_kelamin'   => 'nullable|string',
      'status_nikah'    => 'nullable|string',
      'warga'           => 'nullable|string',
      'pekerjaan'       => 'nullable|string',
      'pendidikan'      => 'nullable|string',
      // Alamat KTP
      'alamat_ktp'      => 'nullable|string',
      'provinsi_ktp'    => 'nullable|exists:m_provinsis,id',
      'kota_ktp'        => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp'   => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp'   => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili'    => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',
      // Validasi untuk t_daftar_hajis
      'no_porsi_haji'   => 'nullable|numeric',
      'cabang_id'       => 'nullable|numeric|exists:m_cabangs,id',
      'sumber_info_id'  => 'nullable|numeric|exists:m_sumber_infos,id',
      'wilayah_daftar'  => 'nullable|numeric|exists:m_kotas,id',
      'paket_haji'      => 'nullable|string',
      'bpjs'            => 'nullable|string',
      'bank'            => 'nullable|string',
      'catatan'         => 'nullable|string',
      'dokumen'         => 'nullable|array',
      'dokumen.*'       => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($validated, $id) {
      // Ambil data customer berdasarkan ID dari tabel t_daftar_hajis
      $haji = TDaftarHaji::findOrFail($id);
      $customer = Customer::findOrFail($haji->customer_id);

      // Update data customer di m_customers
      $customer->update([
        'nama'             => strtoupper($validated['nama']),
        'no_hp_1'          => $validated['no_hp_1'],
        'no_hp_2'          => $validated['no_hp_2'],
        'tempat_lahir'     => $validated['tempat_lahir'],
        'tgl_lahir'        => $validated['tgl_lahir'],
        'jenis_id'         => $validated['jenis_id'],
        'no_id'            => $validated['no_id'],
        'jenis_kelamin'    => $validated['jenis_kelamin'],
        'status_nikah'     => $validated['status_nikah'],
        'warga'            => $validated['warga'],
        'pekerjaan'        => $validated['pekerjaan'],
        'pendidikan'       => $validated['pendidikan'],
        // Alamat KTP
        'alamat_ktp'       => $validated['alamat_ktp'],
        'provinsi_ktp'     => $validated['provinsi_ktp'],
        'kota_ktp'         => $validated['kota_ktp'],
        'kecamatan_ktp'    => $validated['kecamatan_ktp'],
        'kelurahan_ktp'    => $validated['kelurahan_ktp'],
        // Alamat Domisili
        'alamat_domisili'  => $validated['alamat_domisili'],
        'provinsi_domisili' => $validated['provinsi_domisili'],
        'kota_domisili'    => $validated['kota_domisili'],
        'kecamatan_domisili' => $validated['kecamatan_domisili'],
        'kelurahan_domisili' => $validated['kelurahan_domisili'],
      ]);

      // Simpan data baru ke dalam t_daftar_hajis
      TDaftarHaji::create([
        'customer_id'    => $customer->id,
        'no_porsi_haji'  => $validated['no_porsi_haji'],
        'cabang_id'      => $validated['cabang_id'],
        'sumber_info_id' => $validated['sumber_info_id'],
        'wilayah_daftar' => $validated['wilayah_daftar'],
        'paket_haji'     => $validated['paket_haji'],
        'bpjs'           => $validated['bpjs'],
        'bank'           => $validated['bank'],
        'catatan'        => $validated['catatan'],
        'dokumen'        => json_encode($validated['dokumen'] ?? [], JSON_UNESCAPED_UNICODE),
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data berhasil diperbarui dan disimpan ulang');
  }

  public function ambilSemuaData($id)
  {
    $daftar_haji = TDaftarHaji::with([
      'cabang',
      'wilayahDaftar',
      'sumberInfo',
      'customer'
    ])->findOrFail($id);

    // Pastikan relasi `customer` ada sebelum mengaksesnya
    $customer = $daftar_haji->customer ?? abort(404, 'Data pelanggan tidak ditemukan');

    // Decode dokumen dari JSON ke array, pastikan tidak null
    $selected_documents = json_decode($daftar_haji->dokumen, true) ?? [];

    return view('pendaftaran-haji.ambil-semua-data', [
      'daftar_haji' => $daftar_haji,
      'customer' => $customer,
      'sumberInfo' => MSumberInfo::all(),
      'cabang' => MCabang::find($daftar_haji->cabang_id),
      'wilayahDaftar' => Kota::find($daftar_haji->wilayah_daftar),
      'dokumen' => MDokHaji::all(),
      'selected_documents' => $selected_documents,
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
      // Validasi untuk m_customers
      'nama'           => 'required|string|max:255',
      'no_hp_1'        => 'required|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'required|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'required|date',
      'jenis_id'       => 'required|string',
      'no_id'          => 'required|integer|unique:m_customers,no_id',
      'jenis_kelamin'  => 'required|string',
      'status_nikah'   => 'required|string',
      'warga'          => 'required|string',
      'pekerjaan'      => 'required|string',
      'pendidikan'     => 'required|string',
      // wilayah sesuai KTP
      'alamat_ktp'     => 'required|string',
      'provinsi_ktp' => 'required|exists:m_provinsis,id',
      'kota_ktp' => 'required|exists:m_kotas,id',
      'kecamatan_ktp' => 'required|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'required|exists:m_kelurahans,id',
      // wilayah sesuai Domisili
      'alamat_domisili' => 'required|string',
      'provinsi_domisili' => 'required|exists:m_provinsis,id',
      'kota_domisili' => 'required|exists:m_kotas,id',
      'kecamatan_domisili' => 'required|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'required|exists:m_kelurahans,id',

      // Validasi untuk t_daftar_hajis
      'no_porsi_haji' => 'required|numeric',
      'cabang_id' => 'required|exists:m_cabangs,id',
      'sumber_info_id' => 'required|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'required|exists:m_kotas,id',
      'paket_haji' => 'required|string',
      'bpjs' => 'required|string',
      'bank' => 'required|string',
      'catatan' => 'nullable|string',
      'dokumen' => 'array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    // Gunakan transaksi agar penyimpanan ke dua tabel berjalan bersama-sama
    DB::transaction(function () use ($validated) {
      // Simpan data pelanggan ke m_customers
      $customer = Customer::create([
        'nama' => strtoupper($validated['nama']),
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

      // Simpan data pendaftaran haji ke t_daftar_hajis
      TDaftarHaji::create([
        'customer_id' => $customer->id, // Ambil ID dari m_customers yang baru saja dibuat
        'no_porsi_haji' => $validated['no_porsi_haji'],
        'cabang_id' => $validated['cabang_id'],
        'sumber_info_id' => $validated['sumber_info_id'],
        'wilayah_daftar' => $validated['wilayah_daftar'],
        'paket_haji' => $validated['paket_haji'],
        'bpjs' => $validated['bpjs'],
        'bank' => $validated['bank'],
        'catatan' => $validated['catatan'],
        'dokumen' => json_encode($validated['dokumen'], JSON_UNESCAPED_UNICODE),
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data Tersimpan di kedua tabel');
  }
}
