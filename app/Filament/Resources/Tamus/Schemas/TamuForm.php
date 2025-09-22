<?php

namespace App\Filament\Resources\Tamus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class TamuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_pengunjung')
                    ->required(),
                TextInput::make('kategori_instansi')
                    ->required(),
                TextInput::make('nama_instansi')
                    ->required(),
                TextInput::make('no_wa')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('klasifikasi_pelayanan_id')
                    ->label('Jenis Pelayanan')
                    ->relationship('klasifikasi', 'nama_klasifikasi') // sesuai relasi di model Tamu
                    ->required(),
            ]);
    }
}
