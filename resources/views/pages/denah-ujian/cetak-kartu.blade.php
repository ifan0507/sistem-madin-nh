<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Ujian - {{ $denah->nama_ruangan }}</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 10mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
        }

        .page-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: repeat(5, auto);
            gap: 8px;
            page-break-after: always;
        }

        .page-container:last-child {
            page-break-after: auto;
        }

        .kartu {
            border: 2px solid #000;
            padding: 4px;
            box-sizing: border-box;
            width: 100%;
            height: 60mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* --- HEADER KARTU --- */
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 4px;
            margin-bottom: 4px;
        }

        .logo-kartu {
            width: 48px;
            height: auto;
            margin-right: 10px;
        }

        .header-text {
            text-align: center;
            flex-grow: 1;
            line-height: 1.1;
        }

        .title-1 {
            font-size: 11pt;
        }

        .title-2 {
            font-size: 9pt;
        }

        .title-3 {
            font-size: 11pt;
            font-weight: bold;
        }

        .nama-box {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            font-size: 10pt;
        }

        .info-table td {
            padding: 1px 2px;
            vertical-align: top;
        }

        .ruang-box {
            border: 1px solid #000;
            text-align: center;
            min-width: 50px;
            margin-right: 5px;
        }

        .ruang-title {
            font-weight: bold;
            border-bottom: 1px solid #000;
            font-size: 9pt;
            padding: 1px 4px;
        }

        .ruang-number {
            font-size: 16pt;
            font-weight: bold;
            padding: 2px 4px;
        }

        .footer {
            text-align: center;
            font-size: 9pt;
            margin-top: 2px;
        }

        .ttd-title {
            margin-bottom: 12px;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .pesan {
            font-style: italic;
            font-size: 8pt;
            border-top: 1px solid #000;
            margin-top: 2px;
            padding-top: 2px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    @php
        $romawiMap = [1 => 'SIFIR', 2 => 'I', 3 => 'II', 4 => 'III', 5 => 'IV', 6 => 'V', 7 => 'VI'];
    @endphp

    @foreach ($peserta->chunk(10) as $chunkSantri)
        <div class="page-container">
            @foreach ($chunkSantri as $santri)
                <div class="kartu">

                    <div class="header">
                        <img src="{{ asset('assets/images/logo_pondok.png') }}" class="logo-kartu" alt="Logo Pondok">
                        <div class="header-text">
                            <div class="title-1">KARTU PESERTA</div>
                            <div class="title-2">UJIAN MADRASAH DINIYAH</div>
                            <div class="title-3">PONDOK PESANTREN NURUL HUDA</div>
                        </div>
                    </div>

                    <div class="nama-box">
                        {{ strtoupper($santri['nama_santri']) }}
                    </div>

                    <div class="info-row">
                        <table class="info-table">
                            <tr>
                                <td>NOMER PESERTA</td>
                                <td>:</td>
                                <td>{{ $santri['nomor_ujian'] }}</td>
                            </tr>
                            <tr>
                                <td>KELAS</td>
                                <td>:</td>
                                <td>{{ $romawiMap[$santri['kelas_id']] ?? $santri['kelas_id'] }}</td>
                            </tr>
                        </table>

                        <div class="ruang-box">
                            <div class="ruang-title">RUANG</div>
                            <div class="ruang-number">
                                {{ preg_replace('/[^0-9]/', '', $denah->nama_ruangan) ?: $denah->nama_ruangan }}
                            </div>
                        </div>
                    </div>

                    <div class="footer">
                        <div class="ttd-title">Kepala MADIN</div>
                        <div class="ttd-name">GUS M. ZUHRI YAQIN</div>
                        <div class="pesan">JANGAN LUPA MEMBACA BASMALAH YA....... :)</div>
                    </div>

                </div>
            @endforeach
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
