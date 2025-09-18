<?php

namespace App\Filament\Pages;

use App\Models\Antrian;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use BackedEnum; // <-- Tambahkan ini
use UnitEnum;   // <-- Tambahkan ini

class PanggilAntrian extends Page
{
    // --- Properti di bawah ini disesuaikan ---
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-speaker-wave';
    protected string $view = 'filament.pages.panggil-antrian';
    protected static string | UnitEnum | null $navigationGroup = 'Antrian';
    protected static ?string $title = 'Panggil Antrian';
    protected static ?int $navigationSort = 1;

    public ?Antrian $dipanggilPst = null;
    public ?Antrian $berikutnyaPst = null;
    public ?Antrian $dipanggilPpid = null;
    public ?Antrian $berikutnyaPpid = null;
    public bool $layananBuka = true;

    // ... sisa kode method Anda tetap sama ...
    public function mount(): void
    {
        $this->loadQueueStates();
    }

    protected function loadQueueStates(): void
    {
        $today = today();
        $baseQuery = fn($jenis) => Antrian::where('tanggal_antrian', $today)
            ->whereHas('tamu', fn($q) => $q->where('jenis_pelayanan', $jenis));

        $this->dipanggilPst = (clone $baseQuery('PST'))->where('status', 'dipanggil')->first();
        $this->berikutnyaPst = (clone $baseQuery('PST'))->where('status', 'menunggu')->orderBy('created_at', 'asc')->first();

        $this->dipanggilPpid = (clone $baseQuery('PPID'))->where('status', 'dipanggil')->first();
        $this->berikutnyaPpid = (clone $baseQuery('PPID'))->where('status', 'menunggu')->orderBy('created_at', 'asc')->first();
    }

    public function panggilBerikutnya(string $jenisLayanan): void
    {
        if (!$this->layananBuka) return;

        $antrianToCall = ($jenisLayanan === 'PST') ? $this->berikutnyaPst : $this->berikutnyaPpid;

        if ($antrianToCall) {
            $antrianToCall->update(['status' => 'dipanggil']);
            $this->dispatch('play-sound', number: $antrianToCall->no_antrian, loket: $jenisLayanan);
            $this->loadQueueStates();
        }
    }

    public function tandaiSelesai(int $antrianId): void
    {
        $antrian = Antrian::find($antrianId);
        if ($antrian) {
            $antrian->update(['status' => 'selesai']);
            Notification::make()->title("Layanan untuk {$antrian->no_antrian} selesai")->success()->send();
            $this->loadQueueStates();
        }
    }

    public function lewatiAntrian(int $antrianId): void
    {
        $antrian = Antrian::find($antrianId);
        if ($antrian) {
            $antrian->update(['status' => 'dilewati']);
            Notification::make()->title("Antrian {$antrian->no_antrian} dilewati")->warning()->send();
            $this->loadQueueStates();
        }
    }

    public function toggleLayanan(): void
    {
        $this->layananBuka = !$this->layananBuka;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('testSound')
                ->label('Testing Suara Monitor')
                ->action(fn() => $this->dispatch('play-sound', number: 'Testing suara', loket: 'satu dua tiga')),
        ];
    }
}
