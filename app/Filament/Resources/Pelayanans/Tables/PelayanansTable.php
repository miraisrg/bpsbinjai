<?php

namespace App\Filament\Resources\Pelayanans\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PelayanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Antrian.no_antrian')
                    ->searchable(),
                TextColumn::make('Antrian.tamu.nama_pengunjung')
                    ->label('Nama Pengunjung')
                    ->searchable(),
                TextColumn::make('klasifikasi.nama_klasifikasi')
                    ->label('Jenis Pelayanan')
                    ->sortable(),
                TextColumn::make('status_pelayanan')
                    ->searchable(),
                TextColumn::make('tgl_penyelesaian')
                    ->date()
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
                // EditAction::make(),
                Action::make('cetak')
                    ->label('Laporan')
                    ->icon('heroicon-o-printer')
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
