<?php

namespace App\Filament\Resources\Tamus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\Tamu;
use App\Filament\Resources\Pelayanans\PelayananResource;

class TamusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pengunjung')
                    ->searchable(),
                TextColumn::make('kategori_instansi')
                    ->searchable(),
                TextColumn::make('nama_instansi')
                    ->searchable(),
                TextColumn::make('no_wa')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('klasifikasi.nama_klasifikasi')
                    ->label('Jenis Pelayanan')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Kedatangan') // Mengubah nama kolom
                    ->date('d M Y')           // Memberi format tanggal (contoh: 18 Sep 2025)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                // Action::make('lengkapiLaporan')
                //     ->label('Lengkapi Laporan')
                //     ->icon('heroicon-o-pencil-square')
                //     ->color('primary')
                //     ->url(function (Tamu $record): string {
                //         // Cari record pelayanan yang terhubung dengan antrian terakhir tamu ini
                //         $pelayanan = $record->antrians()->latest()->first()?->pelayanan;

                //         // Jika ada, arahkan ke halaman edit record pelayanan tersebut
                //         return $pelayanan ? PelayananResource::getUrl('edit', ['record' => $pelayanan]) : '#';
                //     })
                //     // Sembunyikan tombol jika tamu belum memiliki record pelayanan
                //     ->hidden(fn(Tamu $record) => !$record->antrians()->latest()->first()?->pelayanan),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
