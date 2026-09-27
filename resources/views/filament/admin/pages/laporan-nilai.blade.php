<x-filament-panels::page>

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h2 class="text-2xl font-bold">
                Laporan Nilai
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Rekap nilai santri berdasarkan kelas, jenis kelamin, dan daur.
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

                    @foreach ($this->kelas as $item)

                        <option value="{{ $item->id }}">
                            {{ $item->nama }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- JENIS KELAMIN --}}
            <div>

                <label
                    style="
                        display: block;
                        margin-bottom: 8px;
                        font-weight: 600;
                    "
                >
                    Jenis Kelamin
                </label>

                <select
                    wire:model.live="jenis_kelamin"
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

                    @foreach ($jenisKelaminOptions as $value => $label)

                        <option value="{{ $value }}">
                            {{ $label }}
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
                        -- Pilih Daur --
                    </option>

                    @foreach ($daurOptions as $value => $label)

                        <option value="{{ $value }}">
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        {{-- HASIL LAPORAN --}}
        @if ($kelas_id && $daur)

            <div
                style="
                    padding: 24px;
                    border: 1px solid #374151;
                    border-radius: 16px;
                "
            >

                {{-- HEADER HASIL --}}
                <div
                    style="
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 20px;
                    "
                >

                    <div>

                        <h3
                            style="
                                font-size: 20px;
                                font-weight: 700;
                            "
                        >
                            Rekap Nilai
                        </h3>

                        <p
                            style="
                                margin-top: 5px;
                                font-size: 14px;
                                color: #9ca3af;
                            "
                        >
                            {{ count($this->laporan) }} santri ditemukan.
                        </p>

                    </div>

                </div>


                @if ($this->laporan->count() > 0)

                    {{-- TABLE --}}
                    <div
                        style="
                            overflow-x: auto;
                            border: 1px solid #374151;
                            border-radius: 10px;
                        "
                    >

                        <table
                            style="
                                width: max-content;
                                min-width: 100%;
                                border-collapse: collapse;
                            "
                        >

                            <thead>

                                <tr style="background: #111827;">

                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: center;
                                            position: sticky;
                                            left: 0;
                                            background: #111827;
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
                                            min-width: 220px;
                                        "
                                    >
                                        Nama
                                    </th>

                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: center;
                                        "
                                    >
                                        Kelas
                                    </th>


                                    {{-- SEMUA MAPEL --}}
                                    @foreach ($this->mapels as $mapel)

                                        <th
                                            style="
                                                padding: 12px 16px;
                                                text-align: center;
                                                min-width: 140px;
                                            "
                                        >
                                            {{ $mapel->nama }}
                                        </th>

                                    @endforeach


                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: center;
                                            min-width: 100px;
                                        "
                                    >
                                        Hafalan
                                    </th>

                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: center;
                                            min-width: 100px;
                                        "
                                    >
                                        Jumlah
                                    </th>

                                    <th
                                        style="
                                            padding: 12px 16px;
                                            text-align: center;
                                            min-width: 100px;
                                        "
                                    >
                                        Peringkat
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach ($this->laporan as $index => $row)

                                    <tr
                                        style="
                                            border-top: 1px solid #374151;
                                        "
                                    >

                                        <td
                                            style="
                                                padding: 10px 16px;
                                                text-align: center;
                                            "
                                        >
                                            {{ $index + 1 }}
                                        </td>


                                        <td
                                            style="
                                                padding: 10px 16px;
                                            "
                                        >
                                            {{ $row['nis'] }}
                                        </td>


                                        <td
                                            style="
                                                padding: 10px 16px;
                                                font-weight: 600;
                                            "
                                        >
                                            {{ $row['nama'] }}
                                        </td>


                                        <td
                                            style="
                                                padding: 10px 16px;
                                                text-align: center;
                                            "
                                        >
                                            {{ $row['kelas'] }}
                                        </td>


                                        {{-- NILAI MAPEL --}}
                                        @foreach ($this->mapels as $mapel)

                                            <td
                                                style="
                                                    padding: 10px 16px;
                                                    text-align: center;
                                                "
                                            >
                                                {{ $row['mapel_' . $mapel->id] ?? 0 }}
                                            </td>

                                        @endforeach


                                        {{-- HAFALAN --}}
                                        <td
                                            style="
                                                padding: 10px 16px;
                                                text-align: center;
                                            "
                                        >
                                            {{ $row['hafalan'] }}
                                        </td>


                                        {{-- JUMLAH --}}
                                        <td
                                            style="
                                                padding: 10px 16px;
                                                text-align: center;
                                                font-weight: 700;
                                            "
                                        >
                                            {{ $row['jumlah'] }}
                                        </td>


                                        {{-- PERINGKAT --}}
                                        <td
                                            style="
                                                padding: 10px 16px;
                                                text-align: center;
                                                font-weight: 700;
                                            "
                                        >
                                            {{ $row['peringkat'] }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- EXPORT --}}
                    <div
                        style="
                            display: flex;
                            justify-content: flex-end;
                            margin-top: 20px;
                        "
                    >

                        <button
                            type="button"
                            wire:click="exportExcel"
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
                                wire:target="exportExcel"
                            >
                                Export Excel
                            </span>

                            <span
                                wire:loading
                                wire:target="exportExcel"
                            >
                                Mengekspor...
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
                        Tidak ada santri aktif pada pilihan tersebut.
                    </div>

                @endif

            </div>

        @endif

    </div>

</x-filament-panels::page>