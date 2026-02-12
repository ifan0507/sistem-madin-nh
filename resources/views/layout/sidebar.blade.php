@php
    $activePageMaster = $active->activePageMaster ?? '';
    $activePage = $active->activePage ?? '';
@endphp

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
    id="sidenav-main">

    <div class="sidenav-header" style="display:flex; justify-content:center; align-items:center; padding:12px 0;">
        <a class="navbar-brand m-0" href="/" style="display:flex; align-items:center; gap:8px; padding:0;">
            <img src="{{ asset('assets/images/logo_pondok.jpg') }}" style="width:40px; height:40px; object-fit:contain;">
            <span class="text-sm h2 mt-2 text-dark fw-semibold">Nurul Huda</span>
        </a>
    </div>



    <hr class="horizontal dark mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ $activePage == 'dashboard' ? 'active bg-gradient-primary text-white' : 'text-dark' }}"
                    href="/">
                    <i class="material-symbols-rounded">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- MANAGEMENT USER -->
            <li class="nav-item">
                <a class="nav-link text-dark" data-bs-toggle="collapse" href="#userMenu"
                    aria-expanded="{{ $activePageMaster == 'user-management' ? 'true' : 'false' }}">
                    <i class="material-symbols-rounded">people</i>
                    <span class="nav-link-text ms-1">Management User</span>
                </a>

                <div class="collapse {{ $activePageMaster == 'user-management' ? 'show' : '' }}" id="userMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link {{ $activePage == 'santri' ? 'active fw-semibold' : 'text-dark' }}"
                                href="{{ route('santri') }}">
                                Santri
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activePage == 'guru' ? 'active fw-semibold' : 'text-dark' }}"
                                href="/guru">
                                Guru
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- akademik -->
            <li class="nav-item">
                <a class="nav-link
                    {{ in_array($activePage, ['akademik-management', 'akademik-kelas', 'akademik-pengampu-mapel', 'akademik-abses'])
                        ? 'active bg-gradient-primary text-white'
                        : 'text-dark' }}"
                    data-bs-toggle="collapse" href="#akademikMenu"
                    aria-expanded="{{ in_array($activePage, ['akademik-kelas', 'akademik-mapel', 'akademik-pengampu-mapel', 'akademik-abses']) ? 'true' : 'false' }}">
                    <i class="material-symbols-rounded">menu_book</i>
                    <span class="nav-link-text ms-1">Managemen Akademik</span>
                </a>

                <div class="collapse {{ in_array($activePage, ['akademik-kelas', 'akademik-mapel', 'akademik-pengampu-mapel', 'akademik-abses']) ? 'show' : '' }}"
                    id="akademikMenu">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link {{ $activePage == 'akademik-kelas' ? 'active fw-semibold' : 'text-dark' }}"
                                href="#">
                                Kelas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activePage == 'akademik-mapel' ? 'active fw-semibold' : 'text-dark' }}"
                                href="{{ route('mapel') }}">
                                Mata Pelajaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activePage == 'akademik-pengampu-mapel' ? 'active fw-semibold' : 'text-dark' }}"
                                href="#">
                                Mapel Kelas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activePage == 'akademik-pengampu-mapel' ? 'active fw-semibold' : 'text-dark' }}"
                                href="#">
                                Jadwal KBM
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activePage == 'akademik-abses' ? 'active fw-semibold' : 'text-dark' }}"
                                href="#">
                                Absensi
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</aside>
