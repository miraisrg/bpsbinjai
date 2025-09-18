<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

class OfficersOnDutyTable extends TableWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Petugas Bertugas Hari Ini';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->whereHas('jadwalPiket', fn ($query) => $query->whereDate('tgl_piket', today()))
            )
            ->columns([
                TextColumn::make('name')->label('Nama Petugas'),
                TextColumn::make('role')->label('Jenis Pelayanan'),
            ])
            ->paginated(false);
    }
}
