@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-white border-radius-lg pt-3 pb-3">
                                <div class="d-flex justify-content-between align-items-center px-3">
                                    <h6 class="text-white text-capitalize mb-0">Mata Pelajaran</h6>
                                    <button class="btn bg-white mb-0" data-bs-toggle="modal" data-bs-target="#modal-mapel"
                                        id="btn-tambah-mapel"><i
                                            class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Tambah
                                        Mapel</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kode Mapel</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Nama Mapel</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($mapels as $m)
                                            <tr>
                                                <td class="ps-4">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $m->kode_mapel }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $m->nama_mapel }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button
                                                        class="btn btn-outline-secondary btn-sm btn-icon-round  btn-edit-mapel"
                                                        data-bs-toggle="tooltip" title="Edit"
                                                        data-id="{{ $m->id }}" data-kode="{{ $m->kode_mapel }}"
                                                        data-nama="{{ $m->nama_mapel }}">
                                                        <i class="fa-solid fa-pencil" style="font-size: 12px;"></i>
                                                    </button>

                                                    <button class="btn btn-outline-danger btn-sm  btn-icon-round"
                                                        data-bs-toggle="tooltip" title="Hapus">
                                                        <i class="fa-regular fa-trash-can" style="font-size: 12px;"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">Tidak
                                                        ada data
                                                        mata pelajaran.</span>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-mapel" tabindex="-1" role="dialog" aria-labelledby="modal-default"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-normal" id="modal-title-default">Tambah Mata Pelajaran</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form role="form text-left" action="{{ route('mapel.store') }}" method="POST" id="form-mapel">
                    <div class="modal-body">

                        @csrf
                        <div class="input-group input-group-outline my-3" id="group-kode">
                            <label class="form-label">Kode Mapel</label>
                            <input type="text" class="form-control" name="kode_mapel" id="kode_mapel">
                        </div>
                        <div class="input-group input-group-outline my-3" id="group-nama">
                            <label class="form-label">Nama Mapel</label>
                            <input type="text" class="form-control" name="nama_mapel" id="nama_mapel">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-success btn-simpan">Simpan</button>
                        <button type="button" class="btn ml-auto btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let submitMethod = 'POST';
            // SHOW CREATE 
            $('#btn-tambah-mapel').on('click', function() {
                $('#modal-title-default').text('Tambah Mata Pelajaran');

                $('#form-mapel')[0].reset();
                $('#form-mapel').attr('action', "{{ route('mapel.store') }}");

                // HAPUS is-filled
                $('#group-kode, #group-nama').removeClass('is-filled');
                $('#form-mapel').attr('action', "{{ route('mapel.store') }}");
                submitMethod = 'POST';
                $('#modal-mapel').modal('show');
            });

            // STORE
            $('#form-mapel').on('submit', function(e) {
                e.preventDefault();
                if ($("#kode_mapel").val() == '' || $("#nama_mapel").val() == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Semua field harus diisi!'
                    });
                    return false;
                }
                let formAction = $(this).attr('action');
                let formData = $(this).serialize();
                if (submitMethod === 'PUT') {
                    formData += '&_method=PUT';
                }
                $.ajax({
                    type: "POST",
                    url: formAction,
                    data: formData,
                    dataType: "json",
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#66bb6a',
                        }).then(() => {
                            location.reload();
                        });
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
                            title: 'Gagal',
                            text: message
                        });
                    }
                });


            })

            // SHOW EDIT
            $(".btn-edit-mapel").on('click', function() {
                let id = $(this).data('id');
                let kode = $(this).data('kode');
                let nama = $(this).data('nama');

                $('#modal-title-default').text('Edit Mata Pelajaran');

                $('#kode_mapel').val(kode);
                $('#nama_mapel').val(nama);

                $('#group-kode').addClass('is-filled');
                $('#group-nama').addClass('is-filled');

                let updateUrl = "{{ url('/mapel') }}/" + id + "/update";
                $('#form-mapel').attr('action', updateUrl);
                submitMethod = 'PUT';
                $('#modal-mapel').modal('show');
            })
        });
    </script>
@endsection
