<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Customer;
use App\Models\MDokHaji;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\GroupKeberangkatan;
use Illuminate\Support\Facades\DB;

class TGabungHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function index(Request $request)
  {
    $query = TGabungHaji::with(['customer', 'daftarHaji', 'keberangkatan']);

    // Cek apakah ada filter yang aktif
    $isFiltered = false;

    // Filter berdasarkan search umum
    if ($request->has('search')) {
      $search = $request->search;
      $query->where('no_porsi', 'like', "%{$search}%")
        ->orWhere('no_spph', 'like', "%{$search}%")
        ->orWhereHas('customer', function ($q) use ($search) {
          $q->where('nama', 'like', "%{$search}%")
            ->orWhere('jenis_kelamin', 'like', "%{$search}%")
            ->orWhere('no_hp_1', 'like', "%{$search}%");
        })
        ->orWhereHas('daftarHaji', function ($q) use ($search) {
          $q->where('no_porsi_haji', 'like', "%{$search}%");
        });

      $isFiltered = true;
    }

    // Filter berdasarkan rentang nomor porsi haji
    if ($request->has('no_porsi_haji_1') && $request->has('no_porsi_haji_2')) {
      $noPorsi1 = $request->no_porsi_haji_1;
      $noPorsi2 = $request->no_porsi_haji_2;

      if (!empty($noPorsi1) && !empty($noPorsi2)) {
        $query->whereBetween('no_porsi', [$noPorsi1, $noPorsi2])
          ->orWhereHas('daftarHaji', function ($q) use ($noPorsi1, $noPorsi2) {
            $q->whereBetween('no_porsi_haji', [$noPorsi1, $noPorsi2]);
          });
        $isFiltered = true;
      }
    }

    // Filter berdasarkan keberangkatan
    if ($request->has('keberangkatan') && !empty($request->keberangkatan)) {
      $query->where('keberangkatan_id', $request->keberangkatan);
      $isFiltered = true;
    }

    // Jika filter aktif, tampilkan semua data tanpa pagination
    if ($isFiltered) {
      $gabung_haji = $query->get();
    } else {
      $gabung_haji = $query->latest()->paginate(5);
    }

    // Ambil data keberangkatan
    $keberangkatan = GroupKeberangkatan::latest()->get();

    if ($request->ajax()) {
      return response()->json([
        'html' => trim(view('gabung-haji.partial-table', ['gabung_haji' => $gabung_haji])->render()),
        'paginate' => !$isFiltered, // Jika tidak difilter, pagination tetap muncul
      ]);
    }

    return view('gabung-haji.index', [
      'gabung_haji' => $gabung_haji,
      'keberangkatan' => $keberangkatan,
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
      'depag' => $kota,
      'dokumen' => MDokHaji::all(),
      'provinsi' => Provinsi::all(),
      'keberangkatan' => GroupKeberangkatan::all(),

      // KTP
      'selectedProvinsi' => old('provinsi_ktp'),
      'selectedKota' => old('kota_ktp'),
      'selectedKecamatan' => old('kecamatan_ktp'),
      'selectedKelurahan' => old('kelurahan_ktp'),
      'selectedKotaBank' => old('kota_bank'),
      'selectedDepag' => old('depag'),
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
    // Jika keberangkatan_id kosong, ubah menjadi null sebelum validasi
    $request->merge([
      'keberangkatan_id' => $request->keberangkatan_id ?: null,
    ]);

    $validated = $request->validate([
      // m_customers
      'nama' => 'nullable|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id'          => 'required|digits:16|unique:m_customers,no_id',
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
      // t_gabung_hajis
      'no_spph'  => 'required|digits:9|unique:t_gabung_hajis,no_spph',
      'no_porsi'  => 'required|digits:10|unique:t_gabung_hajis,no_porsi',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'catatan' => 'nullable|string',

      // Validasi checkbox dokumen
      'dokumen'    => 'nullable|array',
      'dokumen.*'  => 'exists:m_dok_hajis,id',
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
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
        'dokumen' => json_encode($validated['dokumen'] ?? []),
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
    $gabung_haji = TGabungHaji::with(['customer', 'kotaBank', 'depag', 'keberangkatan'])->find($id);

    $customer = $gabung_haji->customer;

    // Decode dokumen dari JSON ke array, pastikan tidak null
    $selected_documents = json_decode($gabung_haji->dokumen, true) ?? [];

    return view('gabung-haji.edit', [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'kotaBank' => Kota::find($gabung_haji->kota_bank),
      'depag' => Kota::find($gabung_haji->depag),
      'keberangkatan' => GroupKeberangkatan::find($gabung_haji->keberangkatan_id),
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

  /**
   * Update the specified resource in storage.
   */

  public function update(Request $request, $id)
  {
    $gabung_haji = TGabungHaji::findOrFail($id);
    $customer = Customer::findOrFail($gabung_haji->customer_id);

    // Jika keberangkatan_id kosong, ubah menjadi null sebelum validasi
    $request->merge([
      'keberangkatan_id' => $request->keberangkatan_id ?: null,
    ]);

    $validated = $request->validate([
      'nama' => 'nullable|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => ['required', 'numeric', 'digits:16', Rule::unique('m_customers', 'no_id')->ignore($customer->id)],
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
      'no_spph' => ['required', 'numeric', 'digits:9', Rule::unique('t_gabung_hajis', 'no_spph')->ignore($gabung_haji->id)],
      'no_porsi' => ['required', 'numeric', 'digits:10', Rule::unique('t_gabung_hajis', 'no_porsi')->ignore($gabung_haji->id)],
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'catatan' => 'nullable|string',

      // Validasi checkbox dokumen
      'dokumen'    => 'nullable|array',
      'dokumen.*'  => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($validated, $customer, $gabung_haji) {
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
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
        'catatan' => $validated['catatan'],
        'dokumen' => json_encode($validated['dokumen'] ?? []),
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
    $gabung_haji = TGabungHaji::with(['customer', 'kotaBank', 'depag'])->find($id);

    $customer = $gabung_haji->customer;

    // Decode dokumen dari JSON ke array, pastikan tidak null
    $selected_documents = json_decode($gabung_haji->dokumen, true) ?? [];

    return view('gabung-haji.repeat-data', [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'kotaBank' => Kota::find($gabung_haji->kota_bank),
      'depag' => Kota::find($gabung_haji->depag),
      'keberangkatan' => GroupKeberangkatan::all(),
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
    $gabung_haji = TGabungHaji::findOrFail($id);
    $customer = Customer::findOrFail($gabung_haji->customer_id);

    // Jika keberangkatan_id kosong, ubah menjadi null sebelum validasi
    $request->merge([
      'keberangkatan_id' => $request->keberangkatan_id ?: null,
    ]);

    $validated = $request->validate([
      'nama' => 'nullable|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => ['required', 'numeric', 'digits:16', Rule::unique('m_customers', 'no_id')->ignore($customer->id)],
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
      'no_spph' => ['required', 'numeric', 'digits:9', Rule::unique('t_gabung_hajis', 'no_spph')->ignore($gabung_haji->id)],
      'no_porsi' => ['required', 'numeric', 'digits:10', Rule::unique('t_gabung_hajis', 'no_porsi')->ignore($gabung_haji->id)],
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'catatan' => 'nullable|string',

      // Validasi checkbox dokumen
      'dokumen'    => 'nullable|array',
      'dokumen.*'  => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($validated, $customer) {
      // **Update data customer (Tetap Update, Tidak Diubah)**
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

      // **Create data baru di t_gabung_hajis**
      TGabungHaji::create([
        'customer_id' => $customer->id, // Tetap menggunakan customer yang sudah ada
        'no_spph' => $validated['no_spph'],
        'no_porsi' => $validated['no_porsi'],
        'nama_bank' => $validated['nama_bank'],
        'kota_bank' => $validated['kota_bank'],
        'depag' => $validated['depag'],
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
        'catatan' => $validated['catatan'],
        'dokumen' => json_encode($validated['dokumen'] ?? []),
      ]);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil ditambahkan!');
  }

  public function ambilSemuaData($id)
  {
    // Sama seperti function ambilSemuaData: Load semua relasi dalam satu query
    $gabung_haji = TGabungHaji::with(['customer', 'kotaBank', 'depag'])->find($id);

    $customer = $gabung_haji->customer;

    // Decode dokumen dari JSON ke array, pastikan tidak null
    $selected_documents = json_decode($gabung_haji->dokumen, true) ?? [];

    return view('gabung-haji.ambil-semua-data', [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'kotaBank' => Kota::find($gabung_haji->kota_bank),
      'depag' => Kota::find($gabung_haji->depag),
      'keberangkatan' => GroupKeberangkatan::all(),
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
    // Jika keberangkatan_id kosong, ubah menjadi null sebelum validasi
    $request->merge([
      'keberangkatan_id' => $request->keberangkatan_id ?: null,
    ]);

    $validated = $request->validate([
      'nama' => 'nullable|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id'          => 'required|digits:16|unique:m_customers,no_id',
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

      'no_spph'  => 'required|digits:9|unique:t_gabung_hajis,no_spph',
      'no_porsi'  => 'required|digits:10|unique:t_gabung_hajis,no_porsi',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|integer',
      'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
      'catatan' => 'nullable|string',

      // Validasi checkbox dokumen
      'dokumen'    => 'nullable|array',
      'dokumen.*'  => 'exists:m_dok_hajis,id',
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
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
        'dokumen' => json_encode($validated['dokumen'] ?? []),
        'catatan' => $validated['catatan'],
      ]);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil disimpan!');
  }
}
