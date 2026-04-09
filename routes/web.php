<?php

use App\Http\Controllers\Web\AbsensiGuruWebController;
use App\Http\Controllers\Web\AbsensiSantriWebController;
use App\Http\Controllers\Web\BankSoalWebController;
use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\DenahUjianWebController;
use App\Http\Controllers\Web\GuruWebController;
use App\Http\Controllers\Web\JadwalKbmWebController;
use App\Http\Controllers\Web\JadwalUjianWebController;
use App\Http\Controllers\Web\KelasWebController;
use App\Http\Controllers\Web\MapelKelasWebController;
use App\Http\Controllers\Web\MapelWebController;
use App\Http\Controllers\Web\NilaiUjianPraktekWebController;
use App\Http\Controllers\Web\NilaiUjianWebController;
use App\Http\Controllers\Web\PengaturanWebController;
use App\Http\Controllers\Web\RaporWebController;
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
Route::get('/kelas/data-modal-wali', [KelasWebController::class, 'getDataModalWali'])->name('kelas.modal-wali');
Route::post('/kelas/update-wali', [KelasWebController::class, 'updateWali'])->name('kelas.update-wali');

// Mapel
Route::get('/mapel', [MapelWebController::class, 'index'])->name('mapel');
Route::post('/mapel/store', [MapelWebController::class, 'store'])->name('mapel.store');
Route::put('/mapel/{id}/update', [MapelWebController::class, 'update'])->name('mapel.update');
Route::delete('/mapel/{id}/delete', [MapelWebController::class, 'destroy'])->name('mapel.destroy');

// Mapel Kelas
Route::get('/mapel-kelas', [MapelKelasWebController::class, 'index'])->name('mapel-kelas');
Route::get('/mapel-kelas/kelas/{kelas_id}', [MapelKelasWebController::class, 'getMapelKelasByKelas'])->name('mapel-kelas.getMapelKelasByKelas');
Route::get('/mapel-kelas/kelas/jadwal-kbm/{kelas_id}', [MapelKelasWebController::class, 'getMapelKelasByKelasForJadwalKbm'])->name('mapel-kelas.getMapelKelasByKelasForJadwalKbm');
Route::get('/mapel-kelas/guru', [MapelKelasWebController::class, 'getAllGuru'])->name('mapel-kelas.getAllGuru');
Route::get('/mapel-kelas/mapel', [MapelKelasWebController::class, 'getAllMapel'])->name('mapel-kelas.getAllMapel');
Route::post('/mapel-kelas/store', [MapelKelasWebController::class, 'store'])->name('mapel-kelas.store');
Route::put('/mapel-kelas/{id}/update', [MapelKelasWebController::class, 'update'])->name('mapel-kelas.update');
Route::delete('/mapel-kelas/{id}/delete', [MapelKelasWebController::class, 'destroy'])->name('mapel-kelas.destroy');

// Jadwal KBM
Route::get('/jadwal-kbm', [JadwalKbmWebController::class, 'index'])->name('jadwal-kbm');
Route::post('/jadwal-kbm/store', [JadwalKbmWebController::class, 'store'])->name('jadwal-kbm.store');
Route::get('/jadwal-kbm/cetak', [JadwalKbmWebController::class, 'cetak'])->name('jadwal-kbm.cetak');

// Denah Ujian
Route::get('/denah-ujian', [DenahUjianWebController::class, 'index'])->name('denah-ujian');
Route::post('/denah-ujian/generate', [DenahUjianWebController::class, 'generate'])->name('denah-ujian.generate');
Route::post('/denah-ujian/{id}/acak-ulang', [DenahUjianWebController::class, 'acakUlang'])->name('denah-ujian.acak-ulang');
Route::delete('/denah-ujian/{id}/delete', [DenahUjianWebController::class, 'destroy'])->name('denah.destroy');
Route::get('/denah-ujian/cetak/{id}', [DenahUjianWebController::class, 'cetakDenah'])->name('denah-ujian.cetak-denah');
Route::get('/denah-ujian/cetak-kartu/{id}', [DenahUjianWebController::class, 'cetakKartu'])->name('denah-ujian.cetak-kartu');

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
Route::get('/jadwal-ujian/cetak', [JadwalUjianWebController::class, 'cetak'])->name('jadwal-ujian.cetak');

// Route Nilai Ujian
Route::get('/nilai-ujian', [NilaiUjianWebController::class, 'index'])->name('nilai-ujian');
Route::get('/nilai-ujian/ajax', [NilaiUjianWebController::class, 'getNilaiAjax'])->name('nilai-ujian.ajax');

// Route Nilai Ujian Praktek
Route::get('/nilai-ujian-praktek', [NilaiUjianPraktekWebController::class, 'index'])->name('nilai-ujian-praktek');
Route::post('/nilai-ujian-praktek/store', [NilaiUjianPraktekWebController::class, 'store'])->name('nilai-ujian-praktek.store');
Route::get('/nilai-praktek/get-santri/{kelasId}', [NilaiUjianPraktekWebController::class, 'getSantriByKelas']);
Route::post('/nilai-praktek/store-bulk', [NilaiUjianPraktekWebController::class, 'storeBulk'])->name('nilai-ujian-praktek.store-bulk');

// Rapor
Route::get('/rapor', [RaporWebController::class, 'index'])->name('rapor');
Route::get('/rapor/santri-kelas', [RaporWebController::class, 'getSantriKelasFromRapor'])->name('rapor.getSantriKelasFromRapor');
Route::get('/rapor/kelas/{kelas_id}/santri/{santri_id}', [RaporWebController::class, 'detail'])->name('rapor.detail');
Route::post('/rapor/bulk-create', [RaporWebController::class, 'bulkCreate'])->name('rapor.bulk-create');
Route::get('/rapor/kelas/{kelasId}/ranking', [RaporWebController::class, 'getRankingKelas'])->name('rapor.getRankingKelas');
Route::get('/rapor/kelas/{kelasId}/santri/{santriId}/cetak', [RaporWebController::class, 'cetakSingle'])->name('rapor.cetak-single');
Route::get('/rapor/kelas/{kelasId}/cetak-massal', [RaporWebController::class, 'cetakBulk'])->name('rapor.cetak-bulk');
Route::get('/rapor/kelas/{kelasId}/cetak-juara', [RaporWebController::class, 'cetakDaftarJuara'])->name('rapor.cetak-daftar-juara');

// Route Absensi Santri
Route::get('/absensi-santri', [AbsensiSantriWebController::class, 'index'])->name('absensi-santri');
Route::post('/absensi/ajax', [AbsensiSantriWebController::class, 'getAbsensiAjax'])->name('absensi.ajax');
Route::get('/absensi/export-excel', [AbsensiSantriWebController::class, 'exportExcel'])->name('absensi.export_excel');
Route::get('/absensi/export-rekap', [AbsensiSantriWebController::class, 'exportExcelRekap'])->name('absensi.export_rekap');

Route::get('/absensi-guru', [AbsensiGuruWebController::class, 'index'])->name('absensi-guru');
Route::post('/absensi-guru/ajax', [AbsensiGuruWebController::class, 'getAbsensiGuruAjax'])->name('absensi-guru.ajax');
// Route::get('/transliterate', [PegonController::class, 'transliterate']);
