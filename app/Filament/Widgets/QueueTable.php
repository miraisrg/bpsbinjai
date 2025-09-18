<?php

namespace App\Filament\Widgets;

use App\Models\Antrian;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class QueueTable extends TableWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Antrian Hari Ini (Menunggu)';

    public function table(Table $table): Table
    {
        return $table
            // Mendefinisikan sumber data untuk tabel
            ->query(
                Antrian::query()
                    ->whereDate('tanggal_antrian', today())
                    ->where('status', 'menunggu')
                    ->orderBy('created_at', 'asc')
            )
            // Mendefinisikan kolom-kolom yang akan tampil
            ->columns([
                TextColumn::make('no_antrian')->label('No. Antrian')->searchable(),
                TextColumn::make('tamu.nama_pengunjung')->label('Nama Pengunjung')->searchable(),
                TextColumn::make('tamu.jenis_pelayanan')->label('Jenis Layanan'),
                TextColumn::make('created_at')->label('Waktu Datang')->time('H:i:s'),
                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'menunggu' => 'warning',
                    'dipanggil' => 'primary',
                    'selesai' => 'success',
                    'dilewati' => 'danger',
                    default => 'gray',
                })
            ])
            // Mendefinisikan aksi untuk setiap baris
            ->actions([
                // Action::make('panggil')
                //     ->label('Panggil')
                //     ->color('success')
                //     ->icon('heroicon-o-phone-arrow-up-right')
                //     ->action(function (Antrian $record) {
                //         $record->update(['status' => 'dipanggil']);
                //         Notification::make()
                //             ->title("Antrian {$record->no_antrian} dipanggil")
                //             ->success()
                //             ->send();
                //     }),
                // Action::make('lewati')
                //     ->label('Lewati')
                //     ->color('danger')
                //     ->icon('heroicon-o-forward')
                //     ->requiresConfirmation()
                //     ->action(function (Antrian $record) {
                //         $record->update(['status' => 'dilewati']);
                //         Notification::make()
                //             ->title("Antrian {$record->no_antrian} dilewati")
                //             ->warning()
                //             ->send();
                //     }),
            ])
            // Membuat tabel refresh otomatis setiap 5 detik
            ->poll('5s');
    }
}