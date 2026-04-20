@if (empty($rekapBulanan))
    <div class="d-flex flex-column align-items-center justify-content-center p-4 mt-3"
        style="border: 1px dashed #cbd5e1; border-radius: 12px; background-color: #f8fafc; min-height: 200px;">
        <div class="mb-3 d-flex align-items-center justify-content-center"
            style="width: 56px; height: 56px; background-color: #d1fae5; border-radius: 50%; color: #10b981;">
            <i class="far fa-calendar-times" style="font-size: 1.5rem;"></i>
        </div>
        <h6 class="text-dark font-weight-bold mb-1" style="font-size: 0.95rem;">Tidak Ada Jadwal/Absen</h6>
        <p class="text-muted text-center mb-0" style="font-size: 0.85rem; max-width: 320px;">
            Tidak ditemukan jadwal mengajar atau data absensi untuk periode ini.
        </p>
    </div>
@else
    @foreach ($rekapBulanan as $keyBulan => $dataBulan)
        <div class="card shadow-sm border mt-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 text-sm font-weight-bold">Rekap Absensi Bulan {{ $dataBulan['nama_bulan'] }} -
                            {{ $guru->name ?? 'Guru' }}</h6>
                        <p class="text-xs text-muted mb-0">Periode : {{ $dataBulan['periode_bulan'] }}</p>
                    </div>
                    {{-- <button class="btn btn-success btn-sm mb-0">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </button> --}}
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-attendance-wrapper m-3">
                    <div class="table-responsive">
                        <table
                            class="table table-hover align-items-center mb-0 text-center table-absen-guru table-bordered border-light">
                            <thead class="bg-light">
                                <tr>
                                    <th rowspan="2"
                                        class="text-secondary text-xs font-weight-bold align-middle text-start ps-4"
                                        style="min-width: 180px;">
                                        MATA PELAJARAN
                                    </th>
                                    <th rowspan="2"
                                        class="text-secondary text-xs font-weight-bold align-middle text-center"
                                        style="min-width: 100px;">
                                        KELAS
                                    </th>

                                    @foreach ($dataBulan['maxPertemuanPerMinggu'] as $mingguKe => $colspan)
                                        @if ($colspan > 0)
                                            <th colspan="{{ $colspan }}"
                                                class="text-secondary text-xs font-weight-bold align-middle py-2 border-start border-2">
                                                Minggu {{ $mingguKe }}</th>
                                        @endif
                                    @endforeach
                                    <th colspan="4"
                                        class="text-center text-secondary text-xs font-weight-bold align-middle border-start border-2 border-dark"
                                        style="min-width: 120px;">
                                        REKAP
                                    </th>
                                </tr>

                                <tr>
                                    @php $globalPertKe = 1; @endphp
                                    @foreach ($dataBulan['maxPertemuanPerMinggu'] as $mingguKe => $colspan)
                                        @for ($i = 0; $i < $colspan; $i++)
                                            <th class="text-secondary text-xs font-weight-bold py-2 @if ($i == 0) border-start border-2 @endif"
                                                style="min-width: 80px;">
                                                Pert. {{ $globalPertKe++ }}
                                            </th>
                                        @endfor
                                    @endforeach
                                    <th class="text-center text-success text-xs font-weight-bold py-2 border-start border-2 border-dark"
                                        title="Hadir">H</th>
                                    <th class="text-center text-warning text-xs font-weight-bold py-2" title="Izin">I
                                    </th>
                                    <th class="text-center text-warning text-xs font-weight-bold py-2" title="Sakit">S
                                    </th>
                                    <th class="text-center text-danger text-xs font-weight-bold py-2" title="Alpha">A
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataBulan['dataRekap'] as $item)
                                    <tr>
                                        <td class="text-sm text-start ps-4 align-middle">
                                            <h6 class="mb-0 text-sm font-weight-bold text-arab">
                                                {{ $item['mapel_info']->mapel->nama_mapel ?? '-' }}</h6>
                                        </td>
                                        <td class="text-sm text-center align-middle">
                                            <h6 class="mb-0 text-sm font-weight-bold text-arab">
                                                {{ getKelasArab($item['mapel_info']->kelas->id) ?? '-' }}</h6>
                                        </td>

                                        @foreach ($dataBulan['maxPertemuanPerMinggu'] as $mingguKe => $colspan)
                                            @php $pertemuanDiMingguIni = $item['pertemuan_per_minggu'][$mingguKe] ?? []; @endphp

                                            @for ($i = 0; $i < $colspan; $i++)
                                                @php
                                                    $pert = $pertemuanDiMingguIni[$i] ?? null;
                                                    $isClickable = $pert && in_array($pert['status'], ['1', '2', '4']);
                                                @endphp

                                                <td class="align-middle @if ($i == 0) border-start border-2 @endif @if ($isClickable) cursor-pointer detail-absen-btn @endif"
                                                    @if (!$pert) style="background-color: #fff0f0;" @endif
                                                    @if ($isClickable) data-status="{{ $pert['status'] }}"
                                                data-tanggal="{{ $pert['format_tgl'] }}"
                                                data-mapel="{{ $item['mapel_info']->mapel->nama_mapel ?? '-' }}"
                                                data-materi="{{ $pert['materi'] ?? '-' }}"
                                                data-kelas="{{ getKelasArab($item['mapel_info']->kelas->id) ?? '-' }}"
                                                data-ket="{{ $pert['ket'] ?? '-' }}"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="{{ $pert['status'] == '1' ? 'Hadir' : ($pert['status'] == '2' ? 'Izin' : 'Sakit') }}"
                                            @elseif($pert && $pert['status'] == '3')
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Tidak ada keterangan" @endif>

                                                    @if ($pert)
                                                        <div class="text-muted fw-normal mb-1"
                                                            style="font-size: 0.65rem;">
                                                            {{ $pert['format_tgl'] }}</div>
                                                        @if ($pert['status'] == '1')
                                                            <i class="fas fa-check text-success"
                                                                style="font-size: 1.2rem;"></i>
                                                        @elseif($pert['status'] == '2')
                                                            <i class="fas fa-times text-warning"
                                                                style="font-size: 1.2rem;"></i>
                                                        @elseif($pert['status'] == '3')
                                                            <i class="fas fa-times text-danger"
                                                                style="font-size: 1.2rem;"></i>
                                                        @elseif($pert['status'] == '4')
                                                            <i class="fas fa-times text-warning"
                                                                style="font-size: 1.2rem;"></i>
                                                        @else
                                                            <span class="text-secondary font-weight-bold"
                                                                style="font-size: 1.2rem;">-</span>
                                                        @endif
                                                    @endif
                                                </td>
                                            @endfor
                                        @endforeach

                                        <td class="text-center align-middle border-start border-2"
                                            style="border-left-color: #cbd5e1 !important;">
                                            <span
                                                style="display: inline-block; min-width: 26px; padding: 2px 6px; border-radius: 6px;  color: #059669; font-weight: 700; font-size: 0.8rem;">
                                                {{ $item['rekap']['hadir'] }}
                                            </span>
                                        </td>

                                        <td class="text-center align-middle">
                                            <span
                                                style="display: inline-block; min-width: 26px; padding: 2px 6px; border-radius: 6px;  color: #d97706; font-weight: 700; font-size: 0.8rem;">
                                                {{ $item['rekap']['izin'] }}
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span
                                                style="display: inline-block; min-width: 26px; padding: 2px 6px; border-radius: 6px;  color: #d97706; font-weight: 700; font-size: 0.8rem;">
                                                {{ $item['rekap']['sakit'] }}
                                            </span>
                                        </td>

                                        <td class="text-center align-middle">
                                            <span
                                                style="display: inline-block; min-width: 26px; padding: 2px 6px; border-radius: 6px;  color: #dc2626; font-weight: 700; font-size: 0.8rem;">
                                                {{ $item['rekap']['alpha'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @php $totalColspanMinggu = array_sum($dataBulan['maxPertemuanPerMinggu']); @endphp
                                <tr>
                                    <td colspan="{{ 2 + $totalColspanMinggu }}"
                                        class="text-end font-weight-bold text-sm pe-4 py-3 align-middle"
                                        style="letter-spacing: 0.5px;">
                                        TOTAL KESELURUHAN ({{ strtoupper($dataBulan['nama_bulan']) }})
                                    </td>

                                    <td class="text-center align-middle border-start border-2 py-3"
                                        style="border-left-color: #475569 !important; ">
                                        <span style="font-size: 1.05rem; font-weight: 700; color: #059669;">
                                            {{ $dataBulan['grandTotal']['hadir'] }}
                                        </span>
                                    </td>

                                    <td class="text-center align-middle py-3">
                                        <span style="font-size: 1.05rem; font-weight: 700; color: #d97706;">
                                            {{ $dataBulan['grandTotal']['izin'] }}
                                        </span>
                                    </td>

                                    <td class="text-center align-middle py-3">
                                        <span style="font-size: 1.05rem; font-weight: 700; color: #d97706;">
                                            {{ $dataBulan['grandTotal']['sakit'] }}
                                        </span>
                                    </td>

                                    <td class="text-center align-middle py-3">
                                        <span style="font-size: 1.05rem; font-weight: 700; color: #dc2626;">
                                            {{ $dataBulan['grandTotal']['alpha'] }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
