<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TDaftarHajiController;
use App\Http\Controllers\TGabungHajiController;
use App\Http\Controllers\PencarianSelect2Controller;
use App\Http\Controllers\GroupKeberangkatanController;

Route::middleware(['guest'])->group(function () {
  Route::get('/', [SessionController::class, 'index'])->name('login');
  Route::post('/', [SessionController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index']);
  Route::post('/logout', [SessionController::class, 'logout']);
  Route::get('/logout', function () {
    return redirect('/');
  });

  // Route User
  Route::resource('/user', UserController::class);

  // Route Pendaftaran Haji
  Route::resource('/pendaftaran-haji', TDaftarHajiController::class);
  Route::get('/get-cabang/{id}', [TDaftarHajiController::class, 'getCabang']);
  Route::get('/get-kota/{provinsi_id}', [TDaftarHajiController::class, 'getKota']);
  Route::get('/get-kecamatan/{kota_id}', [TDaftarHajiController::class, 'getKecamatan']);
  Route::get('/get-kelurahan/{kecamatan_id}', [TDaftarHajiController::class, 'getKelurahan']);
  Route::get('/get-kodepos/{kelurahan_id}', [TDaftarHajiController::class, 'getKodePos']);

  Route::get('/cabang/search', [PencarianSelect2Controller::class, 'searchCabang'])->name('cabang.search');
  Route::get('/wilayah/search', [PencarianSelect2Controller::class, 'searchWilayah'])->name('wilayah.search');
  Route::get('/tempat-lahir/search', [PencarianSelect2Controller::class, 'searchTempatLhr'])->name('tempat-lahir.search');
  Route::get('/search-provinsi', [PencarianSelect2Controller::class, 'searchProvinsi'])->name('provinsi.search');
  Route::get('/search-kota/{provinsi_id}', [PencarianSelect2Controller::class, 'searchKota']);
  Route::get('/search-kecamatan/{kota_id}', [PencarianSelect2Controller::class, 'searchKecamatan']);
  Route::get('/search-kelurahan/{kecamatan_id}', [PencarianSelect2Controller::class, 'searchKelurahan']);
  Route::get('/kota-bank/search', [PencarianSelect2Controller::class, 'searchKotaBank'])->name('kota-bank.search');
  Route::get('/depag/search', [PencarianSelect2Controller::class, 'searchDepag'])->name('depag.search');
  Route::get('/keberangkatan/search', [PencarianSelect2Controller::class, 'searchKeberangkatan'])->name('keberangkatan.search');

  Route::get('/get-no-porsi', [PencarianSelect2Controller::class, 'searchNoPorsi']);
  Route::get('/filter-no-porsi', [PencarianSelect2Controller::class, 'filterNoPorsi']);

  Route::get('/search-pendaftaran', [TDaftarHajiController::class, 'search'])->name('pendaftaran.search');
  Route::get('/repeat-data-pendaftaran/{id}', [TDaftarHajiController::class, 'repeatDataPendaftaran']);
  Route::post('/repeat-data-pendaftaran', [TDaftarHajiController::class, 'storeRepeatData'])->name('pendaftaran-haji-storeRepeatData');

  Route::get('/ambil-semua-data-pendaftaran/{id}', [TDaftarHajiController::class, 'ambilSemuaData']);
  Route::post('/ambil-semua-data-pendaftaran', [TDaftarHajiController::class, 'storeAmbilSemuaData'])->name('pendaftaran-haji-ambilSemuaData');

  // Route Gabung Haji
  Route::resource('/gabung-haji', TGabungHajiController::class);
  Route::get('/search-gabung', [TGabungHajiController::class, 'search'])->name('gabung.search');
  Route::get('/repeat-data-gabung/{id}', [TGabungHajiController::class, 'repeatDataGabung']);
  Route::post('/repeat-data-gabung', [TGabungHajiController::class, 'storeRepeatData'])->name('gabung-haji.storeRepeatData');

  Route::get('/ambil-semua-data-gabung/{id}', [TGabungHajiController::class, 'ambilSemuaData']);
  Route::post('/ambil-semua-data-gabung', [TGabungHajiController::class, 'storeAmbilSemuaData'])->name('gabung-haji.ambilSemuaData');

  // Cetak PDF
  Route::get('/daftar-haji/{id}/cetak', [PdfController::class, 'cetakPendaftaran'])->name('daftar_haji.cetak');
  Route::get('/gabung-haji/{id}/cetak', [PdfController::class, 'cetakGabung'])->name('gabung_haji.cetak');
  Route::get('/pembayaran/{id}/cetak', [PdfController::class, 'cetakPembayaran']);

  // Route Keberangkatan
  Route::resource('/keberangkatan', GroupKeberangkatanController::class);
  Route::get('/tahun-keberangkatan', [GroupKeberangkatanController::class, 'tahun_keberangkatan']);
  Route::post('/simpan-peserta-keberangkatan', [GroupKeberangkatanController::class, 'simpanPesertaKeberangkatan'])
    ->name('simpan.peserta.keberangkatan');
  Route::post('/keberangkatan/hapus', [GroupKeberangkatanController::class, 'hapusPesertaKeberangkatan'])
    ->name('hapus.peserta.keberangkatan');

  Route::get('/filter-keberangkatan', [DashboardController::class, 'filterKeberangkatan'])->name('filter.keberangkatan');

  // Route Pembayaran
  Route::get('/pembayaran/{id}', [PembayaranController::class, 'index']);
  Route::post('/pembayaran/{id}', [PembayaranController::class, 'store']);
  // Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
  Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy']);
});
