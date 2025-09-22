<?php

namespace App\Filament\Resources\Pelayanans\Pages;

use App\Filament\Resources\Pelayanans\PelayananResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Antrian;

class CreatePelayanan extends CreateRecord
{
    protected static string $resource = PelayananResource::class;
    // Method ini akan dijalankan setelah record baru berhasil dibuat
    protected function afterCreate(): void
    {
        $antrian = Antrian::find($this->record->antrian_id);

        if ($antrian) {
            $antrian->update(['status' => 'selesai']);
        }
    }
}
