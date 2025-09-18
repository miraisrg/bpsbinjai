<?php

namespace App\Filament\Widgets;

use App\Models\Tamu;
use App\Models\Antrian;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Pengunjung Hari Ini', Tamu::whereDate('created_at', today())->count())
                ->description('Total tamu yang mendaftar hari ini')
                ->color('success'),

            Stat::make('Antrian Menunggu', Antrian::whereDate('tanggal_antrian', today())->where('status', 'menunggu')->count())
                ->description('Tamu yang belum dipanggil')
                ->color('warning'),

            Stat::make('Antrian Selesai', Antrian::whereDate('tanggal_antrian', today())->where('status', 'selesai')->count())
                ->description('Tamu yang telah selesai dilayani')
                ->color('primary'),

            Stat::make('Total Pengunjung Bulan Ini', Tamu::whereMonth('created_at', now()->month)->count())
                ->description('Akumulasi tamu bulan ini')
                ->color('info'),
        ];
    }
}
