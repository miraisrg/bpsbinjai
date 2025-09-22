<?php

namespace App\Filament\Widgets;

use App\Models\Tamu;
use App\Models\KlasifikasiPelayanan;
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

        // Ambil data tamu + klasifikasi
        $query = Tamu::query()
            ->select(
                DB::raw('DATE(tamus.created_at) as date'),
                'klasifikasi_pelayanans.nama_klasifikasi as klasifikasi',
                DB::raw('count(*) as count')
            )
            ->join('klasifikasi_pelayanans', 'tamus.klasifikasi_pelayanan_id', '=', 'klasifikasi_pelayanans.id')
            ->where('tamus.created_at', '>=', $startDate)
            ->groupBy('date', 'klasifikasi')
            ->orderBy('date', 'asc')
            ->get();

        // Buat periode label (misalnya 7 hari / 30 hari)
        $period = CarbonPeriod::create($startDate, now());
        $labels = collect($period)->map(fn(Carbon $date) => $date->format('d M'))->toArray();

        // Ambil semua klasifikasi dari tabel
        $klasifikasis = KlasifikasiPelayanan::pluck('nama_klasifikasi')->toArray();

        // Siapkan dataset kosong untuk tiap klasifikasi
        $datasets = [];
        foreach ($klasifikasis as $klasifikasi) {
            $datasets[$klasifikasi] = array_fill_keys($labels, 0);
        }

        // Isi dataset dengan hasil query
        foreach ($query as $record) {
            $dateLabel = Carbon::parse($record->date)->format('d M');
            if (isset($datasets[$record->klasifikasi][$dateLabel])) {
                $datasets[$record->klasifikasi][$dateLabel] = $record->count;
            }
        }

        // Konversi ke format Chart.js
        $chartData = [];
        $colors = [
            'rgba(54, 162, 235, 0.5)', // biru
            'rgba(255, 99, 132, 0.5)', // merah
            'rgba(75, 192, 192, 0.5)', // hijau
            'rgba(255, 206, 86, 0.5)', // kuning
            'rgba(153, 102, 255, 0.5)', // ungu
        ];

        $borderColors = [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(153, 102, 255, 1)',
        ];

        $i = 0;
        foreach ($datasets as $klasifikasi => $data) {
            $chartData[] = [
                'label' => "Pengunjung {$klasifikasi}",
                'data' => array_values($data),
                'backgroundColor' => $colors[$i % count($colors)],
                'borderColor' => $borderColors[$i % count($borderColors)],
            ];
            $i++;
        }

        return [
            'datasets' => $chartData,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
