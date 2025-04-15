<?php

namespace App\Http\Controllers;

use App\Models\MDokHaji;
use Illuminate\Http\Request;

class MDokHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('dokumen.index', [
      'dokumen' => MDokHaji::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'dokumen' => 'required',
    ]);

    MDokHaji::create($validated);

    return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan!');
  }

  /**
   * Display the specified resource.
   */
  public function show(MDokHaji $mDokHaji)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(MDokHaji $mDokHaji)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $dokumen = MDokHaji::findOrFail($id);

    $validated = $request->validate([
      'dokumen' => 'required|string',
      'status' => 'nullable|string',
    ]);

    $dokumen->update($validated);

    return redirect()->back()->with('success', 'Dokumen berhasil diubah!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(MDokHaji $mDokHaji)
  {
    //
  }
}
