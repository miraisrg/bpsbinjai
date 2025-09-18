<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Antrian; 
use App\Models\Tamu;    
use App\Models\Pelayanan;
use Carbon\Carbon;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = today();
        
        // Kalkulasi waktu layanan rata-rata
        $completedServices = Pelayanan::whereDate('created_at', $today)->get();
        $totalServiceTime = 0;
        foreach ($completedServices as $service) {
            $totalServiceTime += $service->created_at->diffInMinutes($service->updated_at);
        }
        $averageServiceTime = $completedServices->count() > 0 ? round($totalServiceTime / $completedServices->count()) : 0;

        return [
            Stat::make('Pengunjung Hari Ini', Tamu::whereDate('created_at', $today)->count())
                ->description('Total tamu yang mendaftar hari ini'),
            Stat::make('Antrian Menunggu', Antrian::whereDate('tanggal_antrian', $today)->where('status', 'menunggu')->count())
                ->description('Tamu yang belum dipanggil'),
            Stat::make('Antrian Selesai', Antrian::whereDate('tanggal_antrian', $today)->where('status', 'selesai')->count())
                ->description('Tamu yang telah selesai dilayani'),
            Stat::make('Waktu Layanan Rata-rata', $averageServiceTime . ' menit')
                ->description('Rata-rata waktu per layanan hari ini'),
        ];
    }
}
