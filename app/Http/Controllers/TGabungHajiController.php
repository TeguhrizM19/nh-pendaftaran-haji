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
use App\Models\MPerlengkapan;
use Illuminate\Validation\Rule;
use App\Models\GroupKeberangkatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TGabungHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function index(Request $request)
  {
    $query = TGabungHaji::with(['customer', 'daftarHaji', 'keberangkatan', 'pembayaran']);

    // Filter berdasarkan search umum 
    if ($request->has('search')) {
      $search = $request->search;

      $query->where(function ($q) use ($search) {
        $q->where('no_porsi', 'like', "%{$search}%")
          ->orWhere('no_spph', 'like', "%{$search}%")
          ->orWhereRaw("(CASE WHEN pelunasan = 'Lunas' THEN 'Lunas' ELSE 'Belum Lunas' END) LIKE ?", ["{$search}%"])
          ->orWhereRaw("(CASE WHEN pelunasan_manasik = 'Lunas' THEN 'Lunas' ELSE 'Belum Lunas' END) LIKE ?", ["{$search}%"])
          ->orWhereHas('customer', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('jenis_kelamin', 'like', "%{$search}%")
              ->orWhere('no_hp_1', 'like', "%{$search}%");
          })
          ->orWhereHas('daftarHaji', function ($q) use ($search) {
            $q->where('no_porsi_haji', 'like', "%{$search}%");
          })
          ->orWhereHas('keberangkatan', function ($q) use ($search) {
            $q->where('keberangkatan', 'like', "%{$search}%");
          })
          ->orWhereHas('daftarHaji.keberangkatan', function ($q) use ($search) {
            $q->where('keberangkatan', 'like', "%{$search}%");
          });
      });
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
    }

    // Filter berdasarkan keberangkatan
    if ($request->filled('keberangkatan')) {
      $query->where('keberangkatan_id', $request->keberangkatan);
    }

    // Filter pelunasan haji
    if ($request->has('pelunasan') && !empty($request->pelunasan)) {
      $pelunasan = $request->pelunasan;
      if ($pelunasan === 'Lunas') {
        $query->where('pelunasan', 'Lunas');
      } elseif ($pelunasan === 'Belum Lunas') {
        $query->where(function ($q) {
          $q->whereNull('pelunasan')
            ->orWhere('pelunasan', '')
            ->orWhere('pelunasan', '-')
            ->orWhere('pelunasan', '!=', 'Lunas');
        });
      }
    }

    // **Filter pelunasan manasik**
    if ($request->has('pelunasan_manasik') && !empty($request->pelunasan_manasik)) {
      $pelunasanManasik = $request->pelunasan_manasik;
      if ($pelunasanManasik === 'Lunas') {
        $query->where('pelunasan_manasik', 'Lunas');
      } elseif ($pelunasanManasik === 'Belum Lunas') {
        $query->where(function ($q) {
          $q->whereNull('pelunasan_manasik')
            ->orWhere('pelunasan_manasik', '')
            ->orWhere('pelunasan_manasik', '-')
            ->orWhere('pelunasan_manasik', '!=', 'Lunas');
        });
      }
    }

    // Ambil data dengan pagination
    $gabung_haji = $query->latest()->paginate(10)->appends($request->query());
    $keberangkatan = GroupKeberangkatan::latest()->get();

    if ($request->ajax()) {
      if ($gabung_haji instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        return response()->json([
          'html' => trim(view('gabung-haji.partial-table', ['gabung_haji' => $gabung_haji])->render()),
          'pagination' => $gabung_haji->links('pagination::tailwind')->toHtml(),
          'paginate' => true,
        ]);
      } else {
        return response()->json([
          'html' => trim(view('gabung-haji.partial-table', ['gabung_haji' => $gabung_haji])->render()),
          'paginate' => false,
        ]);
      }
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
    $dokumen = MDokHaji::where('status', 'Aktif')->get();
    $perlengkapan = MPerlengkapan::where('status', 'Aktif')->get();

    return view('gabung-haji.create', [
      'kotaBank' => $kota,
      'tempatLahir' => $kota,
      'depag' => $kota,
      'dokumen' => $dokumen,
      'perlengkapan' => $perlengkapan,
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
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => 'nullable|digits:16|unique:m_customers,no_id',
      'warga' => 'nullable|string',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      'instansi' => 'nullable|string',
      'jabatan' => 'nullable|string',
      'merokok' => 'nullable|string',
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
      'no_spph' => 'nullable|unique:t_gabung_hajis,no_spph',
      'no_porsi' => 'nullable|unique:t_gabung_hajis,no_porsi',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan' => 'nullable|string',
      // 'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      'nama_pasport' => 'nullable|string',
      'tempat_lahir_pasport' => 'nullable|string',
      'tgl_lahir_pasport' => 'nullable|date',
      'no_pasport' => 'nullable|string',
      'office_pasport' => 'nullable|string',
      'issue_date' => 'nullable|date',
      'experi_date' => 'nullable|date',

      // Validasi file upload
      'ktp'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'kk'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'surat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'spph'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'bpih'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

      // Validasi checkbox perlengkapan
      'perlengkapan' => 'nullable|array',
      'perlengkapan.*' => 'exists:m_perlengkapans,id',

      // Validasi checkbox dokumen
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
    ]);

    DB::transaction(function () use (&$validated, $request) {
      $user = Auth::user()->name;

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

      $validated['nama'] = strtoupper($validated['nama']);
      $validated['panggilan'] = strtoupper($validated['panggilan']);
      $validated['alamat_ktp'] = strtoupper($validated['alamat_ktp']);
      $validated['alamat_domisili'] = strtoupper($validated['alamat_domisili']);
      $validated['create_user'] = $user;

      $customer = Customer::create($validated);

      $validated['customer_id'] = $customer->id;
      $validated['perlengkapan'] = json_encode($validated['perlengkapan'] ?? []);
      $validated['dokumen'] = json_encode($validated['dokumen'] ?? []);

      TGabungHaji::create($validated);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil disimpan!');
  }

  public function edit($id)
  {
    // Sama seperti function ambilSemuaData: Load semua relasi dalam satu query
    $gabung_haji = TGabungHaji::with([
      'customer',
      'kotaBank',
      'depag',
      'keberangkatan',
    ])->find($id);

    $customer = $gabung_haji->customer;
    $jenisKelamin = strtolower($gabung_haji->customer->jenis_kelamin);

    $dokumen = MDokHaji::where('status', 'Aktif')->get();
    $perlengkapan = MPerlengkapan::where('status', 'Aktif')
      ->where(function ($query) use ($jenisKelamin) {
        $query->whereRaw('LOWER(jenis_kelamin) = ?', [$jenisKelamin])
          ->orWhereRaw('LOWER(jenis_kelamin) = ?', ['laki-laki/perempuan']);
      })
      ->get();

    $selected_perlengkapan = $gabung_haji->selected_perlengkapan->map(fn($id) => (string) $id)->toArray();
    $selected_documents = $gabung_haji->selected_dokumen->map(fn($id) => (string) $id)->toArray();

    return view('gabung-haji.edit', [
      'gabung_haji' => $gabung_haji,
      'customer' => $customer,
      'kotaBank' => Kota::find($gabung_haji->kota_bank),
      'depag' => Kota::find($gabung_haji->depag),
      'keberangkatan' => GroupKeberangkatan::find($gabung_haji->keberangkatan_id),
      'perlengkapan' => $perlengkapan,
      'selected_perlengkapan' => $selected_perlengkapan,
      'dokumen' => $dokumen,
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
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => ['nullable', 'numeric', 'digits:16', Rule::unique('m_customers', 'no_id')->ignore($customer->id)],
      'warga' => 'nullable|string',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      'instansi' => 'nullable|string',
      'jabatan' => 'nullable|string',
      'merokok' => 'nullable|string',
      'alamat_ktp' => 'nullable|string',
      'provinsi_ktp' => 'nullable|exists:m_provinsis,id',
      'kota_ktp' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',
      // upload
      'ktp'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'kk'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'surat'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'spph'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'bpih'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

      // t_gabung_hajis
      'no_spph' => ['nullable', 'numeric', Rule::unique('t_gabung_hajis', 'no_spph')->ignore($gabung_haji->id)],
      'no_porsi' => ['nullable', 'numeric', Rule::unique('t_gabung_hajis', 'no_porsi')->ignore($gabung_haji->id)],
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan' => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      'perlengkapan' => 'nullable|array',
      'perlengkapan.*' => 'exists:m_perlengkapans,id',
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
      'nama_pasport' => 'nullable|string',
      'tempat_lahir_pasport' => 'nullable|string',
      'tgl_lahir_pasport' => 'nullable|date',
      'no_pasport' => 'nullable|string',
      'office_pasport' => 'nullable|string',
      'issue_date' => 'nullable|date',
      'experi_date' => 'nullable|date',
    ]);

    DB::transaction(function () use ($validated, $customer, $gabung_haji) {
      $user = Auth::user()->name;

      $uploadFields = ['ktp', 'kk', 'surat', 'spph', 'bpih', 'photo'];
      $serverPath = '../public_html/folder-image-truenas';

      foreach ($uploadFields as $field) {
        if (request()->hasFile($field)) {
          $file = request()->file($field);
          $newName = time() . "_$field." . $file->extension();

          // Simpan ke local
          // $file->move(public_path('uploads/dokumen_haji'), $newName);

          // Simpan ke server (jika folder server tersedia)
          if (file_exists($serverPath) && is_dir($serverPath)) {
            request()->file($field)->move($serverPath, $newName);
          }

          // Hapus file lama dari local
          $oldFile = $gabung_haji->$field ?? $customer->$field;
          if ($oldFile) {
            // $localPath = public_path('uploads/dokumen_haji/' . $oldFile);
            // if (file_exists($localPath)) {
            //   @unlink($localPath);
            // }

            // Hapus file lama dari server
            $serverFile = $serverPath . '/' . $oldFile;
            if (file_exists($serverFile)) {
              @unlink($serverFile);
            }
          }

          $validated[$field] = $newName;
        }
      }

      $customer->update(array_merge($validated, [
        'nama' => strtoupper($validated['nama']),
        'panggilan' => strtoupper($validated['panggilan']),
        'alamat_ktp' => strtoupper($validated['alamat_ktp']),
        'alamat_domisili' => strtoupper($validated['alamat_domisili']),
        'update_user' => $user,
      ]));

      $gabung_haji->update(array_merge($validated, [
        'perlengkapan' => json_encode($validated['perlengkapan'] ?? []),
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
      $customer = Customer::findOrFail($gabungHaji->customer_id);

      // Cek apakah masih ada id customer yang sama di t_daftar_hajis
      $isDuplicate = TGabungHaji::where('customer_id', $customer->id)
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
      $gabungHaji->delete();

      // Hapus customer jika tidak ada lagi data di t_daftar_hajis
      if (!TGabungHaji::where('customer_id', $customer->id)->exists()) {
        $customer->delete();
      }
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil dihapus.');
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

    $jenisKelamin = strtolower($customer->jenis_kelamin);
    $dokumen = MDokHaji::where('status', 'Aktif')->get();
    $perlengkapan = MPerlengkapan::where('status', 'Aktif')
      ->where(function ($query) use ($jenisKelamin) {
        $query->whereRaw('LOWER(jenis_kelamin) = ?', [$jenisKelamin])
          ->orWhereRaw('LOWER(jenis_kelamin) = ?', ['laki-laki/perempuan']);
      })
      ->get();

    return view('gabung-haji.repeat-data', [
      'customer' => $customer,
      'kotaBank' => $kota,
      'depag' => $kota,
      'keberangkatan' => GroupKeberangkatan::all(),
      'perlengkapan' => $perlengkapan,
      'dokumen' => $dokumen,
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
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => ['nullable', 'numeric', 'digits:16', Rule::unique('m_customers', 'no_id')->ignore($customer->id)],
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'warga' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      'instansi' => 'nullable|string',
      'jabatan' => 'nullable|string',
      'merokok' => 'nullable|string',
      'alamat_ktp' => 'nullable|string',
      'provinsi_ktp' => 'nullable|exists:m_provinsis,id',
      'kota_ktp' => 'nullable|exists:m_kotas,id',
      'kecamatan_ktp' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_ktp' => 'nullable|exists:m_kelurahans,id',
      'alamat_domisili' => 'nullable|string',
      'provinsi_domisili' => 'nullable|exists:m_provinsis,id',
      'kota_domisili' => 'nullable|exists:m_kotas,id',
      'kecamatan_domisili' => 'nullable|exists:m_kecamatans,id',
      'kelurahan_domisili' => 'nullable|exists:m_kelurahans,id',
      // Upload file
      'ktp'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'kk'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'surat'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'spph'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'bpih'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

      // t_gabung_hajis
      'no_spph' => ['nullable', 'numeric', Rule::unique('t_gabung_hajis', 'no_spph')],
      'no_porsi' => ['nullable', 'numeric', Rule::unique('t_gabung_hajis', 'no_porsi')],
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan' => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      'perlengkapan' => 'nullable|array',
      'perlengkapan.*' => 'exists:m_perlengkapans,id',
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
      'nama_pasport' => 'nullable|string',
      'tempat_lahir_pasport' => 'nullable|string',
      'tgl_lahir_pasport' => 'nullable|date',
      'no_pasport' => 'nullable|string',
      'office_pasport' => 'nullable|string',
      'issue_date' => 'nullable|date',
      'experi_date' => 'nullable|date',
    ]);

    DB::transaction(function () use ($customer, $validated, $request) {
      $user = Auth::user()->name;

      // **Simpan data lama sebelum update**
      $oldFiles = [];
      $fileFields = ['ktp', 'kk', 'surat', 'spph', 'bpih', 'photo'];
      foreach ($fileFields as $field) {
        $oldFiles[$field] = $customer->getOriginal($field);
      }

      // Update data customer
      $customer->update(array_merge($validated, [
        'nama' => strtoupper($validated['nama']),
        'panggilan' => strtoupper($validated['panggilan']),
        'alamat_ktp' => strtoupper($validated['alamat_ktp']),
        'alamat_domisili' => strtoupper($validated['alamat_domisili']),
        'update_user' => $user,
      ]));

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

      // Buat data baru di t_gabung_hajis
      TGabungHaji::create(array_merge($validated, [
        'customer_id' => $customer->id,
        'perlengkapan' => json_encode($validated['perlengkapan'] ?? []),
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
    $dokumen = MDokHaji::where('status', 'Aktif')->get();
    $perlengkapan = MPerlengkapan::where('status', 'Aktif')->get();

    return view('gabung-haji.ambil-semua-data', [
      'customer' => $customer,
      'kotaBank' => $kota,
      'depag' => $kota,
      'keberangkatan' => GroupKeberangkatan::all(),
      'perlengkapan' => $perlengkapan,
      'dokumen' => $dokumen,
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
      'no_hp_1' => 'nullable|string|max:15',
      'no_hp_2' => 'nullable|string|max:15',
      'tempat_lahir' => 'nullable|integer|exists:m_kotas,id',
      'tgl_lahir' => 'nullable|date',
      'jenis_id' => 'nullable|string',
      'no_id' => 'nullable|digits:16|unique:m_customers,no_id',
      'warga' => 'nullable|string',
      'jenis_kelamin' => 'nullable|string',
      'status_nikah' => 'nullable|string',
      'pekerjaan' => 'nullable|string',
      'pendidikan' => 'nullable|string',
      'instansi' => 'nullable|string',
      'jabatan' => 'nullable|string',
      'merokok' => 'nullable|string',
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
      'no_spph' => 'nullable|unique:t_gabung_hajis,no_spph',
      'no_porsi' => 'nullable|unique:t_gabung_hajis,no_porsi',
      'nama_bank' => 'nullable|string',
      'kota_bank' => 'nullable|integer',
      'depag' => 'nullable|integer',
      'keberangkatan_id' => 'nullable|exists:group_keberangkatan,id',
      'pelunasan' => 'nullable|string',
      'pelunasan_manasik' => 'nullable|string',
      'catatan' => 'nullable|string',
      // Validasi checkbox perlengkapan
      'perlengkapan' => 'nullable|array',
      'perlengkapan.*' => 'exists:m_perlengkapans,id',
      // Validasi file upload
      'ktp'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'kk'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'surat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'spph'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'bpih'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
      'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
      // Validasi checkbox dokumen
      'dokumen' => 'nullable|array',
      'dokumen.*' => 'exists:m_dok_hajis,id',
      // Pasport
      'nama_pasport' => 'nullable|string',
      'tempat_lahir_pasport' => 'nullable|string',
      'tgl_lahir_pasport' => 'nullable|date',
      'no_pasport' => 'nullable|string',
      'office_pasport' => 'nullable|string',
      'issue_date' => 'nullable|date',
      'experi_date' => 'nullable|date',
    ]);

    DB::transaction(function () use (&$validated, $request) {
      $user = Auth::user()->name;

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

      $validated['create_user'] = $user;
      $validated['nama'] = strtoupper($validated['nama']);
      $validated['panggilan'] = strtoupper($validated['panggilan']);
      $validated['alamat_ktp'] = strtoupper($validated['alamat_ktp']);
      $validated['alamat_domisili'] = strtoupper($validated['alamat_domisili']);

      $customer = Customer::create($validated);

      $validated['customer_id'] = $customer->id;
      $validated['perlengkapan'] = json_encode($validated['perlengkapan'] ?? []);
      $validated['dokumen'] = json_encode($validated['dokumen'] ?? []);

      TGabungHaji::create($validated);
    });

    return redirect('/gabung-haji')->with('success', 'Data berhasil disimpan!');
  }
}
