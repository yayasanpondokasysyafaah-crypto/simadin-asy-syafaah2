<x-filament-panels::page>

<style>
    .simadin-select {
        appearance: none !important;
        -webkit-appearance: none !important;
        width: 100% !important;
        height: 42px !important;
        padding: 0 40px 0 12px !important;

        background: white !important;
        color: #111827 !important;

        border: 1px solid #d1d5db !important;
        border-radius: 8px !important;

        font-size: 14px !important;
        line-height: 42px !important;

        cursor: pointer !important;
    }

    .simadin-select:focus {
        outline: none !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15) !important;
    }

    .simadin-arrow {
        position: absolute !important;
        right: 12px !important;
        top: 50% !important;
        transform: translateY(-55%) !important;

        pointer-events: none !important;

        color: #6b7280 !important;
        font-size: 18px !important;
        font-weight: bold !important;
    }

    .dark .simadin-select {
        background: #18181b !important;
        color: white !important;
        border-color: #3f3f46 !important;
    }
</style>

    <div class="space-y-6">

        {{-- FILTER --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

            {{-- JENIS --}}
            <div>
                <label class="fi-fo-field-wrp-label">
                    Jenis Absensi
                </label>

                <div class="relative mt-2">
                    <select
                        wire:model.live="jenis"
                        class="simadin-select"
                    >
                        <option value="Keamanan">Keamanan</option>
                        <option value="Madin">Madin</option>
                    </select>

                    <span class="simadin-arrow">⌄</span>
                </div>
            </div>

            {{-- KEGIATAN --}}
            <div>
                <label class="fi-fo-field-wrp-label">
                    Kegiatan
                </label>

                <div class="relative mt-2">
                    <select
                        wire:model.live="kegiatan"
                        class="simadin-select"
                    >

                        @if ($jenis === 'Keamanan')

                            <option value="Shubuh">Shubuh</option>
                            <option value="Dhuha">Dhuha</option>
                            <option value="Dzuhur">Dzuhur</option>
                            <option value="Asar">Asar</option>
                            <option value="Maghrib">Maghrib</option>
                            <option value="Tasbih">Tasbih</option>
                            <option value="Isya">Isya</option>
                            <option value="Hajat">Hajat</option>

                        @else

                            <option value="Sorogan Qur'an">Sorogan Qur'an</option>
                            <option value="Sorogan Kitab">Sorogan Kitab</option>
                            <option value="Hapalan">Hapalan</option>
                            <option value="Syarah">Syarah</option>
                            <option value="Takror">Takror</option>
                            <option value="Diniyah">Diniyah</option>
                            <option value="Fiqih">Fiqih</option>

                        @endif

                    </select>

                    <span class="simadin-arrow">⌄</span>
                </div>      

            {{-- TANGGAL --}}
            <div>
                <label class="fi-fo-field-wrp-label">
                    Tanggal
                </label>

                <input
                    type="date"
                    wire:model.live="tanggal"
                    class="fi-input mt-2 w-full rounded-lg border-gray-300"
                >
            </div>

            {{-- KELAS --}}
            <div>
                <label class="fi-fo-field-wrp-label">
                    Kelas
                </label>

                <div class="relative mt-2">
                <select
                    wire:model.live="kelas_id"
                    class="simadin-select"
                >
                    <option value="">-- Pilih Kelas --</option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}">
                            Kelas {{ $item->nama }}
                        </option>
                    @endforeach
                </select>

                <span class="simadin-arrow">⌄</span>
            </div>

        </div>


        {{-- DAFTAR SANTRI --}}
        @if ($kelas_id)

            <div class="overflow-hidden rounded-xl border">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="border-b bg-gray-50">

                            <th class="px-4 py-3 text-left">
                                No
                            </th>

                            <th class="px-4 py-3 text-left">
                                Santri
                            </th>

                            <th class="px-4 py-3 text-center">
                                Status
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($santris as $no => $santri)

                            <tr class="border-b last:border-b-0">

                                {{-- NOMOR --}}
                                <td class="px-4 py-3">
                                    {{ $no + 1 }}
                                </td>

                                {{-- SANTRI --}}
                                <td class="px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        @if ($santri->foto)

                                            <img
                                            src="{{ Storage::disk('public')->url($santri->foto) }}"
                                            alt="{{ $santri->nama }}"
                                            class="h-14 w-11 rounded-lg object-cover object-center"
                                            style="width: 44px; height: 56px; object-fit: cover;"
                                        >

                                        @else

                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-xs text-gray-500">
                                                ?
                                            </div>

                                        @endif

                                        <div>
                                            <div class="font-medium">
                                                {{ $santri->nama }}
                                            </div>

                                            <div class="text-xs text-gray-500">
                                                NIS: {{ $santri->nis }}
                                            </div>
                                        </div>

                                    </div>

                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-3 text-center">

                                    <select
                                        wire:model="absensi.{{ $santri->id }}"
                                     class="w-32 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                    >

                                        <option value=".">
                                            . — Hadir
                                        </option>

                                        <option value="S">
                                            S — Sakit
                                        </option>

                                        <option value="I">
                                            I — Izin
                                        </option>

                                        <option value="A">
                                            A — Alpa
                                        </option>

                                    </select>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="3"
                                    class="px-4 py-8 text-center text-gray-500"
                                >
                                    Belum ada santri di kelas ini.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- SIMPAN --}}
            @if ($santris->count())

                <div class="flex justify-end">

                    <button
                        type="button"
                        wire:click="simpan"
                        class="fi-btn fi-btn-color-primary rounded-lg px-5 py-2"
                    >
                        Simpan Absensi
                    </button>

                </div>

            @endif

        @else

            <div class="rounded-xl border p-6 text-center text-gray-500">
                Pilih kelas terlebih dahulu.
            </div>

        @endif

    </div>

</x-filament-panels::page>