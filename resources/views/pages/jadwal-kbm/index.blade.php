@extends('layout.template')
@section('content')
    <style>
        .table.table-bordered> :not(caption)>*>* {
            border: 1px solid #dee2e6 !important;
        }

        .jadwal-bentrok {
            background-color: #ffcccc !important;
            border: 1px solid #ff7b7b !important;
        }
    </style>
    <div class="content">
        <div class="container-fluid py-2">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-info border-radius-lg pt-3 pb-3">
                        <div class="d-flex justify-content-between align-items-center px-3">
                            <h6 class="text-white text-capitalize mb-0">Jadwal KBM</h6>
                            <a href="{{ route('jadwal-kbm.cetak') }}" class="btn btn-sm bg-white text-success mb-0"
                                target="_blank" title="Cetak Jadwal KBM">
                                <i class="fa-solid fa-print me-1"></i> Cetak Jadwal
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table table-bordered align-items-center mb-0">
                            <thead>
                                <tr class="align-middle text-center bg-light">
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        width="3%">No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        width="10%">
                                        Kelas</th>

                                    @php
                                        $hari_kbm = ['Sabtu', 'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis'];
                                    @endphp

                                    @foreach ($hari_kbm as $hari)
                                        <th class="text-uppercase text-dark text-xxs font-weight-bolder" width="14%">
                                            {{ $hari }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $jadwalBentrokIds = [];
                                    $hari_list = ['Sabtu', 'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis'];

                                    foreach ($hari_list as $h) {
                                        $guru_per_hari = [];

                                        foreach ($kelas as $kls) {
                                            $isKelasMalam = in_array($kls->id, [6, 7]);

                                            $jdwl = $kls->jadwal_kbms->where('hari', $h)->first();

                                            if ($jdwl && $jdwl->mapel_kelas) {
                                                $guruId = $jdwl->mapel_kelas->guru_id;

                                                if (!isset($guru_per_hari[$guruId])) {
                                                    $guru_per_hari[$guruId] = ['pagi' => [], 'malam' => []];
                                                }

                                                if ($isKelasMalam) {
                                                    $guru_per_hari[$guruId]['malam'][] = $jdwl->id;
                                                } else {
                                                    $guru_per_hari[$guruId]['pagi'][] = $jdwl->id;
                                                }
                                            }
                                        }

                                        foreach ($guru_per_hari as $guruId => $jadwalGuru) {
                                            if (count($jadwalGuru['pagi']) > 1) {
                                                $jadwalBentrokIds = array_merge($jadwalBentrokIds, $jadwalGuru['pagi']);
                                            }
                                            if (count($jadwalGuru['malam']) > 1) {
                                                $jadwalBentrokIds = array_merge(
                                                    $jadwalBentrokIds,
                                                    $jadwalGuru['malam'],
                                                );
                                            }
                                        }
                                    }
                                @endphp

                                @foreach ($kelas as $index => $k)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <h6 class="mb-0 text-sm">{{ getKelasArab($k->id) }}</h6>
                                        </td>

                                        @foreach (['Sabtu', 'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis'] as $hari)
                                            @php
                                                $jadwal = $k->jadwal_kbms->where('hari', $hari)->first();
                                            @endphp

                                            <td class="align-middle text-center p-2">
                                                @if ($jadwal)
                                                    @php
                                                        $isBentrok = in_array($jadwal->id, $jadwalBentrokIds);
                                                    @endphp

                                                    <div class="box-jadwal-isi btn-atur-jadwal {{ $isBentrok ? 'jadwal-bentrok' : '' }}"
                                                        data-kelas-id="{{ $k->id }}"
                                                        data-kelas-id="{{ $k->id }}"
                                                        data-kelas-nama="{{ getKelasArab($k->id) }}"
                                                        data-hari="{{ $hari }}" data-jadwal-id="{{ $jadwal->id }}"
                                                        data-mapel-kelas-id="{{ $jadwal->mapel_kelas_id }}">

                                                        <h6 class="mb-0 text-xs text-dark">
                                                            {{ $jadwal->mapel_kelas->mapel->nama_mapel }}
                                                        </h6>
                                                        <p class="text-xxs text-secondary mb-0">
                                                            {{ $jadwal->mapel_kelas->guru->name }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="box-jadwal-kosong btn-atur-jadwal"
                                                        data-kelas-id="{{ $k->id }}"
                                                        data-kelas-nama="{{ getKelasArab($k->id) }}"
                                                        data-hari="{{ $hari }}" data-jadwal-id=""
                                                        data-mapel-kelas-id="">
                                                        <i class="fa-solid fa-plus text-xs mb-1 text-secondary"></i>
                                                        <p class="text-xxs text-secondary mb-0">Belum ada jadwal</p>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-atur-jadwal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success">
                    <h6 class="modal-title font-weight-normal text-white" id="modal-title-default">
                        Atur Jadwal KBM
                    </h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>


                <form id="form-atur-jadwal">
                    @csrf
                    <input type="hidden" name="kelas_id" id="hidden_jadwal_kelas_id">
                    <input type="hidden" name="hari" id="hidden_jadwal_hari">
                    <input type="hidden" name="jadwal_id" id="hidden_jadwal_id">
                    <div class="modal-body">
                        <div class="alert alert-light border text-center mb-4" role="alert">
                            <span class="text-sm">Menjadwalkan untuk:</span><br>
                            <strong class="text-dark" id="info-jadwal-teks">Kelas SIFIR - Hari Senin</strong>
                        </div>

                        <div class="input-group input-group-static my-3">
                            <label for="select-jadwal-mapel" class="ms-0 text-dark font-weight-bold">Pilih Mata
                                Pelajaran</label>
                            <select class="form-control" name="mapel_kelas_id" id="select-jadwal-mapel"
                                style="width: 100%;">
                                <option value="">-- Loading Data... --</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-success btn-simpan-jadwal">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#select-jadwal-mapel').select2({
                dropdownParent: $('#modal-atur-jadwal'),
                placeholder: '-- Pilih Mata Pelajaran --',
                allowClear: true
            });

            let kotakJadwalTerpilih = null;
            $('body').on('click', '.btn-atur-jadwal', function() {
                kotakJadwalTerpilih = $(this);
                let kelasId = $(this).data('kelas-id');
                let kelasNama = $(this).data('kelas-nama');
                let hari = $(this).data('hari');
                let jadwalId = $(this).attr('data-jadwal-id');
                let mapelKelasId = $(this).attr('data-mapel-kelas-id');
                $('#info-jadwal-teks').text(`Kelas ${kelasNama} - Hari ${hari}`);

                $('#hidden_jadwal_kelas_id').val(kelasId);
                $('#hidden_jadwal_hari').val(hari);
                $('#hidden_jadwal_id').val(jadwalId);
                $('#select-jadwal-mapel').html('<option value="">Mencari data mapel...</option>').prop(
                    'disabled', true);
                $('.btn-simpan-jadwal').prop('disabled', false).text('Simpan Jadwal');
                $('#modal-atur-jadwal').modal('show');

                $.ajax({
                    url: `/mapel-kelas/kelas/jadwal-kbm/${kelasId}`,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let options = '<option value="">-- Pilih Mata Pelajaran --</option>';

                        if (data.length > 0) {
                            $.each(data, function(key, item) {
                                let icon = item.sudah_dijadwalkan ? '✅' : '❌';
                                let namaGuruBersih = `${item.guru.name}`;
                                options +=
                                    `<option value="${item.id}" data-mapel="${item.mapel.nama_mapel}" data-guru="${namaGuruBersih}">${item.mapel.nama_mapel}  —  ${item.guru.name} ${icon}</option>`;
                            });
                        } else {
                            options =
                                '<option value="" disabled>Belum ada mapel ditambahkan di kelas ini</option>';
                        }

                        $('#select-jadwal-mapel').html(options).prop('disabled', false);
                        if (mapelKelasId) {
                            $('#select-jadwal-mapel').val(mapelKelasId).trigger('change');
                        }
                    },
                    error: function() {
                        $('#select-jadwal-mapel').html(
                            '<option value="">Gagal memuat data</option>');
                        Swal.fire('Error', 'Gagal mengambil data mapel kelas dari server.',
                            'error');
                    }
                });
            });

            $('body').on('click', '.btn-simpan-jadwal', function(e) {
                e.preventDefault();

                let kelasId = $('#hidden_jadwal_kelas_id').val();
                let hari = $('#hidden_jadwal_hari').val();
                let mapelKelasId = $('#select-jadwal-mapel').val();

                if (!mapelKelasId) {
                    Swal.fire('Oops...', 'Pilih Mata Pelajaran terlebih dahulu!', 'error');
                    return;
                }

                let selectedOption = $('#select-jadwal-mapel option:selected');
                let mapelNama = selectedOption.data('mapel');
                let guruNama = selectedOption.data('guru');

                $('.btn-simpan-jadwal').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

                let formData = $('#form-atur-jadwal').serialize();

                $.ajax({
                    url: "{{ route('jadwal-kbm.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('#modal-atur-jadwal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Tersimpan!',
                            text: 'Jadwal berhasil diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        if (kotakJadwalTerpilih) {
                            kotakJadwalTerpilih.removeClass('box-jadwal-kosong').addClass(
                                'box-jadwal-isi');
                            kotakJadwalTerpilih.html(`
                                <h6 class="mb-0 text-xs text-dark">${mapelNama}</h6>
                                <p class="text-xxs text-secondary mb-0">${guruNama}</p>
                            `);
                            kotakJadwalTerpilih.attr('data-jadwal-id', response.data.id);
                            kotakJadwalTerpilih.attr('data-mapel-kelas-id', mapelKelasId);
                            kotakJadwalTerpilih.hide().fadeIn(400);
                        }

                        if (response.bentrok_ids) {
                            $('.btn-atur-jadwal').removeClass('jadwal-bentrok');

                            response.bentrok_ids.forEach(function(bentrokId) {
                                $(`.btn-atur-jadwal[data-jadwal-id="${bentrokId}"]`)
                                    .addClass('jadwal-bentrok');
                            });
                        }
                        $('#form-atur-jadwal')[0].reset();
                        $('#select-jadwal-mapel').val(null).trigger('change');
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menyimpan data.';

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][0];
                        }
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                        // Swal.fire('Error', 'Terjadi kesalahan saat menyimpan jadwal.', 'error');
                    },
                    complete: function() {
                        $('.btn-simpan-jadwal').prop('disabled', false).text('Simpan Jadwal');
                    }
                });
            });

        });
    </script>
@endsection
