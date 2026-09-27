<x-filament-panels::page>

    <div class="space-y-6">

        {{-- JUDUL --}}
        <div>
            <h2 class="text-2xl font-bold">
                Import Banyak Santri
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Paste data dari LibreOffice Calc ke kolom yang sesuai.
                Setiap baris dianggap sebagai satu santri.
            </p>
        </div>


        {{-- KELAS + TAHUN AJARAN --}}
        <div
            style="
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
                padding: 20px;
                border: 1px solid #374151;
                border-radius: 16px;
            "
        >

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
                    wire:model="kelas_id"
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

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div>
                <label
                    style="
                        display: block;
                        margin-bottom: 8px;
                        font-weight: 600;
                    "
                >
                    Tahun Ajaran
                </label>

                <select
                    wire:model="tahun_ajaran_id"
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
                        -- Pilih Tahun Ajaran --
                    </option>

                    @foreach ($tahunAjaran as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- FOTO SANTRI --}}
        {{-- FOTO SANTRI --}}
<div class="rounded-xl border p-4">

    <div class="font-semibold">
        Foto Santri
    </div>

    <p class="mt-1 text-sm text-gray-500">
        Foto tidak wajib. Jika ada foto, nama file harus sama dengan nama santri.
        Contoh: <b>ALWI.jpg</b>, <b>CAHYA MUJAHHIDA.png</b>.
    </p>

    <input
        type="file"
        wire:model="fotoFiles"
        multiple
        accept="image/*"
        class="fi-input mt-3 w-full"
    >

    <div
        wire:loading
        wire:target="fotoFiles"
        class="mt-2 text-sm text-gray-500"
    >
        Mengupload foto...
    </div>


    @if (count($fotoFiles) > 0)

        <div class="mt-3 rounded-lg bg-green-50 p-3 text-sm text-green-700">

            <div class="font-semibold">
                {{ count($fotoFiles) }} foto dipilih.
            </div>

            <div class="mt-2 space-y-1">

                @foreach ($fotoFiles as $foto)

                    <div>
                        📷 {{ $foto->getClientOriginalName() }}
                    </div>

                @endforeach

            </div>

        </div>

    @else

        <div class="mt-3 rounded-lg bg-gray-50 p-3 text-sm text-gray-500">
            Tidak ada foto yang dipilih. Import tetap bisa dilakukan.
        </div>

    @endif

</div>


        {{-- DATA SANTRI --}}
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
                    Data Santri
                </h3>

                <p
                    style="
                        margin-top: 5px;
                        font-size: 14px;
                        color: #9ca3af;
                    "
                >
                    Copy satu kolom penuh dari Calc, lalu paste ke kotak
                    yang sesuai. Urutan kolom di Calc tidak penting.
                </p>

            </div>


            {{-- GRID INPUT --}}
            <div
                style="
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 20px;
                "
            >

                {{-- NAMA --}}
                <div>

                    <label
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Nama Santri
                    </label>

                    <textarea
                        wire:model="nama"
                        rows="10"
                        placeholder="Paste kolom Nama Santri..."
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

                </div>


                {{-- NIS --}}
                <div>

                    <label
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        NIS
                    </label>

                    <textarea
                        wire:model="nis"
                        rows="10"
                        placeholder="Paste kolom NIS..."
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

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

                    <textarea
                        wire:model="jenis_kelamin"
                        rows="10"
                        placeholder="L
P
L
P"
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

                </div>


                {{-- TEMPAT LAHIR --}}
                <div>

                    <label
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Tempat Lahir
                    </label>

                    <textarea
                        wire:model="tempat_lahir"
                        rows="10"
                        placeholder="Paste kolom Tempat Lahir..."
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

                </div>


                {{-- TANGGAL LAHIR --}}
                <div>

                    <label
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Tanggal Lahir
                    </label>

                    <textarea
                        wire:model="tanggal_lahir"
                        rows="10"
                        placeholder="Paste kolom Tanggal Lahir..."
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

                </div>


                {{-- NAMA AYAH --}}
                <div>

                    <label
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Nama Ayah
                    </label>

                    <textarea
                        wire:model="nama_ayah"
                        rows="10"
                        placeholder="Paste kolom Nama Ayah..."
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

                </div>


                {{-- NAMA IBU --}}
                <div>

                    <label
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Nama Ibu
                    </label>

                    <textarea
                        wire:model="nama_ibu"
                        rows="10"
                        placeholder="Paste kolom Nama Ibu..."
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

                </div>


                {{-- NOMOR WALI --}}
                <div>

                    <label
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Nomor Wali
                    </label>

                    <textarea
                        wire:model="no_hp_wali"
                        rows="10"
                        placeholder="Paste kolom Nomor Wali..."
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

                </div>


                {{-- ALAMAT --}}
                <div>

                    <label
                        style="
                            display: block;
                            margin-bottom: 8px;
                            font-weight: 600;
                        "
                    >
                        Alamat
                    </label>

                    <textarea
                        wire:model="alamat"
                        rows="10"
                        placeholder="Paste kolom Alamat..."
                        style="
                            display: block;
                            width: 100%;
                            min-height: 230px;
                            resize: vertical;
                            padding: 12px;
                            border-radius: 8px;
                            border: 1px solid #4b5563;
                            background: #111827;
                            color: white;
                            font-size: 14px;
                            line-height: 1.6;
                        "
                    ></textarea>

                </div>

            </div>


            {{-- TOMBOL PREVIEW --}}
            <div
                style="
                    display: flex;
                    justify-content: flex-end;
                    margin-top: 24px;
                "
            >

                <button
                    type="button"
                    wire:click="prosesPaste"
                    wire:loading.attr="disabled"
                    style="
                        padding: 10px 20px;
                        border-radius: 8px;
                        font-weight: 600;
                        background: #2563eb;
                        color: white;
                    "
                >

                    <span wire:loading.remove wire:target="prosesPaste">
                        Tampilkan Preview
                    </span>

                    <span wire:loading wire:target="prosesPaste">
                        Memproses...
                    </span>

                </button>

            </div>

        </div>


        {{-- PREVIEW --}}
        @if (count($rows) > 0)

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
                        Preview Data
                    </h3>

                    <p
                        style="
                            margin-top: 5px;
                            color: #9ca3af;
                            font-size: 14px;
                        "
                    >
                        {{ count($rows) }} baris ditemukan.
                    </p>

                </div>


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

                                <th style="padding: 12px 16px; text-align: left;">
                                    No
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    Nama
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    NIS
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    JK
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    Tempat Lahir
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    Tanggal Lahir
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    Nama Ayah
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    Nama Ibu
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    Nomor Wali
                                </th>

                                <th style="padding: 12px 16px; text-align: left;">
                                    Alamat
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($rows as $index => $row)

                                <tr>

                                    <td style="padding: 10px 16px;">
                                        {{ $index + 1 }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['nama'] }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['nis'] }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['jenis_kelamin'] }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['tempat_lahir'] }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['tanggal_lahir'] }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['nama_ayah'] }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['nama_ibu'] }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['no_hp_wali'] }}
                                    </td>

                                    <td style="padding: 10px 16px;">
                                        {{ $row['alamat'] }}
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
                            padding: 10px 20px;
                            border-radius: 8px;
                            font-weight: 600;
                            background: #16a34a;
                            color: white;
                        "
                    >

                        <span wire:loading.remove wire:target="simpan">
                            Simpan Semua
                        </span>

                        <span wire:loading wire:target="simpan">
                            Menyimpan...
                        </span>

                    </button>

                </div>

            </div>

        @endif

    </div>

</x-filament-panels::page>