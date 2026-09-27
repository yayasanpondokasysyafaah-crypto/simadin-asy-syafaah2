<?php

namespace App\Filament\Admin\Pages;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\NilaiHafalan;
use App\Models\Santri;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanNilai extends Page
{
    protected string $view = 'filament.admin.pages.laporan-nilai';

    public ?int $kelas_id = null;

    public ?string $jenis_kelamin = 'Semua';

    public ?string $daur = null;

    public array $daurOptions = [
        'Awwal' => 'Daur Awwal',
        'Tsani' => 'Daur Tsani',
        'Tsalis' => 'Daur Tsalis',
    ];

    public array $jenisKelaminOptions = [
        'Semua' => 'Semua',
        'L' => 'Putra',
        'P' => 'Putri',
    ];

    #[Computed]
        public function kelas()
        {
            return Kelas::select('id', 'nama')
                ->groupBy('nama')
                ->orderBy('nama')
                ->get();
        }

    /**
     * Semua mata pelajaran yang terdaftar
     * pada kelas yang dipilih.
     */
   #[Computed]
    public function mapels()
    {
        if (! $this->kelas_id) {
            return collect();
        }

        return MataPelajaran::whereHas('kelasMapels', function ($query) {
            $query->where('kelas_id', $this->kelas_id);
        })
            ->select('id', 'nama')
            ->groupBy('nama')
            ->orderBy('nama')
            ->get();
    }

    /**
     * Daftar santri berdasarkan kelas + jenis kelamin.
     */
    #[Computed]
    public function santris()
    {
        if (! $this->kelas_id || ! $this->daur) {
            return collect();
        }

        $query = Santri::where('kelas_id', $this->kelas_id)
            ->where('status', 'Aktif');

        if ($this->jenis_kelamin !== 'Semua') {
            $query->where('jenis_kelamin', $this->jenis_kelamin);
        }

        return $query
            ->orderBy('nama')
            ->get();
    }

    /**
     * Data laporan lengkap.
     *
     * Setiap santri menjadi satu baris.
     * Setiap mata pelajaran menjadi satu kolom.
     */
    #[Computed]
    public function laporan()
    {
        if (
            ! $this->kelas_id ||
            ! $this->daur
        ) {
            return collect();
        }

        $santris = $this->santris;
        $mapels = $this->mapels;

        if ($santris->isEmpty()) {
            return collect();
        }

        /*
         * Ambil semua nilai sekaligus agar tidak query
         * berulang-ulang untuk setiap santri.
         */
        $nilais = Nilai::where('kelas_id', $this->kelas_id)
            ->where('daur', $this->daur)
            ->whereIn('santri_id', $santris->pluck('id'))
            ->get()
            ->groupBy('santri_id');

        $nilaiHafalans = NilaiHafalan::whereIn('santri_id', $santris->pluck('id'))
            ->where('daur', $this->daur)
            ->get()
            ->groupBy('santri_id');

        $hasil = collect();

        foreach ($santris as $santri) {

            $nilaiSantri = $nilais->get($santri->id, collect());

            $row = [
                'id' => $santri->id,
                'nis' => $santri->nis,
                'nama' => $santri->nama,
                'kelas' => $santri->kelas?->nama ?? '',
            ];

            $jumlah = 0;

            foreach ($mapels as $mapel) {

                $nilai = $nilaiSantri
                    ->firstWhere('mata_pelajaran_id', $mapel->id);

                /*
                 * Kalau nilai belum diinput,
                 * otomatis dianggap 0.
                 */
                $angka = $nilai?->nilai ?? 0;

                $row['mapel_' . $mapel->id] = $angka;

                $jumlah += $angka;
            }

            /*
             * Hafalan sementara 0.
             *
             * Nanti kita sambungkan dengan modul
             * Nilai Hafalan yang akan kita buat.
             */
        $nilaiHafalanSantri = $nilaiHafalans->get($santri->id, collect());

            $row['hafalan'] = $nilaiHafalanSantri->isNotEmpty()
                ? round($nilaiHafalanSantri->avg('nilai'), 2)
                : 0;

            $jumlah += $row['hafalan'];

            $row['jumlah'] = $jumlah;

            $hasil->push($row);
        }

        /*
         * Peringkat berdasarkan JUMLAH.
         * Nilai terbesar = peringkat 1.
         */
        $hasil = $hasil
            ->sortByDesc('jumlah')
            ->values();

        $peringkat = 0;
        $jumlahSebelumnya = null;

        $hasil = $hasil->map(function ($row, $index) use (&$peringkat, &$jumlahSebelumnya) {

            if ($jumlahSebelumnya !== $row['jumlah']) {
                $peringkat = $index + 1;
                $jumlahSebelumnya = $row['jumlah'];
            }

            $row['peringkat'] = $peringkat;

            return $row;
        });

        return $hasil;
    }

    public function updatedKelasId(): void
    {
        $this->daur = null;
        $this->jenis_kelamin = 'Semua';
    }

    public function updatedJenisKelamin(): void
    {
        //
    }

    public function updatedDaur(): void
    {
        //
    }

    public function exportExcel(): StreamedResponse
    {
    $laporan = $this->laporan;
    $mapels = $this->mapels;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $kolom = 1;

    $sheet->setCellValueByColumnAndRow($kolom++, 1, 'NIS');
    $sheet->setCellValueByColumnAndRow($kolom++, 1, 'Nama');
    $sheet->setCellValueByColumnAndRow($kolom++, 1, 'Kelas');

    foreach ($mapels as $mapel) {
        $sheet->setCellValueByColumnAndRow($kolom++, 1, $mapel->nama);
    }

    $sheet->setCellValueByColumnAndRow($kolom++, 1, 'Hafalan');
    $sheet->setCellValueByColumnAndRow($kolom++, 1, 'Jumlah');
    $sheet->setCellValueByColumnAndRow($kolom++, 1, 'Peringkat');

    $baris = 2;

    foreach ($laporan as $row) {

        $kolom = 1;

        $sheet->setCellValueByColumnAndRow($kolom++, $baris, $row['nis']);
        $sheet->setCellValueByColumnAndRow($kolom++, $baris, $row['nama']);
        $sheet->setCellValueByColumnAndRow($kolom++, $baris, $row['kelas']);

        foreach ($mapels as $mapel) {
            $sheet->setCellValueByColumnAndRow(
                $kolom++,
                $baris,
                $row['mapel_' . $mapel->id] ?? 0
            );
        }

        $sheet->setCellValueByColumnAndRow(
            $kolom++,
            $baris,
            $row['hafalan']
        );

        $sheet->setCellValueByColumnAndRow(
            $kolom++,
            $baris,
            $row['jumlah']
        );

        $sheet->setCellValueByColumnAndRow(
            $kolom++,
            $baris,
            $row['peringkat']
        );

        $baris++;
    }

    $sheet->freezePane('A2');

    foreach (range(1, $kolom - 1) as $column) {
        $sheet->getColumnDimensionByColumn($column)->setAutoSize(true);
    }

    $namaKelas = Kelas::find($this->kelas_id)?->nama ?? 'kelas';
    $namaDaur = $this->daur ?? 'daur';

    $filename = 'Laporan_Nilai_Kelas_' . $namaKelas . '_' . $namaDaur . '.xlsx';

    return response()->streamDownload(
        function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        },
        $filename
    );
    }
}