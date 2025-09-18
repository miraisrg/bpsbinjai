<?php

namespace App\Filament\Resources\Tamus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                TextColumn::make('jenis_pelayanan')
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
