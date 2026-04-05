@foreach ($months as $monthKey => $month)
    <table>
        <thead>
            <tr>
                <th colspan="2" style="font-weight: bold; font-size: 14px;">Kelas: {{ getKelasArab($kelas->id) }}</th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; font-size: 14px;">Periode: {{ $month['title'] }}</th>
            </tr>
            <tr></tr>

            {{-- HEADER TABEL --}}
            <tr>
                <th style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: #f8f9fa;">
                    No</th>
                <th
                    style="font-weight: bold; text-align: left; border: 1px solid #000000; background-color: #f8f9fa; width: 25px;">
                    Nama Santri</th>

                @foreach ($month['dates'] as $date)
                    <th
                        style="font-weight: bold; text-align: center; border: 1px solid #000000; background-color: {{ $date['isJumat'] ? '#fff0f0' : '#f8f9fa' }};">
                        {{ $date['day'] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($santri as $index => $s)
                <tr>
                    <td style="text-align: center; border: 1px solid #000000;">{{ $index + 1 }}</td>
                    <td style="text-align: left; border: 1px solid #000000;">{{ $s->nama }}</td>

                    @foreach ($month['dates'] as $date)
                        @php
                            $status = $absensi[$s->id][$date['full_date']] ?? null;
                            $teks = '';
                            $warnaBg = $date['isJumat'] ? '#fff0f0' : '#ffffff';
                            $warnaTeks = '#000000';

                            if ($status == '1') {
                                $teks = '✔';
                                $warnaTeks = '#008000';
                            } elseif ($status == '2') {
                                $teks = 'S';
                                $warnaBg = '#ffeeba';
                            } elseif ($status == '3') {
                                $teks = 'I';
                                $warnaBg = '#b8daff';
                            } elseif ($status == '4') {
                                $teks = 'A';
                                $warnaBg = '#f5c6cb';
                            }
                        @endphp

                        <td
                            style="text-align: center; border: 1px solid #000000; background-color: {{ $warnaBg }}; color: {{ $warnaTeks }};">
                            {{ $teks }}
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($month['dates']) + 2 }}">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table>
        <tr>
            <td></td>
        </tr>
    </table>
@endforeach
