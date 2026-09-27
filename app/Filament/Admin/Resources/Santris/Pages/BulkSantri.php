<?php

namespace App\Filament\Admin\Resources\Santris\Pages;

use App\Filament\Admin\Resources\Santris\SantriResource;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\TahunAjaran;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class BulkSantri extends Page
{
    use WithFileUploads;

    protected static string $resource = SantriResource::class;

    protected string $view = 'filament.admin.resources.santris.pages.bulk-santri';

    public ?int $kelas_id = null;

    public ?int $tahun_ajaran_id = null;

    public string $nama = '';

    public string $nis = '';

    public string $jenis_kelamin = '';

    public string $tempat_lahir = '';

    public string $tanggal_lahir = '';

    public string $nama_ayah = '';

    public string $nama_ibu = '';

    public string $no_hp_wali = '';

    public string $alamat = '';

    public array $fotoFiles = [];

    public Collection $kelas;

    public Collection $tahunAjaran;

    public array $rows = [];


    public function mount(): void
    {
        $this->kelas = Kelas::orderBy('nama')->get();

        $this->tahunAjaran = TahunAjaran::orderBy('nama')->get();
    }


    public function prosesPaste(): void
    {
        $this->rows = [];

        $nama = $this->pecahKolom($this->nama);
        $nis = $this->pecahKolom($this->nis);
        $jk = $this->pecahKolom($this->jenis_kelamin);
        $tempat = $this->pecahKolom($this->tempat_lahir);
        $tanggal = $this->pecahKolom($this->tanggal_lahir);
        $ayah = $this->pecahKolom($this->nama_ayah);
        $ibu = $this->pecahKolom($this->nama_ibu);
        $wali = $this->pecahKolom($this->no_hp_wali);
        $alamat = $this->pecahKolom($this->alamat);

        $jumlah = max(
            count($nama),
            count($nis),
            count($jk),
            count($tempat),
            count($tanggal),
            count($ayah),
            count($ibu),
            count($wali),
            count($alamat)
        );

        for ($i = 0; $i < $jumlah; $i++) {

            $this->rows[] = [
                'nis' => trim($nis[$i] ?? ''),
                'nama' => trim($nama[$i] ?? ''),
                'jenis_kelamin' => $this->normalisasiJK($jk[$i] ?? ''),
                'tempat_lahir' => trim($tempat[$i] ?? ''),
                'tanggal_lahir' => trim($tanggal[$i] ?? ''),
                'nama_ayah' => trim($ayah[$i] ?? ''),
                'nama_ibu' => trim($ibu[$i] ?? ''),
                'no_hp_wali' => trim($wali[$i] ?? ''),
                'alamat' => trim($alamat[$i] ?? ''),
            ];
        }

        // Buang baris yang benar-benar kosong
        $this->rows = array_values(
            array_filter($this->rows, function ($row) {
                return $row['nama'] !== ''
                    || $row['nis'] !== ''
                    || $row['jenis_kelamin'] !== '';
            })
        );
    }


    private function pecahKolom(string $data): array
    {
        if (trim($data) === '') {
            return [];
        }

        return preg_split(
            '/\r\n|\r|\n/',
            trim($data)
        );
    }


    private function normalisasiJK(string $jk): string
    {
        $jk = strtoupper(trim($jk));

        return match ($jk) {
            'L',
            'LAKI',
            'LAKI-LAKI',
            'LAKI LAKI',
            'PUTRA' => 'L',

            'P',
            'PEREMPUAN',
            'WANITA',
            'PUTRI' => 'P',

            default => '',
        };
    }


    /**
     * Normalisasi nama untuk pencocokan foto.
     *
     * Contoh:
     * "ALWI" = "alwi"
     * "Alwi.jpg" = "alwi"
     * "Cahya_Mujahhida.png" = "cahya mujahhida"
     */
    private function normalisasiNamaFoto(string $nama): string
    {
        $nama = pathinfo($nama, PATHINFO_FILENAME);

        $nama = Str::lower($nama);

        // "_" dan "-" dianggap sebagai spasi
        $nama = str_replace(['_', '-'], ' ', $nama);

        // Hilangkan karakter aneh
        $nama = preg_replace('/[^a-z0-9\s]/u', '', $nama);

        // Rapikan spasi
        $nama = preg_replace('/\s+/', ' ', $nama);

        return trim($nama);
    }


    public function simpan(): void
    {
        if (!$this->kelas_id || !$this->tahun_ajaran_id) {

            Notification::make()
                ->title('Kelas dan Tahun Ajaran wajib dipilih')
                ->danger()
                ->send();

            return;
        }


        if (empty($this->rows)) {

            Notification::make()
                ->title('Belum ada data')
                ->body('Silakan paste data santri terlebih dahulu.')
                ->warning()
                ->send();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SIAPKAN FOTO BERDASARKAN NAMA FILE
        |--------------------------------------------------------------------------
        */

        $fotoByNama = [];
        $fotoBermasalah = [];


        foreach ($this->fotoFiles as $foto) {

            $namaFile = $foto->getClientOriginalName();

            $namaNormal = $this->normalisasiNamaFoto($namaFile);


            if ($namaNormal === '') {

                $fotoBermasalah[] = $namaFile;

                continue;
            }


            // Jika ada dua foto dengan nama yang sama
            if (isset($fotoByNama[$namaNormal])) {

                $fotoBermasalah[] = $namaFile;

                continue;
            }


            $fotoByNama[$namaNormal] = $foto;
        }


        /*
        |--------------------------------------------------------------------------
        | CEK FOTO YANG TIDAK PUNYA SANTRI
        |--------------------------------------------------------------------------
        */

        $namaSantri = [];

        foreach ($this->rows as $row) {

            if (!empty($row['nama'])) {

                $namaNormal = $this->normalisasiNamaFoto(
                    $row['nama']
                );

                $namaSantri[$namaNormal] = $row['nama'];
            }
        }


        $fotoTidakCocok = [];


        foreach ($fotoByNama as $namaFoto => $foto) {

            if (!isset($namaSantri[$namaFoto])) {

                $fotoTidakCocok[] = $foto->getClientOriginalName();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA ADA FOTO TIDAK COCOK
        |--------------------------------------------------------------------------
        */

        if (!empty($fotoTidakCocok)) {

            Notification::make()
                ->title('Ada foto yang tidak cocok')
                ->body(
                    'Nama file berikut tidak ditemukan pada data santri: '
                    . implode(', ', $fotoTidakCocok)
                )
                ->danger()
                ->send();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA SANTRI
        |--------------------------------------------------------------------------
        */

        $berhasil = 0;

        $dilewati = 0;

        $tanpaFoto = 0;


        foreach ($this->rows as $row) {

            if (
                empty($row['nis']) ||
                empty($row['nama']) ||
                !in_array($row['jenis_kelamin'], ['L', 'P'])
            ) {

                $dilewati++;

                continue;
            }


            if (Santri::where('nis', $row['nis'])->exists()) {

                $dilewati++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CARI FOTO BERDASARKAN NAMA SANTRI
            |--------------------------------------------------------------------------
            */

            $namaNormal = $this->normalisasiNamaFoto(
                $row['nama']
            );


            $foto = null;


            if (isset($fotoByNama[$namaNormal])) {

                $fileFoto = $fotoByNama[$namaNormal];


                $foto = $fileFoto->store(
                    'santri',
                    'public'
                );

            } else {

                $tanpaFoto++;
            }


            /*
            |--------------------------------------------------------------------------
            | CREATE SANTRI
            |--------------------------------------------------------------------------
            */

            Santri::create([

                'nis' => $row['nis'],

                'nama' => $row['nama'],

                'jenis_kelamin' => $row['jenis_kelamin'],

                'tempat_lahir' => $row['tempat_lahir'] ?: null,

                'tanggal_lahir' => $row['tanggal_lahir'] ?: null,

                'alamat' => $row['alamat'] ?: null,

                'nama_ayah' => $row['nama_ayah'] ?: null,

                'nama_ibu' => $row['nama_ibu'] ?: null,

                'no_hp_wali' => $row['no_hp_wali'] ?: null,

                'kelas_id' => $this->kelas_id,

                'tahun_ajaran_id' => $this->tahun_ajaran_id,

                'status' => 'Aktif',

                'foto' => $foto,

            ]);


            $berhasil++;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION
        |--------------------------------------------------------------------------
        */

        Notification::make()
            ->title('Import santri selesai')
            ->body(
                "Berhasil: {$berhasil} santri. "
                . "Dilewati: {$dilewati} data. "
                . "Tanpa foto: {$tanpaFoto} santri."
            )
            ->success()
            ->send();


        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        if ($berhasil > 0) {

            $this->reset([

                'nama',
                'nis',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'nama_ayah',
                'nama_ibu',
                'no_hp_wali',
                'alamat',
                'fotoFiles',

            ]);


            $this->rows = [];
        }
    }
}