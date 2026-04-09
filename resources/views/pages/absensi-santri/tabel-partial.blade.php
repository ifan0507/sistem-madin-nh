@if (empty($months))
    <div class="alert alert-warning text-white">Tidak ada data rentang waktu yang valid.</div>
@endif

@foreach ($months as $monthKey => $month)
    <div class="card shadow-sm mb-4 card-detail">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-dark">
                Data Absensi Kelas <strong class="text-success">{{ getKelasArab($kelasId) ?? 'Aktif' }}</strong> Periode:
                <strong class="text-success">{{ $month['start']->locale('id')->isoFormat('D MMMM YYYY') }}
                    s/d
                    {{ $month['end']->locale('id')->isoFormat('D MMMM YYYY') }}</strong>
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-attendance-wrapper m-3">
                <div class="table-responsive">
                    <table class="table table-absensi table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2" class="sticky-no">No</th>
                                <th rowspan="2" class="sticky-nama ps-3">Nama Santri</th>
                                <th colspan="{{ count($month['dates']) }}" class="text-center py-2">Tanggal</th>
                            </tr>
                            <tr>
                                @foreach ($month['dates'] as $date)
                                    <th class="{{ $date['isJumat'] ? 'bg-jumat text-jumat' : '' }}">
                                        {{ $date['day'] }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($santri as $index => $s)
                                <tr>
                                    <td class="sticky-no">{{ $index + 1 }}</td>
                                    <td class="sticky-nama ps-3 font-weight-bold text-dark">{{ $s->nama }}</td>

                                    @foreach ($month['dates'] as $date)
                                        @php
                                            $status = $absensi[$s->id][$date['full_date']] ?? null;
                                        @endphp

                                        @if ($date['isJumat'])
                                            <td class="bg-jumat"></td>
                                        @elseif($status == '1')
                                            <td><i class="fa-solid fa-check icon-hadir"></i></td>
                                        @elseif(in_array($status, ['2', '3', '4']))
                                            @php
                                                $namaStatus = '';
                                                if ($status == '2') {
                                                    $namaStatus = 'Sakit';
                                                } elseif ($status == '3') {
                                                    $namaStatus = 'Izin';
                                                } elseif ($status == '4') {
                                                    $namaStatus = 'Alfa';
                                                }
                                            @endphp
                                            <td data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Status: {{ $namaStatus }}" style="cursor: pointer;">
                                                <i class="fa-solid fa-xmark icon-absen"></i>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($month['dates']) + 2 }}" class="text-center py-4">Belum ada
                                        data santri di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- CARD REKAPITULASI TOTAL --}}
@if (count($santri) > 0)
    <div class="card shadow-sm mb-4" id="card-rekap">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0 text-dark">Rekapitulasi Kehadiran
                </h6>
                <p class="text-xs mb-0 text-secondary mt-1">Total akumulasi berdasarkan filter rentang waktu yang
                    dipilih.</p>
            </div>
            <div class="d-flex gap-2 no-print">
                <button id="btn-cetak-rekap" class="btn btn-sm btn-dark mb-0 d-flex align-items-center gap-1">
                    <i class="fa-solid fa-print text-sm"></i> Cetak Rekap
                </button>
                <button id="btn-excel-rekap" class="btn btn-sm btn-success mb-0 d-flex align-items-center gap-1">
                    <i class="fa-solid fa-file-excel text-sm"></i> Excel Rekap
                </button>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 text-sm">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-2" style="width: 50px;">No</th>
                            <th class="py-2">Nama Santri</th>
                            <th class="text-center py-2 ">Hadir</th>
                            <th class="text-center py-2 ">Sakit</th>
                            <th class="text-center py-2 "></i>Izin</th>
                            <th class="text-center py-2 ">Alfa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($santri as $index => $s)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="font-weight-bold text-dark">{{ $s->nama }}</td>
                                <td class="text-center font-weight-bold">{{ $rekap[$s->id]['hadir'] ?? 0 }}</td>
                                <td class="text-center font-weight-bold">{{ $rekap[$s->id]['sakit'] ?? 0 }}</td>
                                <td class="text-center font-weight-bold">{{ $rekap[$s->id]['izin'] ?? 0 }}</td>
                                <td class="text-center font-weight-bold">{{ $rekap[$s->id]['alfa'] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
