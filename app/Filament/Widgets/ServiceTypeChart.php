<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Tamu;
use App\Models\KlasifikasiPelayanan;
use Illuminate\Support\Facades\DB;

class ServiceTypeChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Layanan';
    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $data = Tamu::query()
            ->select('klasifikasi_pelayanans.nama_klasifikasi', DB::raw('COUNT(tamus.id) as total'))
            ->join('klasifikasi_pelayanans', 'tamus.klasifikasi_pelayanan_id', '=', 'klasifikasi_pelayanans.id')
            ->where('tamus.created_at', '>=', now()->startOfMonth())
            ->groupBy('klasifikasi_pelayanans.nama_klasifikasi')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jenis Layanan',
                    'data' => $data->pluck('total')->toArray(),
                ],
            ],
            'labels' => $data->pluck('nama_klasifikasi')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
