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
use Illuminate\Support\Facades\Log;

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
      'provinsi' => Provinsi::all()->keyBy('id'), // Ubah ke associative array
      'kota' => $kota->keyBy('id'), // Ubah ke associative array
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
      'alamat_ktp' => 'nullable|string',
      'alamat_domisili' => 'nullable|string',
      'provinsi_ktp_id' => 'nullable|exists:m_provinsis,id',
      'kota_ktp_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'nullable|exists:m_kelurahans,id',
      'provinsi_domisili_id' => 'nullable|exists:m_provinsis,id',
      'kota_domisili_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'nullable|exists:m_kelurahans,id',
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

  public function edit(TGabungHaji $tGabungHaji, $id)
  {
    // Sama seperti function ambilSemuaData: Load semua relasi dalam satu query
    $gabung_haji = TGabungHaji::with([
      'customer.kotaLahir',
      'customer.kelurahan',
      'customer.kecamatan',
      'customer.kota',
      'customer.provinsi'
    ])->find($id);

    if (!$gabung_haji) {
      return redirect()->route('gabung-haji.index')->with('error', 'Data tidak ditemukan.');
    }

    $customer = $gabung_haji->customer;

    // ====================== Ambil Semua Data Wilayah Sekaligus (Hanya 1 Query per Model) ======================
    $provinsi = Provinsi::all();
    $kota = Kota::all();
    $kecamatan = Kecamatan::all();
    $kelurahan = Kelurahan::all();

    // ====================== Data Pendukung ======================
    $data = [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'cabang' => MCabang::all(),
      'kotaBank' => $kota,
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

    return view('gabung-haji.edit', $data);
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
      'alamat_ktp' => 'nullable|string',
      'alamat_domisili' => 'nullable|string',
      'provinsi_ktp_id' => 'nullable|exists:m_provinsis,id',
      'kota_ktp_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'nullable|exists:m_kelurahans,id',
      'provinsi_domisili_id' => 'nullable|exists:m_provinsis,id',
      'kota_domisili_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'nullable|exists:m_kelurahans,id',
      'no_spph' => 'nullable|integer',
      'no_porsi' => 'nullable|integer',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|string',
      'catatan' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated, $id) {
      // Temukan data TGabungHaji berdasarkan ID
      $gabung_haji = TGabungHaji::findOrFail($id);

      // Temukan customer yang terkait
      $customer = Customer::findOrFail($gabung_haji->customer_id);

      // Update data Customer
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

      // Update data TGabungHaji
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
    // Sama seperti function sebelumnya: Load semua relasi dalam satu query
    $gabung_haji = TGabungHaji::with([
      'customer.kotaLahir',
      'customer.kelurahan',
      'customer.kecamatan',
      'customer.kota',
      'customer.provinsi'
    ])->find($id);

    if (!$gabung_haji) {
      return redirect()->route('gabung-haji.index')->with('error', 'Data tidak ditemukan.');
    }

    $customer = $gabung_haji->customer;

    // ====================== Ambil Semua Data Wilayah Sekaligus (Hanya 1 Query per Model) ======================
    $provinsi = Provinsi::all();
    $kota = Kota::all();
    $kecamatan = Kecamatan::all();
    $kelurahan = Kelurahan::all();

    // ====================== Data Pendukung ======================
    $data = [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'cabang' => MCabang::all(),
      'kotaBank' => $kota,
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

    return view('gabung-haji.repeat-data', $data);
  }


  public function storeRepeatData(Request $request, $id)
  {
    // Cek apakah ID yang diterima ada di TGabungHaji
    $gabungHaji = TGabungHaji::find($id);

    if (!$gabungHaji) {
      abort(404, "Data Gabung Haji tidak ditemukan.");
    }

    // Cari customer berdasarkan customer_id dari TGabungHaji
    $customer = Customer::find($gabungHaji->customer_id);

    if (!$customer) {
      abort(404, "Customer tidak ditemukan.");
    }

    // Validasi input form
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
      'alamat_ktp' => 'nullable|string',
      'alamat_domisili' => 'nullable|string',
      'provinsi_ktp_id' => 'nullable|exists:m_provinsis,id',
      'kota_ktp_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'nullable|exists:m_kelurahans,id',
      'provinsi_domisili_id' => 'nullable|exists:m_provinsis,id',
      'kota_domisili_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'nullable|exists:m_kelurahans,id',
      'no_spph' => 'nullable|integer',
      'no_porsi' => 'nullable|integer',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|string',
      'catatan' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated, $customer) {
      // Update data customer di `m_customers`
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

      // Tambahkan data baru ke `t_gabung_hajis`
      TGabungHaji::create([
        'customer_id' => $customer->id, // Gunakan ID customer yang sudah ada
        'no_spph' => $validated['no_spph'],
        'no_porsi' => $validated['no_porsi'],
        'nama_bank' => $validated['nama_bank'],
        'kota_bank' => $validated['kota_bank'],
        'depag' => $validated['depag'],
        'catatan' => $validated['catatan'],
      ]);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil disimpan ulang!');
  }

  public function ambilSemuaData($id)
  {
    // Sama seperti function lainnya: Load semua relasi dalam satu query
    $gabung_haji = TGabungHaji::with([
      'customer.kotaLahir',
      'customer.kelurahan',
      'customer.kecamatan',
      'customer.kota',
      'customer.provinsi'
    ])->find($id);

    if (!$gabung_haji) {
      return redirect()->route('gabung-haji.index')->with('error', 'Data tidak ditemukan.');
    }

    $customer = $gabung_haji->customer;

    // ====================== Ambil Semua Data Wilayah Sekaligus ======================
    $provinsi = Provinsi::all();
    $kota = Kota::all();
    $kecamatan = Kecamatan::all();
    $kelurahan = Kelurahan::all();

    // ====================== Data Pendukung ======================
    $data = [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'customers' => Customer::all(),
      'cabang' => MCabang::all(),
      'kotaBank' => $kota,
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

    return view('gabung-haji.ambil-semua-data', $data);
  }

  public function storeAmbilSemuaData(Request $request)
  {
    // Validasi input form
    $validated = $request->validate([
      'nama' => 'required|string|max:255',
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
      'alamat_ktp' => 'nullable|string',
      'alamat_domisili' => 'nullable|string',
      'provinsi_ktp_id' => 'nullable|exists:m_provinsis,id',
      'kota_ktp_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'nullable|exists:m_kelurahans,id',
      'provinsi_domisili_id' => 'nullable|exists:m_provinsis,id',
      'kota_domisili_id' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'nullable|exists:m_kelurahans,id',
      'no_spph' => 'nullable|integer',
      'no_porsi' => 'nullable|integer',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|string',
      'catatan' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated) {
      // Simpan data baru ke `m_customers`
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

      // Simpan data baru ke `t_gabung_hajis`
      TGabungHaji::create([
        'customer_id' => $customer->id, // Ambil ID dari customer yang baru dibuat
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
