<?php

namespace App\Filament\Widgets;
use App\Models\Tamu;

use Filament\Widgets\ChartWidget;

class VisitorCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Kategori Instansi';
    protected static ?int $sort = 6;

    protected function getData(): array
    {
        $data = Tamu::query()
            ->where('created_at', '>=', now()->startOfMonth())
            ->groupBy('kategori_instansi')
            ->selectRaw('kategori_instansi, count(*) as total')
            ->get();
            
        return [
            'datasets' => [
                [
                    'label' => 'Kategori Instansi',
                    'data' => $data->pluck('total')->toArray(),
                ],
            ],
            'labels' => $data->pluck('kategori_instansi')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
