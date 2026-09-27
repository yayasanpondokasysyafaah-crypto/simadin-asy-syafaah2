@php
    $kelasId = $get('kelas_id');
    $mataPelajaranId = $get('mata_pelajaran_id');
    $tahunAjaranId = $get('tahun_ajaran_id');
    $daur = $get('daur');

    $santris = $kelasId
        ? \App\Models\Santri::where('kelas_id', $kelasId)
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get()
        : collect();

    $nilaiTersimpan = collect();

    if ($kelasId && $mataPelajaranId && $tahunAjaranId && $daur) {
        $nilaiTersimpan = \App\Models\Nilai::query()
            ->where('kelas_id', $kelasId)
            ->where('mata_pelajaran_id', $mataPelajaranId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('daur', $daur)
            ->pluck('nilai', 'santri_id');
    }
@endphp

<div class="mt-4 w-full overflow-x-auto">

    @if ($kelasId && $mataPelajaranId)

        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="px-3 py-3 text-left" style="width: 60px;">
                        No
                    </th>

                    <th class="px-3 py-3 text-left" style="min-width: 250px;">
                        Nama Santri
                    </th>

                    <th class="px-3 py-3 text-center" style="width: 150px;">
                        Nilai
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($santris as $index => $santri)
                    <tr class="border-b border-gray-700">

                        <td class="px-3 py-3">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-3 py-3 font-medium">
                            {{ $santri->nama }}
                        </td>

                        <td class="px-3 py-3 text-center">
                            <input
                                type="number"
                                min="0"
                                max="100"
                                wire:model="data.tabel_nilai.{{ $santri->id }}"
                                value="{{ $nilaiTersimpan[$santri->id] ?? '' }}"
                                placeholder="Nilai"
                                style="width: 100px; height: 40px; text-align: center; border: 1px solid #6b7280; border-radius: 6px; background: #1f1f23; color: white;"
                            >
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-3 py-6 text-center">
                            Tidak ada santri aktif di kelas ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @elseif ($kelasId)

        <p class="text-sm text-gray-500">
            Silakan pilih Mata Pelajaran terlebih dahulu.
        </p>

    @else

        <p class="text-sm text-gray-500">
            Silakan pilih Kelas dan Mata Pelajaran terlebih dahulu.
        </p>

    @endif

</div>