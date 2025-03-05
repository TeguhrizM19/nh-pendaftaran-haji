<?php

namespace App\Http\Controllers;

use App\Models\TGabungHaji;
use Illuminate\Http\Request;
use App\Models\GroupKeberangkatan;
use Illuminate\Support\Facades\DB;

class GroupKeberangkatanController extends Controller
{
  public function index()
  {
    return view('keberangkatan.index', [
      'keberangkatan' => GroupKeberangkatan::with(['gabungHaji'])->latest()->get(),
      'gabungHaji' => TGabungHaji::with(['customer', 'daftarHaji'])
        ->whereNull('keberangkatan_id') // Hanya peserta yang belum punya keberangkatan
        ->latest()
        ->get(),
      'gabungHajiDetail' => TGabungHaji::with(['customer', 'daftarHaji']) // Semua peserta untuk modal-detail
        ->latest()
        ->get()
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

    return redirect()->back()->with('success', 'Data keberangkatan diperbarui!');
  }
}
