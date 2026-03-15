<?php

use App\Http\Controllers\Web\BankSoalWebController;
use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\DenahUjianWebController;
use App\Http\Controllers\Web\GuruWebController;
use App\Http\Controllers\Web\JadwalKbmWebController;
use App\Http\Controllers\Web\JadwalUjianWebController;
use App\Http\Controllers\Web\KelasWebController;
use App\Http\Controllers\Web\MapelKelasWebController;
use App\Http\Controllers\Web\MapelWebController;
use App\Http\Controllers\Web\PengaturanWebController;
use App\Http\Controllers\Web\SantriWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardWebController::class, 'index']);
Route::post('/pengaturan/{id}/update', [PengaturanWebController::class, 'update'])->name('pengaturan.update');
// Santri

Route::get('/santri', [SantriWebController::class, 'index'])->name('santri');
Route::get('/santri/create', [SantriWebController::class, 'create'])->name('santri.create');
Route::post('/santri/store', [SantriWebController::class, 'store'])->name('santri.store');
Route::get('/santri/{id}/detail', [SantriWebController::class, 'show'])->name('santri.show');
Route::get('/santri/nis/{nis}/detail', [SantriWebController::class, 'showByNis'])->name('santri.showByNis');
Route::get('/santri/{id}/edit', [SantriWebController::class, 'edit'])->name('santri.edit');
Route::put('/santri/{id}/update', [SantriWebController::class, 'update'])->name('santri.update');
Route::delete('/santri/{id}/delete', [SantriWebController::class, 'destroy'])->name('santri.destroy');
Route::delete('/santri/{id}/delete-kelas', [SantriWebController::class, 'destroyKelas']);
Route::put('/santri/bulk-update-kelas', [SantriWebController::class, 'updateKelasBulk'])->name('santri.updateKelasBulk');

// guru
Route::get('/guru', [GuruWebController::class, 'index']);
Route::get('/guru/get-guru', [GuruWebController::class, 'findAll'])->name('guru.getGuru');
Route::get('/guru/generate-token', [GuruWebController::class, 'generateToken'])->name('guru.generate-token');
Route::post('/guru/store', [GuruWebController::class, 'store'])->name('guru.store');
Route::put('/guru/{id}/update', [GuruWebController::class, 'update'])->name('guru.update');
Route::delete('/guru/{id}/delete', [GuruWebController::class, 'destroy'])->name('guru.destroy');

// Kelas
Route::get('/kelas', [KelasWebController::class, 'index'])->name('kelas');
Route::get('/kelas/santri-kelas/{kelas_id}', [KelasWebController::class, 'getSantriByKelas'])->name('kelas.getSantriByKelas');

// Mapel
Route::get('/mapel', [MapelWebController::class, 'index'])->name('mapel');
Route::post('/mapel/store', [MapelWebController::class, 'store'])->name('mapel.store');
Route::put('/mapel/{id}/update', [MapelWebController::class, 'update'])->name('mapel.update');
Route::delete('/mapel/{id}/delete', [MapelWebController::class, 'destroy'])->name('mapel.destroy');

// Mapel Kelas
Route::get('/mapel-kelas', [MapelKelasWebController::class, 'index'])->name('mapel-kelas');
Route::get('/mapel-kelas/kelas/{kelas_id}', [MapelKelasWebController::class, 'getMapelKelasByKelas'])->name('mapel-kelas.getMapelKelasByKelas');
Route::get('/mapel-kelas/guru', [MapelKelasWebController::class, 'getAllGuru'])->name('mapel-kelas.getAllGuru');
Route::get('/mapel-kelas/mapel', [MapelKelasWebController::class, 'getAllMapel'])->name('mapel-kelas.getAllMapel');
Route::post('/mapel-kelas/store', [MapelKelasWebController::class, 'store'])->name('mapel-kelas.store');
Route::put('/mapel-kelas/{id}/update', [MapelKelasWebController::class, 'update'])->name('mapel-kelas.update');
Route::delete('/mapel-kelas/{id}/delete', [MapelKelasWebController::class, 'destroy'])->name('mapel-kelas.destroy');

// Jadwal KBM
Route::get('/jadwal-kbm', [JadwalKbmWebController::class, 'index'])->name('jadwal-kbm');
Route::post('/jadwal-kbm/store', [JadwalKbmWebController::class, 'store'])->name('jadwal-kbm.store');

// Denah Ujian
Route::get('/denah-ujian', [DenahUjianWebController::class, 'index'])->name('denah-ujian');
Route::post('/denah-ujian/generate', [DenahUjianWebController::class, 'generate'])->name('denah-ujian.generate');
Route::post('/denah-ujian/{id}/acak-ulang', [DenahUjianWebController::class, 'acakUlang'])->name('denah-ujian.acak-ulang');
Route::delete('/denah-ujian/{id}/delete', [DenahUjianWebController::class, 'destroy'])->name('denah.destroy');
Route::get('/denah-ujian/{id}/cetak-kartu', [DenahUjianWebController::class, 'cetakKartu'])->name('denah-ujian.cetak-kartu');

// Bank Soal
Route::get('/bank-soal', [BankSoalWebController::class, 'index'])->name('bank-soal');
Route::get('/bank-soal/{id}/cetak', [BankSoalWebController::class, 'cetakSoal'])->name('bank-soal.cetak');
Route::get('/bank-soal/{id}/preview', [BankSoalWebController::class, 'show'])->name('bank-soal.preview');
Route::post('/bank-soal/{id}/update-soal', [BankSoalWebController::class, 'update'])->name('bank-soal.update-soal');
Route::post('/bank-soal/generate', [BankSoalWebController::class, 'generate'])->name('bank-soal.generate');

// Jadwal Ujian
Route::get('/jadwal-ujian', [JadwalUjianWebController::class, 'index'])->name('jadwal-ujian');
Route::post('/jadwal-ujian/update-tanggal', [JadwalUjianWebController::class, 'updateTanggal'])->name('jadwal-ujian.update-tanggal');
Route::post('/jadwal-ujian/update-mapel', [JadwalUjianWebController::class, 'updateMapel'])->name('jadwal-ujian.update-mapel');
Route::post('/jadwal-ujian/update-pengawas', [JadwalUjianWebController::class, 'updatePengawas'])->name('jadwal-ujian.update-pengawas');
// Route::get('/transliterate', [PegonController::class, 'transliterate']);
