<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Customer;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\MSumberInfo;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('customer.index', [
      'customers' => Customer::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {

    return view('customer.create', [
      'provinsi' => Provinsi::all(),
      'kota' => Kota::all(),
      'sumber_info' => MSumberInfo::all()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'nama' => 'required|string',
      'no_hp_1' => 'required|string',
      'no_hp_2' => 'required|string',
      'tempat_lahir' => 'required|string',
      'tgl_lahir' => 'required|date',
      'jenis_id' => 'required|string',
      'no_id' => 'required|string',
      'jenis_kelamin' => 'required|string',
      'status_nikah' => 'required|string',
      'alamat_ktp' => 'required|string',
      'alamat_domisili' => 'required|string',
      // wilayah sesuai KTP
      'provinsi_ktp_id' => 'required|exists:m_provinsis,id',
      'kota_ktp_id' => 'required|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'required|exists:m_kelurahans,id',
      // wilayah sesuai Domisili
      'provinsi_domisili_id' => 'required|exists:m_provinsis,id',
      'kota_domisili_id' => 'required|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'required|exists:m_kelurahans,id',
      'warga' => 'required|string',
      'pekerjaan' => 'required|string',
      'pendidikan' => 'required|string',
    ]);

    // Ubah nama menjadi huruf besar
    $validated['nama'] = strtoupper($validated['nama']);

    // Simpan data wilayah dalam JSON
    $validated['alamat_ktp'] = json_encode([
      'alamat' => $validated['alamat_ktp'],
      'provinsi_id' => $validated['provinsi_ktp_id'],
      'kota_id' => $validated['kota_ktp_id'],
      'kecamatan_id' => $validated['kecamatan_ktp_id'],
      'kelurahan_id' => $validated['kelurahan_ktp_id'],
    ]);

    $validated['alamat_domisili'] = json_encode([
      'alamat' => $validated['alamat_domisili'],
      'provinsi_id' => $validated['provinsi_domisili_id'],
      'kota_id' => $validated['kota_domisili_id'],
      'kecamatan_id' => $validated['kecamatan_domisili_id'],
      'kelurahan_id' => $validated['kelurahan_domisili_id'],
    ]);

    // Simpan ke database
    Customer::create($validated);

    return redirect('/customer')->with('success', 'Data Tersimpan');
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
    $customer = Customer::findOrFail($id);
    $alamatKtp = json_decode($customer->alamat_ktp); // Ambil data alamat KTP dari JSON
    $alamatDomisili = json_decode($customer->alamat_domisili); // Ambil data alamat Domisili dari JSON

    return view('customer.edit', [
      'customer' => $customer,
      'provinsi' => Provinsi::all(),
      'tempat_lahir' => Kota::all(),
      'kota' => Kota::where('provinsi_id', $alamatKtp->provinsi_id ?? null)->get(),
      'kecamatan' => Kecamatan::where('kota_id', $alamatKtp->kota_id ?? null)->get(),
      'kelurahan' => Kelurahan::where('kecamatan_id', $alamatKtp->kecamatan_id ?? null)->get(),

      // Tambahkan data alamat domisili
      'kota_domisili' => Kota::where('provinsi_id', $alamatDomisili->provinsi_id ?? null)->get(),
      'kecamatan_domisili' => Kecamatan::where('kota_id', $alamatDomisili->kota_id ?? null)->get(),
      'kelurahan_domisili' => Kelurahan::where('kecamatan_id', $alamatDomisili->kecamatan_id ?? null)->get(),

      'sumber_info' => MSumberInfo::all(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, String $id)
  {
    $validated = $request->validate([
      // dd($request->all())
      'nama' => 'required|string',
      'no_hp_1' => 'required|string',
      'no_hp_2' => 'required|string',
      'tempat_lahir' => 'required|string',
      'tgl_lahir' => 'required|date',
      'jenis_id' => 'required|string',
      'no_id' => 'required|string',
      'jenis_kelamin' => 'required|string',
      'status_nikah' => 'required|string',
      'alamat_ktp' => 'required|string',
      'alamat_domisili' => 'required|string',
      // Wilayah sesuai KTP
      'provinsi_ktp_id' => 'required|exists:m_provinsis,id',
      'kota_ktp_id' => 'required|exists:m_kotas,id',
      'kecamatan_ktp_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_ktp_id' => 'required|exists:m_kelurahans,id',
      // Wilayah sesuai Domisili
      'provinsi_domisili_id' => 'required|exists:m_provinsis,id',
      'kota_domisili_id' => 'required|exists:m_kotas,id',
      'kecamatan_domisili_id' => 'required|exists:m_kecamatans,id',
      'kelurahan_domisili_id' => 'required|exists:m_kelurahans,id',
      'warga' => 'required|string',
      'pekerjaan' => 'required|string',
      'pendidikan' => 'required|string',
    ]);

    // Ubah nama menjadi huruf besar
    $validated['nama'] = strtoupper($validated['nama']);

    // Simpan data wilayah dalam JSON
    $validated['alamat_ktp'] = json_encode([
      'alamat' => $validated['alamat_ktp'],
      'provinsi_id' => $validated['provinsi_ktp_id'],
      'kota_id' => $validated['kota_ktp_id'],
      'kecamatan_id' => $validated['kecamatan_ktp_id'],
      'kelurahan_id' => $validated['kelurahan_ktp_id'],
    ]);

    $validated['alamat_domisili'] = json_encode([
      'alamat' => $validated['alamat_domisili'],
      'provinsi_id' => $validated['provinsi_domisili_id'],
      'kota_id' => $validated['kota_domisili_id'],
      'kecamatan_id' => $validated['kecamatan_domisili_id'],
      'kelurahan_id' => $validated['kelurahan_domisili_id'],
    ]);

    // Cari customer berdasarkan ID
    $customer = Customer::findOrFail($id);

    // Update data customer
    $customer->update($validated);

    return redirect('/customer')->with('success', 'Data Diubah');
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(String $id)
  {
    $customer = Customer::find($id);

    $customer->delete();
    return redirect('/customer')->with('success', 'Data Dihapus');
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

  public function getKelurahan($kecamatan_id)
  {
    return response()->json(Kelurahan::where('kecamatan_id', $kecamatan_id)->get());
  }

  public function getKodePos($kelurahan_id)
  {
    $kelurahan = Kelurahan::find($kelurahan_id);
    return response()->json(['kode_pos' => $kelurahan ? $kelurahan->kode_pos : '']);
  }
}
