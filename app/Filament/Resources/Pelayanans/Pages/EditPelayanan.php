<?php

namespace App\Filament\Resources\Pelayanans\Pages;

use App\Filament\Resources\Pelayanans\PelayananResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPelayanan extends EditRecord
{
    protected static string $resource = PelayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
