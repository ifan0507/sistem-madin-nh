@php
    $activePageMaster = $active->activePageMaster ?? '';
    $activePage = $active->activePage ?? '';
@endphp

<div class="sidebar" data-color="green" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">

    <div class="logo">
        <a href="https://creative-tim.com/" class="simple-text logo-normal">
            {{ __('Creative Tim') }}
        </a>
    </div>

    <!-- HANYA 1 SIDEBAR WRAPPER -->
    <div class="sidebar-wrapper">
        <ul class="nav">

            <!-- Dashboard -->
            <li class="nav-item {{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="/">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <ul class="nav" id="sidebarAccordion">

                <!-- Management User -->
                <li class="nav-item {{ $activePageMaster == 'user-management' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#laravelExample"
                        aria-expanded="{{ $activePageMaster == 'user-management' ? 'true' : 'false' }}">
                        <i class="material-icons">people</i>
                        <p>Management User <b class="caret"></b></p>
                    </a>

                    <div class="collapse {{ $activePageMaster == 'user-management' ? 'show' : '' }}" id="laravelExample"
                        data-parent="#sidebarAccordion">
                        <ul class="nav">
                            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                                <a class="nav-link" href="#"><span class="sidebar-mini">ST </span><span
                                        class="sidebar-normal">Santri</span></a>
                            </li>
                            <li class="nav-item{{ $activePage == 'guru' ? ' active' : '' }}">
                                <a class="nav-link" href="/guru"><span class="sidebar-mini">GR</span><span
                                        class="sidebar-normal">Guru</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Management Kurikulum -->
                <li
                    class="nav-item {{ in_array($activePage, ['kurikulum-mapel', 'kurikulum-kelas', 'kurikulum-silabus']) ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#kurikulumMenu"
                        aria-expanded="{{ in_array($activePage, ['kurikulum-mapel', 'kurikulum-kelas', 'kurikulum-silabus']) ? 'true' : 'false' }}">
                        <i class="material-icons">menu_book</i>
                        <p>Kurikulum <b class="caret"></b></p>
                    </a>

                    <div class="collapse {{ in_array($activePage, ['kurikulum-mapel', 'kurikulum-kelas', 'kurikulum-silabus']) ? 'show' : '' }}"
                        id="kurikulumMenu" data-parent="#sidebarAccordion">
                        <ul class="nav">
                            <li class="nav-item{{ $activePage == 'kurikulum-mapel' ? ' active' : '' }}">
                                <a class="nav-link" href="#"><span class="sidebar-mini">MP</span><span
                                        class="sidebar-normal">Mata Pelajaran</span></a>
                            </li>
                            <li class="nav-item{{ $activePage == 'kurikulum-kelas' ? ' active' : '' }}">
                                <a class="nav-link" href="#"><span class="sidebar-mini">KL</span><span
                                        class="sidebar-normal">Kelas</span></a>
                            </li>
                            <li class="nav-item{{ $activePage == 'kurikulum-pengampu-mapel' ? ' active' : '' }}">
                                <a class="nav-link" href="#"><span class="sidebar-mini">PM</span><span
                                        class="sidebar-normal">Pengampu Mapel</span></a>
                            </li>
                            <li class="nav-item{{ $activePage == 'kurikulum-abses' ? ' active' : '' }}">
                                <a class="nav-link" href="#"><span class="sidebar-mini">AB</span><span
                                        class="sidebar-normal">Absensi</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Management Ujian -->
                <li
                    class="nav-item {{ in_array($activePage, ['ujian-banksoal', 'ujian-jadwal', 'ujian-hasil']) ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#ujianMenu"
                        aria-expanded="{{ in_array($activePage, ['ujian-banksoal', 'ujian-jadwal', 'ujian-hasil']) ? 'true' : 'false' }}">
                        <i class="material-icons">assignment</i>
                        <p>Management Ujian <b class="caret"></b></p>
                    </a>

                    <div class="collapse {{ in_array($activePage, ['ujian-banksoal', 'ujian-jadwal', 'ujian-hasil']) ? 'show' : '' }}"
                        id="ujianMenu" data-parent="#sidebarAccordion">
                        <ul class="nav">
                            <li class="nav-item{{ $activePage == 'ujian-banksoal' ? ' active' : '' }}">
                                <a class="nav-link" href="#"><span class="sidebar-mini">BS</span><span
                                        class="sidebar-normal">Bank Soal</span></a>
                            </li>
                            <li class="nav-item{{ $activePage == 'ujian-jadwal' ? ' active' : '' }}">
                                <a class="nav-link" href="#"><span class="sidebar-mini">JU</span><span
                                        class="sidebar-normal">Jadwal Ujian</span></a>
                            </li>
                            <li class="nav-item{{ $activePage == 'ujian-hasil' ? ' active' : '' }}">
                                <a class="nav-link" href="#"><span class="sidebar-mini">HU</span><span
                                        class="sidebar-normal">Hasil Ujian</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

    </div>
</div>
