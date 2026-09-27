<x-filament-panels::page>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h2 class="text-2xl font-bold">
                Input Nilai Santri
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Pilih kelas, mata pelajaran, dan daur. Daftar santri akan muncul otomatis.
            </p>
        </div>


        {{-- FILTER --}}
        <div
            style="
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 20px;
                padding: 20px;
                border: 1px solid #374151;
                border-radius: 16px;
            "
        >

            {{-- KELAS --}}
            <div>

                <label
                    style="
                        display: block;
                        margin-bottom: 8px;
                        font-weight: 600;
                    "
                >
                    Kelas
                </label>

                <select
                    wire:model.live="kelas_id"
                    style="
                        width: 100%;
                        height: 44px;
                        padding: 0 12px;
                        border-radius: 8px;
                        border: 1px solid #4b5563;
                        background: #111827;
                        color: white;
                    "
                >

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    @foreach ($this->kelas as $kelas)
                        <option value="{{ $kelas->id }}">
                            {{ $kelas->nama }}
                        </option>
                    @endforeach

                </select>

            </div>


            {{-- MATA PELAJARAN --}}
            <div>

                <label
                    style="
                        display: block;
                        margin-bottom: 8px;
                        font-weight: 600;
                    "
                >
                    Mata Pelajaran
                </label>

                <select
                    wire:model.live="mata_pelajaran_id"
                    @disabled(!$kelas_id)
                    style="
                        width: 100%;
                        height: 44px;
                        padding: 0 12px;
                        border-radius: 8px;
                        border: 1px solid #4b5563;
                        background: #111827;
                        color: white;
                    "
                >

                    <option value="">
                        -- Pilih Mata Pelajaran --
                    </option>

                    @foreach ($this->mapels as $mapel)
                        <option value="{{ $mapel->id }}">
                            {{ $mapel->nama }}
                        </option>
                    @endforeach

                </select>

            </div>


            {{-- DAUR --}}
            <div>

                <label
                    style="
                        display: block;
                        margin-bottom: 8px;
                        font-weight: 600;
                    "
                >
                    Daur
                </label>

                <select
                    wire:model.live="daur"
                    @disabled(!$mata_pelajaran_id)
                    style="
                        width: 100%;
                        height: 44px;
                        padding: 0 12px;
                        border-radius: 8px;
                        border: 1px solid #4b5563;
                        background: #111827;
                        color: white;
                    "
                >

                    <option value="">
                        -- Pilih Daur --
                    </option>

                    @foreach ($this->daurOptions as $value => $label)
                        <option value="{{ $value }}">
                            {{ $label }}
                        </option>
                    @endforeach

                </select>

            </div>

        </div>


        {{-- DAFTAR SANTRI --}}
        @if ($kelas_id && $mata_pelajaran_id && $daur)

            <div
                style="
                    padding: 24px;
                    border: 1px solid #374151;
                    border-radius: 16px;
                "
            >

                <div style="margin-bottom: 20px;">

                    <h3
                        style="
                            font-size: 20px;
                            font-weight: 700;
                        "
                    >
                        Daftar Nilai
                    </h3>

                    <p
                        style="
                            margin-top: 5px;
                            font-size: 14px;
                            color: #9ca3af;
                        "
                    >
                        {{ count($santris) }} santri ditemukan.
                    </p>

                </div>


                @if (count($santris) > 0)

                    <div
                        style="
                            overflow-x: auto;
                            border: 1px solid #374151;
                            border-radius: 10px;
                        "
                    >

                        <table
                            style="
                                width: 100%;
                                border-collapse: collapse;
                            "
                        >

                            <thead>

                                <tr style="background: #111827;">

                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: left;
                                            width: 70px;
                                        "
                                    >
                                        No
                                    </th>

                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: left;
                                        "
                                    >
                                        NIS
                                    </th>

                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: left;
                                        "
                                    >
                                        Nama Santri
                                    </th>

                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: center;
                                            width: 180px;
                                        "
                                    >
                                        Nilai
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach ($santris as $index => $santri)

                                    <tr
                                        style="
                                            border-top: 1px solid #374151;
                                        "
                                    >

                                        <td
                                            style="
                                                padding: 10px 16px;
                                            "
                                        >
                                            {{ $index + 1 }}
                                        </td>

                                        <td
                                            style="
                                                padding: 10px 16px;
                                            "
                                        >
                                            {{ $santri['nis'] }}
                                        </td>

                                        <td
                                            style="
                                                padding: 10px 16px;
                                                font-weight: 600;
                                            "
                                        >
                                            {{ $santri['nama'] }}
                                        </td>

                                        <td
                                            style="
                                                padding: 10px 16px;
                                            "
                                        >

                                            <input
                                                type="number"
                                                min="0"
                                                max="100"
                                                wire:model="nilai.{{ $santri['id'] }}"
                                                style="
                                                    width: 100%;
                                                    height: 42px;
                                                    padding: 0 12px;
                                                    border-radius: 8px;
                                                    border: 1px solid #4b5563;
                                                    background: #111827;
                                                    color: white;
                                                    text-align: center;
                                                "
                                            >

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- SIMPAN --}}
                    <div
                        style="
                            display: flex;
                            justify-content: flex-end;
                            margin-top: 20px;
                        "
                    >

                        <button
                            type="button"
                            wire:click="simpan"
                            wire:loading.attr="disabled"
                            style="
                                padding: 10px 22px;
                                border-radius: 8px;
                                font-weight: 600;
                                background: #16a34a;
                                color: white;
                            "
                        >

                            <span
                                wire:loading.remove
                                wire:target="simpan"
                            >
                                Simpan Semua Nilai
                            </span>

                            <span
                                wire:loading
                                wire:target="simpan"
                            >
                                Menyimpan...
                            </span>

                        </button>

                    </div>

                @else

                    <div
                        style="
                            padding: 30px;
                            text-align: center;
                            color: #9ca3af;
                        "
                    >
                        Tidak ada santri aktif di kelas ini.
                    </div>

                @endif

            </div>

        @endif

    </div>

</x-filament-panels::page>