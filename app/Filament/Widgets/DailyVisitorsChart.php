<?php

namespace App\Filament\Widgets;

use App\Models\Tamu;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DailyVisitorsChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Grafik Kunjungan';

    protected function getFilters(): ?array
    {
        return [
            'weekly' => 'Mingguan (7 Hari Terakhir)',
            'monthly' => 'Bulanan (30 Hari Terakhir)',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter; // otomatis diisi Filament
        $startDate = match ($activeFilter) {
            'monthly' => now()->subDays(29),
            default => now()->subDays(6),
        };

        $query = Tamu::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                'jenis_pelayanan',
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date', 'jenis_pelayanan')
            ->orderBy('date', 'asc')
            ->get();

        $period = CarbonPeriod::create($startDate, now());
        $labels = collect($period)->map(fn(Carbon $date) => $date->format('d M'))->toArray();

        $pstData = array_fill_keys($labels, 0);
        $ppidData = array_fill_keys($labels, 0);

        foreach ($query as $record) {
            $dateLabel = Carbon::parse($record->date)->format('d M');
            if (isset($pstData[$dateLabel]) && $record->jenis_pelayanan === 'PST') {
                $pstData[$dateLabel] = $record->count;
            } elseif (isset($ppidData[$dateLabel]) && $record->jenis_pelayanan === 'PPID') {
                $ppidData[$dateLabel] = $record->count;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengunjung PST',
                    'data' => array_values($pstData),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
                [
                    'label' => 'Pengunjung PPID',
                    'data' => array_values($ppidData),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
