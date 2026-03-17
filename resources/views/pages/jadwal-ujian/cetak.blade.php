<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Jadwal Ujian - Ponpes Nurul Huda</title>
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.4') }}" rel="stylesheet" />

    <style>
        body {
            background-color: #fff;
            color: #000;
            font-family: 'Times New Roman', Times, serif;
        }

        .judul-simple {
            text-align: center;
            font-weight: bold;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .judul-simple h4 {
            font-size: 20px;
            font-weight: 900;
            margin: 0;
            color: #000;
        }

        .judul-simple h5 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            color: #000;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000 !important;
            vertical-align: middle;
            padding: 4px 6px !important;
            color: #000;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            padding: 10px 4px !important;
            white-space: nowrap;
        }

        .judul-tabel {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
            text-transform: uppercase;
        }

        @media print {
            @page {
                size: 330mm 215mm landscape;
                margin: 10mm;
            }

            body {
                -webkit-print-color-adjust: exact;
                zoom: 95%;
            }

            .btn-print {
                display: none;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    @php
        // LOGIKA SAKTI: Bikin Kamus Kode Pengawas Otomatis
        $kamusPengawas = [];
        $kodeUrut = 1;

        foreach (range(1, 6) as $hari) {
            foreach ($ruangList as $ruang) {
                $jp = $pengawasPerHari[$hari][$ruang->id] ?? null;
                // Hanya kalau ada pengawasnya
                if ($jp && $jp->guru_id) {
                    if (!isset($kamusPengawas[$jp->guru_id])) {
                        $kamusPengawas[$jp->guru_id] = [
                            'kode' => $kodeUrut++,
                            'nama' => $jp->guru->name,
                        ];
                    }
                }
            }
        }
    @endphp

    <div class="container-fluid py-2">
        <div class="text-end mb-3 btn-print">
            <button onclick="window.print()" class="btn btn-dark btn-sm"><i class="fa-solid fa-print me-2"></i>
                Print</button>
            <button onclick="window.close()" class="btn btn-light btn-sm border">Tutup</button>
        </div>

        <div class="judul-simple">
            <h4>JADWAL PENILAIAN AKHIR SEMESTER (PAS) GENAP</h4>
            <h5>TAHUN PELAJARAN 2025/2026</h5>
        </div>

        <div class="judul-tabel">A. JADWAL MATA PELAJARAN</div>
        <table class="table table-bordered text-center w-100 mb-4" style="font-size: 12px;">
            <thead class="bg-light">
                <tr>
                    <th class="font-weight-bold" style="width: 15%;">HARI / TANGGAL</th>
                    @foreach ($kelasList as $kelas)
                        <th class="font-weight-bold">{{ getKelasArab($kelas->id) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach (range(1, 6) as $hari)
                    <tr>
                        <td class="font-weight-bold text-uppercase align-middle">
                            {{ $tanggalPerHari[$hari] ? \Carbon\Carbon::parse($tanggalPerHari[$hari])->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'HARI KE-' . $hari }}
                        </td>
                        @foreach ($kelasList as $kelas)
                            @php $jadwalMapel = $jadwalPerHari[$hari][$kelas->id] ?? null; @endphp
                            <td dir="rtl" class="align-middle">
                                {{ $jadwalMapel && $jadwalMapel->mapel_kelas_id ? $jadwalMapel->mapel_kelas->mapel->nama_mapel : '-' }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="judul-tabel mt-4">B. JADWAL PENGAWAS RUANGAN</div>

        <div class="d-flex align-items-start" style="gap: 10px;">

            <div class="d-flex flex-wrap" style="gap: 10px; flex: 1;">
                @foreach (range(1, 6) as $hari)
                    @php
                        // Saring ruangan: hanya ambil yang GURU-nya ADA ISINYA
                        $ruangTerisi = [];
                        foreach ($ruangList as $ruang) {
                            $jp = $pengawasPerHari[$hari][$ruang->id] ?? null;
                            if ($jp && $jp->guru_id) {
                                $ruangTerisi[] = [
                                    'nama' => $ruang->nama_ruang,
                                    'kode' => $kamusPengawas[$jp->guru_id]['kode'],
                                ];
                            }
                        }
                    @endphp

                    @if (count($ruangTerisi) > 0)
                        <table class="table-bordered text-center" style="font-size: 12px; min-width: 120px;">
                            <tr>
                                <td rowspan="{{ count($ruangTerisi) + 1 }}" class="vertical-text bg-light">
                                    {{ $tanggalPerHari[$hari] ? strtoupper(\Carbon\Carbon::parse($tanggalPerHari[$hari])->locale('id')->isoFormat('dddd, D MMMM YYYY')) : 'HARI KE-' . $hari }}
                                </td>
                                <th class="font-weight-bold" style="padding: 4px 8px;">RUANG</th>
                                <th class="font-weight-bold" style="padding: 4px 8px;">KODE</th>
                            </tr>
                            @foreach ($ruangTerisi as $rt)
                                <tr>
                                    <td>{{ $rt['nama'] }}</td>
                                    <td class="font-weight-bold">{{ $rt['kode'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                @endforeach
            </div>

            <div style="width: 40%;">
                <table class="table-bordered w-100" style="font-size: 12px;">
                    <thead class="bg-light">
                        <tr>
                            <th colspan="2" class="text-center font-weight-bold p-2">KODE PENGAWAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kamusPengawas as $guruId => $data)
                            <tr>
                                <td class="text-center font-weight-bold" style="width: 15%;">{{ $data['kode'] }}</td>
                                <td class="text-start px-2 text-uppercase">UST. {{ $data['nama'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Belum ada pengawas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row mt-5 text-dark" style="page-break-inside: avoid;">
            <div class="col-6 text-start" style="padding-left: 40px;">
                <p class="mb-0">Mengetahui,</p>
                <p class="mb-5">Kepala Madin Nurul Huda</p>
                <p class="mb-0 font-weight-bold"><u>M. Zuhri Yaqin, S.Pd.</u></p>
            </div>
            <div class="col-6 text-center">
                <p class="mb-0">Mangunsari, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                <p class="mb-5">Sekretaris Panitia PAS</p>
                <p class="mb-0 font-weight-bold"><u>Khoirul Akifin</u></p>
            </div>
        </div>

    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
