<?php

namespace App\DTO;

use Illuminate\Http\Request;

class SantriDto
{
    public function __construct(
        private readonly string $nama,
        private readonly string $nis,
        private readonly string $nik,
        private readonly string $tempat_lahir,
        private readonly string $tanggal_lahir,
        private readonly string $jenis_kelamin,
        private readonly string $alamat,
        private readonly string $ayah,
        private readonly string $ibu,
        private readonly string $no_telp,
        private readonly string $thn_angkatan,
        private readonly ?string $kelas_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            nama: $request->input('nama'),
            nis: $request->input('nis'),
            nik: $request->input('nik'),
            tempat_lahir: $request->input('tempat_lahir'),
            tanggal_lahir: $request->input('tanggal_lahir'),
            jenis_kelamin: $request->input('jenis_kelamin'),
            alamat: $request->input('alamat'),
            ayah: $request->input('ayah'),
            ibu: $request->input('ibu'),
            no_telp: $request->input('no_telp'),
            thn_angkatan: $request->input('thn_angkatan'),
            kelas_id: $request->input('kelas_id'),
        );
    }

    public function toArray(): array
    {
        return [
            'nama' => $this->nama,
            'nis' => $this->nis,
            'nik' => $this->nik,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'ayah' => $this->ayah,
            'ibu' => $this->ibu,
            'no_telp' => $this->no_telp,
            'thn_angkatan' => $this->thn_angkatan,
            'kelas_id' => $this->kelas_id,
        ];
    }
}
