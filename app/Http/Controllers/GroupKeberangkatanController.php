<?php

namespace App\Http\Controllers;

use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use App\Models\GroupKeberangkatan;
use Illuminate\Support\Facades\DB;

class GroupKeberangkatanController extends Controller
{
  public function index(Request $request)
  {
    $query = GroupKeberangkatan::with(['gabungHaji.customer', 'gabungHaji.daftarHaji']);

    // Cek apakah ada filter yang aktif
    $isFiltered = false;

    // Filter berdasarkan search umum
    if ($request->has('search')) {
      $search = $request->search;
      $query->whereHas('gabungHaji', function ($q) use ($search) {
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
    if ($request->has('no_porsi_haji_1') && $request->has('no_porsi_haji_2')) {
      $noPorsi1 = $request->no_porsi_haji_1;
      $noPorsi2 = $request->no_porsi_haji_2;

      if (!empty($noPorsi1) && !empty($noPorsi2)) {
        $query->whereHas('gabungHaji', function ($q) use ($noPorsi1, $noPorsi2) {
          $q->whereBetween('no_porsi', [$noPorsi1, $noPorsi2])
            ->orWhereHas('daftarHaji', function ($q) use ($noPorsi1, $noPorsi2) {
              $q->whereBetween('no_porsi_haji', [$noPorsi1, $noPorsi2]);
            });
        });

        $isFiltered = true;
      }
    }

    // Filter berdasarkan tahun keberangkatan
    if ($request->has('keberangkatan') && !empty($request->keberangkatan)) {
      $query->where('id', $request->keberangkatan);
      $isFiltered = true;
    }

    // Jika ada filter aktif, ambil semua data tanpa pagination
    if ($isFiltered) {
      $keberangkatan = $query->get();
    } else {
      $keberangkatan = $query->latest()->paginate(5);
    }

    if ($request->ajax()) {
      return response()->json([
        'html' => trim(view('keberangkatan.partial-table-peserta', ['keberangkatan' => $keberangkatan])->render()),
        'paginate' => !$isFiltered,
      ]);
    }

    return view('keberangkatan.index', [
      'keberangkatan' => $keberangkatan,
      'gabungHaji' => TGabungHaji::with(['customer', 'daftarHaji'])->whereNull('keberangkatan_id')->latest()->get(),
      'gabungHajiDetail' => TGabungHaji::with(['customer', 'daftarHaji'])->latest()->get(),
    ]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'keberangkatan' => 'required|string|',
    ]);

    GroupKeberangkatan::create([
      'keberangkatan' => $request->keberangkatan,
    ]);

    return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
  }

  public function indexKeberangkatan(Request $request)
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
      $gabung_haji = $query->latest()->paginate(10);
    }

    // Ambil data keberangkatan
    $keberangkatan = GroupKeberangkatan::latest()->get();

    if ($request->ajax()) {
      return response()->json([
        'html' => trim(view('keberangkatan.partial-table-peserta', ['gabung_haji' => $gabung_haji])->render()),
        'paginate' => !$isFiltered, // Jika tidak difilter, pagination tetap muncul
      ]);
    }

    return view('keberangkatan.tambah-peserta-keberangkatan', [
      'gabung_haji' => $gabung_haji,
      'keberangkatan' => $keberangkatan,
    ]);
  }

  public function simpanPesertaKeberangkatan(Request $request)
  {
    $request->validate([
      'keberangkatan_id' => 'required|exists:group_keberangkatan,id',
      'peserta_ids' => 'required|array',
      'peserta_ids.*' => 'exists:t_gabung_hajis,id',
    ]);

    $keberangkatan_id = $request->keberangkatan_id;

    // Ambil peserta yang belum punya keberangkatan_id
    $peserta_baru = DB::table('t_gabung_hajis')
      ->whereIn('id', $request->peserta_ids)
      ->whereNull('keberangkatan_id')
      ->pluck('id')
      ->toArray();

    // Jika ada peserta baru, update keberangkatan_id di t_gabung_hajis
    if (!empty($peserta_baru)) {
      DB::table('t_gabung_hajis')
        ->whereIn('id', $peserta_baru)
        ->update(['keberangkatan_id' => $keberangkatan_id]);

      // 🔹 Ambil daftar_haji_id dari peserta baru
      $daftar_haji_ids = DB::table('t_gabung_hajis')
        ->whereIn('id', $peserta_baru)
        ->pluck('daftar_haji_id')
        ->toArray();

      // 🔹 Update keberangkatan_id di t_daftar_hajis
      if (!empty($daftar_haji_ids)) {
        DB::table('t_daftar_hajis')
          ->whereIn('id', $daftar_haji_ids)
          ->whereNull('keberangkatan_id') // Pastikan hanya yang belum punya keberangkatan_id
          ->update(['keberangkatan_id' => $keberangkatan_id]);
      }
    }

    return redirect()->back()->with('success', 'Data berhasil disimpan!');
  }

  public function hapusPesertaKeberangkatan(Request $request)
  {
    $request->validate([
      'keberangkatan_id' => 'required|exists:group_keberangkatan,id',
      'peserta_ids' => 'required|array',
      'peserta_ids.*' => 'exists:t_gabung_hajis,id',
    ]);

    // ❌ Hapus keberangkatan_id di t_gabung_hajis
    DB::table('t_gabung_hajis')
      ->whereIn('id', $request->peserta_ids)
      ->update(['keberangkatan_id' => null]);

    // ❌ Hapus juga keberangkatan_id di t_daftar_hajis
    $daftar_haji_ids = DB::table('t_gabung_hajis')
      ->whereIn('id', $request->peserta_ids)
      ->pluck('daftar_haji_id')
      ->toArray();

    if (!empty($daftar_haji_ids)) {
      DB::table('t_daftar_hajis')
        ->whereIn('id', $daftar_haji_ids)
        ->update(['keberangkatan_id' => null]);
    }

    return response()->json(['message' => 'Peserta berhasil dihapus dari keberangkatan!']);
  }


  // public function createKeberangkatan(Request $request, $keberangkatan_id)
  // {
  //   $query = GroupKeberangkatan::with(['gabungHaji.customer', 'gabungHaji.daftarHaji'])
  //     ->where('id', $keberangkatan_id);

  //   // Cek apakah ada filter yang aktif
  //   $isFiltered = false;

  //   // Filter berdasarkan search umum
  //   if ($request->has('search')) {
  //     $search = $request->search;
  //     $query->whereHas('gabungHaji', function ($q) use ($search) {
  //       $q->where('no_porsi', 'like', "%{$search}%")
  //         ->orWhere('no_spph', 'like', "%{$search}%")
  //         ->orWhereHas('customer', function ($q) use ($search) {
  //           $q->where('nama', 'like', "%{$search}%")
  //             ->orWhere('jenis_kelamin', 'like', "%{$search}%")
  //             ->orWhere('no_hp_1', 'like', "%{$search}%");
  //         })
  //         ->orWhereHas('daftarHaji', function ($q) use ($search) {
  //           $q->where('no_porsi_haji', 'like', "%{$search}%");
  //         });
  //     });

  //     $isFiltered = true;
  //   }

  //   // Filter berdasarkan rentang nomor porsi haji
  //   if ($request->has('no_porsi_haji_1') && $request->has('no_porsi_haji_2')) {
  //     $noPorsi1 = $request->no_porsi_haji_1;
  //     $noPorsi2 = $request->no_porsi_haji_2;

  //     if (!empty($noPorsi1) && !empty($noPorsi2)) {
  //       $query->whereHas('gabungHaji', function ($q) use ($noPorsi1, $noPorsi2) {
  //         $q->whereBetween('no_porsi', [$noPorsi1, $noPorsi2])
  //           ->orWhereHas('daftarHaji', function ($q) use ($noPorsi1, $noPorsi2) {
  //             $q->whereBetween('no_porsi_haji', [$noPorsi1, $noPorsi2]);
  //           });
  //       });

  //       $isFiltered = true;
  //     }
  //   }

  //   // Ambil data keberangkatan
  //   // $keberangkatan = $isFiltered ? $query->get() : $query->first();
  //   $keberangkatan = $isFiltered ? $query->get() : $query->get(); // Selalu `get()` supaya tetap collection


  //   // Jika data tidak ditemukan
  //   if (!$keberangkatan) {
  //     return redirect()->back()->with('error', 'Data keberangkatan tidak ditemukan!');
  //   }

  //   // Ambil peserta yang belum punya keberangkatan
  //   $gabungHaji = TGabungHaji::with(['customer', 'daftarHaji'])
  //     ->whereNull('keberangkatan_id')
  //     ->latest()
  //     ->paginate(5);

  //   // Jika request via AJAX (untuk refresh data tabel tanpa reload)
  //   if ($request->ajax()) {
  //     return response()->json([
  //       'html' => trim(view('keberangkatan.partial-table-peserta', ['keberangkatan' => $keberangkatan])->render()),
  //       'paginate' => !$isFiltered,
  //     ]);
  //   }

  //   // Return ke view
  //   return view('keberangkatan.peserta-keberangkatan', compact('keberangkatan', 'gabungHaji'));
  // }

  // public function detailKeberangkatan($keberangkatan_id)
  // {
  //   return view('keberangkatan.detail-keberangkatan', [
  //     'keberangkatan' => GroupKeberangkatan::with(['gabungHaji'])
  //       ->where('id', $keberangkatan_id) // Filter berdasarkan ID keberangkatan
  //       ->get(),
  //     'gabungHajiDetail' => TGabungHaji::with(['customer', 'daftarHaji']) // Semua peserta untuk modal-detail
  //       ->latest()
  //       ->get()
  //   ]);
  // }

  public function updateKeberangkatan(Request $request)
  {
    $keberangkatan_id = $request->keberangkatan_id;
    $peserta_checked = $request->peserta ?? []; // Peserta yang tetap dicentang

    // 🔹 Ambil semua peserta yang ada di keberangkatan saat ini
    $peserta_lama = DB::table('t_gabung_hajis')
      ->where('keberangkatan_id', $keberangkatan_id)
      ->pluck('id')
      ->toArray();

    // 1️⃣ Tambahkan peserta baru yang dicentang
    DB::table('t_gabung_hajis')
      ->whereIn('id', $peserta_checked)
      ->whereNull('keberangkatan_id')
      ->update(['keberangkatan_id' => $keberangkatan_id]);

    // 2️⃣ Ambil daftar_haji_id dari peserta yang dipilih
    $daftar_haji_ids = DB::table('t_gabung_hajis')
      ->whereIn('id', $peserta_checked)
      ->pluck('daftar_haji_id')
      ->toArray();

    // 3️⃣ Update keberangkatan_id di t_daftar_hajis berdasarkan daftar_haji_id
    DB::table('t_daftar_hajis')
      ->whereIn('id', $daftar_haji_ids)
      ->whereNull('keberangkatan_id')
      ->update(['keberangkatan_id' => $keberangkatan_id]);

    // 4️⃣ Hapus peserta yang sebelumnya ada di keberangkatan tetapi sekarang dihapus centangnya
    $peserta_dihapus = array_diff($peserta_lama, $peserta_checked);

    DB::table('t_gabung_hajis')
      ->whereIn('id', $peserta_dihapus)
      ->update(['keberangkatan_id' => null]);

    DB::table('t_daftar_hajis')
      ->whereIn('id', function ($query) use ($peserta_dihapus) {
        $query->select('daftar_haji_id')
          ->from('t_gabung_hajis')
          ->whereIn('id', $peserta_dihapus);
      })
      ->update(['keberangkatan_id' => null]);

    return redirect('/keberangkatan')->with('success', 'Data keberangkatan diperbarui!');
  }
}
