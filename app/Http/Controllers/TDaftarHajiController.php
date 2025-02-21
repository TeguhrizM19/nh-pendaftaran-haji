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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
      // Validasi untuk m_customers
      'nama'           => 'nullable|string|max:255',
      'no_hp_1'        => 'required|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'required|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'required|date',
      'jenis_id'       => 'required|string',
      'no_id'          => 'required|string',
      'jenis_kelamin'  => 'required|string',
      'status_nikah'   => 'required|string',
      'warga'          => 'required|string',
      'pekerjaan'      => 'required|string',
      'pendidikan'     => 'required|string',
      'alamat_ktp'     => 'nullable|string',
      'alamat_domisili' => 'nullable|string',
      // wilayah sesuai KTP
      'provinsi_ktp_id' => 'required|exists:m_provinsis,id',
      'kota_ktp_id' => 'required|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'required|exists:m_kelurahans,id',
      // wilayah sesuai Domisili
      'provinsi_domisili_id' => 'required|exists:m_provinsis,id',
      'kota_domisili_id' => 'required|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'required|exists:m_kelurahans,id',

      // Validasi untuk t_daftar_hajis
      'no_porsi_haji' => 'required|numeric',
      'cabang_id' => 'required|exists:m_cabangs,id',
      'sumber_info_id' => 'required|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'required|exists:m_kotas,id',
      'paket_haji' => 'nullable|string',
      'bpjs' => 'nullable|string',
      'bank' => 'nullable|string',
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
        'alamat_ktp' => json_encode([
          'alamat' => $validated['alamat_ktp'],
          'provinsi_id' => $validated['provinsi_ktp_id'],
          'kota_id' => $validated['kota_ktp_id'],
          'kecamatan_id' => $validated['kecamatan_ktp_id'],
          'kelurahan_id' => $validated['kelurahan_ktp_id'],
        ]),
        'alamat_domisili' => json_encode([
          'alamat' => $validated['alamat_domisili'],
          'provinsi_id' => $validated['provinsi_domisili_id'],
          'kota_id' => $validated['kota_domisili_id'],
          'kecamatan_id' => $validated['kecamatan_domisili_id'],
          'kelurahan_id' => $validated['kelurahan_domisili_id'],
        ]),
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
    $daftar_haji = TDaftarHaji::with('customer.kotaLahir')->find($id);

    if (!$daftar_haji) {
      return redirect()->route('pendaftaran-haji.index')->with('error', 'Data tidak ditemukan.');
    }

    $customer = $daftar_haji->customer;

    // ====================== Data Pendukung ======================
    $customers = Customer::all();
    $cabang = MCabang::all();
    $wilayahKota = Kota::all();
    $sumberInfo = MSumberInfo::all();
    $dokumen = MDokHaji::all();
    $tempat_lahir = Kota::all();
    $provinsi = Provinsi::all();
    $kota = Kota::all();
    $kecamatan = Kecamatan::all();
    $kelurahan = Kelurahan::all();

    // Konversi dokumen dari JSON ke array jika diperlukan
    $selected_documents = json_decode($daftar_haji->dokumen, true) ?? [];

    // ====================== Alamat Sesuai KTP ======================
    $alamat_ktp = $customer->alamat_ktp;
    if (!is_array($alamat_ktp)) {
      $alamat_ktp = json_decode($alamat_ktp, true) ?? [];
    }

    $provinsi_id = $alamat_ktp['provinsi_id'] ?? null;
    $kota_id = $alamat_ktp['kota_id'] ?? null;
    $kecamatan_id = $alamat_ktp['kecamatan_id'] ?? null;
    $kelurahan_id = $alamat_ktp['kelurahan_id'] ?? null;

    $provinsi_selected = Provinsi::find($provinsi_id);
    $kota_selected = Kota::find($kota_id);
    $kecamatan_selected = Kecamatan::find($kecamatan_id);
    $kelurahan_selected = Kelurahan::find($kelurahan_id);

    $kode_pos = optional($kelurahan_selected)->kode_pos ?? optional($customer->kelurahan)->kode_pos ?? '';

    // ====================== Alamat Domisili ======================
    $alamat_domisili = $customer->alamat_domisili;
    if (!is_array($alamat_domisili)) {
      $alamat_domisili = json_decode($alamat_domisili, true) ?? [];
    }

    $provinsi_domisili = optional(Provinsi::find($alamat_domisili['provinsi_id'] ?? null));
    $kota_domisili = optional(Kota::find($alamat_domisili['kota_id'] ?? null));
    $kecamatan_domisili = optional(Kecamatan::find($alamat_domisili['kecamatan_id'] ?? null));
    $kelurahan_domisili = optional(Kelurahan::find($alamat_domisili['kelurahan_id'] ?? null));

    $kode_pos_domisili = optional($kelurahan_domisili)->kode_pos ?? '';

    return view('pendaftaran-haji.edit', compact(
      'tempat_lahir',
      'daftar_haji',
      'customer',
      'customers',
      'cabang',
      'wilayahKota',
      'sumberInfo',
      'dokumen',
      'selected_documents',
      'alamat_ktp',
      'provinsi',
      'provinsi_selected',
      'kota',
      'kota_selected',
      'kecamatan_selected',
      'kecamatan',
      'kelurahan_selected',
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
    $validated = $request->validate([
      // Validasi untuk m_customers
      'nama'           => 'nullable|string|max:255',
      'no_hp_1'        => 'nullable|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'nullable|date',
      'jenis_id'       => 'nullable|string',
      'no_id'          => 'nullable|string',
      'jenis_kelamin'  => 'nullable|string',
      'status_nikah'   => 'nullable|string',
      'warga'          => 'nullable|string',
      'pekerjaan'      => 'nullable|string',
      'pendidikan'     => 'nullable|string',
      'alamat_ktp'     => 'nullable|string',
      'alamat_domisili' => 'nullable|string',
      // wilayah sesuai KTP
      'provinsi_ktp_id' => 'nullable|exists:m_provinsis,id',
      'kota_ktp_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'nullable|exists:m_kelurahans,id',
      // wilayah sesuai Domisili
      'provinsi_domisili_id' => 'nullable|exists:m_provinsis,id',
      'kota_domisili_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'nullable|exists:m_kelurahans,id',

      // Validasi untuk t_daftar_hajis
      'no_porsi_haji' => 'nullable|numeric',
      'cabang_id' => 'nullable|exists:m_cabangs,id',
      'sumber_info_id' => 'nullable|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'nullable|exists:m_kotas,id',
      'paket_haji' => 'nullable|string',
      'bpjs' => 'nullable|string',
      'bank' => 'nullable|string',
      'catatan' => 'nullable|string',
      'dokumen' => 'array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    // Gunakan transaksi agar update ke dua tabel berjalan bersama-sama
    DB::transaction(function () use ($validated, $id) {
      // Cari data t_daftar_hajis berdasarkan ID
      $daftarHaji = TDaftarHaji::findOrFail($id);

      // Cari data pelanggan di m_customers berdasarkan customer_id dari t_daftar_hajis
      $customer = Customer::findOrFail($daftarHaji->customer_id);

      // Update data pelanggan di m_customers
      $customer->update([
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
        'alamat_ktp' => json_encode([
          'alamat' => $validated['alamat_ktp'],
          'provinsi_id' => $validated['provinsi_ktp_id'],
          'kota_id' => $validated['kota_ktp_id'],
          'kecamatan_id' => $validated['kecamatan_ktp_id'],
          'kelurahan_id' => $validated['kelurahan_ktp_id'],
        ]),
        'alamat_domisili' => json_encode([
          'alamat' => $validated['alamat_domisili'],
          'provinsi_id' => $validated['provinsi_domisili_id'],
          'kota_id' => $validated['kota_domisili_id'],
          'kecamatan_id' => $validated['kecamatan_domisili_id'],
          'kelurahan_id' => $validated['kelurahan_domisili_id'],
        ]),
      ]);

      // Update data pendaftaran haji di t_daftar_hajis
      $daftarHaji->update([
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

    return redirect('/pendaftaran-haji')->with('success', 'Data Berhasil Diperbarui di kedua tabel');
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
      ->get();

    return response()->json($daftarHaji);
  }

  public function repeatDataPendaftaran($id)
  {
    $daftar_haji = TDaftarHaji::with('customer.kotaLahir')->find($id);

    if (!$daftar_haji) {
      return redirect()->route('pendaftaran-haji.index')->with('error', 'Data tidak ditemukan.');
    }

    $customer = $daftar_haji->customer;

    // ====================== Data Pendukung ======================
    $customers = Customer::all();
    $cabang = MCabang::all();
    $wilayahKota = Kota::all();
    $sumberInfo = MSumberInfo::all();
    $dokumen = MDokHaji::all();
    $tempat_lahir = Kota::all();
    $provinsi = Provinsi::all();
    $kota = Kota::all();
    $kecamatan = Kecamatan::all();
    $kelurahan = Kelurahan::all();

    // Konversi dokumen dari JSON ke array jika diperlukan
    $selected_documents = json_decode($daftar_haji->dokumen, true) ?? [];

    // ====================== Alamat Sesuai KTP ======================
    $alamat_ktp = $customer->alamat_ktp;
    if (!is_array($alamat_ktp)) {
      $alamat_ktp = json_decode($alamat_ktp, true) ?? [];
    }

    $provinsi_id = $alamat_ktp['provinsi_id'] ?? null;
    $kota_id = $alamat_ktp['kota_id'] ?? null;
    $kecamatan_id = $alamat_ktp['kecamatan_id'] ?? null;
    $kelurahan_id = $alamat_ktp['kelurahan_id'] ?? null;

    $provinsi_selected = Provinsi::find($provinsi_id);
    $kota_selected = Kota::find($kota_id);
    $kecamatan_selected = Kecamatan::find($kecamatan_id);
    $kelurahan_selected = Kelurahan::find($kelurahan_id);

    $kode_pos = optional($kelurahan_selected)->kode_pos ?? optional($customer->kelurahan)->kode_pos ?? '';

    // ====================== Alamat Domisili ======================
    $alamat_domisili = $customer->alamat_domisili;
    if (!is_array($alamat_domisili)) {
      $alamat_domisili = json_decode($alamat_domisili, true) ?? [];
    }

    $provinsi_domisili = optional(Provinsi::find($alamat_domisili['provinsi_id'] ?? null));
    $kota_domisili = optional(Kota::find($alamat_domisili['kota_id'] ?? null));
    $kecamatan_domisili = optional(Kecamatan::find($alamat_domisili['kecamatan_id'] ?? null));
    $kelurahan_domisili = optional(Kelurahan::find($alamat_domisili['kelurahan_id'] ?? null));

    $kode_pos_domisili = optional($kelurahan_domisili)->kode_pos ?? '';

    return view('pendaftaran-haji.repeat-data', compact(
      'tempat_lahir',
      'daftar_haji',
      'customer',
      'customers',
      'cabang',
      'wilayahKota',
      'sumberInfo',
      'dokumen',
      'selected_documents',
      'alamat_ktp',
      'provinsi',
      'provinsi_selected',
      'kota',
      'kota_selected',
      'kecamatan_selected',
      'kecamatan',
      'kelurahan_selected',
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

  public function storeRepeatData(Request $request, $id)
  {
    // Validasi request
    $validated = $request->validate([
      // Validasi untuk m_customers
      'nama'           => 'nullable|string|max:255',
      'no_hp_1'        => 'required|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'required|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'required|date',
      'jenis_id'       => 'required|string',
      'no_id'          => 'required|string',
      'jenis_kelamin'  => 'required|string',
      'status_nikah'   => 'required|string',
      'warga'          => 'required|string',
      'pekerjaan'      => 'required|string',
      'pendidikan'     => 'required|string',
      'alamat_ktp'     => 'nullable|string',
      'alamat_domisili' => 'nullable|string',
      // Wilayah sesuai KTP
      'provinsi_ktp_id' => 'required|exists:m_provinsis,id',
      'kota_ktp_id' => 'required|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'required|exists:m_kelurahans,id',
      // Wilayah sesuai Domisili
      'provinsi_domisili_id' => 'required|exists:m_provinsis,id',
      'kota_domisili_id' => 'required|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'required|exists:m_kelurahans,id',

      // Validasi untuk t_daftar_hajis
      'no_porsi_haji' => 'required|numeric',
      'paket_haji' => 'nullable|string',
      'bpjs' => 'nullable|string',
      'bank' => 'nullable|string',
      'catatan' => 'nullable|string',
      'dokumen' => 'array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    // Gunakan transaksi untuk menjaga integritas data
    DB::transaction(function () use ($validated, $id) {
      // Cari data t_daftar_hajis berdasarkan ID
      $daftarHaji = TDaftarHaji::findOrFail($id);

      // Cari data pelanggan di m_customers berdasarkan customer_id dari t_daftar_hajis
      $customer = Customer::findOrFail($daftarHaji->customer_id);

      // Update data pelanggan di m_customers
      $customer->update([
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
        'alamat_ktp' => json_encode([
          'alamat' => $validated['alamat_ktp'],
          'provinsi_id' => $validated['provinsi_ktp_id'],
          'kota_id' => $validated['kota_ktp_id'],
          'kecamatan_id' => $validated['kecamatan_ktp_id'],
          'kelurahan_id' => $validated['kelurahan_ktp_id'],
        ]),
        'alamat_domisili' => json_encode([
          'alamat' => $validated['alamat_domisili'],
          'provinsi_id' => $validated['provinsi_domisili_id'],
          'kota_id' => $validated['kota_domisili_id'],
          'kecamatan_id' => $validated['kecamatan_domisili_id'],
          'kelurahan_id' => $validated['kelurahan_domisili_id'],
        ]),
      ]);

      // Simpan data baru ke t_daftar_hajis
      TDaftarHaji::create([
        'customer_id' => $customer->id,
        'cabang_id' => $daftarHaji->cabang_id,
        'sumber_info_id' => $daftarHaji->sumber_info_id,
        'wilayah_daftar' => $daftarHaji->wilayah_daftar,
        'no_porsi_haji' => $validated['no_porsi_haji'],
        'paket_haji' => $validated['paket_haji'],
        'bpjs' => $validated['bpjs'],
        'bank' => $validated['bank'],
        'catatan' => $validated['catatan'],
        'dokumen' => json_encode($validated['dokumen'], JSON_UNESCAPED_UNICODE),
        // 'create_user' => auth()->user()->name ?? 'System',
        // 'create_date' => now(),
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data Repeat Berhasil Ditambahkan.');
  }

  public function ambilSemuaData($id)
  {
    $daftar_haji = TDaftarHaji::with('customer.kotaLahir')->find($id);

    if (!$daftar_haji) {
      return redirect()->route('pendaftaran-haji.index')->with('error', 'Data tidak ditemukan.');
    }

    $customer = $daftar_haji->customer;

    // ====================== Data Pendukung ======================
    $customers = Customer::all();
    $cabang = MCabang::all();
    $wilayahKota = Kota::all();
    $sumberInfo = MSumberInfo::all();
    $dokumen = MDokHaji::all();
    $tempat_lahir = Kota::all();
    $provinsi = Provinsi::all();
    $kota = Kota::all();
    $kecamatan = Kecamatan::all();
    $kelurahan = Kelurahan::all();

    // Konversi dokumen dari JSON ke array jika diperlukan
    $selected_documents = json_decode($daftar_haji->dokumen, true) ?? [];

    // ====================== Alamat Sesuai KTP ======================
    $alamat_ktp = $customer->alamat_ktp;
    if (!is_array($alamat_ktp)) {
      $alamat_ktp = json_decode($alamat_ktp, true) ?? [];
    }

    $provinsi_id = $alamat_ktp['provinsi_id'] ?? null;
    $kota_id = $alamat_ktp['kota_id'] ?? null;
    $kecamatan_id = $alamat_ktp['kecamatan_id'] ?? null;
    $kelurahan_id = $alamat_ktp['kelurahan_id'] ?? null;

    $provinsi_selected = Provinsi::find($provinsi_id);
    $kota_selected = Kota::find($kota_id);
    $kecamatan_selected = Kecamatan::find($kecamatan_id);
    $kelurahan_selected = Kelurahan::find($kelurahan_id);

    $kode_pos = optional($kelurahan_selected)->kode_pos ?? optional($customer->kelurahan)->kode_pos ?? '';

    // ====================== Alamat Domisili ======================
    $alamat_domisili = $customer->alamat_domisili;
    if (!is_array($alamat_domisili)) {
      $alamat_domisili = json_decode($alamat_domisili, true) ?? [];
    }

    $provinsi_domisili = optional(Provinsi::find($alamat_domisili['provinsi_id'] ?? null));
    $kota_domisili = optional(Kota::find($alamat_domisili['kota_id'] ?? null));
    $kecamatan_domisili = optional(Kecamatan::find($alamat_domisili['kecamatan_id'] ?? null));
    $kelurahan_domisili = optional(Kelurahan::find($alamat_domisili['kelurahan_id'] ?? null));

    $kode_pos_domisili = optional($kelurahan_domisili)->kode_pos ?? '';

    return view('pendaftaran-haji.ambil-semua-data', compact(
      'tempat_lahir',
      'daftar_haji',
      'customer',
      'customers',
      'cabang',
      'wilayahKota',
      'sumberInfo',
      'dokumen',
      'selected_documents',
      'alamat_ktp',
      'provinsi',
      'provinsi_selected',
      'kota',
      'kota_selected',
      'kecamatan_selected',
      'kecamatan',
      'kelurahan_selected',
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

  public function storeAmbilSemuaData(Request $request, $id)
  {
    // Validasi request
    $validated = $request->validate([
      // Validasi untuk m_customers
      'nama'           => 'nullable|string|max:255',
      'no_hp_1'        => 'required|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'required|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'required|date',
      'jenis_id'       => 'required|string',
      'no_id'          => 'required|string|unique:m_customers,no_id',
      'jenis_kelamin'  => 'required|string',
      'status_nikah'   => 'required|string',
      'warga'          => 'required|string',
      'pekerjaan'      => 'required|string',
      'pendidikan'     => 'required|string',
      'alamat_ktp'     => 'nullable|string',
      'alamat_domisili' => 'nullable|string',
      // Wilayah sesuai KTP
      'provinsi_ktp_id' => 'required|exists:m_provinsis,id',
      'kota_ktp_id' => 'required|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'required|exists:m_kelurahans,id',
      // Wilayah sesuai Domisili
      'provinsi_domisili_id' => 'required|exists:m_provinsis,id',
      'kota_domisili_id' => 'required|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'required|exists:m_kelurahans,id',

      // Validasi untuk t_daftar_hajis
      'no_porsi_haji' => 'required|numeric|unique:t_daftar_hajis,no_porsi_haji',
      'paket_haji' => 'nullable|string',
      'bpjs' => 'nullable|string',
      'bank' => 'nullable|string',
      'catatan' => 'nullable|string',
      'dokumen' => 'array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    // Gunakan transaksi untuk menjaga integritas data
    DB::transaction(function () use ($validated) {
      // Buat data baru di tabel m_customers
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
        'alamat_ktp' => json_encode([
          'alamat' => $validated['alamat_ktp'],
          'provinsi_id' => $validated['provinsi_ktp_id'],
          'kota_id' => $validated['kota_ktp_id'],
          'kecamatan_id' => $validated['kecamatan_ktp_id'],
          'kelurahan_id' => $validated['kelurahan_ktp_id'],
        ]),
        'alamat_domisili' => json_encode([
          'alamat' => $validated['alamat_domisili'],
          'provinsi_id' => $validated['provinsi_domisili_id'],
          'kota_id' => $validated['kota_domisili_id'],
          'kecamatan_id' => $validated['kecamatan_domisili_id'],
          'kelurahan_id' => $validated['kelurahan_domisili_id'],
        ]),
      ]);

      // Simpan data baru ke tabel t_daftar_hajis
      TDaftarHaji::create([
        'customer_id' => $customer->id, // Menggunakan ID customer yang baru dibuat
        'no_porsi_haji' => $validated['no_porsi_haji'],
        'paket_haji' => $validated['paket_haji'],
        'bpjs' => $validated['bpjs'],
        'bank' => $validated['bank'],
        'catatan' => $validated['catatan'],
        'dokumen' => json_encode($validated['dokumen'], JSON_UNESCAPED_UNICODE),
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data berhasil ditambahkan.');
  }
}
