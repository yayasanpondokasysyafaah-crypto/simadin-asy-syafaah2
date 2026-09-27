<?php

namespace App\Filament\Admin\Resources\Absensis\Pages;

use App\Filament\Admin\Resources\Absensis\AbsensiResource;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Santri;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class InputAbsensi extends Page
{
    protected static string $resource = AbsensiResource::class;

    protected string $view = 'filament.admin.resources.absensis.pages.input-absensi';

    public ?string $tanggal = null;

    public ?int $kelas_id = null;

    public ?string $jenis = 'Keamanan';

    public ?string $kegiatan = null;

    public array $absensi = [];

    public Collection $kelas;

    public Collection $santris;

    public function mount(): void
    {
        $this->tanggal = now()->format('Y-m-d');

        $this->kelas = Kelas::orderBy('nama')->get();

        $this->santris = collect();

        $this->kegiatan = 'Shubuh';
    }

    public function updatedJenis(): void
    {
        if ($this->jenis === 'Keamanan') {
            $this->kegiatan = 'Shubuh';
        } else {
            $this->kegiatan = "Sorogan Qur'an";
        }

        $this->loadSantri();
    }

    public function updatedKegiatan(): void
    {
        $this->loadSantri();
    }

    public function updatedKelasId(): void
    {
        $this->loadSantri();
    }

    public function updatedTanggal(): void
    {
        $this->loadSantri();
    }

    public function loadSantri(): void
    {
        $this->absensi = [];

        if (!$this->kelas_id || !$this->jenis || !$this->kegiatan) {
            $this->santris = collect();

            return;
        }

        $this->santris = Santri::where('kelas_id', $this->kelas_id)
            ->orderBy('nama')
            ->get();

        foreach ($this->santris as $santri) {
            $existing = Absensi::where('santri_id', $santri->id)
                ->whereDate('tanggal', $this->tanggal)
                ->where('jenis', $this->jenis)
                ->where('kegiatan', $this->kegiatan)
                ->first();

            $this->absensi[$santri->id] = $existing?->status ?? '.';
        }
    }

    public function simpan(): void
    {
        foreach ($this->absensi as $santriId => $status) {

            Absensi::updateOrCreate(
                [
                    'santri_id' => $santriId,
                    'tanggal' => $this->tanggal,
                    'jenis' => $this->jenis,
                    'kegiatan' => $this->kegiatan,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        Notification::make()
            ->title('Absensi berhasil disimpan')
            ->body('Data absensi santri telah berhasil disimpan.')
            ->success()
            ->send();
    }
}