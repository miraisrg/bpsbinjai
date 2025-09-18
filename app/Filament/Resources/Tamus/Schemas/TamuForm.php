<?php

namespace App\Filament\Resources\Tamus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

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
                TextInput::make('jenis_pelayanan')
                    ->required(),
            ]);
    }
}
