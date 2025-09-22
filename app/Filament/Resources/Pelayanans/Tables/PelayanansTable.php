<?php

namespace App\Filament\Resources\Pelayanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Pelayanan;
use App\Models\Antrian;
use Filament\Actions\Action;
use App\Models\KlasifikasiPelayanan;
use App\Models\Tamu;

class PelayanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('antrian.no_antrian')
                    ->label('No. Antrian')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('antrian.tamu.nama_pengunjung')
                    ->label('Nama Tamu')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Petugas')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('antrian.tamu.klasifikasi.nama_klasifikasi')
                    ->label('Klasifikasi Layanan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Dilayani')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
                Action::make('tambahLaporan')
                    ->label('Laporan')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->url(fn($record) => route('filament.admin.resources.pelayanans.create', [
                        'antrian_id' => $record->id,
                    ])),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
