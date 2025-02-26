<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
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

Route::get('/cabang/search', [TDaftarHajiController::class, 'searchCabang'])->name('cabang.search');
Route::get('/wilayah/search', [TDaftarHajiController::class, 'searchWilayah'])->name('wilayah.search');
Route::get('/tempat-lahir/search', [TDaftarHajiController::class, 'searchTempatLhr'])->name('tempat-lahir.search');
Route::get('/search-provinsi', [TDaftarHajiController::class, 'searchProvinsi'])->name('provinsi.search');
Route::get('/search-kota/{provinsi_id}', [TDaftarHajiController::class, 'searchKota']);
Route::get('/search-kecamatan/{kota_id}', [TDaftarHajiController::class, 'searchKecamatan']);
Route::get('/search-kelurahan/{kecamatan_id}', [TDaftarHajiController::class, 'searchKelurahan']);



Route::get('/search-pendaftaran', [TDaftarHajiController::class, 'search'])->name('pendaftaran.search');
Route::get('/repeat-data-pendaftaran/{id}', [TDaftarHajiController::class, 'repeatDataPendaftaran']);
Route::post('/repeat-data-pendaftaran/{id}', [TDaftarHajiController::class, 'storeRepeatData'])->name('pendaftaran-haji-storeRepeatData');

Route::post('/ambil-semua-data-pendaftaran/{id}/store', [TDaftarHajiController::class, 'storeAmbilSemuaData'])->name('pendaftaran-haji-ambilSemuaData');
Route::get('/ambil-semua-data-pendaftaran/{id}', [TDaftarHajiController::class, 'ambilSemuaData']);

// Cetak PDF
Route::get('/daftar-haji/{id}/cetak', [PdfController::class, 'cetak'])->name('daftar_haji.cetak');

// Route Gabung Haji
Route::resource('/gabung-haji', TGabungHajiController::class);
Route::get('/search-gabung', [TGabungHajiController::class, 'search'])->name('gabung.search');
Route::get('/repeat-data-gabung/{id}', [TGabungHajiController::class, 'repeatDataGabung']);
Route::post('/repeat-data-gabung/{id}', [TGabungHajiController::class, 'storeRepeatData'])->name('gabung-haji.storeRepeatData');

Route::get('/ambil-semua-data-gabung/{id}', [TGabungHajiController::class, 'ambilSemuaData']);
Route::post('/ambil-semua-data-gabung/{id}/store', [TGabungHajiController::class, 'storeAmbilSemuaData'])->name('gabung-haji.ambilSemuaData');

// Route Customer Master
Route::resource('/customer', CustomerController::class);
// Route::get('/get-kota/{provinsi_id}', [CustomerController::class, 'getKota']);
// Route::get('/get-kecamatan/{kota_id}', [CustomerController::class, 'getKecamatan']);
// Route::get('/get-kelurahan/{kecamatan_id}', [CustomerController::class, 'getKelurahan']);
// Route::get('/get-kodepos/{kelurahan_id}', [CustomerController::class, 'getKodePos']);

// Route::get('/search-customer', [CustomerController::class, 'search'])->name('customer.search');
// Route::get('/repeat-data-customer/{id}', [CustomerController::class, 'repeatDataCustomer']);
// Route::post('/repeat-data-customer/{id}/store', [CustomerController::class, 'storeRepeatData'])->name('store-repeat-data');

// Route::get('/ambil-semua-data-customer/{id}', [CustomerController::class, 'ambilSemuaData']);
// Route::post('/ambil-semua-data-customer/{id}/store', [CustomerController::class, 'storeAmbilSemuaData'])->name('store-ambil-semua-data');
