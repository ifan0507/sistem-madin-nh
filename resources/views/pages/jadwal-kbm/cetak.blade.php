<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Jadwal KBM - Ponpes Nurul Huda</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo_pondok.png') }}">
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.4') }}" rel="stylesheet" />

    <style>
        body {
            background-color: #fff;
            color: #000;
            font-family: Arial, sans-serif;
        }

        .kop-instansi {
            font-size: 20px;
            font-weight: bold;
            line-height: 1.2;
        }

        .kop-instansi-nama {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .kop-alamat {
            font-size: 14px;
            margin-top: 5px;
            font-family: Arial, sans-serif;
        }

        .garis-kop {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin: 10px 0 20px 0;
        }

        .judul-dokumen {
            font-family: Arial, sans-serif;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .sub-judul {
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin-top: 5px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000 !important;
            vertical-align: middle;
            padding: 8px;
        }


        @media print {
            @page {
                size: 330mm 215.9mm;
                margin: 10mm;
            }

            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .btn-print {
                display: none;
            }

            .container-fluid {
                display: block !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid !important;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid py-4">

        {{-- <div class="text-end mb-3 btn-print">
            <button onclick="window.print()" class="btn btn-dark"><i class="fa-solid fa-print me-2"></i> Print
                Sekarang</button>
            <button onclick="window.close()" class="btn btn-light border">Tutup</button>
        </div> --}}

        <table width="100%" style="font-family: 'Times New Roman', Times, serif; color: #000;">
            <tr>
                <td width="15%" align="right" valign="middle" style="padding-right: 15px;">
                    <img src="{{ asset('assets/images/logo_pondok.png') }}" alt="Logo Pondok"
                        style="width: 120px; height: auto;">
                </td>

                <td width="70%" align="center" valign="middle">
                    <div class="kop-instansi">YAYASAN PONDOK PESANTREN NURUL HUDA</div>
                    <div class="kop-instansi-nama">MADIN NURUL HUDA</div>
                    <div class="kop-instansi" style="font-size: 18px;">Mangunsari Tekung Lumajang</div>
                    <div class="kop-alamat">
                        Jl. Pesantren No. 178 Mangunsari, Kec. Tekung, Kab. Lumajang, Jawa Timur<br>
                        Kode Pos: 67381 | Telp: 0823-3276-2818
                    </div>
                </td>

                <td width="15%"></td>
            </tr>
        </table>

        <div class="garis-kop"></div>

        <div class="text-center mb-4">
            <div class="judul-dokumen">JADWAL PELAJARAN</div>
            <div class="sub-judul">TAHUN AJARAN {{ $pengaturanAktif->tahun_ajaran ?? 'Belum Diatur' }}</div>
        </div>


        <table class="table table-bordered text-center w-100 mt-4">
            <thead>
                <tr class="bg-light">
                    <th class="text-dark font-weight-bold" style="width: 5%;">NO</th>
                    <th class="text-dark font-weight-bold" style="width: 15%;">NAMA KELAS</th>
                    <th class="text-dark font-weight-bold">SABTU</th>
                    <th class="text-dark font-weight-bold">AHAD</th>
                    <th class="text-dark font-weight-bold">SENIN</th>
                    <th class="text-dark font-weight-bold">SELASA</th>
                    <th class="text-dark font-weight-bold">RABU</th>
                    <th class="text-dark font-weight-bold">KAMIS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $index => $k)
                    <tr>
                        <td class="align-middle text-dark font-weight-bold">{{ $index + 1 }}</td>
                        <td class="align-middle text-dark font-weight-bold" style="font-size: 16px;">
                            {{ getKelasArab($k->id) }}
                        </td>

                        @foreach (['Sabtu', 'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis'] as $hari)
                            @php
                                $jadwal = $k->jadwal_kbms->where('hari', $hari)->first();
                            @endphp

                            <td class="align-middle p-2">
                                @if ($jadwal && $jadwal->mapel_kelas_id)
                                    <div class="text-dark font-weight-bold text-sm mb-1" dir="rtl">
                                        {{ $jadwal->mapel_kelas->mapel->nama_mapel }}
                                    </div>
                                    <div class="text-xs text-secondary">
                                        Ust. {{ $jadwal->mapel_kelas->guru->name }}
                                    </div>
                                @else
                                    <span class="text-secondary text-xs">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

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
