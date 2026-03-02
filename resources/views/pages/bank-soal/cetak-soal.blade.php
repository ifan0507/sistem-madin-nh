<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Soal - {{ $mapel_kelas->mapel->nama_mapel ?? 'Mapel' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        /* Setup Kertas F4/Folio (215mm x 330mm) */
        @page {
            size: 215mm 330mm;
            margin: 10mm 15mm;
        }

        body {
            font-family: 'Amiri', serif;
            font-size: 13.5pt;
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #fff;
            direction: rtl;
            line-height: 1.4;
        }

        /* --- HEADER KOP SOAL --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .logo {
            width: 75px;
            height: auto;
            margin-left: 15px;
        }

        .dummy-space {
            width: 75px;
        }

        .header-text {
            text-align: center;
            flex-grow: 1;
        }

        .header-text h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: normal;
        }

        .header-text h1 {
            margin: 2px 0;
            font-size: 24pt;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .header-text h4 {
            margin: 0;
            font-size: 13pt;
            font-weight: normal;
        }

        /* --- KUNCI FIX IDENTITAS & KOTAK PENGAWAS --- */
        .info-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            /* Memaksa kotak dan garis lesehan di dasar yang sama */
            margin-bottom: 20px;
        }

        .info-text-container {
            flex-grow: 1;
            border-bottom: 1.5px solid #000;
            /* Garis ditebalkan sedikit biar mirip aslinya */
            padding-bottom: 2px;
        }

        .info-table {
            border-collapse: collapse;
        }

        .info-table td {
            padding: 1px 10px;
            vertical-align: bottom;
        }

        .info-table td:first-child {
            font-weight: bold;
            white-space: nowrap;
        }

        /* Kotak Tanda Tangan (Disamakan Proporsinya) */
        .ttd-box {
            border-collapse: collapse;
            text-align: center;
            margin-left: 8px;
            /* Jarak antara kotak dan putusnya garis */
        }

        .ttd-box th,
        .ttd-box td {
            border: 1px solid #000;
        }

        .ttd-box th {
            font-weight: bold;
            font-size: 11pt;
            padding: 2px 28px;
            /* Bikin kotaknya lebih lebar ke samping */
            height: 25px;
            /* Header dibuat lebih pipih/pendek */
        }

        .ttd-box td {
            height: 90px;
            /* Kotak kosong di bawahnya dibuat lebih luas/tinggi */
        }

        /* --- DAFTAR SOAL --- */
        .soal-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .soal-item {
            display: flex;
            margin-bottom: 5px;
        }

        .soal-number {
            font-weight: bold;
            margin-left: 8px;
            white-space: nowrap;
        }

        .soal-text {
            flex-grow: 1;
            text-align: justify;
        }

        /* --- AREA JAWABAN (GARIS-GARIS) --- */
        .jawab-title {
            font-weight: bold;
            font-size: 14pt;
            margin-top: 20px;
            margin-bottom: 5px;
            text-align: center;
        }

        .garis-jawaban {
            border-bottom: 1px solid #000;
            height: 30px;
            width: 100%;
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
        function toArabicNumber($number)
        {
            $latin = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $arab = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            return str_replace($latin, $arab, $number);
        }
        $tglUjian = toArabicNumber('2026/01/22');
        $waktuUjian = toArabicNumber('15.30') . ' - ' . toArabicNumber('16.15');
    @endphp

    <div class="no-print"
        style="text-align: center; padding: 10px; background: #f8f9fa; margin-bottom: 15px; direction: ltr;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">🖨️ Cetak
            F4</button>
    </div>

    <div class="header">
        <img src="{{ asset('assets/images/logo_pondok.png') }}" class="logo" alt="Logo">

        <div class="header-text">
            <h3>لجنة الامتحان الدور الثانى للمدرسة الدينية</h3>
            <h1>نور الهدى</h1>
            <h4>ماغون سارى تيكوغ لوماجاغ</h4>
        </div>

        <div class="dummy-space"></div>
    </div>

    <div class="info-section">
        <div class="info-text-container">
            <table class="info-table">
                <tr>
                    <td>الاسم</td>
                    <td>: ......................................................</td>
                </tr>
                <tr>
                    <td>الفصل</td>
                    <td>: {{ getKelasArab($mapel_kelas->kelas_id ?? 0) }}</td>
                </tr>
                <tr>
                    <td>الدرس</td>
                    <td>: {{ $mapel_kelas->mapel->nama_mapel ?? '-' }}</td>
                </tr>
                <tr>
                    <td>التاريخ</td>
                    <td>: {{ $tglUjian }}</td>
                </tr>
                <tr>
                    <td>الوقت</td>
                    <td>: {{ $waktuUjian }}</td>
                </tr>
            </table>
        </div>

        <table class="ttd-box">
            <tr>
                <th>امضاء</th>
                <th>رقم الممتحن</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="soal-list">
        @if (isset($bank_soal->soal) && is_array($bank_soal->soal))
            @foreach ($bank_soal->soal as $index => $item)
                <div class="soal-item">
                    <div class="soal-number">{{ toArabicNumber($index + 1) }}.</div>
                    <div class="soal-text">{{ $item['soal_pegon'] }}</div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="jawab-title">جاوب :</div>

    @for ($i = 0; $i < 15; $i++)
        <div class="garis-jawaban"></div>
    @endfor

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
