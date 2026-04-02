<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Juara Kelas</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo_pondok.png') }}">
    <style>
        @page {
            size: 215.9mm 330mm portrait;
            margin: 1cm 1.5cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14pt;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .judul-halaman {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .judul-halaman h2 {
            margin: 0 0 5px 0;
            font-size: 18pt;
            text-transform: uppercase;
        }

        .judul-halaman h4 {
            margin: 0;
            font-size: 14pt;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 10px 8px;
            vertical-align: middle;
        }

        th {
            background-color: #e9ecef !important;
            font-weight: bold;
            text-align: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .juara-top {
            background-color: #fff3cd !important;
            font-weight: bold;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @media print {
            #btn-print-manual {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button id="btn-print-manual" onclick="window.print()" style="padding: 10px; margin: 10px; cursor: pointer;">Cetak
        Sekarang</button>

    <div class="judul-halaman text-center">
        <h2>DAFTAR PERINGKAT KELAS {{ strtoupper(getKelasArab($kelas->id)) }}</h2>
        <h4>Semester {{ ucfirst($semester) }} - Tahun Ajaran {{ $tahunAjaran }}</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">Peringkat</th>
                <th width="20%">NIS</th>
                <th width="50%">Nama Santri</th>
                <th width="20%">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ranking as $data)
                <tr class="{{ $data['peringkat'] <= 3 ? 'juara-top' : '' }}">
                    <td class="text-center font-weight-bold" style="font-size: 16pt;">
                        {{ $data['peringkat'] }}
                    </td>
                    <td class="text-center">{{ $data['nis'] }}</td>
                    <td style="font-size: 15pt;">{{ $data['nama'] }}</td>
                    <td class="text-center">{{ $data['total_nilai'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
