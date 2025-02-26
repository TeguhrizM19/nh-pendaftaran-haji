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

  public function searchCabang(Request $request)
  {
    $query = $request->q;

    // Cari cabang yang namanya mengandung teks yang diketik
    $cabang = MCabang::where('cabang', 'LIKE', "%$query%")
      ->select('id', 'cabang')
      ->limit(10) // Batasi hasil agar tidak terlalu banyak
      ->get();

    return response()->json($cabang);
  }

  public function searchWilayah(Request $request)
  {
    $query = $request->q;

    // Cari wilayah (kota) yang namanya mengandung teks yang diketik
    $wilayah = Kota::where('kota', 'LIKE', "%$query%")
      ->select('id', 'kota')
      ->limit(10) // Batasi hasil agar tidak terlalu banyak
      ->get();

    return response()->json($wilayah);
  }

  public function searchTempatLhr(Request $request)
  {
    $search = $request->q;

    $data = Kota::select('id', 'kota')
      ->where('kota', 'like', "%{$search}%")
      ->limit(10) // Batasi hasil agar tidak terlalu berat
      ->get();

    return response()->json($data);
  }

  public function searchProvinsi(Request $request)
  {
    $search = $request->input('q');

    $provinsi = Provinsi::where('provinsi', 'LIKE', "%$search%")
      ->select('id', 'provinsi')
      ->limit(10)
      ->get();

    return response()->json($provinsi);
  }

  public function searchKota(Request $request, $provinsi_id)
  {
    $search = $request->input('q');

    $kota = Kota::where('provinsi_id', $provinsi_id) // Pastikan ini benar
      ->where('kota', 'LIKE', "%$search%")
      ->select('id', 'kota')
      ->limit(10)
      ->get();

    return response()->json($kota);
  }

  public function searchKecamatan(Request $request, $kota_id)
  {
    $search = $request->input('q'); // Ambil keyword pencarian

    $kecamatan = Kecamatan::where('kota_id', $kota_id)
      ->where('kecamatan', 'LIKE', "%$search%") // Bisa mencari kecamatan juga
      ->select('id', 'kecamatan')
      ->limit(10) // Batasi hasil agar respons lebih cepat
      ->get();

    return response()->json($kecamatan);
  }

  public function searchKelurahan(Request $request, $kecamatan_id)
  {
    $search = $request->input('q'); // Ambil keyword pencarian

    $kelurahan = Kelurahan::where('kecamatan_id', $kecamatan_id)
      ->where('kelurahan', 'LIKE', "%$search%")
      ->select('id', 'kelurahan')
      ->limit(10)
      ->get();

    return response()->json($kelurahan);
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
      'customer.kotaLahir',
      'customer.kelurahan',
      'customer.kecamatan',
      'customer.kota',
      'customer.provinsi',
      'cabang',
      'sumberInfo'
    ])->find($id);

    if (!$daftar_haji) {
      return redirect()->route('pendaftaran-haji.index')->with('error', 'Data tidak ditemukan.');
    }

    $customer = $daftar_haji->customer;

    // Mengambil semua data wilayah dalam satu query untuk menghindari query berulang
    $kota = Kota::all();
    $provinsi = Provinsi::all();
    $kecamatan = Kecamatan::all();
    $kelurahan = Kelurahan::all();

    // ====================== Data Pendukung ======================
    $data = [
      'cabang' => MCabang::all(),
      'sumberInfo' => MSumberInfo::all(),
      'dokumen' => MDokHaji::all(),
      'daftar_haji' => $daftar_haji,
      'customer' => $customer,
      'wilayahKota' => $kota,
      'tempat_lahir' => $kota,
      'provinsi' => $provinsi,
      'kota' => $kota,
      'kecamatan' => $kecamatan,
      'kelurahan' => $kelurahan,
      'selected_documents' => json_decode($daftar_haji->dokumen, true) ?? []
    ];

    // ====================== Alamat Sesuai KTP ======================
    $alamat_ktp = json_decode($customer->alamat_ktp, true) ?? [];
    $data['alamat_ktp'] = $alamat_ktp;
    $data['provinsi_selected'] = $customer->provinsi ?? $provinsi->firstWhere('id', $alamat_ktp['provinsi_id'] ?? null);
    $data['kota_selected'] = $customer->kota ?? $kota->firstWhere('id', $alamat_ktp['kota_id'] ?? null);
    $data['kecamatan_selected'] = $customer->kecamatan ?? $kecamatan->firstWhere('id', $alamat_ktp['kecamatan_id'] ?? null);
    $data['kelurahan_selected'] = $customer->kelurahan ?? $kelurahan->firstWhere('id', $alamat_ktp['kelurahan_id'] ?? null);
    $data['kode_pos'] = optional($data['kelurahan_selected'])->kode_pos ?? '';

    // ====================== Alamat Domisili ======================
    $alamat_domisili = json_decode($customer->alamat_domisili, true) ?? [];
    $data['alamat_domisili'] = $alamat_domisili;
    $data['provinsi_domisili'] = $provinsi->firstWhere('id', $alamat_domisili['provinsi_id'] ?? null);
    $data['kota_domisili'] = $kota->firstWhere('id', $alamat_domisili['kota_id'] ?? null);
    $data['kecamatan_domisili'] = $kecamatan->firstWhere('id', $alamat_domisili['kecamatan_id'] ?? null);
    $data['kelurahan_domisili'] = $kelurahan->firstWhere('id', $alamat_domisili['kelurahan_id'] ?? null);
    $data['kode_pos_domisili'] = optional($data['kelurahan_domisili'])->kode_pos ?? '';

    return view('pendaftaran-haji.repeat-data', $data);
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
    // Sama seperti function edit: Load semua relasi dalam satu query
    $daftar_haji = TDaftarHaji::with([
      'customer.kotaLahir',
      'customer.kelurahan',
      'customer.kecamatan',
      'customer.kota',
      'customer.provinsi',
      'cabang',
      'sumberInfo'
    ])->find($id);

    if (!$daftar_haji) {
      return redirect()->route('pendaftaran-haji.index')->with('error', 'Data tidak ditemukan.');
    }

    $customer = $daftar_haji->customer;

    // ====================== Ambil Semua Data Wilayah Sekaligus (Hanya 1 Query per Model) ======================
    $provinsi = Provinsi::all();
    $kota = Kota::all();
    $kecamatan = Kecamatan::all();
    $kelurahan = Kelurahan::all();

    // ====================== Data Pendukung ======================
    $data = [
      'daftar_haji' => $daftar_haji,
      'customer' => $customer,
      'cabang' => MCabang::all(),
      'sumberInfo' => MSumberInfo::all(),
      'dokumen' => MDokHaji::all(),
      'selected_documents' => json_decode($daftar_haji->dokumen, true) ?? [],
      'wilayahKota' => $kota,
      'tempat_lahir' => $kota,
      'provinsi' => $provinsi,
      'kota' => $kota,
      'kecamatan' => $kecamatan,
      'kelurahan' => $kelurahan,
    ];

    // ====================== Alamat Sesuai KTP ======================
    $alamat_ktp = json_decode($customer->alamat_ktp, true) ?? [];
    $data['alamat_ktp'] = $alamat_ktp;
    $data['provinsi_selected'] = $customer->provinsi ?? $provinsi->firstWhere('id', $alamat_ktp['provinsi_id'] ?? null);
    $data['kota_selected'] = $customer->kota ?? $kota->firstWhere('id', $alamat_ktp['kota_id'] ?? null);
    $data['kecamatan_selected'] = $customer->kecamatan ?? $kecamatan->firstWhere('id', $alamat_ktp['kecamatan_id'] ?? null);
    $data['kelurahan_selected'] = $customer->kelurahan ?? $kelurahan->firstWhere('id', $alamat_ktp['kelurahan_id'] ?? null);
    $data['kode_pos'] = optional($data['kelurahan_selected'])->kode_pos ?? '';

    // ====================== Alamat Domisili ======================
    $alamat_domisili = json_decode($customer->alamat_domisili, true) ?? [];
    $data['alamat_domisili'] = $alamat_domisili;
    $data['provinsi_domisili'] = $provinsi->firstWhere('id', $alamat_domisili['provinsi_id'] ?? null);
    $data['kota_domisili'] = $kota->firstWhere('id', $alamat_domisili['kota_id'] ?? null);
    $data['kecamatan_domisili'] = $kecamatan->firstWhere('id', $alamat_domisili['kecamatan_id'] ?? null);
    $data['kelurahan_domisili'] = $kelurahan->firstWhere('id', $alamat_domisili['kelurahan_id'] ?? null);
    $data['kode_pos_domisili'] = optional($data['kelurahan_domisili'])->kode_pos ?? '';

    return view('pendaftaran-haji.ambil-semua-data', $data);
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
    DB::transaction(function () use ($validated, $id) {
      $daftarHaji = TDaftarHaji::findOrFail($id);
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
        'cabang_id' => $daftarHaji->cabang_id,
        'sumber_info_id' => $daftarHaji->sumber_info_id,
        'wilayah_daftar' => $daftarHaji->wilayah_daftar,
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
