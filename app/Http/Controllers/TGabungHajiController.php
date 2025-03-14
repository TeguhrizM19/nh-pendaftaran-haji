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
use Illuminate\Support\Facades\Auth;

class TGabungHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function index(Request $request)
  {
    $query = TGabungHaji::with(['customer', 'daftarHaji', 'keberangkatan']);
    $isFiltered = false;

    // Filter berdasarkan search umum
    if ($request->has('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('no_porsi', 'like', "%{$search}%")
          ->orWhere('no_spph', 'like', "%{$search}%")
          ->orWhereHas('customer', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('jenis_kelamin', 'like', "%{$search}%")
              ->orWhere('no_hp_1', 'like', "%{$search}%");
          })
          ->orWhereHas('daftarHaji', function ($q) use ($search) {
            $q->where('no_porsi_haji', 'like', "%{$search}%");
          });
      });
      $isFiltered = true;
    }

    // Filter berdasarkan rentang nomor porsi haji
    if ($request->filled('no_porsi_haji_1') && $request->filled('no_porsi_haji_2')) {
      $noPorsi1 = $request->no_porsi_haji_1;
      $noPorsi2 = $request->no_porsi_haji_2;

      $query->where(function ($q) use ($noPorsi1, $noPorsi2) {
        $q->whereBetween('no_porsi', [$noPorsi1, $noPorsi2])
          ->orWhereHas('daftarHaji', function ($q) use ($noPorsi1, $noPorsi2) {
            $q->whereBetween('no_porsi_haji', [$noPorsi1, $noPorsi2]);
          });
      });

      $isFiltered = true;
    }

    // Filter berdasarkan keberangkatan
    if ($request->filled('keberangkatan')) {
      $query->where('keberangkatan_id', $request->keberangkatan);
      $isFiltered = true;
    }

    if ($request->filled('pelunasan')) {
      $pelunasan = $request->pelunasan;

      if ($pelunasan === 'Lunas') {
        $query->where(function ($q) {
          $q->where('pelunasan', 'Lunas')
            ->orWhereHas('daftarHaji', function ($q) {
              $q->where('pelunasan', 'Lunas');
            });
        });
      } elseif ($pelunasan === 'Belum Lunas') {
        $query->where(function ($q) {
          $q->whereNull('pelunasan')
            ->orWhere('pelunasan', '')
            ->orWhere('pelunasan', '-')
            ->orWhere('pelunasan', '!=', 'Lunas');
        })->whereDoesntHave('daftarHaji', function ($q) {
          $q->where('pelunasan', 'Lunas');
        });
      }
    }

    // Ambil data
    $gabung_haji = $isFiltered ? $query->latest()->get() : $query->latest()->paginate(20);
    $keberangkatan = GroupKeberangkatan::latest()->get();

    if ($request->ajax()) {
      return response()->json([
        'html' => trim(view('gabung-haji.partial-table', ['gabung_haji' => $gabung_haji])->render()),
        'paginate' => !$isFiltered,
      ]);
    }

    return view('gabung-haji.index', [
      'gabung_haji' => $gabung_haji,
      'keberangkatan' => $keberangkatan,
      'isFiltered' => $isFiltered
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
    $request->merge(['keberangkatan_id' => $request->keberangkatan_id ?: null]);

    $validated = $request->validate([
      // m_customers
      'nama' => 'required|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'required|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'required|integer|exists:m_kotas,id',
      'tgl_lahir' => 'required|date',
      'jenis_id' => 'nullable|string',
      'no_id' => 'nullable|digits:16|unique:m_customers,no_id',
      'warga' => 'nullable|string',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      // Alamat KTP
      'alamat_ktp' => 'required|string',
      'provinsi_ktp' => 'required|exists:m_provinsis,id',
      'kota_ktp' => 'required|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'required|string',
      'provinsi_domisili' => 'required|exists:m_provinsis,id',
      'kota_domisili' => 'required|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      // t_gabung_hajis
      'no_spph' => 'nullable|unique:t_gabung_hajis,no_spph',
      'no_porsi' => 'required|digits:10|unique:t_gabung_hajis,no_porsi',
      'nama_bank' => 'required|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'required|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan' => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      // Validasi checkbox dokumen
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($validated) {
      $user = Auth::user()->name;

      $validated['create_user'] = $user;
      $validated['nama'] = strtoupper($validated['nama']);
      $validated['panggilan'] = strtoupper($validated['panggilan']);
      $validated['alamat_ktp'] = strtoupper($validated['alamat_ktp']);
      $validated['alamat_domisili'] = strtoupper($validated['alamat_domisili']);

      $customer = Customer::create($validated);

      $validated['customer_id'] = $customer->id;
      $validated['dokumen'] = json_encode($validated['dokumen'] ?? []);

      TGabungHaji::create($validated);
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
    $gabung_haji = TGabungHaji::with([
      'customer',
      'kotaBank',
      'depag',
      'keberangkatan'
    ])->find($id);

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

    $request->merge(['keberangkatan_id' => $request->keberangkatan_id ?: null]);

    $validated = $request->validate([
      // m_customers
      'nama' => 'required|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'required|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'required|integer|exists:m_kotas,id',
      'tgl_lahir' => 'required|date',
      'jenis_id' => 'nullable|string',
      'no_id' => ['nullable', 'numeric', 'digits:16', Rule::unique('m_customers', 'no_id')->ignore($customer->id)],
      'warga' => 'nullable|string',
      'jenis_kelamin' => 'required|string',
      'status_nikah' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      'alamat_ktp' => 'required|string',
      'provinsi_ktp' => 'required|exists:m_provinsis,id',
      'kota_ktp' => 'required|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      'alamat_domisili' => 'required|string',
      'provinsi_domisili' => 'required|exists:m_provinsis,id',
      'kota_domisili' => 'required|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      // t_gabung_hajis
      'no_spph' => ['nullable', 'numeric', Rule::unique('t_gabung_hajis', 'no_spph')->ignore($gabung_haji->id)],
      'no_porsi' => ['required', 'numeric', 'digits:10', Rule::unique('t_gabung_hajis', 'no_porsi')->ignore($gabung_haji->id)],
      'nama_bank' => 'required|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'required|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan' => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($validated, $customer, $gabung_haji) {
      $user = Auth::user()->name;
      $customer->update(array_merge($validated, [
        'nama' => strtoupper($validated['nama']),
        'panggilan' => strtoupper($validated['panggilan']),
        'alamat_ktp' => strtoupper($validated['alamat_ktp']),
        'alamat_domisili' => strtoupper($validated['alamat_domisili']),
        'update_user' => $user,
      ]));

      $gabung_haji->update(array_merge($validated, [
        'dokumen' => json_encode($validated['dokumen'] ?? []),
        'update_user' => $user,
      ]));
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

    // 🔹 Ambil data customer
    $customers = Customer::where('nama', 'LIKE', "%{$query}%")
      ->orWhere('no_id', 'LIKE', "%{$query}%")
      ->select('id', 'nama', 'no_id')
      ->get();

    // 🔹 Ambil data gabung haji (berdasarkan customer_id)
    $gabungHaji = TGabungHaji::whereIn('customer_id', $customers->pluck('id'))
      ->select('id', 'customer_id', 'no_porsi')
      ->get();

    return response()->json([
      'customers' => $customers,
      'gabungHaji' => $gabungHaji
    ]);
  }



  public function repeatDataGabung($id)
  {
    $customer = Customer::find($id);

    $kota = Kota::all();

    return view('gabung-haji.repeat-data', [
      'customer' => $customer,
      'kotaBank' => $kota,
      'depag' => $kota,
      'keberangkatan' => GroupKeberangkatan::all(),
      'dokumen' => MDokHaji::all(),
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

  public function storeRepeatData(Request $request)
  {
    $customer = Customer::findOrFail($request->customer_id);

    $request->merge(['keberangkatan_id' => $request->keberangkatan_id ?: null]);

    $validated = $request->validate([
      'nama' => 'required|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'required|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'required|integer|exists:m_kotas,id',
      'tgl_lahir' => 'required|date',
      'jenis_id' => 'nullable|string',
      'no_id' => ['nullable', 'numeric', 'digits:16', Rule::unique('m_customers', 'no_id')->ignore($customer->id)],
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'warga' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      'alamat_ktp' => 'required|string',
      'provinsi_ktp' => 'required|exists:m_provinsis,id',
      'kota_ktp' => 'required|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      'alamat_domisili' => 'required|string',
      'provinsi_domisili' => 'required|exists:m_provinsis,id',
      'kota_domisili' => 'required|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      // t_gabung_hajis
      'no_spph' => ['nullable', 'numeric', Rule::unique('t_gabung_hajis', 'no_spph')],
      'no_porsi' => ['required', 'numeric', 'digits:10', Rule::unique('t_gabung_hajis', 'no_porsi')],
      'nama_bank' => 'required|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'required|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan' => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($validated, $customer) {
      $user = Auth::user()->name;

      // Update data customer
      $customer->update(array_merge($validated, [
        'nama' => strtoupper($validated['nama']),
        'panggilan' => strtoupper($validated['panggilan']),
        'alamat_ktp' => strtoupper($validated['alamat_ktp']),
        'alamat_domisili' => strtoupper($validated['alamat_domisili']),
        'update_user' => $user,
      ]));

      // Buat data baru di t_gabung_hajis
      TGabungHaji::create(array_merge($validated, [
        'customer_id' => $customer->id,
        'dokumen' => json_encode($validated['dokumen'] ?? []),
        'create_user' => $user,
      ]));
    });


    return redirect('/gabung-haji')->with('success', 'Data berhasil ditambahkan!');
  }


  public function ambilSemuaData($id)
  {
    $customer = Customer::find($id);
    $kota = Kota::all();

    return view('gabung-haji.ambil-semua-data', [
      'customer' => $customer,
      'kotaBank' => $kota,
      'depag' => $kota,
      'keberangkatan' => GroupKeberangkatan::all(),
      'dokumen' => MDokHaji::all(),
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
    $request->merge(['keberangkatan_id' => $request->keberangkatan_id ?: null]);

    $validated = $request->validate([
      // m_customers
      'nama' => 'required|string|max:255',
      'panggilan' => 'nullable|string|max:50',
      'no_hp_1' => 'required|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'required|integer|exists:m_kotas,id',
      'tgl_lahir' => 'required|date',
      'jenis_id' => 'nullable|string',
      'no_id' => 'nullable|digits:16|unique:m_customers,no_id',
      'warga' => 'nullable|string',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      // Alamat KTP
      'alamat_ktp' => 'required|string',
      'provinsi_ktp' => 'required|exists:m_provinsis,id',
      'kota_ktp' => 'required|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'required|string',
      'provinsi_domisili' => 'required|exists:m_provinsis,id',
      'kota_domisili' => 'required|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      // t_gabung_hajis
      'no_spph' => 'nullable|unique:t_gabung_hajis,no_spph',
      'no_porsi' => 'required|digits:10|unique:t_gabung_hajis,no_porsi',
      'nama_bank' => 'required|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'required|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan' => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      // Validasi checkbox dokumen
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($validated) {
      $user = Auth::user()->name;

      $validated['create_user'] = $user;
      $validated['nama'] = strtoupper($validated['nama']);
      $validated['panggilan'] = strtoupper($validated['panggilan']);
      $validated['alamat_ktp'] = strtoupper($validated['alamat_ktp']);
      $validated['alamat_domisili'] = strtoupper($validated['alamat_domisili']);

      $customer = Customer::create($validated);

      $validated['customer_id'] = $customer->id;
      $validated['dokumen'] = json_encode($validated['dokumen'] ?? []);

      TGabungHaji::create($validated);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil disimpan!');
  }
}
