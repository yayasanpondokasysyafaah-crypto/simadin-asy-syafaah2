<?php

namespace App\Exports;

use App\Models\RekapAbsensi as RekapAbsensiModel;
use App\Models\Santri;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapAbsensiExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    public function __construct(
        protected string $bulan,
        protected int $kelas_id,
        protected string $jenis,
        protected string $kegiatan = 'Semua',
        protected ?string $jk = null,
    ) {
    }


    public function startCell(): string
    {
        return 'A4';
    }


    public function collection(): Collection
    {
        $santris = Santri::where('kelas_id', $this->kelas_id)
            ->when(
                $this->jk ?? null,
                fn ($query) => $query->where('jenis_kelamin', $this->jk)
            )
            ->orderBy('nama')
            ->get();


        return $santris->map(function ($santri, $index) {

            $data = RekapAbsensiModel::where('santri_id', $santri->id)
                ->where('bulan', $this->bulan)
                ->where('jenis', $this->jenis)
                ->when(
                    $this->jenis === 'Madin' && $this->kegiatan !== 'Semua',
                    fn ($query) => $query->where('kegiatan', $this->kegiatan)
                )
                ->first();


            $hadir = $data?->hadir ?? 0;
            $sakit = $data?->sakit ?? 0;
            $izin = $data?->izin ?? 0;
            $alpa = $data?->alpa ?? 0;

            $totalDenda = $alpa * 2000;


            return [
                'No' => $index + 1,
                'NIS' => $santri->nis,
                'Nama Santri' => $santri->nama,
                'JK' => $santri->jenis_kelamin,
                'Hadir' => $hadir,
                'Sakit' => $sakit,
                'Izin' => $izin,
                'Alpa' => $alpa,
                'Total Denda' => $totalDenda,
            ];
        });
    }


    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Santri',
            'JK',
            'Hadir',
            'Sakit',
            'Izin',
            'Alpa',
            'Total Denda',
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $bulanIndonesia = [
                    '01' => 'Januari',
                    '02' => 'Februari',
                    '03' => 'Maret',
                    '04' => 'April',
                    '05' => 'Mei',
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember',
                ];

                $tahun = substr($this->bulan, 0, 4);
                $nomorBulan = substr($this->bulan, 5, 2);

                $namaBulan = $bulanIndonesia[$nomorBulan] ?? $nomorBulan;

                $event->sheet->setCellValue(
                    'A1',
                    'REKAP ABSENSI SANTRI'
                );

                $event->sheet->setCellValue(
                    'A2',
                    'Bulan: ' . $namaBulan . ' ' . $tahun
                );

                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');

                $event->sheet->getStyle('A1:I1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14);

                $event->sheet->getStyle('A2:I2')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(11);
            },
        ];
    }
}