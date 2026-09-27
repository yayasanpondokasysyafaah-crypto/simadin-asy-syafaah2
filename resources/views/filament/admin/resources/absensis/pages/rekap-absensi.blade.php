<x-filament-panels::page>

    <div class="space-y-6">

        {{-- =========================
            FILTER
        ========================== --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">

            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                    Filter Rekap Absensi
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pilih periode dan kelompok santri yang ingin ditampilkan.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">

                {{-- BULAN --}}
                <div>
                    <label class="fi-fo-field-wrp-label">
                        Bulan
                    </label>

                    <input
                        type="month"
                        wire:model.live="bulan"
                        class="fi-input mt-2 w-full rounded-xl border-gray-300"
                    >
                </div>


                {{-- JENIS --}}
                <div>
                    <label class="fi-fo-field-wrp-label">
                        Jenis Absensi
                    </label>

                    <select
                        wire:model.live="jenis"
                        class="fi-input mt-2 w-full rounded-xl border-gray-300"
                    >
                        <option value="Keamanan">
                            Keamanan
                        </option>

                        <option value="Madin">
                            Madin
                        </option>
                    </select>
                </div>


                {{-- KEGIATAN --}}
                @if ($jenis === 'Madin')

                    <div>
                        <label class="fi-fo-field-wrp-label">
                            Kegiatan
                        </label>

                        <select
                            wire:model.live="kegiatan"
                            class="fi-input mt-2 w-full rounded-xl border-gray-300"
                        >
                            <option value="Sorogan Qur'an">
                                Sorogan Qur'an
                            </option>

                            <option value="Sorogan Kitab">
                                Sorogan Kitab
                            </option>

                            <option value="Hapalan">
                                Hapalan
                            </option>

                            <option value="Syarah">
                                Syarah
                            </option>

                            <option value="Takror">
                                Takror
                            </option>

                            <option value="Diniyah">
                                Diniyah
                            </option>

                            <option value="Fiqih">
                                Fiqih
                            </option>
                        </select>
                    </div>

                @endif


                {{-- JENIS KELAMIN --}}
                <div>
                    <label class="fi-fo-field-wrp-label">
                        Jenis Kelamin
                    </label>

                    <select
                        wire:model.live="jk"
                        class="fi-input mt-2 w-full rounded-xl border-gray-300"
                    >
                        <option value="">
                            Semua JK
                        </option>

                        <option value="L">
                            Laki-laki
                        </option>

                        <option value="P">
                            Perempuan
                        </option>
                    </select>
                </div>


                {{-- KELAS --}}
                <div>
                    <label class="fi-fo-field-wrp-label">
                        Kelas
                    </label>

                    <select
                        wire:model.live="kelas_id"
                        class="fi-input mt-2 w-full rounded-xl border-gray-300"
                    >
                        <option value="">
                            -- Pilih Kelas --
                        </option>

                        @foreach ($kelas as $item)

                            <option value="{{ $item->id }}">
                                Kelas {{ $item->nama }}
                            </option>

                        @endforeach
                    </select>
                </div>

            </div>

        </div>


        {{-- =========================
            REKAP
        ========================== --}}
        @if ($kelas_id)

            @php

                $totalHadir = 0;
                $totalSakit = 0;
                $totalIzin = 0;
                $totalAlpa = 0;

                foreach ($santris as $santri) {

                    $dataRekap = $rekap[$santri->id] ?? [];

                    $totalHadir += (int) ($dataRekap['hadir'] ?? 0);
                    $totalSakit += (int) ($dataRekap['sakit'] ?? 0);
                    $totalIzin += (int) ($dataRekap['izin'] ?? 0);
                    $totalAlpa += (int) ($dataRekap['alpa'] ?? 0);

                }

                $totalDenda = $totalAlpa * 2000;

                $kelasTerpilih = $kelas->firstWhere('id', $kelas_id);

            @endphp


            {{-- =========================
                HEADER + RINGKASAN
            ========================== --}}
            <div class="space-y-4">

                {{-- HEADER --}}
                <div>

                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Rekap Absensi
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">

                        Kelas {{ $kelasTerpilih?->nama ?? '-' }}

                        @if ($jk === 'L')
                            • Putra
                        @elseif ($jk === 'P')
                            • Putri
                        @else
                            • Semua
                        @endif

                        • {{ $santris->count() }} santri

                    </p>

                </div>


                {{-- =========================
                    KARTU RINGKASAN
                ========================== --}}
                <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-5">

                    {{-- HADIR --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">

                        <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Hadir
                        </div>

                        <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $totalHadir }}
                        </div>

                    </div>


                    {{-- SAKIT --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">

                        <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Sakit
                        </div>

                        <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $totalSakit }}
                        </div>

                    </div>


                    {{-- IZIN --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900">

                        <div class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Izin
                        </div>

                        <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $totalIzin }}
                        </div>

                    </div>


                    {{-- ALPA --}}
                    <div class="rounded-2xl border border-red-200 bg-red-50 p-4 shadow-sm dark:border-red-900 dark:bg-red-950/30">

                        <div class="text-xs font-medium uppercase tracking-wide text-red-600 dark:text-red-400">
                            Alpa
                        </div>

                        <div class="mt-1 text-2xl font-bold text-red-700 dark:text-red-400">
                            {{ $totalAlpa }}
                        </div>

                    </div>


                    {{-- DENDA --}}
                    <div class="rounded-2xl border border-orange-200 bg-orange-50 p-4 shadow-sm dark:border-orange-900 dark:bg-orange-950/30">

                        <div class="text-xs font-medium uppercase tracking-wide text-orange-600 dark:text-orange-400">
                            Total Denda
                        </div>

                        <div class="mt-1 text-xl font-bold text-orange-700 dark:text-orange-400">
                            Rp{{ number_format($totalDenda, 0, ',', '.') }}
                        </div>

                    </div>

                </div>

            </div>


           {{-- =========================
                TABEL REKAP
            ========================== --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">

                <div class="max-h-[65vh] overflow-auto">

                    <table class="w-full min-w-[1050px] border-collapse text-sm">

                        {{-- HEADER --}}
                        <thead class="sticky top-0 z-20">

                            <tr class="border-b-2 border-gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-800">

                                <th
                                    class="sticky left-0 z-30 w-14 border-r border-gray-300 bg-gray-100 px-3 py-3 text-center font-bold dark:border-gray-600 dark:bg-gray-800"
                                >
                                    No
                                </th>

                                <th
                                    class="sticky left-14 z-30 w-32 border-r border-gray-300 bg-gray-100 px-3 py-3 text-left font-bold dark:border-gray-600 dark:bg-gray-800"
                                >
                                    NIS
                                </th>

                                <th
                                    class="sticky left-[9.5rem] z-30 min-w-[240px] border-r border-gray-300 bg-gray-100 px-4 py-3 text-left font-bold dark:border-gray-600 dark:bg-gray-800"
                                >
                                    Nama Santri
                                </th>

                                <th class="w-20 border-r border-gray-300 px-3 py-3 text-center font-bold dark:border-gray-600">
                                    JK
                                </th>

                                <th class="w-24 border-r border-gray-300 px-3 py-3 text-center font-bold dark:border-gray-600">
                                    Hadir
                                </th>

                                <th class="w-24 border-r border-gray-300 px-3 py-3 text-center font-bold dark:border-gray-600">
                                    Sakit
                                </th>

                                <th class="w-24 border-r border-gray-300 px-3 py-3 text-center font-bold dark:border-gray-600">
                                    Izin
                                </th>

                                <th class="w-24 border-r border-gray-300 px-3 py-3 text-center font-bold dark:border-gray-600">
                                    Alpa
                                </th>

                                <th class="w-32 border-r border-gray-300 px-3 py-3 text-center font-bold dark:border-gray-600">
                                    Total Denda
                                </th>

                                <th class="w-28 px-3 py-3 text-center font-bold">
                                    WhatsApp
                                </th>

                            </tr>

                        </thead>


                        {{-- BODY --}}
                        <tbody>

                            @forelse ($santris as $no => $santri)

                                @php
                                    $jumlahAlpa = (int) ($rekap[$santri->id]['alpa'] ?? 0);
                                    $totalDendaSantri = $jumlahAlpa * 2000;
                                @endphp

                                <tr
                                    wire:key="santri-{{ $santri->id }}"
                                    class="group border-b border-gray-200 dark:border-gray-800"
                                >

                                    {{-- NO --}}
                                    <td
                                        class="sticky left-0 z-10 border-r border-gray-200 bg-white px-3 py-2.5 text-center text-gray-500 group-hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:group-hover:bg-gray-800"
                                    >
                                        {{ $no + 1 }}
                                    </td>


                                    {{-- NIS --}}
                                    <td
                                        class="sticky left-14 z-10 border-r border-gray-200 bg-white px-3 py-2.5 font-mono text-xs text-gray-600 group-hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:group-hover:bg-gray-800"
                                    >
                                        {{ $santri->nis }}
                                    </td>


                                    {{-- NAMA --}}
                                    <td
                                        class="sticky left-[9.5rem] z-10 border-r border-gray-200 bg-white px-4 py-2.5 font-semibold text-gray-900 group-hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white dark:group-hover:bg-gray-800"
                                    >
                                        {{ $santri->nama }}
                                    </td>


                                    {{-- JK --}}
                                    <td class="border-r border-gray-200 px-3 py-2.5 text-center dark:border-gray-800">

                                        @if ($santri->jenis_kelamin === 'L')

                                            <span class="inline-flex min-w-[32px] justify-center rounded-md bg-blue-100 px-2 py-1 text-xs font-bold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                                L
                                            </span>

                                        @else

                                            <span class="inline-flex min-w-[32px] justify-center rounded-md bg-pink-100 px-2 py-1 text-xs font-bold text-pink-700 dark:bg-pink-950 dark:text-pink-300">
                                                P
                                            </span>

                                        @endif

                                    </td>


                                    {{-- HADIR --}}
                                    <td class="border-r border-gray-200 px-3 py-2 text-center dark:border-gray-800">

                                        <input
                                            type="number"
                                            min="0"
                                            wire:model="rekap.{{ $santri->id }}.hadir"
                                            class="w-[70px] rounded-md border-gray-300 bg-white px-2 py-1.5 text-center text-sm font-semibold focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800"
                                        >

                                    </td>


                                    {{-- SAKIT --}}
                                    <td class="border-r border-gray-200 px-3 py-2 text-center dark:border-gray-800">

                                        <input
                                            type="number"
                                            min="0"
                                            wire:model="rekap.{{ $santri->id }}.sakit"
                                            class="w-[70px] rounded-md border-gray-300 bg-white px-2 py-1.5 text-center text-sm font-semibold focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800"
                                        >

                                    </td>


                                    {{-- IZIN --}}
                                    <td class="border-r border-gray-200 px-3 py-2 text-center dark:border-gray-800">

                                        <input
                                            type="number"
                                            min="0"
                                            wire:model="rekap.{{ $santri->id }}.izin"
                                            class="w-[70px] rounded-md border-gray-300 bg-white px-2 py-1.5 text-center text-sm font-semibold focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800"
                                        >

                                    </td>


                                    {{-- ALPA --}}
                                    <td class="border-r border-gray-200 px-3 py-2 text-center dark:border-gray-800">

                                        <input
                                            type="number"
                                            min="0"
                                            wire:model="rekap.{{ $santri->id }}.alpa"
                                            class="
                                                w-[70px]
                                                rounded-md
                                                border-gray-300
                                                px-2 py-1.5
                                                text-center
                                                text-sm
                                                font-semibold
                                                focus:border-primary-500
                                                focus:ring-primary-500
                                                dark:border-gray-600
                                                dark:bg-gray-800
                                                {{ $jumlahAlpa > 0
                                                    ? 'border-red-300 bg-red-50 text-red-700 dark:border-red-800 dark:bg-red-950/30 dark:text-red-400'
                                                    : ''
                                                }}
                                            "
                                        >

                                    </td>


                                    {{-- DENDA --}}
                                    <td class="border-r border-gray-200 px-3 py-2.5 text-center dark:border-gray-800">

                                        <span
                                            class="
                                                inline-flex min-w-[100px]
                                                justify-center rounded-md
                                                px-2.5 py-1.5
                                                text-xs font-bold
                                                {{ $totalDendaSantri > 0
                                                    ? 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-400'
                                                    : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400'
                                                }}
                                            "
                                        >
                                            Rp{{ number_format($totalDendaSantri, 0, ',', '.') }}
                                        </span>

                                    </td>


                                    {{-- WHATSAPP --}}
                                    <td class="px-3 py-2.5 text-center">

                                        <button
                                            type="button"
                                            wire:click="kirimWA({{ $santri->id }})"
                                            class="inline-flex items-center justify-center rounded-md bg-green-600 px-3 py-1.5 text-xs font-bold text-white shadow-sm transition hover:bg-green-700"
                                            title="Kirim rekap melalui WhatsApp"
                                        >
                                            🟢 WA
                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="10"
                                        class="px-4 py-10 text-center text-gray-500"
                                    >
                                        Belum ada data santri untuk filter yang dipilih.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

                {{-- =========================
                    FOOTER ACTION
                ========================== --}}
                @if ($santris->count())

                    <div class="flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:justify-end dark:border-gray-700 dark:bg-gray-800/50">

                        <button
                            type="button"
                            wire:click="simpanRekap"
                            class="fi-btn rounded-xl px-5 py-2.5 font-semibold"
                        >
                            💾 Simpan Rekap
                        </button>


                        <button
                            type="button"
                            wire:click="exportExcel"
                            class="fi-btn rounded-xl bg-green-600 px-5 py-2.5 font-semibold text-white shadow-sm transition hover:bg-green-700"
                        >
                            📊 Export Excel
                        </button>

                    </div>

                @endif

            </div>

        @else

            {{-- =========================
                BELUM PILIH KELAS
            ========================== --}}
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center dark:border-gray-700 dark:bg-gray-900">

                <div class="text-4xl">
                    📋
                </div>

                <h3 class="mt-3 font-semibold text-gray-900 dark:text-white">
                    Belum ada kelas yang dipilih
                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pilih kelas terlebih dahulu untuk melihat rekap absensi.
                </p>

            </div>

        @endif

    </div>

</x-filament-panels::page>