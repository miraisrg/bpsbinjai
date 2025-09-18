<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Tamu;

class ServiceTypeChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Layanan';
    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $data = Tamu::query()
            ->where('created_at', '>=', now()->startOfMonth())
            ->groupBy('jenis_pelayanan')
            ->selectRaw('jenis_pelayanan, count(*) as total')
            ->get();
        
        return [
            'datasets' => [
                [
                    'label' => 'Jenis Layanan',
                    'data' => $data->pluck('total')->toArray(),
                ],
            ],
            'labels' => $data->pluck('jenis_pelayanan')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
