<?php

namespace App\Http\Controllers;

use App\Models\MCabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('user.index', [
      'users' => User::all(),
      'cabang' => MCabang::all(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  // public function create()
  // {
  //   return view('user.create');
  // }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validasi input
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:users,username',
      'password' => 'required|string|min:5',
      'cabang_id' => 'required|exists:m_cabangs,id',
      'level' => 'required|in:super_admin,admin,qc',
    ]);

    // Tambahkan data tambahan sebelum insert ke database
    $validated['password'] = bcrypt($validated['password']); // Enkripsi password
    $validated['create_user'] = Auth::check() ? Auth::user()->name : 'System';

    // Simpan data ke database
    User::create($validated);

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'User berhasil ditambahkan!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    // Cari user berdasarkan ID
    $user = User::findOrFail($id);

    // Hapus user
    $user->delete();

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'User berhasil dihapus!');
  }
}
