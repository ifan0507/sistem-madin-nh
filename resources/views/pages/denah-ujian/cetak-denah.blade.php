<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Denah Ruang - {{ $denah->nama_ruangan }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.4') }}" rel="stylesheet" />

    <style>
        body {
            background-color: #fff;
            color: #333;
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .judul-simple {
            text-align: center;
            margin-bottom: 25px;
            padding-top: 20px;
        }

        .judul-simple h4 {
            font-size: 22px;
            font-weight: 800;
            margin: 0;
            color: #111827;
            letter-spacing: -0.5px;
        }

        .judul-simple h5 {
            font-size: 15px;
            font-weight: 600;
            margin: 6px 0 16px;
            color: #6b7280;
        }

        .box-ruang {
            font-size: 18px;
            font-weight: 800;
            background-color: #f3f4f6;
            color: #1f2937;
            display: inline-block;
            padding: 6px 24px;
            border-radius: 20px;
        }

        .meja-guru {
            text-align: center;
            margin-bottom: 30px;
        }

        .kotak-guru {
            display: inline-block;
            border: 2px dashed #d1d5db;
            padding: 8px 60px;
            font-weight: 600;
            font-size: 13px;
            background-color: #f9fafb;
            color: #6b7280;
            border-radius: 12px;
        }

        .grid-bangku {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            padding: 0 15px;
        }

        .seat-cell {
            display: flex;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            min-height: 80px;
        }

        .seat-badge {
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 0.75rem;
            padding: 5px;
        }

        .seat-details {
            width: 72%;
            padding: 6px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .seat-santri-name {
            font-size: 10px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 3px;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }

        .seat-exam-number {
            font-size: 12px;
            color: #2563eb;
            font-weight: 800;
        }

        .seat-cell.empty .seat-badge {
            background-color: #d1d5db !important;
            color: #9ca3af;
        }

        .seat-empty-number {
            font-size: 16px;
            color: #9ca3af;
            font-weight: 800;
        }

        .btn-print-area {
            text-align: right;
            padding: 15px;
        }

        .btn {
            padding: 8px 16px;
            cursor: pointer;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
        }

        .btn-dark {
            background-color: #111827;
            color: white;
        }

        .btn-light {
            background-color: #f3f4f6;
            color: #374151;
            margin-left: 8px;
        }

        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }

            body {
                -webkit-print-color-adjust: exact;
                zoom: 100%;
            }

            .btn-print-area {
                display: none;
            }

            .seat-cell {
                box-shadow: none;
                border: 1px solid #cbd5e1;
            }
        }
    </style>
</head>

<body>

    @php
        $warnaKelas = [
            'bg-gradient-primary',
            'bg-gradient-success',
            'bg-gradient-info',
            'bg-gradient-warning',
            'bg-gradient-danger',
            'bg-gradient-dark',
        ];
    @endphp


    <div class="judul-simple">
        <h4>DENAH TEMPAT DUDUK PENILAIAN AKHIR SEMESTER (PAS)
            {{ strtoupper($pengaturanAktif->semester) ?? 'Belum Diatur' }}</h4>
        <h5>TAHUN AJARAN {{ $pengaturanAktif->tahun_ajaran ?? 'Belum Diatur' }}</h5>
        <div class="box-ruang">RUANG: {{ strtoupper($denah->nama_ruangan) }}</div>
    </div>

    <div class="meja-guru">
        <div class="kotak-guru">MEJA PENGAWAS / PAPAN TULIS</div>
    </div>

    <div class="grid-bangku">
        @forelse($susunan as $seat)
            @if (isset($seat['is_filled']) && $seat['is_filled'])
                <div class="seat-cell">
                    <div class="seat-badge {{ $warnaKelas[$seat['kelas_id'] % count($warnaKelas)] }}">
                        <span>{{ getKelasArab($seat['kelas_id']) }}</span>
                    </div>

                    <div class="seat-details">
                        <div class="seat-santri-name" title="{{ $seat['nama_santri'] }}">
                            {{ strtoupper($seat['nama_santri']) }}
                        </div>
                        <div class="seat-exam-number">
                            {{ $seat['nomor_ujian'] ?? '-' }}
                        </div>
                    </div>
                </div>
            @else
                <div class="seat-cell empty">
                    <div class="seat-badge">-</div>
                    <div class="seat-details">
                        <span class="seat-empty-number">{{ $seat['nomor_kursi'] }}</span>
                    </div>
                </div>
            @endif
        @empty
            <div style="grid-column: span 6; text-align: center; font-weight: bold; color: #6b7280;">
                Susunan Bangku Belum Diatur.
            </div>
        @endforelse
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
