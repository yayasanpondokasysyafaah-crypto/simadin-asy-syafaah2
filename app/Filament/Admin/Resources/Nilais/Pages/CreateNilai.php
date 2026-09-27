<?php

namespace App\Filament\Admin\Resources\Nilais\Pages;

use App\Filament\Admin\Resources\Nilais\NilaiResource;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Nilai;
use App\Models\Santri;
use App\Models\TahunAjaran;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class CreateNilai extends Page
{
    protected static string $resource = NilaiResource::class;

    protected string $view = 'filament.admin.resources.nilais.pages.create-nilai';

    public ?int $kelas_id = null;

    public ?int $mata_pelajaran_id = null;

    public ?int $tahun_ajaran_id = null;

    public string $daur = '';

    public array $nilai = [];

    public array $santris = [];

    public function mount(): void
    {
        $tahunAktif = TahunAjaran::where('aktif', true)->first();

        if ($tahunAktif) {
            $this->tahun_ajaran_id = $tahunAktif->id;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DATA DROPDOWN KELAS
    |--------------------------------------------------------------------------
    */

    public function getKelasProperty()
    {
        return Kelas::orderBy('nama')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | DATA DROPDOWN MAPEL
    |--------------------------------------------------------------------------
    |
    | Hanya mengambil mata pelajaran yang terdaftar
    | pada kelas_mapels untuk kelas yang dipilih.
    |
    */

    public function getMapelsProperty()
    {
        if (!$this->kelas_id) {
            return collect();
        }

        return KelasMapel::where('kelas_id', $this->kelas_id)
            ->with('mataPelajaran')
            ->get()
            ->pluck('mataPelajaran')
            ->filter();
    }

    /*
    |--------------------------------------------------------------------------
    | DAUR
    |--------------------------------------------------------------------------
    */

    public function getDaurOptionsProperty(): array
    {
        return [
            'Awwal' => 'Daur Awwal',
            'Tsani' => 'Daur Tsani',
            'Tsalis' => 'Daur Tsalis',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SAAT KELAS BERUBAH
    |--------------------------------------------------------------------------
    */

    public function updatedKelasId(): void
    {
        $this->mata_pelajaran_id = null;
        $this->daur = '';
        $this->nilai = [];
        $this->santris = [];
    }

    /*
    |--------------------------------------------------------------------------
    | SAAT MAPEL BERUBAH
    |--------------------------------------------------------------------------
    */

    public function updatedMataPelajaranId(): void
    {
        $this->daur = '';
        $this->nilai = [];
        $this->santris = [];
    }

    /*
    |--------------------------------------------------------------------------
    | SAAT DAUR BERUBAH
    |--------------------------------------------------------------------------
    */

    public function updatedDaur(): void
    {
        $this->loadSantris();
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD SANTRI
    |--------------------------------------------------------------------------
    */

    private function loadSantris(): void
    {
        $this->santris = [];

        if (
            !$this->kelas_id ||
            !$this->mata_pelajaran_id ||
            !$this->daur
        ) {
            return;
        }

        $santris = Santri::where('kelas_id', $this->kelas_id)
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        foreach ($santris as $santri) {

            $nilaiLama = Nilai::where('santri_id', $santri->id)
                ->where('kelas_id', $this->kelas_id)
                ->where('mata_pelajaran_id', $this->mata_pelajaran_id)
                ->where('tahun_ajaran_id', $this->tahun_ajaran_id)
                ->where('semester', 1)
                ->where('daur', $this->daur)
                ->value('nilai');

            $this->santris[] = [
                'id' => $santri->id,
                'nis' => $santri->nis,
                'nama' => $santri->nama,
            ];

            if ($nilaiLama !== null) {
                $this->nilai[$santri->id] = $nilaiLama;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN SEMUA NILAI
    |--------------------------------------------------------------------------
    */

    public function simpan(): void
    {
        if (!$this->kelas_id) {
            Notification::make()
                ->title('Kelas belum dipilih')
                ->danger()
                ->send();

            return;
        }

        if (!$this->mata_pelajaran_id) {
            Notification::make()
                ->title('Mata pelajaran belum dipilih')
                ->danger()
                ->send();

            return;
        }

        if (!$this->daur) {
            Notification::make()
                ->title('Daur belum dipilih')
                ->danger()
                ->send();

            return;
        }

        if (!$this->tahun_ajaran_id) {
            Notification::make()
                ->title('Tahun ajaran belum tersedia')
                ->danger()
                ->send();

            return;
        }

        $berhasil = 0;

        foreach ($this->santris as $santri) {

            $nilai = $this->nilai[$santri['id']] ?? null;

            /*
             * Kalau nilai dikosongkan,
             * jangan disimpan.
             */
            if ($nilai === null || $nilai === '') {
                continue;
            }

            if (!is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
                continue;
            }

            Nilai::updateOrCreate(
                [
                    'santri_id' => $santri['id'],
                    'kelas_id' => $this->kelas_id,
                    'mata_pelajaran_id' => $this->mata_pelajaran_id,
                    'tahun_ajaran_id' => $this->tahun_ajaran_id,
                    'semester' => 1,
                    'daur' => $this->daur,
                ],
                [
                    'nilai' => (int) $nilai,
                ]
            );

            $berhasil++;
        }

        Notification::make()
            ->title('Nilai berhasil disimpan')
            ->body("{$berhasil} nilai berhasil disimpan.")
            ->success()
            ->send();

        /*
         * Jangan menghapus daftar santri.
         * Supaya setelah simpan tetap bisa melihat data.
         */
        $this->loadSantris();
    }
}