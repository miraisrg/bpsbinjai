<?php

namespace App\Filament\Resources\Pelayanans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PelayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('antrian_id')
                    ->relationship('antrian', 'no_antrian')
                    ->required(),
                Select::make('user_id')
                    ->relationship('tamu', 'nama_pengunjung'),
                TextInput::make('nama_klasifikasi')
                    ->required(),
                TextInput::make('status_pelayanan')
                    ->required(),
                DatePicker::make('tgl_penyelesaian'),
                Textarea::make('kebutuhan_pengaduan')
                    ->columnSpanFull(),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }
}
