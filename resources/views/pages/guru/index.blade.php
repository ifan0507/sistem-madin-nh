@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-dark border-radius-lg pt-4 pb-3">
                                <div class="d-flex justify-content-between align-items-center px-3">
                                    <h6 class="text-white text-capitalize mb-0">Guru Madin</h6>
                                    <button class="btn bg-white mb-0" data-bs-toggle="modal" data-bs-target="#modal-guru"
                                        id="btn-tambah-guru"><i class="material-symbols-rounded">add</i>&nbsp;&nbsp;Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kode</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Nama</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Qr Code</th>
                                            <th class="text-secondary opacity-7">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($gurus as $g)
                                            <tr>
                                                <td>
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold ps-3">{{ $g->kode_guru }}</span>
                                                </td>
                                                <td class="text-sm">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $g->name }}</span>
                                                </td>
                                                <td>
                                                    @if ($g->qr_activation != null)
                                                        <div class="ms-4 d-flex align-items-center">
                                                            <div class="qr-icon btn-view-qr"
                                                                data-token="{{ $g->qr_activation }}"
                                                                data-nama="{{ $g->name }}" data-bs-toggle="tooltip"
                                                                title="Lihat & Bagikan QR">
                                                                <img src="{{ asset('assets/images/qr.png') }}"
                                                                    alt="QR Code">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="ms-4 d-flex align-items-center">
                                                            <div class="qr-x">
                                                                <i class="fa-solid fa-x" style="color: red"></i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit user">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">Tidak
                                                        ada data
                                                        guru.</span>
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

    <div class="modal fade" id="modal-guru" tabindex="-1" role="dialog" aria-labelledby="modal-default"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-normal" id="modal-title-default">Tambah Guru</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form role="form text-left" action="{{ route('guru.store') }}" method="POST" id="form-guru">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-7 ps-4">
                                <h6 class="font-weight-bolder mb-3">Informasi Guru</h6>

                                <div class="input-group input-group-outline mb-3" id="group-kode">
                                    <label class="form-label">Kode Guru</label>
                                    <input type="text" class="form-control" name="kode_guru" id="kode_guru">
                                </div>

                                <div class="input-group input-group-outline mb-3" id="group-nama">
                                    <label class="form-label">Nama Guru</label>
                                    <input type="text" class="form-control" name="name" id="nama_guru">
                                </div>

                                <input type="hidden" name="qr_activation" id="qr_activation">
                                <input type="hidden" name="role" value="2">
                            </div>

                            <div class="col-md-5 text-center">
                                <p class="text-xs font-weight-bold mb-2">QR Code Login</p>

                                <div id="qrcode-container" class="border p-2 d-inline-block bg-white rounded"
                                    style="width: 130px; height: 130px;">
                                </div>

                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-info w-76 mb-1"
                                        id="btn-regenerate">
                                        <i class="fa fa-refresh me-1"></i> Random Ulang
                                    </button>
                                </div>
                            </div>
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


    <div class="modal fade" id="modal-view-qr" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">QR Code Login</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h6 id="preview-nama" class="mb-3">Nama Guru</h6>

                    <div class="p-3 border rounded bg-white d-inline-block shadow-sm">
                        <div id="preview-qrcode"></div>
                    </div>

                    <p class="text-xs mt-2 text-secondary">Token: <span id="preview-token"
                            class="font-weight-bold"></span></p>

                    <div class="row mt-3">
                        <div class="col-6 pe-1">
                            <button type="button" class="btn btn-outline-success w-100 btn-sm mb-0"
                                id="btn-native-share">
                                <i class="fa-solid fa-share-nodes" style="font-size: 12px"></i> Bagikan
                            </button>
                        </div>
                        <div class="col-6 ps-1">
                            <button type="button" class="btn btn-dark w-100 btn-sm mb-0" id="btn-download-img">
                                <i class="fa fa-download me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let qrcodeObj = null;
        $(document).ready(function() {
            let submitMethod = 'POST';
            $('#btn-tambah-guru').on('click', function() {
                $('#form-guru')[0].reset();
                $('#modal-title-default').text('Tambah Guru Baru');

                generateNewQRCode();

                $('#modal-guru').modal('show');
            });

            $('#btn-regenerate').on('click', function() {
                generateNewQRCode();
            });

            $('#btn-download-qr').on('click', function() {
                downloadQR();
            });

            // CRREATE
            $("#form-guru").on('submit', function(e) {
                e.preventDefault();
                if ($("#kode_guru").val() == '' || $("#name").val() == '') {
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
                            title: 'Error',
                            text: message
                        });
                    }
                });

            })

            let qrPreviewObj = null;
            $('.btn-view-qr').on('click', function() {
                let token = $(this).data('token');
                let nama = $(this).data('nama');

                $('#preview-nama').text(nama);
                $('#preview-token').text(token);

                $('#preview-qrcode').html('');

                qrPreviewObj = new QRCode(document.getElementById("preview-qrcode"), {
                    text: token,
                    width: 150,
                    height: 150,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });

                $('#modal-view-qr').modal('show');
            });

            $('#btn-download-img').on('click', function() {
                let img = $('#preview-qrcode img').attr('src');
                let nama = $('#preview-nama').text();

                if (img) {
                    let link = document.createElement('a');
                    link.href = img;
                    link.download = 'QR_' + nama + '.png';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });

            $('#btn-native-share').on('click', async function() {

                let imgSrc = $('#preview-qrcode img').attr('src'); // Ambil gambar QR
                let nama = $('#preview-nama').text();
                let token = $('#preview-token').text();

                // Cek apakah Browser mendukung fitur Share
                if (navigator.share) {
                    try {
                        // 1. Ubah Base64 Image jadi File Blob
                        const blob = await (await fetch(imgSrc)).blob();
                        const file = new File([blob], `QR_${nama}.png`, {
                            type: blob.type
                        });

                        // 2. Panggil Menu Share Bawaan HP
                        await navigator.share({
                            title: 'Login QR Code',
                            text: `Halo ${nama}, ini adalah Token Login Anda: ${token}`,
                            files: [file] // Lampirkan Gambar QR langsung!
                        });

                        console.log('Berhasil dibagikan');

                    } catch (err) {
                        console.error('Share gagal/dibatalkan:', err);
                    }
                } else {
                    // Fallback: Kalau browser gak dukung (misal Firefox Desktop lama)
                    // Kita alihkan ke copy text atau WA biasa
                    alert(
                        'Browser Anda tidak mendukung fitur share file langsung. Silakan download gambar manual.'
                    );
                }
            });
        });


        function generateNewQRCode() {
            $('#btn-regenerate').prop('disabled', true).text('Loading...');

            $.ajax({
                url: "{{ route('guru.generate-token') }}",
                type: "GET",
                success: function(response) {
                    let serverToken = response.token;

                    $('#qr_activation').val(serverToken);

                    $('#qrcode-container').html('');

                    qrcodeObj = new QRCode(document.getElementById("qrcode-container"), {
                        text: serverToken,
                        width: 110,
                        height: 110,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });

                    $('#btn-regenerate').prop('disabled', false).html(
                        '<i class="fa fa-refresh me-1"></i> Random Ulang');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagagl mengenerate qr qode. silahkan ulang lagi!'
                    })
                    $('#btn-regenerate').prop('disabled', false).text('Error');
                }
            });
        }
    </script>
@endsection
