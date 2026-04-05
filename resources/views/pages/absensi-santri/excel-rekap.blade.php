<table>
    <thead>
        <tr>
            <th colspan="6" style="font-weight: bold; font-size: 14px; text-align: center;">REKAPITULASI KEHADIRAN
                SANTRI</th>
        </tr>
        <tr>
            <th colspan="6" style="font-weight: bold;">Kelas: {{ $kelas->nama_kelas }}</th>
        </tr>
        <tr>
            <th colspan="6" style="font-weight: bold;">Filter: {{ $filter_waktu ?? 'Sesuai Pilihan' }}</th>
        </tr>
        <tr></tr>

        <tr>
            <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #f8f9fa;">No
            </th>
            <th
                style="font-weight: bold; text-align: left; border: 1px solid #000000; background-color: #f8f9fa; width: 30px;">
                Nama Santri</th>
            <th
                style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #d4edda; color: #155724;">
                Hadir</th>
            <th
                style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #fff3cd; color: #856404;">
                Sakit</th>
            <th
                style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #d1ecf1; color: #0c5460;">
                Izin</th>
            <th
                style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #f8d7da; color: #721c24;">
                Alfa</th>
        </tr>
    </thead>
    <tbody>
        @forelse($santri as $index => $s)
            <tr>
                <td style="text-align: center; border: 1px solid #000000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">{{ $s->nama }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $rekap[$s->id]['hadir'] ?? 0 }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $rekap[$s->id]['sakit'] ?? 0 }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $rekap[$s->id]['izin'] ?? 0 }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $rekap[$s->id]['alfa'] ?? 0 }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; border: 1px solid #000000;">Tidak ada data santri.</td>
            </tr>
        @endforelse
    </tbody>
</table>
