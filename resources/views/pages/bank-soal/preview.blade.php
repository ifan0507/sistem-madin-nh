@extends('layout.template')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">

                <div class="card mb-4 shadow-sm">
                    <div class="card-header pb-0 bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-3"><i class="fa-solid fa-pen-to-square text-success me-2"></i> Preview & Edit Soal
                            </h5>
                            <a href="{{ route('bank-soal') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row align-items-center">

                            <div class="col-md-5 ps-3">
                                <p class="text-xs mb-1 font-weight-bold text-secondary">
                                    <i class="fa-solid fa-circle-info me-1"></i> Tips Edit Soal
                                </p>
                                <p class="text-xs text-secondary mb-0" style="line-height: 1.4;">
                                    Ubah teks Latin lalu klik <b>Generate</b>, ATAU langsung perbaiki teks Arab Pegon di
                                    kolom kanan.
                                </p>
                            </div>

                            <div class="col-md-7 d-flex justify-content-end flex-wrap gap-8 mt-3 mt-md-0">

                                <div>
                                    <p class="text-sm mb-0 text-secondary">Mata Pelajaran</p>
                                    <h6 class="font-weight-bold mb-0">
                                        {{ $bank_soal->mapel_kelas->mapel->nama_mapel ?? '-' }}</h6>
                                </div>

                                <div>
                                    <p class="text-sm mb-0 text-secondary">Kelas</p>
                                    <h6 class="font-weight-bold mb-0"
                                        style="font-family: 'Amiri', serif; font-size: 1.2rem;">
                                        {{ getKelasArab($bank_soal->mapel_kelas->kelas_id ?? 0) }}
                                    </h6>
                                </div>

                                <div>
                                    <p class="text-sm mb-0 text-secondary">Total Soal</p>
                                    <h6 class="font-weight-bold mb-0">{{ count($bank_soal->soal ?? []) }} Butir</h6>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <form id="formUpdateSoal" action="{{ route('bank-soal.update-soal', $bank_soal->id) }}" method="POST">
                    @csrf

                    @if (isset($bank_soal->soal) && is_array($bank_soal->soal))
                        @foreach ($bank_soal->soal as $index => $item)
                            <div class="card mb-3 shadow-sm border-0" style="background-color: #f8f9fa;">

                                <div class="card-header bg-transparent p-3 d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#collapseSoal_{{ $index }}" role="button"
                                    aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                    aria-controls="collapseSoal_{{ $index }}" style="cursor: pointer;">

                                    <h6 class="text-success mb-0"><i class="fa-solid fa-list-ol me-2"></i> Soal No.
                                        {{ $index + 1 }}</h6>

                                    <i
                                        class="fa-solid fa-chevron-{{ $index == 0 ? 'up' : 'down' }} text-secondary toggle-icon"></i>
                                </div>

                                <div id="collapseSoal_{{ $index }}"
                                    class="collapse {{ $index == 0 ? 'show' : '' }}">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label text-xs font-weight-bold text-secondary text-uppercase">Teks
                                                    Latin</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label
                                                    class="form-label text-xs font-weight-bold text-success text-uppercase text-end w-100">Teks
                                                    Arab Pegon</label>
                                            </div>
                                        </div>

                                        <div class="row align-items-stretch">

                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <div class="input-group input-group-outline is-filled h-100">
                                                    <textarea class="form-control" name="soal[{{ $index }}][latin]" id="latin_{{ $index }}" rows="4"
                                                        placeholder="Tulis soal latin di sini...">{{ $item['soal_latin'] ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="input-group input-group-outline is-filled h-100">
                                                    <textarea class="form-control text-end" name="soal[{{ $index }}][pegon]" id="pegon_{{ $index }}"
                                                        dir="rtl" style="font-family: 'Amiri', serif; font-size: 1.5rem; height: 100%; resize: vertical;"
                                                        placeholder="Hasil pegon akan muncul di sini...">{{ $item['soal_pegon'] ?? '' }}</textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6 text-end">
                                                <button type="button" class="btn btn-sm btn-secondary mb-0"
                                                    onclick="generatePegon({{ $index }})">
                                                    <i class="fa-solid fa-language"></i> Generate Pegon <i
                                                        class="fa-solid fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="d-flex justify-content-end mb-5">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa-solid fa-save me-2"></i> Perbarui Dan Cetak
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $('#formUpdateSoal').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $btn = $form.find('button[type="submit"]');
            let originalText = $btn.html();

            $btn.html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Menyimpan...').prop('disabled', true);

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.open(response.print_url, '_blank');
                        });
                    } else {
                        Swal.fire('Gagal', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'Gagal menyimpan ke server, cek console.', 'error');
                },
                complete: function() {
                    $btn.html(originalText).prop('disabled', false);
                }
            });
        });

        function generatePegon(index) {
            let textLatin = $('#latin_' + index).val();
            let $btn = $(event.currentTarget);
            let originalText = $btn.html();

            if (!textLatin.trim()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Teks latin tidak boleh kosong',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Oke'
                });
                return;
            }

            $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Memproses...').prop('disabled', true);

            $.ajax({
                url: '{{ route('bank-soal.generate') }}',
                type: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify({
                    text: textLatin
                }),
                success: function(response) {
                    if (response.status === 'success') {
                        $('#pegon_' + index).val(response.data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Transliterasi Berhasil!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan dari server.',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Waduh Gagal!',
                        text: 'Gagal menghubungi server transliterasi.',
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function() {
                    $btn.html(originalText).prop('disabled', false);
                }
            });
        }
    </script>
@endsection
