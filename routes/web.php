<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TDaftarHajiController;
use App\Http\Controllers\TGabungHajiController;
use Illuminate\Support\Facades\Route;

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

// Route Gabung Haji
Route::resource('/gabung-haji', TGabungHajiController::class);

// Route Customer Master
Route::resource('/customer', CustomerController::class);
Route::get('/get-kota/{provinsi_id}', [CustomerController::class, 'getKota']);
Route::get('/get-kecamatan/{kota_id}', [CustomerController::class, 'getKecamatan']);
Route::get('/get-kelurahan/{kecamatan_id}', [CustomerController::class, 'getKelurahan']);
Route::get('/get-kodepos/{kelurahan_id}', [CustomerController::class, 'getKodePos']);
