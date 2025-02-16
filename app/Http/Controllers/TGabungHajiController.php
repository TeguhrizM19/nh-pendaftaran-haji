<?php

namespace App\Http\Controllers;

use App\Models\TGabungHaji;
use App\Http\Requests\StoreTGabungHajiRequest;
use App\Http\Requests\UpdateTGabungHajiRequest;
use App\Models\Kota;

class TGabungHajiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('gabung-haji.index', [
      'gabung_haji' => TGabungHaji::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('gabung-haji.create', [
      'kota' => Kota::all()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreTGabungHajiRequest $request)
  {
    //
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
  public function edit(TGabungHaji $tGabungHaji)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateTGabungHajiRequest $request, TGabungHaji $tGabungHaji)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(TGabungHaji $tGabungHaji)
  {
    //
  }
}
