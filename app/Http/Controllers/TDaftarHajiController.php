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
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\GroupKeberangkatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TDaftarHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function index(Request $request)
  {
    $query = TDaftarHaji::with('customer', 'keberangkatan');

    // 🔹 Pencarian Umum
    if ($request->has('search')) {
      $search = $request->search;

      $query->where(function ($q) use ($search) {
        $q->where('no_porsi_haji', 'like', "%{$search}%")
          ->orWhereRaw("(CASE WHEN pelunasan = 'Lunas' THEN 'Lunas' ELSE 'Belum Lunas' END) LIKE ?", ["{$search}%"])
          ->orWhereRaw("(CASE WHEN pelunasan_manasik = 'Lunas' THEN 'Lunas' ELSE 'Belum Lunas' END) LIKE ?", ["{$search}%"])
          ->orWhereHas('customer', function ($subQuery) use ($search) {
            $subQuery->where('nama', 'like', "%{$search}%")
              ->orWhere('paket_haji', 'like', "%{$search}%")
              ->orWhere('jenis_kelamin', 'like', "%{$search}%")
              ->orWhere('no_hp_1', 'like', "%{$search}%");
          })
          ->orWhereHas('keberangkatan', function ($subQuery) use ($search) {
            $subQuery->where('keberangkatan', 'like', "%{$search}%");
          });
      });
    }

    // 🔹 Filter Rentang Nomor Porsi Haji
    if ($request->has('no_porsi_haji_1') && $request->has('no_porsi_haji_2')) {
      $noPorsi1 = $request->no_porsi_haji_1;
      $noPorsi2 = $request->no_porsi_haji_2;
      if (!empty($noPorsi1) && !empty($noPorsi2)) {
        $query->whereBetween('no_porsi_haji', [$noPorsi1, $noPorsi2]);
      }
    }

    // 🔹 Filter Keberangkatan
    if ($request->filled('keberangkatan')) {
      $query->whereHas('keberangkatan', function ($q) use ($request) {
        $q->where('keberangkatan', 'like', "%{$request->keberangkatan}%");
      });
    }

    // 🔹 Filter Pelunasan Haji
    if ($request->filled('pelunasan')) {
      if ($request->pelunasan === 'Lunas') {
        $query->where('pelunasan', 'Lunas');
      } else {
        $query->where(function ($q) {
          $q->whereNull('pelunasan')
            ->orWhere('pelunasan', '')
            ->orWhere('pelunasan', '-')
            ->orWhere('pelunasan', '!=', 'Lunas');
        });
      }
    }

    // 🔹 Filter Pelunasan Manasik
    if ($request->filled('pelunasan_manasik')) {
      if ($request->pelunasan_manasik === 'Lunas') {
        $query->where('pelunasan_manasik', 'Lunas');
      } else {
        $query->where(function ($q) {
          $q->whereNull('pelunasan_manasik')
            ->orWhere('pelunasan_manasik', '')
            ->orWhere('pelunasan_manasik', '-')
            ->orWhere('pelunasan_manasik', '!=', 'Lunas');
        });
      }
    }

    // 🔹 Pagination & Response
    $daftar_haji = $query->latest()->paginate(10)->appends($request->query());
    $keberangkatan = GroupKeberangkatan::latest()->get();

    if ($request->ajax()) {
      if ($daftar_haji instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        return response()->json([
          'html' => trim(view('pendaftaran-haji.partial-table', ['daftar_haji' => $daftar_haji])->render()),
          'pagination' => $daftar_haji->links('pagination::tailwind')->toHtml(),
          'paginate' => true,
        ]);
      } else {
        return response()->json([
          'html' => trim(view('gabung-haji.partial-table', ['daftar_haji' => $daftar_haji])->render()),
          'paginate' => false,
        ]);
      }
    }

    return view('pendaftaran-haji.index', [
      'daftar_haji' => $daftar_haji,
      'keberangkatan' => $keberangkatan,
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
      'keberangkatan' => GroupKeberangkatan::all(),

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
    // Jika keberangkatan_id kosong, ubah menjadi null sebelum validasi
    $request->merge([
      'keberangkatan_id' => $request->keberangkatan_id ?: null,
    ]);

    $validated = $request->validate([
      // Validasi untuk m_customers
      'nama'           => 'required|string|max:255',
      'no_hp_1'        => 'nullable|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'nullable|date',
      'jenis_id'       => 'nullable|string',
      'no_id'          => 'nullable|digits:16|unique:m_customers,no_id',
      'warga'          => 'nullable|string',
      'jenis_kelamin'  => 'nullable|string',
      'status_nikah'   => 'nullable|string',
      'pekerjaan'      => 'nullable|string',
      'pendidikan'     => 'nullable|string',
      // Alamat KTP
      'alamat_ktp'     => 'nullable|string',
      'provinsi_ktp'   => 'nullable|exists:m_provinsis,id',
      'kota_ktp'       => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp'  => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp'  => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili'    => 'nullable|string',
      'provinsi_domisili'  => 'nullable|exists:m_provinsis,id',
      'kota_domisili'      => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      // Validasi untuk t_daftar_hajis
      'no_porsi_haji'  => 'nullable|digits:10|unique:t_daftar_hajis,no_porsi_haji',
      'cabang_id'      => 'nullable|exists:m_cabangs,id',
      'sumber_info_id' => 'nullable|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'nullable|exists:m_kotas,id',
      'paket_haji'     => 'nullable|string',
      'bpjs'           => 'nullable|digits:13',
      'bank'           => 'nullable|string',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'catatan'        => 'nullable|string',

      // Validasi file upload
      'ktp'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'kk'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'surat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'spph'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'bpih'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

      // Validasi checkbox dokumen
      'dokumen'    => 'nullable|array',
      'dokumen.*'  => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use (&$validated, $request) {
      $user = Auth::user()->name; // Ambil nama user yang sedang login

      // Upload file satu per satu
      if ($request->file('ktp')) {
        $newName = time() . "_ktp." . $request->ktp->extension();
        // server
        $request->ktp->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->ktp->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['ktp'] = $newName;
      }

      if ($request->file('kk')) {
        $newName = time() . "_kk." . $request->kk->extension();
        // server
        $request->kk->move('../public_html/folder-image-truenas', $newName);

        // Local
        // $request->kk->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['kk'] = $newName;
      }

      if ($request->file('surat')) {
        $newName = time() . "_surat." . $request->surat->extension();
        // server
        $request->surat->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->surat->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['surat'] = $newName;
      }

      if ($request->file('spph')) {
        $newName = time() . "_spph." . $request->spph->extension();
        // server
        $request->spph->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->spph->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['spph'] = $newName;
      }

      if ($request->file('bpih')) {
        $newName = time() . "_bpih." . $request->bpih->extension();
        // server
        $request->bpih->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->bpih->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['bpih'] = $newName;
      }

      if ($request->file('photo')) {
        $newName = time() . "_photo." . $request->photo->extension();
        // server
        $request->photo->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->photo->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['photo'] = $newName;
      }

      // Simpan data pelanggan ke m_customers
      $customer = Customer::create(array_merge($validated, [
        'nama' => strtoupper($validated['nama']),
        'alamat_ktp' => strtoupper($validated['alamat_ktp']),
        'alamat_domisili' => strtoupper($validated['alamat_domisili']),
        'create_user' => $user
      ]));

      // Simpan data pendaftaran haji ke t_daftar_hajis
      $daftarHaji = TDaftarHaji::create(array_merge($validated, [
        'customer_id' => $customer->id,
        'dokumen' => json_encode($validated['dokumen'] ?? []),
        'create_user' => $user
      ]));

      // Simpan data ke TGabungHaji
      TGabungHaji::create([
        'customer_id'   => $customer->id,
        'daftar_haji_id' => $daftarHaji->id,
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data berhasil disimpan');
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
      'keberangkatan',
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
      'keberangkatan' => GroupKeberangkatan::find($daftar_haji->keberangkatan_id),
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
    $daftar_haji = TDaftarHaji::findOrFail($id);
    $customer = Customer::findOrFail($daftar_haji->customer_id);
    $gabung_haji = TGabungHaji::where('daftar_haji_id', $daftar_haji->id)->first();

    // Jika keberangkatan_id kosong, ubah menjadi null sebelum validasi
    $request->merge([
      'keberangkatan_id' => $request->keberangkatan_id ?: null,
    ]);

    $validated = $request->validate([
      // m_customers
      'nama'           => 'required|string|max:255',
      'no_hp_1'        => 'nullable|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'nullable|date',
      'jenis_id'       => 'nullable|string',
      'no_id'          => ['nullable', 'numeric', 'digits:16', Rule::unique('m_customers', 'no_id')->ignore($customer->id)],
      'warga'          => 'nullable|string',
      'jenis_kelamin'  => 'nullable|string',
      'status_nikah'   => 'nullable|string',
      'pekerjaan'      => 'nullable|string',
      'pendidikan'     => 'nullable|string',
      // Alamat KTP
      'alamat_ktp'     => 'nullable|string',
      'provinsi_ktp'   => 'nullable|exists:m_provinsis,id',
      'kota_ktp'       => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp'  => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp'  => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili'  => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      // t_daftar_hajis
      'no_porsi_haji'  => ['nullable', 'numeric', 'digits:10', Rule::unique('t_daftar_hajis', 'no_porsi_haji')->ignore($daftar_haji->id)],
      'cabang_id'      => 'nullable|exists:m_cabangs,id',
      'sumber_info_id' => 'nullable|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'nullable|exists:m_kotas,id',
      'paket_haji'     => 'nullable|string',
      'bpjs'           => 'nullable|digits:13',
      'bank'   => 'nullable|string',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan'     => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      // upload
      'ktp'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'kk'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'surat'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'spph'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'bpih'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

      // Validasi checkbox dokumen
      'dokumen'    => 'nullable|array',
      'dokumen.*'  => 'exists:m_dok_hajis,id',
    ]);

    DB::beginTransaction();

    $user = Auth::user()->name; // Ambil nama user yang sedang login

    // **Update data customer**
    $customer->update([
      'nama' => strtoupper($validated['nama']),
      'no_hp_1' => $validated['no_hp_1'] ?? null,
      'no_hp_2' => $validated['no_hp_2'] ?? null,
      'tempat_lahir' => $validated['tempat_lahir'] ?? null,
      'tgl_lahir' => $validated['tgl_lahir'] ?? null,
      'jenis_id' => $validated['jenis_id'] ?? null,
      'no_id' => $validated['no_id'] ?? null,
      'warga' => $validated['warga'] ?? null,
      'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
      'status_nikah' => $validated['status_nikah'] ?? null,
      'pekerjaan' => $validated['pekerjaan'] ?? null,
      'pendidikan' => $validated['pendidikan'] ?? null,
      'alamat_ktp' => $validated['alamat_ktp'] ?? null,
      'provinsi_ktp' => $validated['provinsi_ktp'] ?? null,
      'kota_ktp' => $validated['kota_ktp'] ?? null,
      'kecamatan_ktp' => $validated['kecamatan_ktp'] ?? null,
      'kelurahan_ktp' => $validated['kelurahan_ktp'] ?? null,
      'alamat_domisili' => $validated['alamat_domisili'] ?? null,
      'provinsi_domisili' => $validated['provinsi_domisili'] ?? null,
      'kota_domisili' => $validated['kota_domisili'] ?? null,
      'kecamatan_domisili' => $validated['kecamatan_domisili'] ?? null,
      'kelurahan_domisili' => $validated['kelurahan_domisili'] ?? null,
      'update_user' => $user
    ]);

    // **Update dokumen pelanggan**
    $fileFields = ['ktp', 'kk', 'surat', 'spph', 'bpih', 'photo'];

    foreach ($fileFields as $field) {
      if ($request->hasFile($field)) {
        // Hapus file lama jika ada
        if (!empty($customer->$field)) {
          // server
          $oldFilePath = '../public_html/folder-image-truenas/' . $customer->$field;

          // local
          // $oldFilePath = public_path('uploads/dokumen_haji/' . $customer->$field);

          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }

        // Simpan file baru
        $newFileName = time() . '_' . $field . '.' . $request->file($field)->extension();
        // server
        $request->file($field)->move('../public_html/folder-image-truenas', $newFileName);

        // local
        // $request->file($field)->move(public_path('uploads/dokumen_haji'), $newFileName);

        // Simpan nama file baru di database
        $customer->$field = $newFileName;
      }
    }

    $customer->save();

    // **Update data daftar haji**
    $daftar_haji->update([
      'no_porsi_haji' => $validated['no_porsi_haji'] ?? null,
      'cabang_id' => $validated['cabang_id'] ?? null,
      'sumber_info_id' => $validated['sumber_info_id'] ?? null,
      'wilayah_daftar' => $validated['wilayah_daftar'] ?? null,
      'paket_haji' => $validated['paket_haji'] ?? null,
      'bpjs' => $validated['bpjs'] ?? null,
      'bank' => $validated['bank'] ?? null,
      'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
      'pelunasan' => $validated['pelunasan'] ?? null,
      'pelunasan_manasik' => $validated['pelunasan_manasik'] ?? null,
      'catatan' => $validated['catatan'] ?? null,
      'dokumen' => json_encode($validated['dokumen'] ?? []),
      'update_user' => $user
    ]);

    // **Update atau Buat TGabungHaji**
    if ($gabung_haji) {
      $gabung_haji->update([
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
      ]);
    } else {
      TGabungHaji::create([
        'daftar_haji_id' => $daftar_haji->id,
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
      ]);
    }

    DB::commit();

    return redirect('/pendaftaran-haji')->with('success', 'Data berhasil diperbarui beserta dokumen.');
  }

  /**
   * Remove the specified resource from storage.
   */

  public function destroy($id)
  {
    DB::transaction(function () use ($id) {
      $daftarHaji = TDaftarHaji::findOrFail($id);
      $customer = Customer::findOrFail($daftarHaji->customer_id);

      // Cek apakah masih ada id customer yang sama di t_daftar_hajis
      $isDuplicate = TDaftarHaji::where('customer_id', $customer->id)
        ->where('id', '!=', $id) // Pastikan bukan data yang akan dihapus
        ->exists();

      // Hapus file dokumen jika tidak ada customer_id yang sama lagi
      if (!$isDuplicate) {
        foreach (['ktp', 'kk', 'surat', 'spph', 'bpih', 'photo'] as $field) {
          // local
          // $filePathLocal = public_path("uploads/dokumen_haji/{$customer->$field}");
          // if (!empty($customer->$field) && file_exists($filePathLocal)) {
          //   @unlink($filePathLocal);
          // }

          // server
          $filePathServer = '../public_html/folder-image-truenas/' . $customer->$field;
          if (!empty($customer->$field) && file_exists($filePathServer)) {
            @unlink($filePathServer);
          }
        }
      }

      // Hapus data di t_daftar_hajis
      $daftarHaji->delete();

      // Hapus customer jika tidak ada lagi data di t_daftar_hajis
      if (!TDaftarHaji::where('customer_id', $customer->id)->exists()) {
        $customer->delete();
      }
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data berhasil dihapus.');
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

    // 🔹 Ambil data customer
    $customers = Customer::where('nama', 'LIKE', "%{$query}%")
      ->orWhere('no_id', 'LIKE', "%{$query}%")
      ->select('id', 'nama', 'no_id')
      ->get();

    // 🔹 Ambil data gabung haji (berdasarkan customer_id)
    $daftarHaji = TDaftarHaji::whereIn('customer_id', $customers->pluck('id'))
      ->select('id', 'customer_id')
      ->get();

    return response()->json([
      'customers' => $customers,
      'daftarHaji' => $daftarHaji
    ]);
  }

  public function repeatDataPendaftaran($id)
  {
    $customer = Customer::find($id);

    $kota = Kota::all();

    return view('pendaftaran-haji.repeat-data', [
      'customer' => $customer,
      'sumberInfo' => MSumberInfo::all(),
      'cabang' => MCabang::all(),
      'wilayahDaftar' => $kota,
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
      // m_customers
      'nama'           => 'required|string|max:255',
      'no_hp_1'        => 'nullable|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'nullable|date',
      'jenis_id'       => 'nullable|string',
      'no_id'          => ['nullable', 'numeric', 'digits:16', Rule::unique('m_customers', 'no_id')->ignore($customer->id)],
      'warga'          => 'nullable|string',
      'jenis_kelamin'  => 'nullable|string',
      'status_nikah'   => 'nullable|string',
      'pekerjaan'      => 'nullable|string',
      'pendidikan'     => 'nullable|string',
      // Alamat KTP
      'alamat_ktp'     => 'nullable|string',
      'provinsi_ktp'   => 'nullable|exists:m_provinsis,id',
      'kota_ktp'       => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp'  => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp'  => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili'  => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili'    => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',
      // t_daftar_hajis
      'no_porsi_haji'  => 'nullable|digits:10|unique:t_daftar_hajis,no_porsi_haji',
      'cabang_id'      => 'nullable|exists:m_cabangs,id',
      'sumber_info_id' => 'nullable|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'nullable|exists:m_kotas,id',
      'paket_haji'     => 'nullable|string',
      'bpjs'           => 'nullable|digits:13',
      'bank'           => 'nullable|string',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan'      => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan'        => 'nullable|string',
      // Upload file
      'ktp'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'kk'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'surat'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'spph'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'bpih'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      // Validasi checkbox dokumen
      'dokumen'    => 'nullable|array',
      'dokumen.*'  => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use ($customer, $validated, $request) {
      $user = Auth::user()->name;

      // **Simpan data lama sebelum update**
      $oldFiles = [];
      $fileFields = ['ktp', 'kk', 'surat', 'spph', 'bpih', 'photo'];
      foreach ($fileFields as $field) {
        $oldFiles[$field] = $customer->getOriginal($field);
      }

      // **Update Data Customer**
      $customer->update([
        'nama' => strtoupper($validated['nama']),
        'alamat_ktp' => strtoupper($validated['alamat_ktp']),
        'alamat_domisili' => strtoupper($validated['alamat_domisili']),
        'provinsi_ktp' => $validated['provinsi_ktp'],
        'kota_ktp' => $validated['kota_ktp'],
        'kecamatan_ktp' => $validated['kecamatan_ktp'],
        'kelurahan_ktp' => $validated['kelurahan_ktp'],
        'provinsi_domisili' => $validated['provinsi_domisili'],
        'kota_domisili' => $validated['kota_domisili'],
        'kecamatan_domisili' => $validated['kecamatan_domisili'],
        'kelurahan_domisili' => $validated['kelurahan_domisili'],
        'update_user' => $user,
      ]);

      // **Update dokumen pelanggan**
      foreach ($fileFields as $field) {
        if ($request->hasFile($field)) {
          // **Hapus file lama jika ada**
          if (!empty($oldFiles[$field])) {
            // server
            $oldFilePath = '../public_html/folder-image-truenas/' . $customer->$field;

            // local
            // $oldFilePath = public_path('uploads/dokumen_haji/' . $oldFiles[$field]);
            if (File::exists($oldFilePath)) {
              File::delete($oldFilePath);
            }
          }

          // **Simpan file baru**
          $newFileName = time() . '_' . $field . '.' . $request->file($field)->extension();
          // server
          $request->file($field)->move('../public_html/folder-image-truenas', $newFileName);

          // local
          // $request->file($field)->move(public_path('uploads/dokumen_haji'), $newFileName);

          // **Update field dokumen di database**
          $customer->update([$field => $newFileName]);
        }
      }

      // **Buat data baru di t_daftar_hajis**
      $daftarHaji = TDaftarHaji::create(array_merge($validated, [
        'customer_id'     => $customer->id,
        'dokumen'         => json_encode($validated['dokumen'] ?? []),
        'create_user'     => $user
      ]));

      // **Buat data di TGabungHaji**
      TGabungHaji::create([
        'customer_id' => $customer->id,
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
        'daftar_haji_id' => $daftarHaji->id
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data berhasil ditambahkan.');
  }


  public function ambilSemuaData($id)
  {
    $customer = Customer::find($id);
    $kota = Kota::all();

    return view('pendaftaran-haji.ambil-semua-data', [
      'customer' => $customer,
      'sumberInfo' => MSumberInfo::all(),
      'cabang' => $kota,
      'wilayahDaftar' => $kota,
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
    // Jika keberangkatan_id kosong, ubah menjadi null sebelum validasi
    $request->merge([
      'keberangkatan_id' => $request->keberangkatan_id ?: null,
    ]);

    $validated = $request->validate([
      // Validasi untuk m_customers
      'nama'           => 'required|string|max:255',
      'no_hp_1'        => 'nullable|string|max:15',
      'no_hp_2'        => 'nullable|string|max:15',
      'tempat_lahir'   => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir'      => 'nullable|date',
      'jenis_id'       => 'nullable|string',
      'no_id'          => 'nullable|digits:16|unique:m_customers,no_id',
      'warga'          => 'nullable|string',
      'jenis_kelamin'  => 'nullable|string',
      'status_nikah'   => 'nullable|string',
      'pekerjaan'      => 'nullable|string',
      'pendidikan'     => 'nullable|string',
      // Alamat KTP
      'alamat_ktp'     => 'nullable|string',
      'provinsi_ktp'   => 'nullable|exists:m_provinsis,id',
      'kota_ktp'       => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp'  => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp'  => 'nullable|exists:m_kelurahans,id',
      // Alamat Domisili
      'alamat_domisili'    => 'nullable|string',
      'provinsi_domisili'  => 'nullable|exists:m_provinsis,id',
      'kota_domisili'      => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',

      // Validasi untuk t_daftar_hajis
      'no_porsi_haji'  => 'nullable|digits:10|unique:t_daftar_hajis,no_porsi_haji',
      'cabang_id'      => 'nullable|exists:m_cabangs,id',
      'sumber_info_id' => 'nullable|exists:m_sumber_infos,id',
      'wilayah_daftar' => 'nullable|exists:m_kotas,id',
      'paket_haji'     => 'nullable|string',
      'bpjs'           => 'nullable|digits:13',
      'bank'           => 'nullable|string',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'catatan'        => 'nullable|string',

      // Validasi file upload
      'ktp'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'kk'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'surat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'spph'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'bpih'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

      // Validasi checkbox dokumen
      'dokumen'    => 'nullable|array',
      'dokumen.*'  => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use (&$validated, $request) {
      $user = Auth::user()->name; // Ambil nama user yang sedang login

      // Upload file satu per satu
      if ($request->file('ktp')) {
        $newName = time() . "_ktp." . $request->ktp->extension();
        // server
        $request->ktp->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->ktp->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['ktp'] = $newName;
      }

      if ($request->file('kk')) {
        $newName = time() . "_kk." . $request->kk->extension();
        // server
        $request->kk->move('../public_html/folder-image-truenas', $newName);

        // Local
        // $request->kk->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['kk'] = $newName;
      }

      if ($request->file('surat')) {
        $newName = time() . "_surat." . $request->surat->extension();
        // server
        $request->surat->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->surat->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['surat'] = $newName;
      }

      if ($request->file('spph')) {
        $newName = time() . "_spph." . $request->spph->extension();
        // server
        $request->spph->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->spph->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['spph'] = $newName;
      }

      if ($request->file('bpih')) {
        $newName = time() . "_bpih." . $request->bpih->extension();
        // server
        $request->bpih->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->bpih->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['bpih'] = $newName;
      }

      if ($request->file('photo')) {
        $newName = time() . "_photo." . $request->photo->extension();
        // server
        $request->photo->move('../public_html/folder-image-truenas', $newName);

        // local
        // $request->photo->move(public_path('uploads/dokumen_haji'), $newName);
        $validated['photo'] = $newName;
      }

      // Simpan data pelanggan ke m_customers
      $customer = Customer::create(array_merge($validated, [
        'nama' => strtoupper($validated['nama']),
        'alamat_ktp' => strtoupper($validated['alamat_ktp']),
        'alamat_domisili' => strtoupper($validated['alamat_domisili']),
        'create_user' => $user
      ]));

      // Simpan data pendaftaran haji ke t_daftar_hajis
      $daftarHaji = TDaftarHaji::create(array_merge($validated, [
        'customer_id' => $customer->id,
        'dokumen' => json_encode($validated['dokumen'] ?? []),
        'create_user' => $user
      ]));

      // Simpan data ke TGabungHaji
      TGabungHaji::create([
        'customer_id'   => $customer->id,
        'daftar_haji_id' => $daftarHaji->id,
        'keberangkatan_id' => $validated['keberangkatan_id'] ?? null,
      ]);
    });

    return redirect('/pendaftaran-haji')->with('success', 'Data berhasil disimpan beserta dokumen.');
  }
}
