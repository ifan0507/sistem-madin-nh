@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">
            <div class="card mb-4 shadow-sm">
                <div class="card-header pb-2 bg-white">
                    <h6 class="mb-0">
                        <i class="fa-solid fa-wand-magic-sparkles text-success me-2"></i> Generate Ruang Ujian
                    </h6>
                </div>
                <div class="card-body py-3 p-5">
                    <form id="form-generate-denah">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Nama Ruangan</label>
                                    <input type="text" name="nama_ruangan" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Kapasitas Kursi</label>
                                    <input type="text" inputmode="numeric" name="total_kursi"
                                        class="form-control only-number" required min="1">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex flex-column">
                                <div class=" rounded d-flex flex-wrap gap-2 flex-grow-1 align-middle">
                                    @foreach ($kelas as $k)
                                        <div class="form-check mb-0 bg-white px-2 py-1 rounded border"
                                            style="min-width: 80px;">
                                            <input class="form-check-input mt-1" type="checkbox" name="kelas_ids[]"
                                                value="{{ $k->id }}" id="kelas_{{ $k->id }}">
                                            <label class="form-check-label text-sm font-weight-bold"
                                                for="kelas_{{ $k->id }}">
                                                {{ getKelasArab($k->id) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-2 align-items-center">
                            <div class="col-md-12">
                                <button type="submit"
                                    class="btn btn-success btn-generate mt-auto d-flex align-items-center justify-content-center gap-2 w-100"
                                    style="height: 40px;">
                                    <i class="fa-solid fa-gears"></i> Generate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div id="ruangan-container">
                @forelse($denahList as $index => $denah)
                    @php
                        $susunan = is_string($denah->susunan_denah)
                            ? json_decode($denah->susunan_denah, true)
                            : $denah->susunan_denah ?? [];

                        $warnaKelas = [
                            'bg-gradient-primary',
                            'bg-gradient-success',
                            'bg-gradient-info',
                            'bg-gradient-warning',
                            'bg-gradient-danger',
                            'bg-gradient-dark',
                        ];

                        $collapseId = 'collapseDenah-' . $denah->id;
                        $isShow = $index === 0 ? 'show' : '';
                        $ariaExpanded = $index === 0 ? 'true' : 'false';
                    @endphp

                    <div class="card mb-4 shadow-sm">
                        <div
                            class="card-header p-3 bg-white border-bottom d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center flex-grow-1 card-header-action py-1"
                                data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                aria-expanded="{{ $ariaExpanded }}" aria-controls="{{ $collapseId }}">

                                <i class="fa-solid fa-chevron-down me-3 text-secondary toggle-icon"></i>
                                <div>
                                    <h6 class="mb-0 font-weight-bolder text-dark">{{ $denah->nama_ruangan }}</h6>
                                    <p class="text-xs text-secondary mb-0">
                                        Kapasitas: <span class="font-weight-bold text-dark">{{ $denah->total_kursi }}
                                            Kursi</span>
                                    </p>
                                </div>
                            </div>

                            <div class="btn-group ms-3" style="position: relative; z-index: 2;">
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-0 px-3"
                                    onclick="cetakDenah({{ $denah->id }})" title="Cetak Denah Tempel">
                                    <i class="fa-solid fa-print me-1"></i> Denah
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-0 px-3"
                                    onclick="cetakKartu({{ $denah->id }})" title="Cetak Kartu Ujian">
                                    <i class="fa-solid fa-id-card-clip me-1"></i> Kartu
                                </button>

                                <div class="btn-group shadow-none">
                                    <button type="button" class="btn btn-sm btn-outline-dark mb-0 dropdown-toggle px-3"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end px-2 py-2 shadow-lg border-0">
                                        <li><button
                                                class="dropdown-item border-radius-md mb-1 text-warning font-weight-bold"
                                                onclick="acakUlang({{ $denah->id }})"><i
                                                    class="fa-solid fa-sync me-2"></i>
                                                Acak
                                                Ulang Posisi</button></li>
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        <li><button
                                                class="dropdown-item border-radius-md text-danger font-weight-bold btn-delete"
                                                data-url="{{ route('denah.destroy', $denah->id) }}"
                                                data-name="Denah Ujian Ruangan {{ $denah->nama_ruangan }}"><i
                                                    class="fa-solid fa-trash-can me-2"></i> Hapus Ruangan</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="{{ $collapseId }}" class="collapse {{ $isShow }}">
                            <div class="card-body p-0">
                                <div class="denah-grid-container">
                                    <div class="denah-grid">
                                        @forelse($susunan as $seat)
                                            @if ($seat['is_filled'])
                                                <div class="seat-cell filled">
                                                    <div class="seat-badge {{ $warnaKelas[$seat['kelas_id'] % count($warnaKelas)] }} d-flex flex-column justify-content-center align-items-center"
                                                        style="min-width: 45px;">

                                                        <span
                                                            style="font-size: 1.1rem; font-weight: bold; font-family: 'Amiri', 'Traditional Arabic', serif; line-height: 1.2;">
                                                            {{ getKelasArab($seat['kelas_id']) }}
                                                        </span>

                                                    </div>
                                                    <div class="seat-details">
                                                        <div class="seat-santri-name" title="{{ $seat['nama_santri'] }}">
                                                            {{ strtoupper($seat['nama_santri']) }}
                                                        </div>
                                                        <div class="seat-exam-number">
                                                            {{ $seat['nomor_ujian'] ?? '- BUKAN PESERTA -' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="seat-cell empty">
                                                    <div class="seat-badge bg-secondary">
                                                        -
                                                    </div>
                                                    <div
                                                        class="seat-details d-flex align-items-center justify-content-center">
                                                        <span class="seat-empty-number">{{ $seat['nomor_kursi'] }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="col-12 text-center py-5 text-muted">
                                                <i class="fa-solid fa-triangle-exclamation fa-2x mb-3"></i>
                                                <p>Data susunan denah rusak atau kosong.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="card shadow-none border-2 border-dashed border-secondary bg-gray-100 py-5">
                        <div class="card-body text-center text-secondary">
                            <i class="fa-solid fa-chair fa-3x mb-3 opacity-5"></i>
                            <h5 class="mt-2">Belum Ada Ruang Ujian</h5>
                            <p class="text-sm">Silakan gunakan form di atas untuk membuat denah ruang ujian baru.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#form-generate-denah').submit(function(e) {
                e.preventDefault();

                let btn = $('.btn-generate');
                let form = $(this);

                if ($('input[name="kelas_ids[]"]:checked').length === 0) {
                    Swal.fire('Oops!', 'Pilih minimal 1 kelas untuk diacak!', 'warning');
                    return false;
                }

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');

                $.ajax({
                    url: "{{ route('denah-ujian.generate') }}",
                    type: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON.message || 'Gagal generate data',
                            'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).text('Generate Denah');
                    }
                });
            });
        });

        function acakUlang(id) {
            Swal.fire({
                title: 'Acak Ulang Posisi?',
                text: "Posisi duduk santri di ruangan ini akan diacak ulang secara selang-seling.",
                icon: 'question',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: "#4caf50",
                cancelButtonColor: "#6c757d",
                confirmButtonText: '<i class="fa fa-sync"></i> Ya, Acak!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengacak Posisi...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/denah-ujian/${id}/acak-ulang`,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message ||
                                'Gagal mengacak denah',
                                'error');
                        }
                    });
                }
            });
        }
    </script>

@endsection
