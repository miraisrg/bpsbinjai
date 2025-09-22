<?php

namespace App\Filament\Resources\Pelayanans;

use App\Filament\Resources\Pelayanans\Pages\CreatePelayanan;
use App\Filament\Resources\Pelayanans\Pages\EditPelayanan;
use App\Filament\Resources\Pelayanans\Pages\ListPelayanans;
use App\Filament\Resources\Pelayanans\Schemas\PelayananForm;
use App\Filament\Resources\Pelayanans\Tables\PelayanansTable;
use App\Models\Pelayanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Card;
use App\Models\Antrian;

class PelayananResource extends Resource
{
    protected static ?string $model = Pelayanan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Pelayanan';

    public static function form(Schema $schema): Schema
    {
        return PelayananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PelayanansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPelayanans::route('/'),
            'create' => CreatePelayanan::route('/create'),
            'edit' => EditPelayanan::route('/{record}/edit'),
        ];
    }

    // public static function canCreate(): bool
    // {
    //     return false; // disable tombol "Create Pelayanan"
    // }
}
