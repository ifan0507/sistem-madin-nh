@extends('layout.template')
@section('content')
    <style>
        .rapor-container {
            background: #fff;
            padding: 30px;
            color: #000;
            font-family: 'Times New Roman', Times, serif;
        }

        .rapor-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .rapor-table th,
        .rapor-table td {
            border: 2px solid #000;
            padding: 6px 10px;
            vertical-align: middle;
        }

        .rapor-table th {
            text-align: center;
            font-weight: bold;
        }

        .input-rapor {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-family: 'Times New Roman', Times, serif;
            font-size: 1rem;
        }

        .input-rapor:focus {
            background: #f0f8ff;
        }

        .kop-surat {
            border-bottom: 4px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
    </style>

    <div class="content">
        <div class="container-fluid py-4">

            <div class="d-flex justify-content-start gap-2 mb-3">
                <a href="{{ route('rapor') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i>
                    Kembali</a>
                <div>
                    <a href="{{ route('rapor.cetak-single', ['santriId' => $santri->id, 'kelasId' => $kelas->id, 'semester' => $semester, 'tahun_ajaran' => $tahun_ajaran]) }}"
                        class="btn btn-success btn-sm" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body rapor-container">

                    {{-- KOP SURAT --}}
                    <div class="kop-surat text-center position-relative">
                        <img src="{{ asset('assets/images/logo_pondok.png') }}"
                            style="position: absolute; left: 10px; top: 10px; width: 100px;">
                        <h5 class="mb-0 font-weight-bold" style="color: #003366;">YAYASAN PONDOK PESANTREN NURUL HUDA</h5>
                        <p class="mb-0" style="font-size: 14px;">Akte Notaris : TAUFIQ HIDAYAT, SH., M, Kn No. 93 / 2015
                        </p>
                        <p class="mb-0" style="font-size: 14px;">(AHU-0558.AH.02.01.TAHUN 2010)</p>
                        <h4 class="mb-0 font-weight-bold mt-2" style="color: #003366; text-decoration: underline;">MADIN
                            NURUL HUDA</h4>
                        <h6 class="mb-0 font-weight-bold" style="color: #003366;">MANGUNSARI TEKUNG LUMAJANG 67381</h6>
                        <p class="mb-0 font-weight-bold">NSMD : 123235080116</p>
                        <div style="border-top: 2px solid #000; margin-top: 5px; font-size: 13px;">
                            Sekretariat : Jl. Pesantren No.178 Mangunsari Tekung Lumajang Hp. 0822-4718-6060
                        </div>
                    </div>

                    <h5 class="text-center font-weight-bold mb-4">LAPORAN HASIL PENILAIAN SEMESTER
                        {{ strtoupper($semester) }}</h5>

                    {{-- FORM MULAI --}}
                    {{-- BIODATA SANTRI --}}
                    <div class="row mb-3" style="font-weight: bold; font-size: 15px;">
                        <div class="col-7">
                            <table style="width: 100%">
                                <tr>
                                    <td width="30%">Nama Santri</td>
                                    <td width="5%">:</td>
                                    <td>{{ $santri->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Induk</td>
                                    <td>:</td>
                                    <td>{{ $santri->nis }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>:</td>
                                    <td>{{ $santri->nisn ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-5">
                            <table style="width: 100%">
                                <tr>
                                    <td width="30%">Kelas</td>
                                    <td width="5%">:</td>
                                    <td>{{ getKelasArab($kelas->id) }}</td>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <td>:</td>
                                    <td>{{ $semester }}</td>
                                </tr>
                                <tr>
                                    <td>Tahun</td>
                                    <td>:</td>
                                    <td>{{ $tahun_ajaran }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- TABEL NILAI --}}
                    <table class="rapor-table" style="width: 100%; border-collapse: collapse;" border="1">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th rowspan="2" width="5%" class="text-center">No</th>
                                <th rowspan="2" width="35%" class="text-center">Mata Pelajaran</th>
                                <th rowspan="2" width="10%" class="text-center">KKM</th>
                                <th colspan="2" class="text-center">Nilai</th>
                                <th rowspan="2" width="15%" class="text-center">Rata-rata<br>Ketuntasan<br>Kelas (%)
                                </th>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <th width="10%" class="text-center">Angka</th>
                                <th width="25%" class="text-center">Huruf</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="text-center">1</td>
                                <td colspan="5" class="bg-light">Pendidikan Al-Qur'an</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="ps-3">a. Qiro'atul Qur'an</td>
                                <td class="text-center">70</td>
                                <td
                                    class="text-center {{ ($nilaiPraktek->al_quran ?? 0) < 70 ? 'text-danger font-weight-bold' : '' }}">
                                    {{ $nilaiPraktek->al_quran ?? 0 }}
                                </td>
                                <td class="text-center">{{ angkaKeHuruf($nilaiPraktek->al_quran ?? 0) }}</td>
                                <td class="text-center">{{ $rataPraktekQuran }}</td>
                            </tr>

                            @foreach ($list_nilai as $index => $nilai)
                                <tr>
                                    <td class="text-center">{{ $index + 2 }}</td>
                                    <td class="ps-3">{{ $nilai['nama_mapel'] }}</td>
                                    <td class="text-center">{{ $nilai['kkm'] }}</td>
                                    <td
                                        class="text-center {{ $nilai['angka'] < $nilai['kkm'] ? 'text-danger font-weight-bold' : '' }}">
                                        {{ $nilai['angka'] }}
                                    </td>
                                    <td class="text-center">{{ $nilai['huruf'] }}</td>
                                    <td class="text-center">{{ number_format($nilai['rata_kelas'], 2) }}</td>
                                </tr>
                            @endforeach

                            @php
                                $lastNo = count($list_nilai) + 2;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $lastNo }}</td>
                                <td colspan="5" class="bg-light">Muatan Lokal</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="ps-3">a. Muhafadloh</td>
                                <td class="text-center">70</td>
                                <td
                                    class="text-center {{ ($nilaiPraktek->muhafadloh ?? 0) < 70 ? 'text-danger font-weight-bold' : '' }}">
                                    {{ $nilaiPraktek->muhafadloh ?? 0 }}
                                </td>
                                <td class="text-center">{{ angkaKeHuruf($nilaiPraktek->muhafadloh ?? 0) }}</td>
                                <td class="text-center">{{ $rataPraktekMuhafadloh }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="ps-3">b. Qiro'atul Kutub</td>
                                <td class="text-center">70</td>
                                <td
                                    class="text-center {{ ($nilaiPraktek->kitab ?? 0) < 70 ? 'text-danger font-weight-bold' : '' }}">
                                    {{ $nilaiPraktek->kitab ?? 0 }}
                                </td>
                                <td class="text-center">{{ angkaKeHuruf($nilaiPraktek->kitab ?? 0) }}</td>
                                <td class="text-center">{{ $rataPraktekKitab }}</td>
                            </tr>

                            <tr style="background-color: #f8f9fa;">
                                <td colspan="3" class="font-weight-bold text-center">JUMLAH KESELURUHAN</td>
                                <td colspan="3" class="font-weight-bold text-center">{{ $total_nilai }}</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td colspan="3" class="font-weight-bold text-center">PERINGKAT KELAS</td>
                                <td colspan="3" class="font-weight-bold text-center">{{ $peringkat }}</td>
                            </tr>

                            <tr>
                                <td rowspan="3" class="font-weight-bold text-center align-middle">PERILAKU</td>
                                <td colspan="2" class="ps-3">Kerapian</td>
                                <td colspan="3" class="text-center">{{ $rapor->sikap_kerapian ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="ps-3">Kerajinan</td>
                                <td colspan="3" class="text-center">{{ $rapor->sikap_kerajinan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="ps-3">Ketertiban</td>
                                <td colspan="3" class="text-center">{{ $rapor->sikap_ketertiban ?? '-' }}</td>
                            </tr>

                            <tr>
                                <td rowspan="3" class="font-weight-bold text-center align-middle">KETIDAK<br>HADIRAN
                                </td>
                                <td colspan="2" class="ps-3">Sakit</td>
                                <td colspan="3" class="text-center">{{ $rapor->absen_sakit ?? 0 }} Hari</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="ps-3">Izin</td>
                                <td colspan="3" class="text-center">{{ $rapor->absen_izin ?? 0 }} Hari</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="ps-3">Tanpa Keterangan</td>
                                <td colspan="3" class="text-center">{{ $rapor->absen_alfa ?? 0 }} Hari</td>
                            </tr>

                            <tr>
                                <td colspan="3" class="font-weight-bold text-center" style="letter-spacing: 5px;">
                                    CATATAN</td>
                                <td colspan="3" class="text-center align-middle">
                                    {{ $rapor->catatan ?? 'Pertahankan prestasimu dengan giat belajar' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- TANDA TANGAN --}}
                    <div class="row mt-5 text-center" style="font-weight: bold;">
                        <div class="col-4">
                            <br>
                            WALI MURID
                            <br><br><br><br>
                            _____________________
                        </div>
                        <div class="col-4 position-relative">
                            Mengetahui;<br>Kepala Madin
                            <br><br><br><br>
                            <u>M. ZUHRI YAQIN, S.Pd</u>
                        </div>
                        <div class="col-4">
                            Lumajang, {{ date('d F Y') }}<br>
                            WALI KELAS
                            <br><br><br><br>
                            <u>{{ $kelas->wali_kelas->name ?? '_____________________' }}</u>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
