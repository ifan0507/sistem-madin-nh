<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rapor Santri</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo_pondok.png') }}">
    <style>
        @page {
            size: 215.9mm 330mm portrait;
            margin: 1cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .page-break:last-child {
            page-break-after: auto;
        }

        .kop-surat {
            width: 100%;
            border-bottom: 3px double #000;
            margin-bottom: 15px;
        }

        .kop-surat table {
            width: 100%;
            border: none;
        }

        .kop-surat td {
            border: none;
            padding: 0;
            text-align: center;
        }

        .table-nilai {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid;
        }

        .table-nilai th,
        .table-nilai td {
            border: 1px solid;
            padding: 4px 6px;
            vertical-align: middle;
        }

        .table-nilai th {
            text-align: center;
            font-weight: bold;
        }

        .bg-arsir {
            background-color: #d9d9d9 !important;
            background-image: repeating-linear-gradient(45deg, transparent, transparent 2px, #888 2px, #888 3px) !important;

            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .ps-3 {
            padding-left: 15px !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        @media print {
            #btn-print-manual {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button id="btn-print-manual" onclick="window.print()"
        style="padding: 10px; margin: 10px; cursor: pointer; background: #2dce89; color: white; border: none; border-radius: 5px;">Cetak
        Sekarang</button>

    @foreach ($kumpulan_rapor as $data)
        <div class="page-break">

            <div class="kop-surat">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="15%" style="vertical-align: middle; padding-bottom: 5px;">
                            <img src="{{ asset('assets/images/logo_pondok.png') }}" alt="Logo"
                                style="width: 90px; height: auto;">
                        </td>
                        <td width="85%" style="vertical-align: middle; padding-bottom: 5px;">
                            <div style="font-weight: bold; font-size: 14pt;">YAYASAN PONDOK PESANTREN
                                NURUL HUDA</div>

                            <div style="font-weight: bold; font-size: 11pt;">Akte Notaris : TAUFIQ HIDAYAT, SH., M, Kn
                                No. 93 / 2015</div>
                            <div style="font-weight: bold; font-size: 11pt;">(AHU-0558.AH.02.01.TAHUN 2010)</div>
                            <div style="font-weight: bold; font-size: 18pt; margin: 3px 0;">MADIN NURUL
                                HUDA</div>
                            <div style="font-weight: bold; font-size: 12pt;">MANGUNSARI TEKUNG LUMAJANG 67381</div>
                            <div style="font-weight: bold; font-size: 11pt;">NSMD : 123235080116</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            style="border-top: 1.5px solid #000; padding-top: 4px; padding-bottom: 2px; font-size: 10pt;">
                            Sekretariat : Jl. Pesantren No.178 Mangunsari Tekung Lumajang Hp. 0822-4718-6060
                        </td>
                    </tr>
                </table>
            </div>

            <div class="text-center font-weight-bold" style="margin-bottom: 15px; font-size: 12pt;">
                LAPORAN HASIL PENILAIAN SEMESTER {{ strtoupper($data['semester']) }}
            </div>

            <table style="width: 100%; border: none; font-size: 11pt; margin-bottom: 5px;">
                <tr>
                    <td width="20%" style="border: none; padding: 2px;">Nama Santri</td>
                    <td width="2%" style="border: none; padding: 2px;">:</td>
                    <td width="43%" style="border: none; padding: 2px;">{{ strtoupper($data['santri']->nama) }}</td>

                    <td width="15%" style="border: none; padding: 2px;">Kelas</td>
                    <td width="2%" style="border: none; padding: 2px;">:</td>
                    <td width="18%" style="border: none; padding: 2px;">{{ getKelasArab($data['kelas']->id) }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 2px;">Tempat, Tanggal Lahir</td>
                    <td style="border: none; padding: 2px;">:</td>
                    <td style="border: none; padding: 2px;">{{ $data['santri']->tempat_lahir ?? 'Lumajang' }},
                        {{ $data['santri']->tanggal_lahir ? \Carbon\Carbon::parse($data['santri']->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </td>

                    <td style="border: none; padding: 2px;">Semester</td>
                    <td style="border: none; padding: 2px;">:</td>
                    <td style="border: none; padding: 2px;">{{ ucfirst($data['semester']) }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 2px;">No. ID Santri</td>
                    <td style="border: none; padding: 2px;">:</td>
                    <td style="border: none; padding: 2px;">{{ $data['santri']->nis }}</td>

                    <td style="border: none; padding: 2px;">Tahun</td>
                    <td style="border: none; padding: 2px;">:</td>
                    <td style="border: none; padding: 2px;">{{ $data['tahun_ajaran'] }}</td>
                </tr>
            </table>

            <table class="table-nilai">
                <thead>
                    <tr>
                        <th rowspan="2" width="5%">No</th>
                        <th rowspan="2" width="35%">Mata Pelajaran</th>
                        <th rowspan="2" width="8%">KKM</th>
                        <th colspan="2">Nilai</th>
                        <th rowspan="2" width="12%">Rata-rata<br>Ketuntasan<br>Kelas (%)</th>
                    </tr>
                    <tr>
                        <th width="10%">Angka</th>
                        <th width="30%">Huruf</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td rowspan="2" class="text-center">1</td>
                        <td>Pendidikan Al-Qur'an</td>
                        <td class="bg-arsir"></td>
                        <td class="bg-arsir"></td>
                        <td class="bg-arsir"></td>
                        <td class="bg-arsir"></td>
                    </tr>
                    <tr>
                        <td class="ps-3">a. Qiro'atul Qur'an</td>
                        <td class="text-center">70</td>
                        <td class="text-center {{ ($data['nilaiPraktek']->al_quran ?? 0) < 70 ? 'text-danger' : '' }}">
                            {{ $data['nilaiPraktek']->al_quran ?? 0 }}</td>
                        <td class="text-center">{{ angkaKeHuruf($data['nilaiPraktek']->al_quran ?? 0) }}</td>
                        <td class="text-center">{{ $data['rataPraktekQuran'] }}</td>
                    </tr>

                    @foreach ($data['list_nilai'] as $index => $nilai)
                        <tr>
                            <td class="text-center">{{ $index + 2 }}</td>
                            <td>{{ $nilai['nama_mapel'] }}</td>
                            <td class="text-center">{{ $nilai['kkm'] }}</td>
                            <td class="text-center {{ $nilai['angka'] < $nilai['kkm'] ? 'text-danger' : '' }}">
                                {{ $nilai['angka'] }}</td>
                            <td class="text-center">{{ $nilai['huruf'] }}</td>
                            <td class="text-center {{ $nilai['rata_kelas'] < $nilai['kkm'] ? 'text-danger' : '' }}">
                                {{ number_format($nilai['rata_kelas'], 2) }}</td>
                        </tr>
                    @endforeach

                    @php $lastNo = count($data['list_nilai']) + 2; @endphp
                    <tr>
                        <td rowspan="3" class="text-center">{{ $lastNo }}</td>
                        <td>Muatan Lokal</td>
                        <td class="bg-arsir"></td>
                        <td class="bg-arsir"></td>
                        <td class="bg-arsir"></td>
                        <td class="bg-arsir"></td>
                    </tr>
                    <tr>
                        <td class="ps-3">a. Muhafadloh</td>
                        <td class="text-center">70</td>
                        <td
                            class="text-center {{ ($data['nilaiPraktek']->muhafadloh ?? 0) < 70 ? 'text-danger' : '' }}">
                            {{ $data['nilaiPraktek']->muhafadloh ?? 0 }}</td>
                        <td class="text-center">{{ angkaKeHuruf($data['nilaiPraktek']->muhafadloh ?? 0) }}</td>
                        <td class="text-center">{{ $data['rataPraktekMuhafadloh'] }}</td>
                    </tr>
                    <tr>
                        <td class="ps-3">b. Qiro'atul Kutub</td>
                        <td class="text-center">70</td>
                        <td class="text-center {{ ($data['nilaiPraktek']->kitab ?? 0) < 70 ? 'text-danger' : '' }}">
                            {{ $data['nilaiPraktek']->kitab ?? 0 }}</td>
                        <td class="text-center">{{ angkaKeHuruf($data['nilaiPraktek']->kitab ?? 0) }}</td>
                        <td class="text-center">{{ $data['rataPraktekKitab'] }}</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="font-weight-bold">JUMLAH KESELURUHAN</td>
                        <td colspan="2" class="text-center font-weight-bold">{{ $data['total_nilai'] }}</td>
                        <td colspan="2" class="bg-arsir"></td>
                    </tr>

                    <tr>
                        <td colspan="2" class="font-weight-bold">PERINGKAT KELAS</td>
                        <td colspan="2" class="text-center font-weight-bold">{{ $data['peringkat'] }}</td>
                        <td colspan="2" class="bg-arsir"></td>
                    </tr>

                    <tr>
                        <td rowspan="3" class="font-weight-bold text-center">PERILAKU</td>
                        <td>Kerapian</td>
                        <td colspan="2" class="text-center">{{ $data['rapor']->sikap_kerapian ?? '-' }}</td>
                        <td colspan="2" class="bg-arsir"></td>
                    </tr>
                    <tr>
                        <td>Kerajinan</td>
                        <td colspan="2" class="text-center">{{ $data['rapor']->sikap_kerajinan ?? '-' }}</td>
                        <td colspan="2" class="bg-arsir"></td>
                    </tr>
                    <tr>
                        <td>Ketertiban</td>
                        <td colspan="2" class="text-center">{{ $data['rapor']->sikap_ketertiban ?? '-' }}</td>
                        <td colspan="2" class="bg-arsir"></td>
                    </tr>

                    <tr>
                        <td rowspan="3" class="font-weight-bold text-center">KETIDAK<br>HADIRAN</td>
                        <td>Sakit</td>
                        <td colspan="2" class="text-center">{{ $data['rapor']->absen_sakit ?? 0 }}</td>
                        <td colspan="2" class="bg-arsir"></td>
                    </tr>
                    <tr>
                        <td>Izin</td>
                        <td colspan="2" class="text-center">{{ $data['rapor']->absen_izin ?? 0 }}</td>
                        <td colspan="2" class="bg-arsir"></td>
                    </tr>
                    <tr>
                        <td>Tanpa Keterangan</td>
                        <td colspan="2" class="text-center">{{ $data['rapor']->absen_alfa ?? 0 }}</td>
                        <td colspan="2" class="bg-arsir"></td>
                    </tr>

                    <tr>
                        <td colspan="2" class="font-weight-bold text-center" style="letter-spacing: 3px;">C A T A
                            T A N</td>
                        <td colspan="4" class="text-center">
                            {{ $data['rapor']->catatan ?? 'Tingkatkan prestasimu dengan lebih giat belajar' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div
                style="position: relative; width: 100%; height: 180px; margin-top: 30px; font-weight: bold; font-family: 'Times New Roman', Times, serif; font-size: 11pt;">

                <div style="position: absolute; left: 0; top: 20px; width: 30%; text-align: center;">
                    WALI MURID
                    <br><br><br><br><br>
                    <div style="border-bottom: 1px solid #000; width: 90%; margin: 0 auto;"></div>
                </div>

                <div
                    style="position: absolute; left: 50%; transform: translateX(-50%); top: 80px; width: 35%; text-align: center;">
                    Mengetahui;<br>
                    Kepala Madin
                    <br><br><br><br><br>
                    <div style="display: inline-block; border-bottom: 1px solid #000; padding: 0 5px;">
                        M. ZUHRI YAQIN, S.Pd
                    </div>
                </div>

                <div style="position: absolute; right: 0; top: 0; width: 35%; text-align: center;">
                    Lumajang, {{ date('d F Y') }}<br>
                    WALI KELAS
                    <br><br><br><br>
                    <div style="display: inline-block; border-bottom: 1px solid #000; padding: 0 5px;">
                        {{ $data['kelas']->wali_kelas->name ?? ' ' }}
                    </div>
                </div>

            </div>
        </div>
    @endforeach

    <script>
        window.onload = function() {
            window.print();
        };
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>
