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
                // Action::make('laporan')
                //     ->label(function (Tamu $record) {
                //         $pelayanan = $record->antrians()->latest()->first()?->pelayanan;
                //         return ($pelayanan && $pelayanan->user_id) ? 'Lihat Laporan' : 'Lengkapi Laporan';
                //     })
                //     ->icon('heroicon-o-pencil-square')
                //     ->color(function (Tamu $record) {
                //         $pelayanan = $record->antrians()->latest()->first()?->pelayanan;
                //         return ($pelayanan && $pelayanan->user_id) ? 'gray' : 'primary';
                //     })
                //     ->url(function (Tamu $record): string {
                //         $antrian = $record->antrians()->latest()->first();

                //         // --- PENGECEKAN DITAMBAHKAN DI SINI ---
                //         if (!$antrian) {
                //             // Jika tidak ada antrian, kembalikan URL aman yang tidak melakukan apa-apa
                //             return '#';
                //         }

                //         $pelayanan = $antrian->pelayanan;

                //         if ($pelayanan && $pelayanan->user_id) {
                //             return PelayananResource::getUrl('view', ['record' => $pelayanan]);
                //         }

                //         // Jika ada antrian, teruskan ID-nya
                //         return PelayananResource::getUrl('create', ['antrian_id' => $antrian->id]);
                //     })
                //     ->hidden(fn(Tamu $record) => !$record->antrians()->latest()->first()),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
