<?php

namespace App\Exports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SantriExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Santri::with(['kelas', 'tahunAjaran'])
            ->orderBy('nama')
            ->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'NIS',
            'NAMA SANTRI',
            'JENIS KELAMIN',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'KELAS',
            'TAHUN AJARAN',
            'NAMA AYAH',
            'NAMA IBU',
            'NOMOR WALI',
            'ALAMAT',
            'STATUS',
        ];
    }

    public function map($santri): array
    {
        return [
            $santri->id,
            $santri->nis,
            $santri->nama,
            $santri->jenis_kelamin,
            $santri->tempat_lahir,
            $santri->tanggal_lahir?->format('d/m/Y'),
            $santri->kelas?->nama,
            $santri->tahunAjaran?->nama,
            $santri->nama_ayah,
            $santri->nama_ibu,
            $santri->no_hp_wali,
            $santri->alamat,
            $santri->status,
        ];
    }
}