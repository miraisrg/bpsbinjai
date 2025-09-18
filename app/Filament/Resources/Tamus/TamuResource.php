<?php

namespace App\Filament\Resources\Tamus;

use App\Filament\Resources\Tamus\Pages\CreateTamu;
use App\Filament\Resources\Tamus\Pages\EditTamu;
use App\Filament\Resources\Tamus\Pages\ListTamus;
use App\Filament\Resources\Tamus\Schemas\TamuForm;
use App\Filament\Resources\Tamus\Tables\TamusTable;
use App\Models\Tamu;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TamuResource extends Resource
{
    protected static ?string $model = Tamu::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Buku Tamu';

    protected static ?string $recordTitleAttribute = 'Tamu';

    public static function form(Schema $schema): Schema
    {
        return TamuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TamusTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPluralLabel(): string
    {
        return 'Daftar Tamu'; // atau cukup 'Tamu'
    }

    public static function getLabel(): string
    {
        return 'Tamu';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTamus::route('/'),
            'create' => CreateTamu::route('/create'),
            'edit' => EditTamu::route('/{record}/edit'),
        ];
    }
}
