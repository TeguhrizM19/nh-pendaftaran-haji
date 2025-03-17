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
    $query = TGabungHaji::with(['customer', 'daftarHaji', 'keberangkatan']);

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

    // Ambil data dengan pagination
    $gabung_haji = $query->latest()->paginate(5)->appends($request->query());
    $keberangkatan = GroupKeberangkatan::latest()->get();

    if ($request->ajax()) {
      if ($gabung_haji instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        return response()->json([
          'html' => trim(view('keberangkatan.partial-table-peserta', ['gabung_haji' => $gabung_haji])->render()),
          'pagination' => $gabung_haji->links('pagination::tailwind')->toHtml(),
          'paginate' => true,
        ]);
      } else {
        return response()->json([
          'html' => trim(view('keberangkatan.partial-table-peserta', ['gabung_haji' => $gabung_haji])->render()),
          'paginate' => false,
        ]);
      }
    }

    return view('keberangkatan.index', [
      'gabung_haji' => $gabung_haji,
      'keberangkatan' => $keberangkatan,
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
      'peserta_ids' => 'required|array',
      'peserta_ids.*' => 'exists:t_gabung_hajis,id',
    ]);

    // Hapus keberangkatan_id di t_gabung_hajis
    DB::table('t_gabung_hajis')
      ->whereIn('id', $request->peserta_ids)
      ->update(['keberangkatan_id' => null]);

    // Hapus juga keberangkatan_id di t_daftar_hajis
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


  // public function updateKeberangkatan(Request $request)
  // {
  //   $keberangkatan_id = $request->keberangkatan_id;
  //   $peserta_checked = $request->peserta ?? []; // Peserta yang tetap dicentang

  //   // 🔹 Ambil semua peserta yang ada di keberangkatan saat ini
  //   $peserta_lama = DB::table('t_gabung_hajis')
  //     ->where('keberangkatan_id', $keberangkatan_id)
  //     ->pluck('id')
  //     ->toArray();

  //   // 1️⃣ Tambahkan peserta baru yang dicentang
  //   DB::table('t_gabung_hajis')
  //     ->whereIn('id', $peserta_checked)
  //     ->whereNull('keberangkatan_id')
  //     ->update(['keberangkatan_id' => $keberangkatan_id]);

  //   // 2️⃣ Ambil daftar_haji_id dari peserta yang dipilih
  //   $daftar_haji_ids = DB::table('t_gabung_hajis')
  //     ->whereIn('id', $peserta_checked)
  //     ->pluck('daftar_haji_id')
  //     ->toArray();

  //   // 3️⃣ Update keberangkatan_id di t_daftar_hajis berdasarkan daftar_haji_id
  //   DB::table('t_daftar_hajis')
  //     ->whereIn('id', $daftar_haji_ids)
  //     ->whereNull('keberangkatan_id')
  //     ->update(['keberangkatan_id' => $keberangkatan_id]);

  //   // 4️⃣ Hapus peserta yang sebelumnya ada di keberangkatan tetapi sekarang dihapus centangnya
  //   $peserta_dihapus = array_diff($peserta_lama, $peserta_checked);

  //   DB::table('t_gabung_hajis')
  //     ->whereIn('id', $peserta_dihapus)
  //     ->update(['keberangkatan_id' => null]);

  //   DB::table('t_daftar_hajis')
  //     ->whereIn('id', function ($query) use ($peserta_dihapus) {
  //       $query->select('daftar_haji_id')
  //         ->from('t_gabung_hajis')
  //         ->whereIn('id', $peserta_dihapus);
  //     })
  //     ->update(['keberangkatan_id' => null]);

  //   return redirect('/keberangkatan')->with('success', 'Data keberangkatan diperbarui!');
  // }
}
