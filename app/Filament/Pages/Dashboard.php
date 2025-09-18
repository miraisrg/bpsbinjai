<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverview::class,
            \App\Filament\Widgets\QueueTable::class,
            \App\Filament\Widgets\DailyVisitorsChart::class,
            \App\Filament\Widgets\ServiceTypeChart::class,
            \App\Filament\Widgets\VisitorCategoryChart::class,
            \App\Filament\Widgets\OfficersOnDutyTable::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 2;
    }
}