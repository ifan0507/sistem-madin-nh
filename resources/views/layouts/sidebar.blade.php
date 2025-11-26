@php
    $activePage = $activePage ?? '';
@endphp

<div class="sidebar" data-color="orange" data-background-color="white"
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
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

           <ul class="nav" id="sidebarAccordion">

    <!-- Management User -->
    <li class="nav-item {{ $activePage == 'profile' || $activePage == 'user-management' ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample"
            aria-expanded="{{ ($activePage == 'profile' || $activePage == 'user-management') ? 'true' : 'false' }}">
            <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
            <p>Management User <b class="caret"></b></p>
        </a>

        <div class="collapse {{ ($activePage == 'profile' || $activePage == 'user-management') ? 'show' : '' }}"
            id="laravelExample" data-parent="#sidebarAccordion">
            <ul class="nav">
                <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                    <a class="nav-link" href="#"><span class="sidebar-mini">UP</span><span class="sidebar-normal">User Profile</span></a>
                </li>
                <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                    <a class="nav-link" href="#"><span class="sidebar-mini">UM</span><span class="sidebar-normal">User Management</span></a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Management Kurikulum -->
    <li class="nav-item {{ in_array($activePage, ['kurikulum-mapel','kurikulum-kelas','kurikulum-silabus']) ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#kurikulumMenu"
            aria-expanded="{{ in_array($activePage, ['kurikulum-mapel','kurikulum-kelas','kurikulum-silabus']) ? 'true' : 'false' }}">
            <i class="material-icons">menu_book</i>
            <p>Management Kurikulum <b class="caret"></b></p>
        </a>

        <div class="collapse {{ in_array($activePage, ['kurikulum-mapel','kurikulum-kelas','kurikulum-silabus']) ? 'show' : '' }}"
            id="kurikulumMenu" data-parent="#sidebarAccordion">
            <ul class="nav">
                <li class="nav-item{{ $activePage == 'kurikulum-mapel' ? ' active' : '' }}">
                    <a class="nav-link" href="#"><span class="sidebar-mini">MP</span><span class="sidebar-normal">Mata Pelajaran</span></a>
                </li>
                <li class="nav-item{{ $activePage == 'kurikulum-kelas' ? ' active' : '' }}">
                    <a class="nav-link" href="#"><span class="sidebar-mini">KL</span><span class="sidebar-normal">Kelas & Level</span></a>
                </li>
                <li class="nav-item{{ $activePage == 'kurikulum-silabus' ? ' active' : '' }}">
                    <a class="nav-link" href="#"><span class="sidebar-mini">SB</span><span class="sidebar-normal">Silabus</span></a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Management Ujian -->
    <li class="nav-item {{ in_array($activePage, ['ujian-banksoal','ujian-jadwal','ujian-hasil']) ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#ujianMenu"
            aria-expanded="{{ in_array($activePage, ['ujian-banksoal','ujian-jadwal','ujian-hasil']) ? 'true' : 'false' }}">
            <i class="material-icons">assignment</i>
            <p>Management Ujian <b class="caret"></b></p>
        </a>

        <div class="collapse {{ in_array($activePage, ['ujian-banksoal','ujian-jadwal','ujian-hasil']) ? 'show' : '' }}"
            id="ujianMenu" data-parent="#sidebarAccordion">
            <ul class="nav">
                <li class="nav-item{{ $activePage == 'ujian-banksoal' ? ' active' : '' }}">
                    <a class="nav-link" href="#"><span class="sidebar-mini">BS</span><span class="sidebar-normal">Bank Soal</span></a>
                </li>
                <li class="nav-item{{ $activePage == 'ujian-jadwal' ? ' active' : '' }}">
                    <a class="nav-link" href="#"><span class="sidebar-mini">JU</span><span class="sidebar-normal">Jadwal Ujian</span></a>
                </li>
                <li class="nav-item{{ $activePage == 'ujian-hasil' ? ' active' : '' }}">
                    <a class="nav-link" href="#"><span class="sidebar-mini">HU</span><span class="sidebar-normal">Hasil Ujian</span></a>
                </li>
            </ul>
        </div>
    </li>

</ul>

    </div>
</div>
