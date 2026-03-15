<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="d-flex align-items-center  px-3 py-2 border-radius-lg">
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-xs font-weight-bolder mb-0 text-dark">
                            Tahun Ajaran {{ $pengaturanAktif->tahun_ajaran ?? 'Belum Diatur' }}
                        </h6>
                        <p class="text-xs text-secondary mb-0 font-weight-bold">
                            Semester {{ $pengaturanAktif->semester ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav d-flex align-items-center  justify-content-end">


                <li class="nav-item dropdown pe-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownSettingButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownSettingButton">
                        <li class="mb-2 px-3 py-2" style="min-width: 250px;">
                            <form id="formUpdatePengaturan" action="{{ route('pengaturan.update', 1) }}" method="POST">
                                @csrf

                                <h6 class="text-sm font-weight-bold mb-3 text-center border-bottom pb-2">
                                    <i class="fa-solid fa-sliders text-success me-1"></i> Pengaturan Akademik
                                </h6>

                                <div class="input-group input-group-static mb-3">
                                    <label for="tahun_ajaran" class="ms-0 font-weight-bold">Tahun
                                        Ajaran</label>
                                    <select class="form-control" id="tahun_ajaran" name="tahun_ajaran" required>
                                        <option value="2024/2025"
                                            {{ ($pengaturanAktif->tahun_ajaran ?? '') == '2024/2025' ? 'selected' : '' }}>
                                            2024/2025</option>
                                        <option value="2025/2026"
                                            {{ ($pengaturanAktif->tahun_ajaran ?? '') == '2025/2026' ? 'selected' : '' }}>
                                            2025/2026</option>
                                        <option value="2026/2027"
                                            {{ ($pengaturanAktif->tahun_ajaran ?? '') == '2026/2027' ? 'selected' : '' }}>
                                            2026/2027</option>
                                        <option value="2027/2028"
                                            {{ ($pengaturanAktif->tahun_ajaran ?? '') == '2027/2028' ? 'selected' : '' }}>
                                            2027/2028</option>
                                    </select>
                                </div>

                                <div class="input-group input-group-static mb-4">
                                    <label for="semester" class="ms-0 font-weight-bold">Semester</label>
                                    <select class="form-control" id="semester" name="semester" required>
                                        <option value="Ganjil"
                                            {{ ($pengaturanAktif->semester ?? '') == 'Ganjil' ? 'selected' : '' }}>
                                            Ganjil</option>
                                        <option value="Genap"
                                            {{ ($pengaturanAktif->semester ?? '') == 'Genap' ? 'selected' : '' }}>Genap
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-sm bg-gradient-success w-100 mb-0"
                                    id="btnSimpanPengaturan">
                                    <i class="fa-solid fa-save me-1"></i> Terapkan
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown pe-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-symbols-rounded">notifications</i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('assets/img/team-2.jpg') }}" class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('assets/img/small-logos/logo-spotify.svg') }}"
                                            class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New album</span> by Travis Scott
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background"
                                                                d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                opacity="0.593633743"></path>
                                                            <path class="color-background"
                                                                d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            Payment successfully completed
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <a href="../pages/sign-in.html" class="nav-link text-body font-weight-bold px-0">
                        <i class="material-symbols-rounded">account_circle</i>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    $(document).ready(function() {
        $('#formUpdatePengaturan').on('click', function(e) {
            e.stopPropagation();
        });
        $('#formUpdatePengaturan').on('submit', function(e) {
            e.preventDefault();
            let tahunAjaran = $('#tahun_ajaran').val();
            let semester = $('#semester').val();
            let $btn = $('#btnSimpanPengaturan');
            let originalText = $btn.html();

            $btn.html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Menyimpan...').prop('disabled',
                true);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $('#formUpdatePengaturan').serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pengaturan berhasil diperbarui',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal', response.message, 'error');
                        $btn.html(originalText).prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Server',
                        text: 'Gagal memperbarui pengaturan akademik.'
                    });
                    $btn.html(originalText).prop('disabled', false);
                }
            });
        });
    });
</script>
