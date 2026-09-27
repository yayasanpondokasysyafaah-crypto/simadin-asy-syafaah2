@php
    $kelasId = $get('kelas_id');
    $daur = $get('daur');
    $tahunAjaranId = $get('tahun_ajaran_id');

    $santris = $kelasId
        ? \App\Models\Santri::where('kelas_id', $kelasId)
            ->orderBy('nama')
            ->get()
        : collect();

    $hafalans = $kelasId
        ? \App\Models\Hafalan::where('kelas_id', $kelasId)
            ->orderBy('urutan')
            ->get()
        : collect();

    $nilaiTersimpan = collect();

    if ($kelasId && $daur && $tahunAjaranId) {
        $nilaiTersimpan = \App\Models\NilaiHafalan::query()
            ->whereIn('santri_id', $santris->pluck('id'))
            ->whereIn('hafalan_id', $hafalans->pluck('id'))
            ->where('daur', $daur)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->get()
            ->keyBy(fn ($item) => $item->santri_id . '_' . $item->hafalan_id);
    }

    $rataRata = $get('rata_rata') ?? [];
@endphp

<div class="mt-4 w-full overflow-x-auto">

    @if ($kelasId)

        <div class="mb-4">
            <button
                type="button"
                wire:click="hitungRataRata"
                class="fi-btn fi-btn-color-primary"
            >
                Hasilkan Rata-rata
            </button>
        </div>

        <table
            class="w-full border-collapse text-sm"
            style="min-width: 900px;"
        >
            <thead>
                <tr class="border-b border-gray-700">

                    <th
                        class="px-3 py-3 text-left"
                        style="width: 50px;"
                    >
                        No
                    </th>

                    <th
                        class="px-3 py-3 text-left"
                        style="min-width: 220px;"
                    >
                        Nama
                    </th>

                    @foreach ($hafalans as $hafalan)
                        <th
                            class="px-3 py-3 text-center"
                            style="min-width: 150px;"
                        >
                            {{ $hafalan->nama }}
                        </th>
                    @endforeach

                    <th
                        class="px-3 py-3 text-center"
                        style="min-width: 120px;"
                    >
                        Rata-rata
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

                        @foreach ($hafalans as $hafalan)

                            @php
                                $key = $santri->id . '_' . $hafalan->id;
                                $nilai = $nilaiTersimpan->get($key)?->nilai;
                            @endphp

                            <td
                                class="px-3 py-3 text-center"
                                style="min-width: 150px;"
                            >
                                <input
                                type="number"
                                min="0"
                                max="100"
                                wire:model="data.tabel_hafalan.{{ $santri->id }}.{{ $hafalan->id }}"
                                value="{{ data_get($get('tabel_hafalan'), $santri->id . '.' . $hafalan->id) }}"
                                class="fi-input"
                                style="width: 100px; text-align: center;"
                                placeholder="Nilai"
                            >
                            </td>

                        @endforeach

                        <td
                            class="px-3 py-3 text-center font-bold"
                            style="min-width: 120px;"
                        >
                            {{ data_get($rataRata, $santri->id, '-') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="{{ $hafalans->count() + 3 }}"
                            class="px-3 py-6 text-center"
                        >
                            Tidak ada santri di kelas ini.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    @else

        <p class="text-sm text-gray-500">
            Silakan pilih Kelas terlebih dahulu.
        </p>

    @endif

</div>