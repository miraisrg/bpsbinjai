<?php

namespace App\Filament\Pages;

use App\Models\Antrian;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PanggilAntrian extends Page
{
    // Deklarasi properti yang benar
    protected static ?string $navigationIcon = 'heroicon-o-speaker-wave';
    protected static string $view = 'filament.pages.panggil-antrian';
    protected static ?string $navigationGroup = 'Antrian';
    protected static ?int $navigationSort = 1;

    // Properti untuk melacak antrian
    public ?Antrian $dipanggilPst = null;
    public ?Antrian $berikutnyaPst = null;
    public ?Antrian $dipanggilPpid = null;
    public ?Antrian $berikutnyaPpid = null;

    public function mount(): void
    {
        $this->loadQueueStates();
    }

    protected function loadQueueStates(): void
    {
        $today = today();

        // Cari antrian DIPANGGIL untuk PST
        $this->dipanggilPst = Antrian::where('status', 'dipanggil')
            ->where('tanggal_antrian', $today)
            ->whereHas('tamu', fn ($q) => $q->where('jenis_pelayanan', 'PST'))
            ->first();

        // Cari antrian MENUNGGU berikutnya untuk PST
        $this->berikutnyaPst = Antrian::where('status', 'menunggu')
            ->where('tanggal_antrian', $today)
            ->whereHas('tamu', fn ($q) => $q->where('jenis_pelayanan', 'PST'))
            ->orderBy('created_at', 'asc')
            ->first();

        // Lakukan hal yang sama untuk PPID
        $this->dipanggilPpid = Antrian::where('status', 'dipanggil')
            ->where('tanggal_antrian', $today)
            ->whereHas('tamu', fn ($q) => $q->where('jenis_pelayanan', 'PPID'))
            ->first();

        $this->berikutnyaPpid = Antrian::where('status', 'menunggu')
            ->where('tanggal_antrian', $today)
            ->whereHas('tamu', fn ($q) => $q->where('jenis_pelayanan', 'PPID'))
            ->orderBy('created_at', 'asc')
            ->first();
    }

    public function panggilBerikutnya(string $jenisLayanan): void
    {
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

    protected function getHeaderActions(): array
    {
        return [
            Action::make('testSound')
                ->label('Testing Suara Monitor')
                ->action(fn () => $this->dispatch('play-sound', number: 'Testing suara', loket: 'satu dua tiga')),
            Action::make('resetDay')
                ->label('Reset Antrian Hari Ini')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    Antrian::where('tanggal_antrian', today())->whereIn('status', ['menunggu', 'dipanggil', 'dilewati'])
                        ->update(['status' => 'dibatalkan']);
                    Notification::make()->title('Semua antrian hari ini telah di-reset.')->success()->send();
                    $this->loadQueueStates();
                }),
        ];
    }
}