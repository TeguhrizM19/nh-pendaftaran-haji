<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use App\Models\GroupKeberangkatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Group;

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

  public function tahun_keberangkatan()
  {
    return view('keberangkatan.tahun-keberangkatan', [
      'keberangkatan' => GroupKeberangkatan::latest()->paginate(10)
    ]);
  }

  public function store(Request $request)
  {
    $user = Auth::user()->name;

    $validated = $request->validate([
      'keberangkatan' => 'required|string',
      'manasik_raw' => 'nullable|numeric',
      'operasional_raw' => 'nullable|numeric',
      'dam_raw' => 'nullable|numeric',
    ]);

    // Simpan ke database dengan nama kolom yang sesuai
    GroupKeberangkatan::create([
      'keberangkatan' => $validated['keberangkatan'],
      'manasik' => $validated['manasik_raw'] ?? 0,
      'operasional' => $validated['operasional_raw'] ?? 0,
      'dam' => $validated['dam_raw'] ?? 0,
      'create_user' => $user
    ]);

    return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
  }


  public function edit($id)
  {
    $keberangkatan = GroupKeberangkatan::findOrFail($id);
    return view('keberangkatan.edit', compact('keberangkatan'));
  }

  public function update(Request $request, $id)
  {
    $user = Auth::user()->name;

    $validated = $request->validate([
      'keberangkatan' => 'required|digits:4',
      'manasik_raw' => 'nullable|numeric',
      'operasional_raw' => 'nullable|numeric',
      'dam_raw' => 'nullable|numeric',
    ]);

    $keberangkatan = GroupKeberangkatan::findOrFail($id);
    $keberangkatan->update([
      'keberangkatan' => $validated['keberangkatan'],
      'manasik' => $validated['manasik_raw'] ?? 0,
      'operasional' => $validated['operasional_raw'] ?? 0,
      'dam' => $validated['dam_raw'] ?? 0,
      'update_user' => $user
    ]);

    return redirect()->back()->with('success', 'Data keberangkatan berhasil diperbarui.');
  }


  public function destroy($id)
  {
    $keberangkatan = GroupKeberangkatan::find($id);

    $keberangkatan->delete();

    return redirect()->back()->with('success', 'Data berhasil dihapus!');
  }
}
