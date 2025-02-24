<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TDaftarHajiController;
use App\Http\Controllers\TGabungHajiController;

Route::get('/', function () {
    return view('dashboard');
});

// Route Pendaftaran Haji
Route::resource('/pendaftaran-haji', TDaftarHajiController::class);
Route::get('/get-cabang/{id}', [TDaftarHajiController::class, 'getCabang']);
Route::get('/get-kota/{provinsi_id}', [TDaftarHajiController::class, 'getKota']);
Route::get('/get-kecamatan/{kota_id}', [TDaftarHajiController::class, 'getKecamatan']);
Route::get('/get-kelurahan/{kecamatan_id}', [TDaftarHajiController::class, 'getKelurahan']);
Route::get('/get-kodepos/{kelurahan_id}', [TDaftarHajiController::class, 'getKodePos']);

Route::get('/search-pendaftaran', [TDaftarHajiController::class, 'search'])->name('pendaftaran.search');
Route::get('/repeat-data-pendaftaran/{id}', [TDaftarHajiController::class, 'repeatDataPendaftaran']);
Route::post('/repeat-data-pendaftaran/{id}', [TDaftarHajiController::class, 'storeRepeatData'])->name('pendaftaran-haji-storeRepeatData');

Route::get('/ambil-semua-data-pendaftaran/{id}', [TDaftarHajiController::class, 'ambilSemuaData']);
Route::post('/ambil-semua-data-pendaftaran/{id}/store', [TDaftarHajiController::class, 'storeAmbilSemuaData'])->name('pendaftaran-haji-ambilSemuaData');

// Route Gabung Haji
Route::resource('/gabung-haji', TGabungHajiController::class);
Route::get('/search-gabung', [TGabungHajiController::class, 'search'])->name('gabung.search');
Route::get('/repeat-data-gabung/{id}', [TGabungHajiController::class, 'repeatDataGabung']);
Route::post('/repeat-data-gabung/{id}', [TGabungHajiController::class, 'storeRepeatData'])->name('gabung-haji.storeRepeatData');

Route::get('/ambil-semua-data-gabung/{id}', [TGabungHajiController::class, 'ambilSemuaData']);
Route::post('/ambil-semua-data-gabung/{id}/store', [TGabungHajiController::class, 'storeAmbilSemuaData'])->name('gabung-haji.ambilSemuaData');

// Route::post('/get-location-options', function (Request $request) {
//     $provinsi = $request->input('provinsi');
//     $kota = $request->input('kota');
//     $kecamatan = $request->input('kecamatan');
//     $kelurahan = $request->input('kelurahan');

//     $kotaOptions = '<option value="">Pilih Kota</option>';
//     $kecamatanOptions = '<option value="">Pilih Kecamatan</option>';
//     $kelurahanOptions = '<option value="">Pilih Kelurahan</option>';

//     // Ambil data kota berdasarkan provinsi
//     if ($provinsi) {
//         $kotaList = DB::table('kota')->where('provinsi_id', $provinsi)->get();
//         foreach ($kotaList as $k) {
//             $selected = $k->id == $kota ? "selected" : "";
//             $kotaOptions .= "<option value='{$k->id}' $selected>{$k->nama}</option>";
//         }
//     }

//     // Ambil data kecamatan berdasarkan kota
//     if ($kota) {
//         $kecamatanList = DB::table('kecamatan')->where('kota_id', $kota)->get();
//         foreach ($kecamatanList as $kec) {
//             $selected = $kec->id == $kecamatan ? "selected" : "";
//             $kecamatanOptions .= "<option value='{$kec->id}' $selected>{$kec->nama}</option>";
//         }
//     }

//     // Ambil data kelurahan berdasarkan kecamatan
//     if ($kecamatan) {
//         $kelurahanList = DB::table('kelurahan')->where('kecamatan_id', $kecamatan)->get();
//         foreach ($kelurahanList as $kel) {
//             $selected = $kel->id == $kelurahan ? "selected" : "";
//             $kelurahanOptions .= "<option value='{$kel->id}' $selected>{$kel->nama}</option>";
//         }
//     }

//     return response()->json([
//         'kotaOptions' => $kotaOptions,
//         'kecamatanOptions' => $kecamatanOptions,
//         'kelurahanOptions' => $kelurahanOptions
//     ]);
// });

// Route Customer Master
Route::resource('/customer', CustomerController::class);
Route::get('/get-kota/{provinsi_id}', [CustomerController::class, 'getKota']);
Route::get('/get-kecamatan/{kota_id}', [CustomerController::class, 'getKecamatan']);
Route::get('/get-kelurahan/{kecamatan_id}', [CustomerController::class, 'getKelurahan']);
Route::get('/get-kodepos/{kelurahan_id}', [CustomerController::class, 'getKodePos']);

// Route::get('/search-customer', [CustomerController::class, 'search'])->name('customer.search');
// Route::get('/repeat-data-customer/{id}', [CustomerController::class, 'repeatDataCustomer']);
// Route::post('/repeat-data-customer/{id}/store', [CustomerController::class, 'storeRepeatData'])->name('store-repeat-data');

// Route::get('/ambil-semua-data-customer/{id}', [CustomerController::class, 'ambilSemuaData']);
// Route::post('/ambil-semua-data-customer/{id}/store', [CustomerController::class, 'storeAmbilSemuaData'])->name('store-ambil-semua-data');
