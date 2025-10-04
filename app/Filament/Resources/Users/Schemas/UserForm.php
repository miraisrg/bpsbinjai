<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Operation;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('no_wa')
                            ->label('No. WhatsApp')
                            ->numeric()
                            ->required(),

                        Select::make('role')
                            ->label('Role / Jenis Pelayanan')
                            ->options([
                                'PST'   => 'Petugas PST',
                                'PPID'  => 'Petugas PPID',
                                'Admin' => 'Administrator',
                            ])
                            ->required(),

                        TextInput::make('password')
                            ->password()
                            // Tampilkan & wajib hanya saat operasi Create (v4 cara recommended)
                            ->visibleOn(Operation::Create)
                            ->required()
                            // Saat Edit, field bisa disembunyikan; jika ingin tampil opsional:
                            // ->hiddenOn(Operation::Edit)
                            // Simpan hanya jika diisi (skenario Create/aksi lain yg kelihatan)
                            ->dehydrated(fn($state) => filled($state)),
                    ])
                    ->columns(2),
            ]);
    }
}
