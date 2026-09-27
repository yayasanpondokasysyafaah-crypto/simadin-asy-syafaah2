<?php

namespace App\Filament\Admin\Resources\Absensis\Pages;

use App\Filament\Admin\Resources\Absensis\AbsensiResource;
use App\Models\Kelas;
use App\Models\RekapAbsensi as RekapAbsensiModel;
use App\Models\Santri;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Collection;
use App\Exports\RekapAbsensiExport;

class RekapAbsensi extends Page
{
    protected static string $resource = AbsensiResource::class;

    protected string $view = 'filament.admin.resources.absensis.pages.rekap-absensi';

    public ?string $bulan = null;

    public ?int $kelas_id = null;

    public ?string $jenis = 'Keamanan';

    public ?string $jk = null;

    public ?string $kegiatan = null;

    public Collection $kelas;

    public Collection $santris;

    public array $rekap = [];

    public function mount(): void
    {
        $this->bulan = now()->format('Y-m');

        $this->kelas = Kelas::orderBy('nama')->get();

        $this->santris = collect();

        $this->kegiatan = 'Semua';

        $this->loadRekap();
    }

    public function updatedJenis(): void
    {
        if ($this->jenis === 'Keamanan') {
            $this->kegiatan = 'Semua';
        } else {
            $this->kegiatan = "Sorogan Qur'an";
        }

        $this->loadRekap();
    }

    public function updatedKegiatan(): void
    {
        $this->loadRekap();
    }

    public function updatedKelasId(): void
    {
        $this->loadRekap();
    }

    public function updatedJk(): void
    {
        $this->loadRekap();
    }

    public function updatedBulan(): void
    {
        $this->loadRekap();
    }

    public function loadRekap(): void
    {
        $this->rekap = [];

        if (!$this->kelas_id) {
            $this->santris = collect();

            return;
        }

       $this->santris = Santri::where('kelas_id', $this->kelas_id)
            ->when(
                $this->jk,
                fn ($query) => $query->where('jenis_kelamin', $this->jk)
            )
            ->orderBy('nama')
            ->get();

        foreach ($this->santris as $santri) {

            $data = RekapAbsensiModel::where('santri_id', $santri->id)
                ->where('bulan', $this->bulan)
                ->where('jenis', $this->jenis)
                ->when(
                    $this->jenis === 'Madin' && $this->kegiatan !== 'Semua',
                    fn ($query) => $query->where('kegiatan', $this->kegiatan)
                )
                ->first();

            $this->rekap[$santri->id] = [
                'hadir' => $data?->hadir ?? 0,
                'sakit' => $data?->sakit ?? 0,
                'izin' => $data?->izin ?? 0,
                'alpa' => $data?->alpa ?? 0,
            ];
        }
    }

    public function simpanRekap(): void
    {
        foreach ($this->santris as $santri) {

            $data = $this->rekap[$santri->id] ?? [];

            RekapAbsensiModel::updateOrCreate(
                [
                    'santri_id' => $santri->id,
                    'bulan' => $this->bulan,
                    'jenis' => $this->jenis,
                    'kegiatan' => $this->jenis === 'Keamanan'
                        ? 'Semua'
                        : $this->kegiatan,
                ],
                [
                    'hadir' => (int) ($data['hadir'] ?? 0),
                    'sakit' => (int) ($data['sakit'] ?? 0),
                    'izin' => (int) ($data['izin'] ?? 0),
                    'alpa' => (int) ($data['alpa'] ?? 0),
                ]
            );
        }

        Notification::make()
            ->title('Rekap berhasil disimpan')
            ->body('Data rekap absensi berhasil disimpan.')
            ->success()
            ->send();
    }

        public function kirimWA(int $santriId)
        {
            $santri = Santri::find($santriId);

            if (!$santri) {
                Notification::make()
                    ->title('Santri tidak ditemukan')
                    ->danger()
                    ->send();

                return;
            }

            if (empty($santri->no_hp_wali)) {
                Notification::make()
                    ->title('Nomor wali belum tersedia')
                    ->body("Nomor wali untuk {$santri->nama} belum diisi.")
                    ->warning()
                    ->send();

                return;
            }

            $data = $this->rekap[$santri->id] ?? [];

            $bulan = \Carbon\Carbon::createFromFormat('Y-m', $this->bulan)
                ->translatedFormat('F Y');

            $namaKegiatan = $this->jenis === 'Keamanan'
                ? 'Keamanan'
                : $this->kegiatan;

            $pesan =
                "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\n" .
                "Yth. Bapak/Ibu Wali Santri,\n\n" .
                "Berikut rekap absensi santri:\n\n" .
                "Nama Santri : {$santri->nama}\n" .
                "NIS : {$santri->nis}\n" .
                "Jenis Kelamin : {$santri->jenis_kelamin}\n" .
                "Bulan : {$bulan}\n" .
                "Absensi : {$namaKegiatan}\n\n" .
                "Hadir : " . ($data['hadir'] ?? 0) . "\n" .
                "Sakit : " . ($data['sakit'] ?? 0) . "\n" .
                "Izin : " . ($data['izin'] ?? 0) . "\n" .
                "Alpa : " . ($data['alpa'] ?? 0) . "\n\n" .
                "Demikian informasi rekap absensi ini kami sampaikan.\n" .
                "Terima kasih atas perhatian dan kerja samanya.\n\n" .
                "Wassalamu'alaikum Warahmatullahi Wabarakatuh.";

            $nomor = preg_replace('/[^0-9]/', '', $santri->no_hp_wali);

            // Kalau nomor dimulai 08..., ubah menjadi 628...
            if (str_starts_with($nomor, '0')) {
                $nomor = '62' . substr($nomor, 1);
            }

            $url = 'https://wa.me/' . $nomor . '?text=' . urlencode($pesan);

            return redirect()->away($url);
        }

            public function exportExcel()
            {
                if (!$this->kelas_id) {
                    Notification::make()
                        ->title('Kelas belum dipilih')
                        ->body('Silakan pilih kelas terlebih dahulu.')
                        ->warning()
                        ->send();

                    return;
                }

                $kelas = $this->kelas->firstWhere('id', $this->kelas_id);

                $namaKelas = $kelas?->nama ?? 'Kelas';

                $namaKegiatan = $this->jenis === 'Keamanan'
                    ? 'Keamanan'
                    : $this->kegiatan;

                $namaJk = match ($this->jk) {
                'L' => 'Putra',
                'P' => 'Putri',
                default => 'Semua',
            };

            $namaFile = 'Rekap_Absensi_'
                . str_replace(' ', '_', $namaKegiatan)
                . '_'
                . $namaJk
                . '_Kelas_'
                . str_replace(' ', '_', $namaKelas)
                . '_'
                . $this->bulan
                . '.xlsx';
                
                return Excel::download(
                new RekapAbsensiExport(
                $this->bulan,
                $this->kelas_id,
                $this->jenis,
                $this->kegiatan,
                $this->jk
            ),
                $namaFile
            );
            }
    
}