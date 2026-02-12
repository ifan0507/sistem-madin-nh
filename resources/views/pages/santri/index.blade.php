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
                                    <h6 class="text-white text-capitalize mb-0">Data Santri</h6>
                                    <a class="btn bg-white mb-0" href="{{ route('santri.create') }}"><i class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Tambah Data Santri</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NIS</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jenis Kelamin</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kelas</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Angkatan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($santris as $s)
                                        <tr>
                                            <td class="ps-4">
                                                <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $s->nama }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $s->nis }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $s->jenis_kelamin }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $s->kelas }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $s->thn_angkatan }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="#" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Lihat Detail
                                                </a>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">Tidak
                                                        ada data
                                                        santri.</span>
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
@endsection
